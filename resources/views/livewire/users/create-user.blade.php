<div>
    <x-modal-small class="w/full md:w-1/2 border border-blue-500">
        <x-slot name="titulo">
            {{ __('pages.users.titles.create') }}
        </x-slot>
        <div class="pt-2">
            <form wire:submit.prevent="save">
                <div class="grid grid-cols-2 gap-4">
                    <x-inputs.text name="create_user_firstname" label="{{ __('pages.users.create.form.firstname') }}" wire:model="firstname" required />

                    <x-inputs.text name="create_user_lastname" label="{{ __('pages.users.create.form.lastname') }}" wire:model="lastname" required />

                    <div class="col-span-2">
                        <x-inputs.text name="create_user_email" label="{{ __('pages.users.create.form.email') }}" wire:model="email" autocomplete="username" required />
                    </div>

                    {{-- <div class="col-span-2">
                        <x-photo-user name="profile_user" :photo="$photo" wire:model="photo" />
                    </div> --}}

                    <x-inputs.text name="create_user_name" label="{{ __('pages.users.create.form.name') }}" wire:model="name" autocomplete="username" required />

                    <x-inputs.select name="role" label="{{ __('pages.users.create.form.role_id') }}" :options="$this->roles" wire:model="role_id" required />
                </div>
                <div class="flex justify-end mt-4">
                    <x-buttons.submit class="btn-primary">
                        {{ __('common.save') }}
                    </x-buttons.submit>
                </div>
            </form>
        </div>
    </x-modal-small>
</div>
