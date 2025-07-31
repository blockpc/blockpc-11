@props(['name', 'label' => null, 'type' => 'text', 'required' => false])

<div {{ $attributes->only('class') }}>
    @if ( $label )
    <label class="label" for="{{$name}}">
        <span>{{__($label)}}</span>
        @if ($required)
        <span class="ml-1 text-red-600 dark:text-red-400">*</span>
        @endif
    </label>
    @endif

    <input {{ $attributes->except('class') }} name="{{$name}}" id="{{$name}}" class="input input-sm border-dark p-2 @error( $attributes->wire('model')->value() ) border-error @enderror" type="{{$type}}" />

    @error( $attributes->wire('model')->value() )
        <div class="text-error">{{$message}}</div>
    @enderror
</div>
