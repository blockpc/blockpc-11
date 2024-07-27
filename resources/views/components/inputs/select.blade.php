@props(['name', 'label', 'options', 'required' => false, 'showError' => true, 'tooltip' => null])

<div class="">
    <label class="label" for="{{$name}}">
        <span>{{title(__($label))}}</span>
        @if ($required)
        <span class="ml-1 text-red-600 dark:text-red-400">*</span>
        @endif
    </label>

    <div class="flex flex-col space-y-2 w-full">
        <select {{ $attributes->except('class') }} name="{{$name}}" id="{{$name}}" class="select scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-700 @error( $attributes->wire('model')->value() ) border-error @enderror" title="{{ $tooltip }}">
            <option value="" wire:key="0">{{__('common.select')}}...</option>
            @foreach ($options as $option_key => $option_value)
                <option value="{{ $option_key }}" wire:key="{{ $option_key }}">{{ __($option_value) }}</option>
            @endforeach
        </select>oi

        @if ( $showError )
        @error( $attributes->wire('model')->value() )
            <div class="text-error">{{$message}}</div>
        @enderror
        @endif
    </div>
</div>
