<div>
    <x-page-header titulo="pages.profile.titles.link" icon="heroicon-s-user">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">
        <div class="container md:w-1/2 mx-auto">
            <form wire:submit.prevent="updateProfile">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-inputs.text name="firstname" label="{{ __('pages.profile.form.firstname') }}" wire:model="firstname" />
                    </div>

                    <div>
                        <x-inputs.text name="lastname" label="{{ __('pages.profile.form.lastname') }}" wire:model="lastname" />
                    </div>

                    <div class="col-span-2">
                        <x-inputs.text name="email" label="{{ __('pages.profile.form.email') }}" wire:model="email" autocomplete="username" />
                    </div>

                    <div class="col-span-2">
                        <x-inputs.text type="file" name="photo" label="{{ __('pages.profile.form.photo') }}" wire:model="photo" />
                    </div>

                </div>
                <div class="flex justify-end mt-4">
                    <x-buttons.submit type="submit" class="btn-primary">
                        {{ __('pages.profile.buttons.update') }}
                    </x-buttons.submit>
                </div>
            </form>

            <hr class="hr">

            <form wire:submit.prevent="updatePassword">
                <div class="grid gap-4">
                    <div>
                        <x-inputs.text type="password" name="current_password" label="{{ __('pages.profile.form.current_password') }}" wire:model="current_password" autocomplete="new-password" />
                    </div>

                    <div>
                        <x-inputs.text type="password" name="password" label="{{ __('pages.profile.form.password') }}" wire:model="password" autocomplete="new-password" />
                    </div>

                    <div>
                        <x-inputs.text type="password" name="password_confirmation" label="{{ __('pages.profile.form.password_confirmation') }}" wire:model="password_confirmation" autocomplete="new-password" />
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <x-buttons.submit type="submit" class="btn-primary">
                        {{ __('pages.profile.buttons.update-password') }}
                    </x-buttons.submit>
                </div>
            </form>
    </section>
</div>
