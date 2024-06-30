@props(['active' => false, 'permission' => null])

@if ( is_null($permission) || ($permission && current_user()->can($permission)) )
<a wire:navigate @class([
    'sidebar',
    'sidebar-active' => $active]
) {{ $attributes }}>
    {{ $slot }}
</a>
@endif
