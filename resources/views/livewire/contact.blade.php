<div class="flex flex-col justify-between items-center h-screen-nav">
    <div class="w-full md:w-9/12 lg:w-8/12 px-6 lg:px-32">
        <img class="w-48 mx-auto py-6" src="{{ asset('img/logo150x75.png') }}" alt="BlockPC" />
    </div>
    <section class="w-full md:w-9/12 lg:w-8/12 px-6 sm:px-12">
        <form wire:submit.prevent="submit">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <x-inputs.text name="contact_firstname" label="{{ __('pages.users.attributes.form.firstname') }}" wire:model="firstname" placeholder="{{ __('pages.users.attributes.form.firstname') }}" />

                <x-inputs.text name="contact_lastname" label="{{ __('pages.users.attributes.form.lastname') }}" wire:model="lastname" placeholder="{{ __('pages.users.attributes.form.lastname') }}" />

                <div class="col-span-2">
                    <x-inputs.text name="contact_email" label="{{ __('pages.users.attributes.form.email') }}" wire:model="email" autocomplete="username" required placeholder="{{ __('pages.users.attributes.form.email') }}" />
                </div>

                <div class="col-span-2">
                    <x-inputs.textarea name="contact_message" label="{{ __('Mensaje') }}" wire:model="message" required rows="6" />
                </div>

                <x-inputs.text name="contact_resultado" wire:model="resultado" required placeholder="{{$numero_uno}} + {{$numero_dos}}" />

                <x-buttons.submit class="btn-primary">
                    {{ __('Enviar Correo') }}
                </x-buttons.submit>
            </div>
        </form>
    </section>
</div>
