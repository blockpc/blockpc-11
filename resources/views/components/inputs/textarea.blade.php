@props(['name', 'label', 'required' => false])

<div class="">
    <label class="label" for="{{$name}}">
        <span>{{title(__($label))}}</span>
        @if ($required)
        <span class="ml-1 text-red-600 dark:text-red-400">*</span>
        @endif
    </label>

    <textarea {{ $attributes->except('class') }} name="{{$name}}" id="{{$name}}" class="textarea scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-700 @error( $attributes->wire('model')->value() ) border-error @enderror" placeholder="{{__($label)}}" rows="3"></textarea>

    @error( $attributes->wire('model')->value() )
    <div class="text-error">{{$message}}</div>
    @enderror
</div>
