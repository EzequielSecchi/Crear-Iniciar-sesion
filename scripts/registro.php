<?php
// Iniciamos la "sesión". Una sesión es como una memoria temporal que PHP
// guarda en el servidor para recordar datos del usuario entre páginas.
// SIEMPRE tiene que ir al principio del archivo, antes de cualquier otra cosa.
session_start();

// Incluimos el archivo de conexión que creamos antes.
// "require_once" significa: "traé ese archivo, y si no existe, pará todo".
require_once "conexion.php";

// Verificamos que el formulario fue enviado por el método POST.
// $_POST es un array que contiene todos los datos que el formulario envió.
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Leemos el mail y la contraseña que escribió el usuario.
    // trim() elimina espacios al inicio y al final (ej: " hola " → "hola").
    $email     = trim($_POST["mail-crear"] ?? "");
    $clave     = $_POST["contrasena-crear"] ?? "";
    $clave2    = $_POST["confirmar-contrasena"] ?? "";

    // --- VALIDACIONES ---

    // Verificamos que el mail tenga un formato válido (que tenga @ y dominio).
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Guardamos el error en la sesión para mostrarlo en la página.
        $_SESSION["error_registro"] = "El mail no es válido.";
        header("Location: ../index.php");
        exit;
    }

    // Verificamos que las dos contraseñas escritas sean iguales.
    if ($clave !== $clave2) {
        $_SESSION["error_registro"] = "Las contraseñas no coinciden.";
        header("Location: ../index.php");
        exit;
    }

    // Verificamos que la contraseña tenga al menos 6 caracteres.
    if (strlen($clave) < 6) {
        $_SESSION["error_registro"] = "La contraseña debe tener al menos 6 caracteres.";
        header("Location: ../index.php");
        exit;
    }

    // --- VERIFICAR SI EL MAIL YA EXISTE ---

    // Preparamos una consulta SQL para buscar si ya existe ese mail.
    // El "?" es un placeholder seguro. Nunca ponemos el dato directo en el SQL
    // para evitar ataques de inyección SQL (SQL injection).
    $consulta = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
    
    // Ejecutamos la consulta reemplazando el "?" con el email real.
    $consulta->execute([$email]);

    if ($consulta->rowCount() > 0) {
        // rowCount() devuelve cuántas filas encontró. Si encontró alguna,
        // ese mail ya está registrado.
        $_SESSION["error_registro"] = "Ese mail ya está registrado.";
        header("Location: ../index.php");
        exit;
    }

    // --- GUARDAR EL USUARIO ---

    // password_hash() encripta la contraseña. Nunca guardamos la contraseña
    // en texto plano. PASSWORD_DEFAULT usa el algoritmo más seguro disponible.
    $hash = password_hash($clave, PASSWORD_DEFAULT);

    // Preparamos el INSERT para agregar el nuevo usuario.
    $insertar = $pdo->prepare("INSERT INTO usuarios (email, password_hash) VALUES (?, ?)");
    
    // Ejecutamos con los datos reales (email y la contraseña encriptada).
    $insertar->execute([$email, $hash]);

    // Guardamos un mensaje de éxito en la sesión para mostrarlo en la página.
    $_SESSION["exito_registro"] = "Cuenta creada correctamente. Ya podés iniciar sesión.";

    // Redirigimos al usuario de vuelta a la página principal.
    // header("Location: ...") es como decirle al navegador "andá a esta URL".
    header("Location: ../index.php");
    exit; // Siempre ponemos exit después de un redirect para detener el script.
}
