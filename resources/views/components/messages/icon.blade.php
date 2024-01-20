@switch($type ?: 'info')
@case('info')
<div class="flex-shrink-0">
    <x-heroicon-o-exclamation-circle class="h-6 w-6 text-blue-400" />
</div>
@break
@case('error')
<div class="flex-shrink-0">
    <x-heroicon-o-exclamation-circle class="h-6 w-6 text-red-400" />
</div>
@break
@case('success')
<div class="flex-shrink-0">
    <x-heroicon-o-check-circle class="h-6 w-6 text-green-400" />
</div>
@break
@case('warning')
<div class="flex-shrink-0">
    <x-heroicon-o-exclamation-circle class="h-6 w-6 text-yellow-400" />
</div>
@break
@case('danger')
<div class="flex-shrink-0">
    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-400" />
</div>
@break
@case('important')
<div class="flex-shrink-0">
    <x-heroicon-o-exclamation-triangle class="h-6 w-6 text-red-400" />
</div>
@break
@endswitch
