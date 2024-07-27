@props(['permission' => null])

@if ( is_null($permission) || ($permission && current_user()->can($permission)) )
<a {{ $attributes }} target="_blank">
    {{ $slot }}
</a>
@endif
