<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Registrarse</title>
</head>
<body class="pagina-acceso">
    <div class="centro">
        <div class="encabezado-tarjeta">
            <div>Estudio de Maquillaje</div>
            <h1 >Crear cuenta</h1>
        </div>

        <form action="guardar-usuario.php" method="POST" class="formulario-acceso">
            <label for="usuario">usuario:</label>
            <input class="texto" type="text" id="usuario" name="usuario" required>

            <label for="contraseña">contraseña:</label>
            <input class="contraseña" type="password" id="contraseña" name="contraseña" required>

            <label for="nombre">nombre:</label>
            <input class="texto" type="text" id="nombre" name="nombre" required>

            <label for="apellido">apellido:</label>
            <input class="texto"  type="text" id="apellido" name="apellido" required>

            <label for="dni">dni:</label>
            <input class="texto" type="text" id="dni" name="dni" required>

            <label for="correo">correo electronico:</label>
            <input class="texto" type="text" id="correo" name="correo" required>

            <button class="submit" type="submit">Registrarse</button>
        </form>
    </div>
</body>
</html>