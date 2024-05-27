<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
</head>
<body>
    <h1>Restablecer Contraseña</h1>
    <p>Hola,</p>
    <p>Has solicitado restablecer tu contraseña. Aquí tienes la información necesaria:</p>
    <p><strong>Código:</strong> {{ $codigo }}</p>
    <p><a href="{{ url('/catalogo/passwordback/codigo.php?email=' . $email . '&token=' . $token) }}">Da clic aquí para actualizar tu contraseña</a></p>
    <p>Gracias,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
