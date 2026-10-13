<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar médico | Clínica Salud Ágil</title>
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
        input, select {
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
    <h2>Editar médico</h2>
    <p>Actualiza la información del médico seleccionado.</p>

    @if ($errors->any())
        <div class="error">
            <strong>Revisa los siguientes errores:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST"
          action="{{ route('medicos.update', $medico->id_medico) }}">
        @csrf
        @method('PUT')

        <label for="id_usuario">Usuario asociado *</label>
        <select id="id_usuario" name="id_usuario" required>
            @foreach ($usuarios as $usuario)
                <option value="{{ $usuario->id_usuario }}"
                    {{ (string)old('id_usuario', $medico->id_usuario) === (string)$usuario->id_usuario ? 'selected' : '' }}>
                    {{ $usuario->nombre_completo }} — {{ $usuario->correo }}
                </option>
            @endforeach
        </select>

        <label for="especialidad">Especialidad *</label>
        <input
            id="especialidad"
            name="especialidad"
            maxlength="100"
            value="{{ old('especialidad', $medico->especialidad) }}"
            required
        >

        <label for="numero_colegiatura">Número de colegiatura</label>
        <input
            id="numero_colegiatura"
            name="numero_colegiatura"
            maxlength="50"
            value="{{ old('numero_colegiatura', $medico->numero_colegiatura) }}"
        >

        <label for="telefono">Teléfono</label>
        <input
            id="telefono"
            name="telefono"
            maxlength="30"
            value="{{ old('telefono', $medico->telefono) }}"
        >

        <label for="activo">Estado del médico *</label>
        <select id="activo" name="activo" required>
            <option value="1"
                {{ (string)old('activo', $medico->activo) === '1' ? 'selected' : '' }}>
                Activo
            </option>
            <option value="0"
                {{ (string)old('activo', $medico->activo) === '0' ? 'selected' : '' }}>
                Inactivo
            </option>
        </select>

        <button class="boton" type="submit">Guardar cambios</button>
        <a class="boton" href="{{ route('medicos.index') }}">Cancelar</a>
    </form>
</div>
</body>
</html>
