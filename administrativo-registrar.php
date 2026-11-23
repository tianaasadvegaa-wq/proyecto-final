<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registrar administrador</title>
</head>
<body class="pagina-acceso">
    <div class="centro">
        <div class="encabezado-tarjeta">
            <span class="subtitulo-marca">Estudio de Maquillaje</span>
            <h1 class="titulo-tarjeta">Registrar administrador</h1>
        </div>

        <form action="guardar-administrador.php" method="POST" class="formulario-acceso">
            <label for="usuario">usuario:</label>
            <input class="texto" type="text" id="usuario" name="usuario" required>

            <label for="contraseña">contraseña:</label>
            <input class="contraseña" type="password" id="contraseña" name="contraseña" required>

            <button class="submit" type="submit">Registrar</button>
        </form>
    </div>
</body>
</html>