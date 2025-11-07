<?php
session_start(); //inicia sesion para poder guardar los datos

// Regenerar el ID de sesión periódicamente para evitar el secuestro de sesión
if (!isset($_SESSION['creada'])) {
    session_regenerate_id(true);
    $_SESSION['creada'] = time();
} elseif (time() - $_SESSION['creada'] > 300) 
{ // cada 5 minutos
    session_regenerate_id(true);
    $_SESSION['creada'] = time();
}


//Verificar si hay sesion activa
        if(!isset($_SESSION['email']))
        {
                header("Location: /index.html?error=acceso_no_autorizado");
                exit;
        }

        //Verificar que hay parametro GET y que coincida con la sesion
        if (!isset($_GET['user']) || $_GET['user'] !== $_SESSION['email']) {
                echo "No tienes permiso para acceder a esta página.";
                echo " 
                <style>
                .volver-container {
                position: absolute;
                top: 10px;
                right: 20px;
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                font-family: Arial, sans-serif;
                font-size: 16px;
                color: #333;
                gap: 5px;
                }

                .volver-container a {
                background: #4CAF50;
                color: white;
                padding: 8px 16px;
                border-radius: 5px;
                text-decoration: none;
                font-weight: bold;
                transition: background 0.3s ease;
                }

                .volver-container a:hover {
                background: #45a049;
                }
                </style>";
                echo "<div class='volver-container'>";
                echo "<a href='../index.html'>Volver</a>";
                echo "</div>";
                exit;
        }


$inactividad_max = 60*30;
if (isset($_SESSION['ultimo_acceso'])) {
    if (time() - $_SESSION['ultimo_acceso'] > $inactividad_max) {
        session_unset();
        session_destroy();
        header("Location: /index.html?error=session_expirada");
        exit;
    }
}

$_SESSION['ultimo_acceso'] = time();

// Generar token CSRF si no existe
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

