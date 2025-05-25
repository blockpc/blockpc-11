@props(['name', 'photo' => null])

<div class="flex flex-col md:flex-row text-xs md:text-sm items-center">
    <label class="w-full md:w-1/3" for="{{ $name }}">{{__('common.upload-photo')}}</label>
    <div class="flex flex-col space-y-2 w-full md:w-2/3 mt-1 md:mt-0">
        <div class="flex flex-1 space-x-2">
            <div class="flex items-center h-20 w-20 rounded-full overflow-hidden">
                @if ($photo instanceof \Livewire\TemporaryUploadedFile && $photo->exists())
                    <img class="h-16 w-16 rounded-full" src="{{ $photo->temporaryUrl() }}">
                @else
                    <img class="h-16 w-16 rounded-full" src="{{ image_profile() }}">
                @endif
            </div>
            <div class="overflow-hidden relative w-full my-auto"
                x-data="{ isUploading: false, progress: 0 }"
                x-on:livewire-upload-start="isUploading = true"
                x-on:livewire-upload-finish="isUploading = false"
                x-on:livewire-upload-error="isUploading = false"
                x-on:livewire-upload-progress="progress = $event.detail.progress">
                <button type="button" class="text-dark font-bold py-2 px-4 w-full inline-flex items-center bg-gray-200 dark:bg-gray-600 rounded-md h-8">
                    <x-bx-upload class="h-4 w-4"/>
                    <div class="ml-2 flex w-full justify-between items-center">
                        <span class="whitespace-pre">{{__('common.upload-photo')}}</span>
                        @if ( $photo )
                        <span class="ml-2 xl:text-xs">{{ $photo->getClientOriginalName()}}</span>
                        @endif
                    </div>
                </button>
                <input class="cursor-pointer absolute block py-2 px-4 w-full opacity-0 top-0 h-8" type="file" wire:model="{{ $attributes->wire('model')->value() }}" id="{{ $name }}" accept="image/*">
                <!-- Progress Bar -->
                <div class="px-2 pt-2" x-show="isUploading">
                    <progress class="w-full rounded" max="100" x-bind:value="progress"></progress>
                </div>
            </div>
        </div>
        @error($attributes->wire('model')->value())
            <div class="text-error">{{$message}}</div>
        @enderror
    </div>
</div>
