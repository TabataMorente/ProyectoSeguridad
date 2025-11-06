<?php
session_start(); //inicia sesion para poder guardar los datos

//Verificar si hay sesion activa
        if(!isset($_SESSION['email']))
        {
                header("Location: /index.html?error=acceso_no_autorizado");
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

