<div>
    <x-page-header titulo="pages.profile.titles.link" icon="heroicon-s-user">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">
        <div class="grid gap-8">

            <x-fieldset>
                <div class="grid lg:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <legend class="upper-legend">{{__('Sobre el Perfil')}}</legend>
                        <p class="legend italic">{{__('Datos asociados al usuario')}}</p>
                    </div>

                    <div class="lg:col-span-2">
                        <form wire:submit.prevent="updateProfile">
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
                                    <x-buttons.submit class="btn-primary">
                                        <span>{{ __('pages.profile.buttons.update') }}</span>
                                    </x-buttons.submit>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </x-fieldset>

            <x-fieldset>
                <div class="grid lg:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <legend class="upper-legend">{{__('Sobre la Contraseña')}}</legend>
                        <p class="legend italic">{{__('Cambio / actualización de clave de usuario.')}}</p>
                    </div>

                    <div class="lg:col-span-2">
                        <form wire:submit.prevent="updatePassword">
                            <div class="grid gap-4">
                                <x-inputs.password name="current_password" label="{{ __('pages.profile.form.current_password') }}" wire:model="current_password" autocomplete="new-password" />

                                <x-inputs.password name="password" label="{{ __('pages.profile.form.password') }}" wire:model="password" autocomplete="new-password" />

                                <x-inputs.password name="password_confirmation" label="{{ __('pages.profile.form.password_confirmation') }}" wire:model="password_confirmation" autocomplete="new-password" />

                                <div class="flex justify-end">
                                    <x-buttons.submit class="btn-primary">
                                        <span>{{ __('pages.profile.buttons.update-password') }}</span>
                                    </x-buttons.submit>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </x-fieldset>

            <x-fieldset>
                <div class="grid lg:grid-cols-3 gap-4">
                    <div class="flex flex-col">
                        <legend class="upper-legend">{{__('Eliminación de la Cuenta')}}</legend>
                        <p class="legend italic">{{__('Eliminación de la cuenta de usuario.')}}</p>
                    </div>

                    <div class="lg:col-span-2">
                        <form wire:submit.prevent="deleteAccount">
                            <div class="grid gap-4">
                                <x-inputs.text type="email" name="delete_email" label="{{ __('pages.profile.form.email') }}" wire:model="delete_email" />

                                <x-inputs.password name="delete_current_password" label="{{ __('pages.profile.form.current_password') }}" wire:model="delete_current_password" autocomplete="new-password" />

                                <div class="flex justify-end">
                                    <x-buttons.submit class="btn-danger">
                                        <span>{{ __('pages.profile.buttons.delete-account') }}</span>
                                    </x-buttons.submit>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </x-fieldset>

        </div>
    </section>
</div>
