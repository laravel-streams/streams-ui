<div {{ $modalFooter->getHtmlAttributeBag()->class('ui-modal-footer flex items-center gap-3 px-6 pb-6') }}>
    @foreach ($modalFooter->getActions() as $action)
        @if ($action->isVisible())
            {!! $action->render() !!}
        @endif
    @endforeach
</div>
