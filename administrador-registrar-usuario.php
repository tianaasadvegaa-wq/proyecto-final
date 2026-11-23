<?php

session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: index.php");
    exit();
}

$host = "localhost";
$dbname = "base-trabajo";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $password_plana = $_POST['contraseña'] ?? '';
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $dni = trim($_POST['dni'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $usuario = trim($_POST['usuario'] ?? '');
        $rol = "usuario";
        $fecha_creacion = date("Y-m-d");

        if (empty($nombre) || empty($password_plana) || empty($apellido) || empty($dni) || empty($correo) || empty($usuario)) {
            echo "todos los campos tiene que estar llenos";
        } else {
            $sql_correo = "SELECT id FROM usuarios WHERE correo = :correo";
            $comprobar_correo = $conn->prepare($sql_correo);
            $comprobar_correo->execute([':correo' => $correo]);

            $sql_dni = "SELECT id FROM usuarios WHERE dni = :dni";
            $comprobar_dni = $conn->prepare($sql_dni);
            $comprobar_dni->execute([':dni' => $dni]);

            if ($comprobar_correo->rowCount() > 0) {
                echo "ese mail ya esta en uso";
            } elseif ($comprobar_dni->rowCount() > 0) {
                echo "ese DNI ya esta registrado";
            } else {
                $password_segura = password_hash($password_plana, PASSWORD_DEFAULT);

                $sql = "INSERT INTO usuarios (nombre, apellido, dni, correo, contraseña, usuario, rol, fecha_creacion) 
                        VALUES (:nombre, :apellido, :dni, :correo, :contrasena, :usuario, :rol, :fecha_creacion)";
                $stmt = $conn->prepare($sql);

                $stmt->execute([
                    ':nombre' => $nombre,
                    ':apellido' => $apellido,
                    ':dni' => $dni,
                    ':correo' => $correo,
                    ':contrasena' => $password_segura,
                    ':usuario' => $usuario,
                    ':rol' => $rol,
                    ':fecha_creacion' => $fecha_creacion
                ]);

                echo "<h3>¡Usuario registrado con éxito!</h3>";
                echo '<br><a href="index.php">Ir a Iniciar Sesión</a>';
            }
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}

?>