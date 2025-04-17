<div>
    <x-page-header titulo="pages.profile.titles.link" icon="heroicon-s-user">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">
        <div class="grid gap-4">

            <x-fieldset class="" title="Sobre el Perfil">
                <form class="w-full md:w-1/2" wire:submit.prevent="updateProfile">
                    <div class="grid grid-cols-2 gap-4">
                        <x-inputs.text name="firstname" label="{{ __('pages.profile.form.firstname') }}" wire:model="firstname" />

                        <x-inputs.text name="lastname" label="{{ __('pages.profile.form.lastname') }}" wire:model="lastname" />

                        <div class="col-span-2">
                            <x-inputs.text name="email" label="{{ __('pages.profile.form.email') }}" wire:model="email" autocomplete="username" />
                        </div>

                        <div class="col-span-2">
                            <x-photo-user name="profile_user" :photo="$photo" wire:model="photo" />
                        </div>

                        <div class="col-span-2 flex justify-end">
                            <x-buttons.submit class="bg-blue-600 hover:bg-blue-500 border border-transparent rounded-md font-semibold text-white uppercase tracking-wider focus:outline-none focus:border-blue-900 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('pages.profile.buttons.update') }}
                            </x-buttons.submit>
                        </div>
                    </div>
                </form>
            </x-fieldset>

            <x-fieldset title="Sobre la Contraseña">
                <form class="w-full md:w-1/2" wire:submit.prevent="updatePassword">
                    <div class="grid gap-4">
                        <x-inputs.password name="current_password" label="{{ __('pages.profile.form.current_password') }}" wire:model="current_password" autocomplete="new-password" />

                        <x-inputs.password name="password" label="{{ __('pages.profile.form.password') }}" wire:model="password" autocomplete="new-password" />

                        <x-inputs.password name="password_confirmation" label="{{ __('pages.profile.form.password_confirmation') }}" wire:model="password_confirmation" autocomplete="new-password" />
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-buttons.submit class="btn-primary">
                            {{ __('pages.profile.buttons.update-password') }}
                        </x-buttons.submit>
                    </div>
                </form>
            </x-fieldset>

            <x-fieldset title="Eliminación de la Cuenta">
                <form class="w-full md:w-1/2" wire:submit.prevent="deleteAccount">
                    <div class="grid gap-4">
                        <x-inputs.text type="email" name="delete_email" label="{{ __('pages.profile.form.email') }}" wire:model="delete_email" />

                        <x-inputs.password name="delete_current_password" label="{{ __('pages.profile.form.current_password') }}" wire:model="delete_current_password" autocomplete="new-password" />
                    </div>
                    <div class="flex justify-end mt-4">
                        <x-buttons.submit class="btn-danger">
                            {{ __('pages.profile.buttons.delete-account') }}
                        </x-buttons.submit>
                    </div>
                </form>
            </x-fieldset>

        </div>
    </section>
</div>
