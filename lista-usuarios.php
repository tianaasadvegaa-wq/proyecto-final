<?php
session_start();

if (empty($_SESSION['usuario'])) {
    header("Location: administrativo-ingreso.php");
    exit();
}

$host = "localhost";
$usuario = "root";
$password = "";
$base_de_datos = "base-trabajo";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos;charset=utf8", $usuario, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

if (isset($_GET['toggle_archivado']) && isset($_GET['estado_actual'])) {
    $id_a_cambiar = (int) $_GET['toggle_archivado'];
    $estado_actual = (int) $_GET['estado_actual'];

    $nuevo_estado = ($estado_actual === 1) ? 0 : 1;
    $fecha_archivado = ($nuevo_estado === 1) ? date("Y-m-d") : null;

    $sql_archivado = "UPDATE usuarios SET archivado = :archivado, fecha_archivado = :fecha_archivado WHERE id = :id AND rol = 'usuario'";
    $stmt_archivado = $pdo->prepare($sql_archivado);
    $stmt_archivado->execute([
        ':archivado' => $nuevo_estado,
        ':fecha_archivado' => $fecha_archivado,
        ':id' => $id_a_cambiar
    ]);

    header("Location: lista-usuarios.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['actualizar'])) {
    $id = (int) $_POST['id'];
    $nombre = trim($_POST['nombre'] ?? '');
    $correo = trim($_POST['correo'] ?? '');

    $sql_update = "UPDATE usuarios SET nombre = :nombre, correo = :correo WHERE id = :id AND rol = 'usuario'";
    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->execute([
        ':nombre' => $nombre,
        ':correo' => $correo,
        ':id' => $id
    ]);

    header("Location: lista-usuarios.php");
    exit();
}

$busqueda = isset($_GET['busq']) ? trim($_GET['busq']) : "";
$id_editar = isset($_GET['editar']) ? (int) $_GET['editar'] : null;

$usuario_a_editar = null;
if ($id_editar) {
    $stmt_edit = $pdo->prepare("SELECT id, nombre, apellido, dni, correo, usuario, rol, archivado, fecha_archivado FROM usuarios WHERE id = :id AND rol = 'usuario'");
    $stmt_edit->execute([':id' => $id_editar]);
    $usuario_a_editar = $stmt_edit->fetch(PDO::FETCH_ASSOC);
}

if ($busqueda !== "") {
    $sql = "SELECT id, nombre, apellido, dni, correo, usuario, rol, archivado, fecha_archivado FROM usuarios 
            WHERE rol = 'usuario'
            AND (nombre LIKE :busq 
            OR apellido LIKE :busq 
            OR dni LIKE :busq 
            OR correo LIKE :busq
            OR usuario LIKE :busq)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':busq' => '%' . $busqueda . '%']);
} else {
    $sql = "SELECT id, nombre, apellido, dni, correo, usuario, rol, archivado, fecha_archivado FROM usuarios WHERE rol = 'usuario'";
    $stmt = $pdo->query($sql);
}

$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Panel de Administración</title>
</head>
<body class="pagina-administrador">
    <div class="contenedor-administrador">
        <div class="encabezado-seccion">
            <span class="subtitulo-marca">Estudio de Maquillaje</span>
            <h2 class="titulo-seccion">Panel de Administración - Lista de Usuarios</h2>
        </div>

        <div class="contenedor-tabla">
            <?php if ($usuario_a_editar): ?>
                <div class="tarjeta-edicion">
                    <h3 class="subtitulo-edicion">Editando al usuario: <?php echo htmlspecialchars($usuario_a_editar['nombre'] ?: ($usuario_a_editar['usuario'] ?? '')); ?></h3>
                    <form action="lista-usuarios.php" method="POST" class="formulario-edicion">
                        <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario_a_editar['id']); ?>">

                        <label for="nombre-editar">Nombre:</label>
                        <input type="text" id="nombre-editar" name="nombre" value="<?php echo htmlspecialchars($usuario_a_editar['nombre'] ?? ''); ?>">

                        <label for="correo-editar">Correo Electrónico:</label>
                        <input type="email" id="correo-editar" name="correo" value="<?php echo htmlspecialchars($usuario_a_editar['correo'] ?? ''); ?>">

                        <div class="acciones-formulario">
                            <button type="submit" name="actualizar">Guardar Cambios</button>
                            <a href="lista-usuarios.php" class="enlace-cancelar">Cancelar</a>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

            <form method="GET" action="" class="formulario-buscador">
                <input type="text" name="busq" placeholder="Buscar por nombre, usuario, DNI o correo..." value="<?php echo htmlspecialchars($busqueda); ?>">
                <button type="submit">Buscar</button>
                <?php if (!empty($busqueda)): ?>
                    <a href="lista-usuarios.php" class="enlace-limpiar">Ver todos</a>
                <?php endif; ?>
            </form>

            <div class="envoltorio-tabla">
                <table class="tabla-usuarios">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre / Usuario</th>
                            <th>Correo Electrónico</th>
                            <th>Rol</th>
                            <th>Archivado / Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['nombre'] ?: ($user['usuario'] ?? '')); ?></td>
                            <td><?php echo htmlspecialchars($user['correo'] ?? ''); ?></td>
                            <td><?php echo htmlspecialchars($user['rol'] ?? ''); ?></td>
                            <td>
                                <span class="estado-usuario">Estado: <?php echo htmlspecialchars($user['archivado']); ?></span>
                                <?php if (!empty($user['fecha_archivado'])): ?>
                                    <br><small class="fecha-archivo">Fecha: <?php echo htmlspecialchars($user['fecha_archivado']); ?></small>
                                <?php endif; ?>
                                <br>
                                <a href="lista-usuarios.php?toggle_archivado=<?php echo urlencode($user['id']); ?>&estado_actual=<?php echo urlencode($user['archivado']); ?>" class="enlace-accion">
                                    <?php echo ($user['archivado'] == 1) ? 'Desarchivar' : 'Archivar'; ?>
                                </a>
                            </td>
                            <td>
                                <a href="lista-usuarios.php?editar=<?php echo urlencode($user['id']); ?>" class="enlace-accion">Editar</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>