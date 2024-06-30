@props(['name', 'label', 'type' => 'text', 'tooltip' => null])

<div class="">
    <label class="label" for="{{$name}}">{{__($label)}}</label>

    <input {{ $attributes->except('class') }} name="{{$name}}" id="{{$name}}" class="input input-sm border-dark p-2 @error( $attributes->wire('model')->value() ) border-error @enderror" type="{{$type}}" title="{{ $tooltip }}" placeholder="{{__($label)}}" />

    @error( $attributes->wire('model')->value() )
        <div class="text-error">{{$message}}</div>
    @enderror
</div>
