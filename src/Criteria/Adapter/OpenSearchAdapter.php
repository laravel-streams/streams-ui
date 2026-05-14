<?php

namespace Streams\Ui\Criteria\Adapter;

use Illuminate\Support\Arr;
use Streams\Core\Stream\Stream;
use Illuminate\Support\Facades\Config;
use Streams\Core\Criteria\Adapter\AbstractAdapter;

class OpenSearchAdapter extends AbstractAdapter
{
    protected array $wheres = [];

    protected array $orders = [];

    protected int $size = 10000;

    protected int $from = 0;

    public function __construct(Stream $stream)
    {
        $this->stream = $stream;
        $this->query = $this->buildClient();
    }

    protected function buildClient(): \OpenSearch\Client
    {
        if (! class_exists(\OpenSearch\ClientBuilder::class)) {
            throw new \RuntimeException(
                'The opensearch-project/opensearch-php package is required to use the OpenSearch adapter.'
            );
        }

        $connection = $this->stream->config('source.connection',
            Config::get('streams.opensearch.default', 'default'));

        $config = Config::get("streams.opensearch.connections.{$connection}", []);

        $builder = \OpenSearch\ClientBuilder::create()
            ->setHosts(Arr::get($config, 'hosts', ['https://localhost:9200']));

        $username = Arr::get($config, 'username');
        $password = Arr::get($config, 'password');

        if ($username && $password) {
            $builder->setBasicAuthentication($username, $password);
        }

        if (Arr::get($config, 'ssl_verification', true) === false) {
            $builder->setSSLVerification(false);
        }

        return $builder->build();
    }

    public function where($field, $operator = null, $value = null, $nested = null): static
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }

        $this->wheres[] = compact('field', 'operator', 'value', 'nested');

        return $this;
    }

    public function orderBy($field, $direction = 'asc'): static
    {
        $this->orders[] = [$field => ['order' => strtolower($direction)]];

        return $this;
    }

    public function limit($limit, $offset = 0): static
    {
        $this->size = (int) $limit;
        $this->from = (int) $offset;

        return $this;
    }

    public function get(array $parameters = []): array
    {
        $this->callParameterMethods($parameters);

        $response = $this->query->search([
            'index' => $this->index(),
            'body' => $this->buildBody(),
        ]);

        return $this->extractHits($response);
    }

    public function count(array $parameters = []): int
    {
        $this->callParameterMethods($parameters);

        $body = $this->buildBody();

        $response = $this->query->count([
            'index' => $this->index(),
            'body' => ['query' => $body['query']],
        ]);

        $this->reset();

        return (int) ($response['count'] ?? 0);
    }

    public function save(array $attributes): array
    {
        $keyName = $this->stream->config('key_name', 'id');

        $id = Arr::pull($attributes, $keyName);

        $params = [
            'index' => $this->index(),
            'body' => $attributes,
        ];

        if ($id) {
            $params['id'] = $id;
        }

        $response = $this->query->index($params);

        $attributes[$keyName] = $response['_id'];

        return $attributes;
    }

    public function delete(array $parameters = []): bool
    {
        $this->callParameterMethods($parameters);

        $body = $this->buildBody();

        $response = $this->query->deleteByQuery([
            'index' => $this->index(),
            'body' => ['query' => $body['query']],
        ]);

        return empty($response['failures'] ?? []);
    }

    public function truncate(): void
    {
        $this->query->deleteByQuery([
            'index' => $this->index(),
            'body' => ['query' => ['match_all' => new \stdClass]],
        ]);
    }

    protected function buildBody(): array
    {
        $body = [
            'query' => $this->buildQuery(),
            'size' => $this->size,
            'from' => $this->from,
        ];

        if (! empty($this->orders)) {
            $body['sort'] = $this->orders;
        }

        return $body;
    }

    protected function buildQuery(): array
    {
        if (empty($this->wheres)) {
            return ['match_all' => new \stdClass];
        }

        $must = [];
        $should = [];

        foreach ($this->wheres as $where) {
            $clause = $this->buildClause($where['field'], $where['operator'], $where['value']);

            if ($where['nested'] === 'or') {
                $should[] = $clause;
            } else {
                $must[] = $clause;
            }
        }

        $bool = [];

        if ($must) {
            $bool['must'] = $must;
        }

        if ($should) {
            $bool['should'] = $should;
        }

        return ['bool' => $bool];
    }

    protected function buildClause(string $field, string $operator, mixed $value): array
    {
        return match (strtoupper($operator)) {
            '=' => ['term' => [$field => $value]],
            '!=', '<>' => ['bool' => ['must_not' => [['term' => [$field => $value]]]]],
            'LIKE' => $this->buildLikeClause($field, $value),
            '>' => ['range' => [$field => ['gt' => $value]]],
            '>=' => ['range' => [$field => ['gte' => $value]]],
            '<' => ['range' => [$field => ['lt' => $value]]],
            '<=' => ['range' => [$field => ['lte' => $value]]],
            'IN' => ['terms' => [$field => (array) $value]],
            'NOT IN' => ['bool' => ['must_not' => [['terms' => [$field => (array) $value]]]]],
            default => ['match' => [$field => $value]],
        };
    }

    protected function buildLikeClause(string $field, string $value): array
    {
        if (strpos($value, '%') !== false) {
            return ['wildcard' => [$field => [
                'value' => str_replace('%', '*', $value),
                'case_insensitive' => true,
            ]]];
        }

        return ['match' => [$field => $value]];
    }

    protected function extractHits(array $response): array
    {
        $keyName = $this->stream->config('key_name', 'id');

        return array_map(function (array $hit) use ($keyName) {
            $source = $hit['_source'] ?? [];

            if (! isset($source[$keyName])) {
                $source[$keyName] = $hit['_id'];
            }

            return $source;
        }, $response['hits']['hits'] ?? []);
    }

    protected function index(): string
    {
        return $this->stream->config('source.index', $this->stream->id);
    }

    protected function reset(): void
    {
        $this->wheres = [];
        $this->orders = [];
        $this->size = 10000;
        $this->from = 0;
    }
}
