<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Médicos | Clínica Salud Ágil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }
        .contenedor {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000012;
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
        }
        .eliminar { background: #c62828; }
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
        }
        th, td {
            border: 1px solid #e2e8f0;
            padding: 11px;
            text-align: left;
        }
        th { background: #eaf2f8; }
        tr:nth-child(even) { background: #f8fafc; }
        .acciones { display: flex; gap: 8px; }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Clínica Salud Ágil</h1>
    <h2>Gestión de médicos</h2>
    <p>Consulta y administra los médicos registrados en el sistema.</p>

    <a class="boton" href="{{ route('medicos.create') }}">
        + Registrar médico
    </a>

    <a class="boton" href="{{ route('pacientes.index') }}">
        Ver pacientes
    </a>

    @if (session('success'))
        <div class="mensaje">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="mensaje error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="mensaje error">
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
                <th>Médico</th>
                <th>Correo</th>
                <th>Especialidad</th>
                <th>Colegiatura</th>
                <th>Teléfono</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($medicos as $medico)
            <tr>
                <td>{{ $medico->id_medico }}</td>
                <td>{{ $medico->nombre_completo }}</td>
                <td>{{ $medico->correo }}</td>
                <td>{{ $medico->especialidad }}</td>
                <td>{{ $medico->numero_colegiatura ?: 'No indicada' }}</td>
                <td>{{ $medico->telefono ?: 'No indicado' }}</td>
                <td>{{ $medico->activo ? 'Activo' : 'Inactivo' }}</td>
                <td>
                    <div class="acciones">
                        <a class="boton"
                           href="{{ route('medicos.edit', $medico->id_medico) }}">
                            Editar
                        </a>

                        <form method="POST"
                              action="{{ route('medicos.destroy', $medico->id_medico) }}"
                              onsubmit="return confirm('¿Deseas eliminar este médico?')">
                            @csrf
                            @method('DELETE')
                            <button class="boton eliminar" type="submit">
                                Eliminar
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">Todavía no hay médicos registrados.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $medicos->links() }}
</div>
</body>
</html>
