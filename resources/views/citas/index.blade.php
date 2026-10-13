<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Agenda médica | Clínica Salud Ágil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }
        .contenedor {
            max-width: 1250px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000012;
            overflow-x: auto;
        }
        h1 { color: #1769aa; }
        .boton {
            display: inline-block;
            padding: 9px 12px;
            background: #1769aa;
            color: white;
            text-decoration: none;
            border: 0;
            border-radius: 6px;
            cursor: pointer;
            font-size: 13px;
        }
        .cancelar { background: #c62828; }
        .mensaje {
            padding: 12px;
            margin: 15px 0;
            border-radius: 6px;
            background: #e8f5e9;
            color: #256029;
        }
        .error {
            background: #ffebee;
            color: #b71c1c;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            min-width: 1000px;
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 10px;
            text-align: left;
        }
        th { background: #eaf2f8; }
        tr:nth-child(even) { background: #f8fafc; }
        .acciones {
            display: flex;
            gap: 8px;
            align-items: center;
        }
        .estado { font-weight: bold; }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Clínica Salud Ágil</h1>
    <h2>Agenda de citas médicas</h2>
    <p>Programa y consulta las citas de pacientes con los médicos de la clínica.</p>

    <a class="boton" href="{{ route('citas.create') }}">+ Programar cita</a>
    <a class="boton" href="{{ route('pacientes.index') }}">Pacientes</a>
    <a class="boton" href="{{ route('medicos.index') }}">Médicos</a>

    @if (session('success'))
        <div class="mensaje">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="mensaje error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="mensaje error">
            <strong>Se encontraron errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Paciente</th>
                <th>Médico</th>
                <th>Especialidad</th>
                <th>Motivo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($citas as $cita)
            <tr>
                <td>{{ $cita->id_cita }}</td>
                <td>{{ $cita->fecha_cita }}</td>
                <td>{{ substr((string) $cita->hora_cita, 0, 5) }}</td>
                <td>{{ $cita->paciente }}</td>
                <td>{{ $cita->medico }}</td>
                <td>{{ $cita->especialidad }}</td>
                <td>{{ $cita->motivo ?: 'Sin motivo indicado' }}</td>
                <td class="estado">{{ str_replace('_', ' ', $cita->estado) }}</td>
                <td>
                    <div class="acciones">
                        <a class="boton"
                           href="{{ route('citas.edit', $cita->id_cita) }}">
                            Editar
                        </a>

                        @if (!in_array($cita->estado, ['CANCELADA', 'ATENDIDA', 'NO_ASISTIO'], true))
                            <form method="POST"
                                  action="{{ route('citas.destroy', $cita->id_cita) }}"
                                  onsubmit="return confirm('¿Confirmas la cancelación de esta cita?')">
                                @csrf
                                @method('DELETE')
                                <button class="boton cancelar" type="submit">
                                    Cancelar
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">Todavía no hay citas registradas.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $citas->links() }}
</div>
</body>
</html>
