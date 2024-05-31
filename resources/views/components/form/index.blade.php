<form
    x-data="{ isUploadingFile: false }"
    x-on:submit="if (isUploadingFile) $event.preventDefault()"
    x-on:file-upload-started="isUploadingFile = true"
    x-on:file-upload-finished="isUploadingFile = false"
    {{ $attributes->class(['ui-form grid gap-y-6'])->merge($this->getHtmlAttributes()) }}>
    {{ $slot }}
</form>
