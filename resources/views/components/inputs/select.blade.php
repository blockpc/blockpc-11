@props(['name', 'options', 'label' => null, 'required' => false, 'showError' => true, 'tooltip' => null])

<div {{ $attributes->only('class') }}>
    @if ( $label)
        <label class="label mb-1 mx-2" for="{{$name}}">
            <span>{{ $label }}</span>
            @if ($required)
            <span class="ml-1 text-red-600 dark:text-red-400">*</span>
            @endif
        </label>
    @endif

    <div class="flex flex-col space-y-2 w-full">
        <select {{ $attributes->except('class') }} name="{{$name}}" id="{{$name}}" class="select text-sm scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-700 @error( $attributes->wire('model')->value() ) border-error @enderror" title="{{ $tooltip }}">
            <option wire:key="0">{{__('common.select')}}...</option>
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
