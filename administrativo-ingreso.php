<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Ingreso administrativos</title>
</head>
<body class="pagina-acceso">
    <div class="centro">
        <div class="encabezado-tarjeta">
            <span class="subtitulo-marca">Estudio de Maquillaje</span>
            <h1 class="titulo-tarjeta">Ingreso administrativos</h1>
        </div>

        <form action="administrativo-ingresar.php" method="POST" class="formulario-acceso">
            <label for="usuario">usuario:</label>
            <input class="texto" type="text" name="usuario" id="usuario" required>

            <label for="contraseña">contraseña:</label>
            <input class="contraseña" type="password" name="contraseña" id="contraseña" required>

            <button class="submit" type="submit">Ingresar</button>
        </form>
    </div>
</body>
</html>