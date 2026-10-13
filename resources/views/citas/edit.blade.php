<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar cita | Clínica Salud Ágil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            margin: 0;
            padding: 30px;
            color: #1e293b;
        }
        .contenedor {
            max-width: 700px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px #00000012;
        }
        h1 { color: #1769aa; }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 11px;
            margin-top: 6px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }
        .boton {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 18px;
            background: #1769aa;
            color: white;
            border: 0;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }
        .error {
            padding: 12px;
            background: #ffebee;
            color: #b71c1c;
            border-radius: 6px;
        }
    </style>
</head>
<body>
<div class="contenedor">
    <h1>Clínica Salud Ágil</h1>
    <h2>Editar cita médica</h2>
    <p>Actualiza los datos de la cita seleccionada.</p>

    @if ($errors->any())
        <div class="error">
            <strong>Revisa los datos introducidos:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('citas.update', $cita->id_cita) }}">
        @csrf
        @method('PUT')

        <label for="id_paciente">Paciente *</label>
        <select id="id_paciente" name="id_paciente" required>
            @foreach ($pacientes as $paciente)
                <option value="{{ $paciente->id_paciente }}"
                    {{ (string)old('id_paciente', $cita->id_paciente) === (string)$paciente->id_paciente ? 'selected' : '' }}>
                    {{ $paciente->nombre_completo }}
                </option>
            @endforeach
        </select>

        <label for="id_medico">Médico *</label>
        <select id="id_medico" name="id_medico" required>
            @foreach ($medicos as $medico)
                <option value="{{ $medico->id_medico }}"
                    {{ (string)old('id_medico', $cita->id_medico) === (string)$medico->id_medico ? 'selected' : '' }}>
                    {{ $medico->nombre_completo }} — {{ $medico->especialidad }}
                </option>
            @endforeach
        </select>

        <label for="fecha_cita">Fecha de la cita *</label>
        <input type="date" id="fecha_cita" name="fecha_cita"
               value="{{ old('fecha_cita', $cita->fecha_cita) }}"
               required>

        <label for="hora_cita">Hora de la cita *</label>
        <input type="time" id="hora_cita" name="hora_cita"
               value="{{ old('hora_cita', substr((string)$cita->hora_cita, 0, 5)) }}"
               required>

        <label for="motivo">Motivo de la consulta</label>
        <textarea id="motivo" name="motivo" maxlength="500"
                  rows="3">{{ old('motivo', $cita->motivo) }}</textarea>

        <label for="estado">Estado *</label>
        <select id="estado" name="estado" required>
            @foreach ([
                'PROGRAMADA' => 'Programada',
                'CONFIRMADA' => 'Confirmada',
                'ATENDIDA' => 'Atendida',
                'CANCELADA' => 'Cancelada',
                'NO_ASISTIO' => 'No asistió'
            ] as $valor => $etiqueta)
                <option value="{{ $valor }}"
                    {{ old('estado', $cita->estado) === $valor ? 'selected' : '' }}>
                    {{ $etiqueta }}
                </option>
            @endforeach
        </select>

        <label for="observaciones">Observaciones</label>
        <textarea id="observaciones" name="observaciones"
                  maxlength="1000" rows="3">{{ old('observaciones', $cita->observaciones) }}</textarea>

        <button class="boton" type="submit">Guardar cambios</button>
        <a class="boton" href="{{ route('citas.index') }}">Volver a la agenda</a>
    </form>
</div>
</body>
</html>
