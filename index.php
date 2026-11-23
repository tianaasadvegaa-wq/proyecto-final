<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="style.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
</head>
<body class="pagina-acceso">
    <div class="centro">
        <div class="encabezado-tarjeta">
            <div class="subtitulo-marca">Estudio de Maquillaje</div>
            <h1 class="titulo-tarjeta">Iniciar sesión</h1>
        </div>

        <form action="codigos.php" method="POST" class="formulario-acceso">
            <label for="usuario">Usuario:</label>
            <input class="texto" type="text" name="usuario" id="usuario" required>

            <label for="contraseña">Contraseña:</label>
            <input class="contraseña" type="password" name="contraseña" id="contraseña" required>

            <button class="submit" type="submit">iniciar sesion</button>
        </form>
        <a href="administrativo-registrar.php" class="registrar-administrador">Registrar administrador</a> </br> </br>
        <a href="registrar.php" class="registrar">no tiene usuario? registrese</a>

        

    </div>
</body>
</html>