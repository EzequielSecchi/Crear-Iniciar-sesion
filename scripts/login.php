<?php
// Siempre session_start() primero para poder usar $_SESSION.
session_start();

// Traemos la conexión a la base de datos.
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Leemos los datos del formulario de inicio de sesión.
    $email = trim($_POST["mail-inicio"] ?? "");
    $clave = $_POST["contrasena-inicio"] ?? "";

    // Validación básica: que no estén vacíos.
    if (empty($email) || empty($clave)) {
        $_SESSION["error_login"] = "Completá todos los campos.";
        header("Location: ../index.php");
        exit;
    }

    // Buscamos en la base de datos un usuario con ese email.
    $consulta = $pdo->prepare("SELECT id, email, password_hash FROM usuarios WHERE email = ?");
    $consulta->execute([$email]);

    // fetch() devuelve la fila encontrada como un array asociativo.
    // Si no encontró nada, devuelve false.
    $usuario = $consulta->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        // No existe ningún usuario con ese mail.
        // Usamos un mensaje genérico a propósito para no revelar si el mail existe.
        $_SESSION["error_login"] = "Mail o contraseña incorrectos.";
        header("Location: ../index.php");
        exit;
    }

    // password_verify() compara la contraseña escrita con el hash guardado.
    // Devuelve true si coinciden, false si no.
    if (!password_verify($clave, $usuario["password_hash"])) {
        $_SESSION["error_login"] = "Mail o contraseña incorrectos.";
        header("Location: ../index.php");
        exit;
    }

    // Si llegamos acá, las credenciales son correctas.
    // Guardamos el id y email del usuario en la sesión.
    // Esto es lo que usaremos en otras páginas para saber quién está logueado.
    $_SESSION["usuario_id"]    = $usuario["id"];
    $_SESSION["usuario_email"] = $usuario["email"];

    // Redirigimos a la página principal donde mostraremos "iniciaste sesión".
    header("Location: ../index.php");
    exit;
}
