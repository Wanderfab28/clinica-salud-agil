<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Registrar paciente | Clínica Salud Ágil</title>
<style>
body{font-family:Arial,sans-serif;background:#f1f5f9;margin:0;padding:30px;color:#1e293b}
.contenedor{max-width:700px;margin:auto;background:white;padding:30px;border-radius:12px;box-shadow:0 4px 15px #00000012}
h1{color:#1769aa}
label{display:block;margin-top:15px;font-weight:bold}
input,select,textarea{width:100%;box-sizing:border-box;padding:11px;margin-top:6px;border:1px solid #cbd5e1;border-radius:6px}
button,.boton{display:inline-block;margin-top:20px;padding:12px 18px;background:#1769aa;color:white;border:0;border-radius:6px;text-decoration:none;cursor:pointer}
.error{color:#b91c1c;font-size:14px}
</style>
</head>
<body>
<div class="contenedor">
<h1>Clínica Salud Ágil</h1>
<h2>Registrar paciente</h2>
<p>Completa los datos para registrar un nuevo paciente.</p>

@if ($errors->any())
<div class="error">
<ul>
@foreach ($errors->all() as $error)
<li>{{ $error }}</li>
@endforeach
</ul>
</div>
@endif

<form method="POST" action="{{ route('pacientes.store') }}">
@csrf

<label for="nombre_completo">Nombre completo *</label>
<input id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo') }}" maxlength="150" required>

<label for="documento_identidad">Documento de identidad *</label>
<input id="documento_identidad" name="documento_identidad" value="{{ old('documento_identidad') }}" maxlength="30" required>

<label for="fecha_nacimiento">Fecha de nacimiento *</label>
<input type="date" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>

<label for="sexo">Sexo</label>
<select id="sexo" name="sexo">
<option value="">Seleccionar</option>
<option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
<option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Femenino</option>
</select>

<label for="telefono">Teléfono</label>
<input id="telefono" name="telefono" value="{{ old('telefono') }}" maxlength="30">

<label for="correo">Correo electrónico</label>
<input type="email" id="correo" name="correo" value="{{ old('correo') }}" maxlength="150">

<label for="direccion">Dirección</label>
<textarea id="direccion" name="direccion" maxlength="255">{{ old('direccion') }}</textarea>

<button type="submit">Guardar paciente</button>
<a class="boton" href="{{ route('pacientes.index') }}">Volver al listado</a>
</form>
</div>
</body>
</html>
