@if (Auth::check())
    @php
        $session = DB::table('sessions')
                    ->where('user_id', Auth::id())
                    ->first();

        $user = Auth::user(); // Obtener el usuario actual
    @endphp

    @if ($session && $user)
        <div class="px-4 card">
            <span class="my-1">Información de la sesión:</span>
            <span style="font-size: 10px;">Dirección IP: {{ $session->ip_address }}</span>
            <span class="mb-2" style="font-size: 10px;">Última actividad: {{ $session->last_activity }}</span>

        </div>
    @endif
@endif