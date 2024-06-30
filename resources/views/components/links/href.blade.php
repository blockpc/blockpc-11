@props(['permission' => null])

@if ( is_null($permission) || ($permission && current_user()->can($permission)) )
<a wire:navigate {{ $attributes }}>
    {{ $slot }}
</a>
@endif
