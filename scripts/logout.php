<?php
// Este archivo cierra la sesión del usuario.
session_start();

// Eliminamos todos los datos de la sesión.
session_destroy();

// Redirigimos a la página de inicio.
header("Location: ../index.php");
exit;
