<?php

namespace Streams\Ui\Panels\Traits;

use Livewire\Livewire;
use Livewire\Mechanisms\ComponentRegistry;

trait HasLivewireComponents
{
    protected array $livewireComponents = [];

    public function livewireComponents(array $components): static
    {
        foreach ($components as $component) {
            $this->queueLivewireComponent($component);
        }

        return $this;
    }

    protected function registerLivewireComponents(): void
    {
        // $this->queueLivewireComponent(DatabaseNotifications::class);
        // $this->queueLivewireComponent(EditProfile::class);
        // $this->queueLivewireComponent(GlobalSearch::class);
        // $this->queueLivewireComponent(Notifications::class);

        // if ($this->hasEmailVerification() && is_subclass_of($emailVerificationRouteAction = $this->getEmailVerificationPromptRouteAction(), Component::class)) {
        //     $this->queueLivewireComponent($emailVerificationRouteAction);
        // }

        // if ($this->hasLogin() && is_subclass_of($loginRouteAction = $this->getLoginRouteAction(), Component::class)) {
        //     $this->queueLivewireComponent($loginRouteAction);
        // }

        // if ($this->hasPasswordReset()) {
        //     if (is_subclass_of($requestPasswordResetRouteAction = $this->getRequestPasswordResetRouteAction(), Component::class)) {
        //         $this->queueLivewireComponent($requestPasswordResetRouteAction);
        //     }

        //     if (is_subclass_of($resetPasswordRouteAction = $this->getResetPasswordRouteAction(), Component::class)) {
        //         $this->queueLivewireComponent($resetPasswordRouteAction);
        //     }
        // }

        // if ($this->hasRegistration() && is_subclass_of($registrationRouteAction = $this->getRegistrationRouteAction(), Component::class)) {
        //     $this->queueLivewireComponent($registrationRouteAction);
        // }

        foreach ($this->getPages() as $page) {

            $this->queueLivewireComponent($page);

            if (method_exists($page, 'getWidgets')) {
                foreach ($page::getWidgets() as $widget) {
                    $this->queueLivewireComponent($widget);
                }
            }
        }

        foreach ($this->getResources() as $resource) {

            foreach ($resource::getPages() as $page) {
                $this->queueLivewireComponent($page->getPage());
            }

            // foreach ($resource::getRelations() as $relation) {
            //     if ($relation instanceof RelationGroup) {
            //         foreach ($relation->getManagers() as $groupedRelation) {
            //             $this->queueLivewireComponent($this->normalizeRelationManagerClass($groupedRelation));
            //         }

            //         continue;
            //     }

            //     $this->queueLivewireComponent($this->normalizeRelationManagerClass($relation));
            // }

            // foreach ($resource::getWidgets() as $widget) {
            //     $this->queueLivewireComponent($widget);
            // }
        }

        foreach ($this->livewireComponents as $componentName => $componentClass) {
            Livewire::component($componentName, $componentClass);
        }

        $this->livewireComponents = [];
    }

    protected function queueLivewireComponent(string $component): void
    {
        $componentName = app(ComponentRegistry::class)->getName($component);

        $this->livewireComponents[$componentName] = $component;
    }
}
