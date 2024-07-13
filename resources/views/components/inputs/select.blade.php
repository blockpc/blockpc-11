@props(['name', 'title', 'options', 'required' => false, 'showError' => true, 'tooltip' => null])

<div class="flex flex-col text-xs font-semibold lg:text-sm">
    <label class="label" for="{{$name}}">{{title(__($title))}} {!! $required ? '<span class="ml-1 text-red-600 dark:text-red-400">*</span>' : '' !!}</label>
    <div class="flex flex-col space-y-2 w-full">
        <select {{ $attributes->except('class') }} name="{{$name}}" id="{{$name}}" class="text-sm select-sm scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-700 @error( $attributes->wire('model')->value() ) border-error @enderror" title="{{ $tooltip }}">
            <option value="" wire:key="0">{{__('common.select')}}...</option>
            @foreach ($options as $option_key => $option_value)
                <option value="{{ $option_key }}" wire:key="{{ $option_key }}">{{ __($option_value) }}</option>
            @endforeach
        </select>
        @if ( $showError )
        @error( $attributes->wire('model')->value() )
            <div class="text-error">{{$message}}</div>
        @enderror
        @endif
    </div>
</div>
