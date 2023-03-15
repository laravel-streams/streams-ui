<?php

namespace Streams\Ui\Components;

use Illuminate\Support\Facades\Redirect;
use Streams\Ui\Support\Component;
use Illuminate\Support\Facades\Request;
use Streams\Ui\Components\Traits\HasStream;
use Streams\Ui\Components\Traits\HasAttributes;
use Streams\Ui\Components\Workflows\TableBuilder;

class Table extends Component
{
    use HasStream;
    use HasAttributes;

    public ?string $builder = TableBuilder::class;

    public string $template = 'ui::components.table';

    public ?string $handle = 'default';
    
    public bool $selectable = false;
    
    public ?string $caption = null;

    public ?string $stream = null;

    public array $entries = [];

    public array $filters = [];
    public array $columns = [];
    public array $buttons = [];
    public array $actions = [];
    
    public array $views = [];
    public array $query = [];
    
    public array $pagination = [];

    public array $attributes = [];

    public function delete()
    {
        $ids = array_keys(Request::post('id'));

        $keyName = $this->stream()->config('key_name', 'id');
        
        $this->stream()->entries()->where($keyName, 'IN', $ids)->delete();

        return Redirect::back(301);
    }
}
