<?php

$host = "localhost";
$dbname = "base-trabajo";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password_plana = $_POST['contraseña'] ?? '';
        $usuario = trim($_POST['usuario'] ?? '');
        $rol = "administrador";
        $fecha_creacion = date("Y-m-d");

        if (empty($usuario) || empty($password_plana)) {
            echo "todos los campos tiene que estar llenos";
        } else {
            $sql_usuario = "SELECT id FROM usuarios WHERE usuario = :usuario";
            $comprobar_usuario = $conn->prepare($sql_usuario);
            $comprobar_usuario->execute([':usuario' => $usuario]);

            if ($comprobar_usuario->rowCount() > 0) {
                echo "ese nombre de usuario ya esta en uso";
            } else {
                $password_segura = password_hash($password_plana, PASSWORD_DEFAULT);

                $sql = "INSERT INTO `usuarios` (`usuario`, `contraseña`, `rol`, `fecha_creacion`) 
                        VALUES (:usuario, :contrasena, :rol, :fecha_creacion)";
                $stmt = $conn->prepare($sql);

                $stmt->execute([
                    ':usuario' => $usuario,
                    ':contrasena' => $password_segura,
                    ':rol' => $rol,
                    ':fecha_creacion' => $fecha_creacion
                ]);

                echo "<h3>¡Administrador registrado con éxito!</h3>";
                echo '<br><a href="administrativo-ingreso.php">Ir a Iniciar Sesión</a>';
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>