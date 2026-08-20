<?php

namespace Streams\Ui\Builders\Inputs;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class FileInput extends Input
{
    protected string $view = 'ui::builders.inputs.file';

    protected string|\Closure|null $disk = 'public';

    protected string|\Closure|null $accept = null;

    protected bool|\Closure $multiple = false;

    protected string|\Closure|null $previewUrl = null;

    protected bool|\Closure $previewImages = true;

    protected bool|\Closure $removable = false;

    public function disk(string|\Closure|null $disk): static
    {
        $this->disk = $disk;

        return $this;
    }

    public function getDisk(): string
    {
        return $this->evaluate($this->disk) ?? 'public';
    }

    public function accept(string|\Closure|null $accept): static
    {
        $this->accept = $accept;

        return $this;
    }

    public function getAccept(): ?string
    {
        return $this->evaluate($this->accept);
    }

    public function multiple(bool|\Closure $condition = true): static
    {
        $this->multiple = $condition;

        return $this;
    }

    public function isMultiple(): bool
    {
        return (bool) $this->evaluate($this->multiple);
    }

    /**
     * Force a preview URL (e.g. CDN / absolute asset URL) instead of resolving from state.
     */
    public function previewUrl(string|\Closure|null $url): static
    {
        $this->previewUrl = $url;

        return $this;
    }

    public function previewImages(bool|\Closure $condition = true): static
    {
        $this->previewImages = $condition;

        return $this;
    }

    public function shouldPreviewImages(): bool
    {
        return (bool) $this->evaluate($this->previewImages);
    }

    /**
     * Show a control to clear the current file from form state.
     */
    public function removable(bool|\Closure $condition = true): static
    {
        $this->removable = $condition;

        return $this;
    }

    public function isRemovable(): bool
    {
        return (bool) $this->evaluate($this->removable);
    }

    public function canRemoveCurrentFile(): bool
    {
        if (! $this->isRemovable() || $this->isDisabled()) {
            return false;
        }

        $state = $this->getState();

        if ($state instanceof TemporaryUploadedFile) {
            return true;
        }

        return is_string($state) && trim($state) !== '';
    }

    /**
     * Convenience: restrict to images and enable image previews.
     */
    public function image(bool|\Closure $condition = true): static
    {
        if ($this->evaluate($condition)) {
            $this->accept('image/*');
            $this->previewImages(true);
        }

        return $this;
    }

    public function getPreviewUrl(): ?string
    {
        $explicit = $this->evaluate($this->previewUrl);

        if (filled($explicit)) {
            return (string) $explicit;
        }

        $state = $this->getState();

        if ($state instanceof TemporaryUploadedFile) {
            try {
                return $state->temporaryUrl();
            } catch (\Throwable) {
                return null;
            }
        }

        if (! is_string($state) || trim($state) === '') {
            return null;
        }

        $path = trim($state);

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return $path;
        }

        return Storage::disk($this->getDisk())->url($path);
    }

    public function getCurrentFileName(): ?string
    {
        $state = $this->getState();

        if ($state instanceof TemporaryUploadedFile) {
            $name = $state->getClientOriginalName();

            return filled($name) ? $name : null;
        }

        if (! is_string($state) || trim($state) === '') {
            return null;
        }

        $path = trim($state);

        if (Str::startsWith($path, ['http://', 'https://', '//'])) {
            return basename(parse_url($path, PHP_URL_PATH) ?: $path) ?: null;
        }

        return basename($path) ?: null;
    }

    public function shouldShowImagePreview(): bool
    {
        if (! $this->shouldPreviewImages() || ! filled($this->getPreviewUrl())) {
            return false;
        }

        $state = $this->getState();

        if ($state instanceof TemporaryUploadedFile) {
            $mime = (string) ($state->getMimeType() ?? '');

            return Str::startsWith($mime, 'image/')
                || $this->pathLooksLikeImage($state->getClientOriginalName());
        }

        if (is_string($state) && trim($state) !== '') {
            return $this->pathLooksLikeImage($state);
        }

        return $this->pathLooksLikeImage((string) $this->getPreviewUrl())
            || str_contains((string) ($this->getAccept() ?? ''), 'image');
    }

    protected function pathLooksLikeImage(string $path): bool
    {
        $path = strtolower(parse_url($path, PHP_URL_PATH) ?: $path);

        return (bool) preg_match('/\.(jpe?g|png|gif|webp|svg|bmp|avif)$/', $path);
    }
}
