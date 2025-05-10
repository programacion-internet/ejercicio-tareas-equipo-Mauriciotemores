{{-- resources/views/emails/invitacion-tarea.blade.php --}}
@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
{{ config('app.name') }}
@endcomponent
@endslot

{{-- Body --}}
# ¡Has sido invitado a una tarea!

**Tarea:** {{ $tarea->nombre }}  
**Descripción:** {{ $tarea->descripcion }}  
**Fecha límite:** {{ $tarea->fecha_limite->format('d/m/Y') }}  
**Creada por:** {{ $tarea->owner->name }}

@component('mail::button', ['url' => $url, 'color' => 'primary'])
Ver tarea en el sistema
@endcomponent

{{-- Saludo --}}
Saludos,<br>
El equipo de {{ config('app.name') }}

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.name') }}. Todos los derechos reservados.
@endcomponent
@endslot
@endcomponent