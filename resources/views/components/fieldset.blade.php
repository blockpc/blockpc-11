@props(['title' => null, 'color' => 'gray'])

<fieldset class="fieldset">
    @if ( $title )
    <legend class="legend">{{ __($title) }}</legend>
    @endif

    {{ $slot }}
</fieldset>
