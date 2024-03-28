<?php

namespace Streams\Ui\Panels\Traits;

use Illuminate\Support\Arr;

trait HasRoutes
{
    protected string $path = '';

    protected array $domains = [];

    protected \Closure | null $routes = null;

    protected string | \Closure | null $homeUrl = null;

    public function path(string $path): static
    {
        $this->path = $path;

        return $this;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function domain(?string $domain): static
    {
        $this->domains(filled($domain) ? [$domain] : []);

        return $this;
    }

    public function domains(array $domains): static
    {
        $this->domains = $domains;

        return $this;
    }

    public function routes(?\Closure $routes): static
    {
        $this->routes = $routes;

        return $this;
    }

    public function getRoutes(): ?\Closure
    {
        return $this->routes;
    }

    public function homeUrl(string | \Closure | null $url): static
    {
        $this->homeUrl = $url;

        return $this;
    }

    public function getHomeUrl(): ?string
    {
        return $this->evaluate($this->homeUrl);
    }

    public function getUrl($tenant = null): ?string
    {
        // if (! $this->auth()->check()) {
        //     return $this->hasLogin() ? $this->getLoginUrl() : url($this->getPath());
        // }

        // $hasTenancy = $this->hasTenancy();

        // if ((! $tenant) && $hasTenancy) {
        //     $tenant = Filament::getUserDefaultTenant($this->auth()->user());
        // }

        // if ((! $tenant) && $hasTenancy) {
        //     return ($this->hasTenantRegistration() && filament()->getTenantRegistrationPage()::canView()) ?
        //         $this->getTenantRegistrationUrl() :
        //         null;
        // }

        // if ($tenant) {
        //     $originalTenant = Filament::getTenant();
        //     Filament::setTenant($tenant);

        //     $isNavigationMountedOriginally = $this->isNavigationMounted;
        //     $originalNavigationItems = $this->navigationItems;
        //     $originalNavigationGroups = $this->navigationGroups;

        //     $this->isNavigationMounted = false;
        //     $this->navigationItems = [];
        //     $this->navigationGroups = [];

        //     $navigation = $this->getNavigation();

        //     Filament::setTenant($originalTenant);

        //     $this->isNavigationMounted = $isNavigationMountedOriginally;
        //     $this->navigationItems = $originalNavigationItems;
        //     $this->navigationGroups = $originalNavigationGroups;
        // } else {
        $navigation = $this->getNavigation();
        // }

        $firstGroup = Arr::first($navigation);

        if (!$firstGroup) {
            return null;
        }

        $firstItem = Arr::first($firstGroup->getItems());

        if (!$firstItem) {
            return null;
        }

        return $firstItem->getUrl();
    }
}
