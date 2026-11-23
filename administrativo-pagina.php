<?php
session_start();


if (empty($_SESSION['usuario'])) {
    header("Location: administrativo-ingreso.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Gestión de usuarios — Administrador</title>
</head>
<body class="pagina-administrador">
    <div class="contenedor-administrador">
        <div class="registrar-usuario">
            <div class="encabezado-tarjeta">
                <span class="subtitulo-marca">Estudio de Maquillaje</span>
                <p class="titulo-tarjeta">Registrar un nuevo usuario</p>
            </div>

            <form action="administrador-registrar-usuario.php" method="POST" class="formulario-acceso">
                <label for="usuario">usuario:</label>
                <input class="texto" type="text" id="usuario" name="usuario" required>

                <label for="contraseña">contraseña:</label>
                <input class="contraseña" type="password" id="contraseña" name="contraseña" required>

                <label for="nombre">nombre:</label>
                <input class="texto" type="text" id="nombre" name="nombre" required>

                <label for="apellido">apellido:</label>
                <input class="texto" type="text" id="apellido" name="apellido" required>

                <label for="dni">dni:</label>
                <input class="texto" type="text" id="dni" name="dni" required>

                <label for="correo">correo electronico:</label>
                <input class="texto" type="text" id="correo" name="correo" required>

                <button class="submit" type="submit">Registrarse</button>
            </form>
        </div>

        <div class="lista-usuarios">
            <a href="lista-usuarios.php">Ver lista de usuarios</a>
        </div>
    </div>
</body>
</html>