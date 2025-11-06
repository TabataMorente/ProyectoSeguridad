<?php
session_start();

// Destruir todos los datos de sesión
session_unset();     // Limpia las variables de sesión
session_destroy();   // Elimina la sesión en el servidor

// Borrar la cookie de sesión (opcional pero recomendado)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirigir al usuario a la página principal
header("Location: /index.html?logout=ok");
exit;
?>