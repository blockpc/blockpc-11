@component('mail::message')
# Correo Contacto

{{$data['firstname']}} {{$data['lastname']}}

{{$data['email']}}

@component('mail::panel')
{{$data['message']}}
@endcomponent

@component('mail::footer')
Thanks, {{ config('app.name') }}
@endcomponent
@endcomponent
