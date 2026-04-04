<?php
// Este archivo se encarga SOLO de conectarse a la base de datos.
// Los otros archivos PHP van a "incluirlo" para no repetir este código.

// Datos para conectarse a MySQL (los de XAMPP por defecto)
$host     = "localhost";   // El servidor de base de datos (en tu PC local siempre es este)
$bd       = "login_app";   // El nombre de la base de datos que creaste
$usuario  = "root";        // Usuario de MySQL (en XAMPP por defecto es "root")
$clave    = "";            // Contraseña de MySQL (en XAMPP por defecto está vacía)

// Intentamos conectarnos. PDO es la forma segura de conectar PHP con MySQL.
try {
    // Creamos la conexión con PDO.
    // El string "mysql:host=..." le dice a PHP qué motor usar y a dónde conectarse.
    // "charset=utf8" evita problemas con tildes y caracteres especiales.
    $pdo = new PDO("mysql:host=$host;dbname=$bd;charset=utf8", $usuario, $clave);

    // Esta línea hace que PHP muestre errores de base de datos si algo falla.
    // Muy útil mientras desarrollás. En producción (internet real) se quitaría.
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    // Si la conexión falla, mostramos el error y detenemos todo.
    // "die" significa "parar el programa aquí".
    die("Error de conexión: " . $e->getMessage());
}
