<?php
// Iniciamos la sesión para poder leer los mensajes que guardaron login.php y registro.php.
session_start();
?>
<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio de Sesion</title>
        <link rel="stylesheet" href="estilos/estilo1.css">
    </head>

    <body>
        <div class="bloque-inicio-secion">

            <?php
            // Si hay un usuario logueado en la sesión, mostramos el mensaje de bienvenida
            // y un botón para cerrar sesión. En vez del formulario.
            if (isset($_SESSION["usuario_id"])): ?>

                <h1>¡Bienvenido!</h1>
                <p class="mensaje-exito">
                    Iniciaste sesión como
                    <?php
                    // htmlspecialchars() convierte caracteres especiales en texto seguro.
                    // Evita que alguien inyecte código HTML malicioso (ataque XSS).
                    echo htmlspecialchars($_SESSION["usuario_email"]);
                    ?>
                </p>
                <a href="scripts/logout.php" class="boton-secundario" style="text-align:center;">Cerrar sesión</a>

            <?php else: ?>

                <!-- Formulario de inicio de sesión -->
                <!-- action apunta a login.php que procesa el formulario -->
                <form id="form-inicio" class="panel-formulario" action="scripts/login.php" method="post">
                    <h1>Iniciar Sesion</h1>

                    <?php if (!empty($_SESSION["error_login"])): ?>
                        <p class="mensaje-error">
                            <?php echo htmlspecialchars($_SESSION["error_login"]); ?>
                        </p>
                        <?php unset($_SESSION["error_login"]); ?>
                    <?php endif; ?>

                    <?php if (!empty($_SESSION["exito_registro"])): ?>
                        <p class="mensaje-exito">
                            <?php echo htmlspecialchars($_SESSION["exito_registro"]); ?>
                        </p>
                        <?php unset($_SESSION["exito_registro"]); ?>
                    <?php endif; ?>

                    <input type="email" name="mail-inicio" placeholder="Mail" required>
                    <input type="password" name="contrasena-inicio" placeholder="Contraseña" required>
                    <input type="submit" value="Iniciar Sesion">
                    <button type="button" id="btn-ir-crear" class="boton-secundario">Crear una cuenta</button>
                </form>

                <!-- Formulario de crear cuenta -->
                <form id="form-crear" class="panel-formulario oculto" action="scripts/registro.php" method="post">
                    <h1>Crear Cuenta</h1>

                    <?php if (!empty($_SESSION["error_registro"])): ?>
                        <p class="mensaje-error">
                            <?php echo htmlspecialchars($_SESSION["error_registro"]); ?>
                        </p>
                        <?php unset($_SESSION["error_registro"]); ?>
                    <?php endif; ?>

                    <input type="email" name="mail-crear" placeholder="Mail" required>
                    <input type="password" name="contrasena-crear" placeholder="Contraseña" required>
                    <input type="password" name="confirmar-contrasena" placeholder="Confirmar contraseña" required>
                    <input type="submit" value="Crear cuenta">
                    <button type="button" id="btn-volver-inicio" class="boton-secundario">Volver al inicio de sesion</button>
                </form>

            <?php endif; ?>

        </div>

        <script src="scripts/formularios.js"></script>
    </body>

</html>
