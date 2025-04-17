@props(['name', 'label' => null, 'required' => false])

<div {{ $attributes->only('class') }} x-data="{show_password: true}">
    @if ( $label )
    <label class="label" for="{{$name}}">
        <span>{{title(__($label))}}</span>
        @if ($required)
        <span class="ml-1 text-red-600 dark:text-red-400">*</span>
        @endif
    </label>
    @endif

    <div class="flex items-center space-x-2">
        <input {{ $attributes->except('class') }} name="{{$name}}" id="{{$name}}" class="input input-sm border-dark p-2 @error( $attributes->wire('model')->value() ) border-error @enderror" :type="show_password ? 'password' : 'text'" />
        <button type="button" class="btn-sm btn-default" x-on:click="show_password = !show_password">
            <x-heroicon-o-eye class="w-4 h-4" x-show="show_password"  />
            <x-heroicon-o-eye-slash class="w-4 h-4" x-show="!show_password" />
        </button>
    </div>

    @error( $attributes->wire('model')->value() )
        <div class="text-error">{{$message}}</div>
    @enderror
</div>