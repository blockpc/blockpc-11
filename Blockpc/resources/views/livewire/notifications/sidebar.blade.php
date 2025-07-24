<div>
    <div x-data="{sidebar: @entangle('sidebar')}">
        <!-- Panel -->
        <section class="fixed inset-y-0 right-0 z-20 w-full max-w-xs bg-dark shadow-xl text-dark sm:max-w-md focus:outline-none border-l border-gray-600 dark:border-gray-800" aria-labelledby="notifications"
            x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            x-ref="settingsPanel"
            tabindex="-1"
            x-show="sidebar"
            x-cloak
        >
            <!-- Panel content -->
            <div class="flex flex-col h-screen">
                <!-- Panel header -->
                <div class="flex items-center justify-between flex-shrink-0 h-16 bg-white dark:bg-gray-800 px-4">
                    <div class="flex items-center space-x-2">
                        <x-bx-bell class="h-6 w-6" />
                        <h2 id="notifications" class="text-xl font-medium">Notificaciones</h2>
                    </div>
                    <div>
                        <button wire:click="open_new_notification" class="p-2 rounded-md focus:outline-none focus:ring">
                            <x-bx-plus class="w-6 h-6" />
                        </button>
                        <button wire:click="hide_sidebar" class="p-2 rounded-md focus:outline-none focus:ring">
                            <x-bx-x class="w-6 h-6" />
                        </button>
                    </div>
                </div>
                <!-- Content -->
                <div class="flex-1 overflow-hidden hover:overflow-y-auto p-2 scrollbar-thin scrollbar-thumb-gray-500 scrollbar-track-gray-700">

                    @forelse ($notifications as $key => $notification)
                        @if ( $notification->type == 'sistema' )
                            <x-blockpc::notifications.sistema :notification="$notification" />
                        @endif

                        @if ( $notification->type == 'info' )
                            <x-blockpc::notifications.info :notification="$notification" />
                        @endif

                        @if ( $notification->type == 'danger' )
                            <x-blockpc::notifications.error :notification="$notification" />
                        @endif

                        @if ( $notification->type == 'warning' )
                            <x-blockpc::notifications.warning :notification="$notification" />
                        @endif

                        @if ( $notification->type == 'success' )
                            <x-blockpc::notifications.success :notification="$notification" />
                        @endif
                    @empty
                        <p class="text-center text-lg italic font-semibold">Sin notificaciones pendientes</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>

    <x-loading title="Enviando Respuesta" wire:target="send_response">
        <p class="text-sm">{{__('common.load-message')}}</p>
    </x-loading>

    <x-blockpc::notifications.response class="w-full lg:w-1/2 border-2 border-blue-800">
        <x-slot name="titulo">{{__('Responder al usuario')}}</x-slot>
        <x-slot name="action">
            <x-buttons.cancel wire:click="close_response" />
        </x-slot>
        <div class="grid gap-4">
            @if ( $user_to_response )
                <div class="flex items-center flex-col lg:flex-row">
                    <label class="label w-full lg:w-1/3">Usuario Destino</label>
                    <div class="w-full lg:w-2/3">{{ $user_to_response->fullname }}</div>
                </div>

                <x-inputs.select label="Tipo Respuesta" name="type_select_response" title="Tipo de respuesta" :options="$this->types" wire:model="response_type_id" required />

                <x-inputs.textarea label="Mensaje" name="message_user_response" title="Mensaje" wire:model="response_message" required />

                <div class="flex justify-end items-center space-x-2">
                    <x-buttons.cancel wire:click="close_response" />
                    <x-buttons.info wire:click="send_response">{{__('common.answer')}}</x-buttons.info>
                </div>
            @endif
        </div>
    </x-blockpc::notifications.response>

    <x-blockpc::notifications.notification class="w-full lg:w-1/2 border-2 border-blue-800">
        <x-slot name="titulo">{{__('Nueva Notificación')}}</x-slot>
        <x-slot name="action">
            <x-buttons.cancel wire:click="close_new_notification" />
        </x-slot>
        <div class="grid gap-4 mt-4">
                <x-inputs.select label="Tipo Respuesta" name="type_select_response_new_notification" title="Tipo de respuesta" :options="$this->types" wire:model="response_type_id" required />

                <x-inputs.select label="Destinatario" name="user_to_response_new_notification" title="Usuario Destino" :options="$this->users" wire:model="notification_user_id" required />

                <x-inputs.textarea label="Mensaje" name="message_user_response_new_notification" title="Mensaje" wire:model="response_message" required />

                <div class="flex justify-end items-center space-x-2">
                    <x-buttons.cancel wire:click="close_new_notification" />
                    <x-buttons.info wire:click="send_new_notification">{{__('Enviar Notificación')}}</x-buttons.info>
                </div>
        </div>
    </x-blockpc::notifications.notification>
</div>
