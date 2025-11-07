<?php
session_start();

// Generar el token CSRF si no existe
if (!isset($_SESSION['csrf_token'])) {
  $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Los MontaMarcos - Login</title>
	<link rel="stylesheet" type="text/css" href="login.css">
	<script type="text/javascript" src="login.js"></script>
</head>
<body>
  <div class="volver-container">
    <a href="../index.html">Volver al inicio</a>
  </div>

  <div class="container">
    <h1>Inicio de sesión</h1>
    <form class="login-form" id="login_form" action="login.php" method="POST">
      <input type="text" id="nombre" name="email" placeholder="email"/>
      <input type="password" id="contrasena" name="contrasena" placeholder="password"/>
      <input type="submit" class="boton" value="Iniciar sesi&oacute;n" id="login_submit"/>
      <p class="message">¿No registrado? <a href="/register/index.html" class="crear-cuenta">Crear cuenta</a></p>

      <!-- Token CSRF -->
      <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

    </form>
  </div>
<script>
  // Detecta si la URL tiene ?error=1 y muestra una alerta
  const params = new URLSearchParams(window.location.search);
  if (params.get('error') === '1') {
    alert('Usuario incorrecto');
  }
  else if (params.get('error') === '2') {
    alert('Contraseña incorrecta');
  }
  else if (params.get('error') === '3') {
    alert('Se deben rellenar los campos');
  }
  // Limpia la URL para que no se repita la alerta al refrescar
  const cleanUrl = window.location.origin + window.location.pathname;
  window.history.replaceState({}, document.title, cleanUrl);
</script>
</body>
</html>
