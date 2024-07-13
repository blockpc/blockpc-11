<div>
    <x-page-header titulo="pages.users.titles.create" icon="heroicon-s-users">
        <x-slot name="buttons">
            <x-links.href class="btn-sm btn-default" href="{{ route('dashboard') }}">
                <span>{{__('pages.dashboard.titles.link')}}</span>
            </x-links.href>
            <x-links.href class="btn-sm btn-default" href="{{ route('users.table') }}">
                <span>{{__('pages.users.titles.link')}}</span>
            </x-links.href>
        </x-slot>
    </x-page-header>

    <section class="mt-2 mx-auto w-full">
        <div class="container md:w-1/2 mx-auto">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <x-inputs.text name="create_user_name" label="{{ __('pages.users.create.form.name') }}" wire:model="name" autocomplete="username" />
                    </div>

                    <div>
                        <x-inputs.text name="create_user_firstname" label="{{ __('pages.users.create.form.firstname') }}" wire:model="firstname" />
                    </div>

                    <div>
                        <x-inputs.text name="create_user_lastname" label="{{ __('pages.users.create.form.lastname') }}" wire:model="lastname" />
                    </div>

                    <div class="col-span-2">
                        <x-inputs.text name="create_user_email" label="{{ __('pages.users.create.form.email') }}" wire:model="email" autocomplete="username" />
                    </div>

                    <div class="col-span-2">
                        <x-photo-user name="profile_user" :photo="$photo" wire:model="photo" />
                    </div>

                    <div class="col-span-2">
                        <x-inputs.select name="role" title="{{ __('pages.users.create.form.role_id') }}" :options="$this->roles" wire:model="role_id" />
                    </div>
                </div>
                <div class="flex justify-end mt-4">
                    <x-buttons.submit class="btn-primary">
                        {{ __('common.save') }}
                    </x-buttons.submit>
                </div>
            </form>
        </div>
    </section>
</div>
