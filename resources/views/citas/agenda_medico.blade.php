<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mi agenda | Clínica Salud Ágil</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f1f5f9; margin: 0; padding: 24px; color: #1e293b; }
        main { max-width: 1150px; margin: auto; padding: 24px; background: white; border-radius: 12px; }
        h1 { color: #1769aa; }
        .barra { display: flex; justify-content: space-between; gap: 12px; flex-wrap: wrap; align-items: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 11px; border-bottom: 1px solid #e2e8f0; }
        th { background: #eaf2f8; }
        .boton { padding: 9px 12px; border: 0; border-radius: 6px; background: #1769aa; color: white; cursor: pointer; text-decoration: none; }
        .mensaje { padding: 12px; margin: 14px 0; background: #e8f5e9; border-radius: 6px; }
        .error { background: #ffebee; color: #b71c1c; }
        .vacio { padding: 20px 0; color: #64748b; }
        @media (max-width: 760px) {
            main { overflow-x: auto; }
            table { min-width: 700px; }
        }
    </style>
</head>
<body>
<main>
    <div class="barra">
        <div>
            <h1>Clínica Salud Ágil</h1>
            <h2>Mi agenda médica</h2>
            <p>Consulta tus citas asignadas y registra las consultas atendidas.</p>
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="boton" type="submit">Cerrar sesión</button>
        </form>
    </div>

    @if (session('success'))
        <div class="mensaje">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="mensaje error">{{ session('error') }}</div>
    @endif

    <table>
        <thead>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Paciente</th>
            <th>Motivo</th>
            <th>Estado</th>
            <th>Acción</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($citas as $cita)
            <tr>
                <td>{{ $cita->fecha_cita }}</td>
                <td>{{ substr((string) $cita->hora_cita, 0, 5) }}</td>
                <td>{{ $cita->paciente }}</td>
                <td>{{ $cita->motivo ?: 'Sin motivo indicado' }}</td>
                <td>{{ str_replace('_', ' ', $cita->estado) }}</td>
                <td>
                    @if (in_array($cita->estado, ['PROGRAMADA', 'CONFIRMADA'], true) && $cita->fecha_cita <= now()->toDateString())
                        <form method="POST" action="{{ route('medico.citas.atendida', $cita->id_cita) }}">
                            @csrf
                            <button class="boton" type="submit">Marcar atendida</button>
                        </form>
                    @else
                        —
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="vacio">No hay citas asignadas a tu ficha médica.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $citas->links() }}
</main>
</body>
</html>
