
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pacientes | Clínica Salud Ágil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }
        .contenedor {
            max-width: 1100px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000012;
        }
        h1 { color: #1769aa; }
        .boton {
            display: inline-block;
            padding: 10px 14px;
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
        .vacio { padding: 25px; text-align: center; }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Clínica Salud Ágil</h1>
    <h2>Gestión de pacientes</h2>
    <p>Consulta y administra los pacientes registrados en el sistema.</p>

    <a class="boton" href="{{ route('pacientes.create') }}">
        + Registrar paciente
    </a>

    @if (session('success'))
        <div class="mensaje">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="mensaje error">{{ session('error') }}</div>
    @endif

    @if ($errors->any())
        <div class="mensaje error">
            <strong>Revisa los siguientes errores:</strong>
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
                <th>Nombre completo</th>
                <th>Documento</th>
                <th>Fecha de nacimiento</th>
                <th>Teléfono</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($pacientes as $paciente)
            <tr>
                <td>{{ $paciente->id_paciente }}</td>
                <td>{{ $paciente->nombre_completo }}</td>
                <td>{{ $paciente->documento_identidad }}</td>
                <td>{{ $paciente->fecha_nacimiento }}</td>
                <td>{{ $paciente->telefono }}</td>
                <td>
                    <div class="acciones">
                        <a class="boton"
                           href="{{ route('pacientes.edit', $paciente->id_paciente) }}">
                            Editar
                        </a>

                        <form method="POST"
                              action="{{ route('pacientes.destroy', $paciente->id_paciente) }}"
                              onsubmit="return confirm('¿Confirmas que deseas eliminar este paciente?')">
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
                <td colspan="6" class="vacio">
                    Todavía no hay pacientes registrados.
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{ $pacientes->links() }}
</div>
</body>
</html>
