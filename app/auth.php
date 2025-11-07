<?php
session_start(); //inicia sesion para poder guardar los datos

// Regenerar el ID de sesión periódicamente para evitar el secuestro de sesión
if (!isset($_SESSION['creada'])) {
    session_regenerate_id(true);
    $_SESSION['creada'] = time();
} elseif (time() - $_SESSION['creada'] > 300) { // cada 5 minutos
    session_regenerate_id(true);
    $_SESSION['creada'] = time();


//Verificar si hay sesion activa
        if(!isset($_SESSION['email']))
        {
                header("Location: /index.html?error=acceso_no_autorizado");
                exit;
        }

        //Verificar que hay parametro GET y que coincida con la sesion
        if (!isset($_GET['user']) || $_GET['user'] !== $_SESSION['email']) {
                echo "No tienes permiso para acceder a esta página.";
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

