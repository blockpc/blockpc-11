@props(['title' => null])

<fieldset {{ $attributes->merge(['class' => 'fieldset']) }}>
    @if ( $title )
    <legend class="legend">{{ __($title) }}</legend>
    @endif

    <div>{{ $slot }}</div>
</fieldset>
