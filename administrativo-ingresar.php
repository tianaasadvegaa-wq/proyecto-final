<?php
session_start();

$host = 'localhost';
$dbname = 'base-trabajo';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $usuario_ingresado = trim($_POST['usuario'] ?? '');
        $password_ingresada = $_POST['contraseña'] ?? '';

        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario AND rol = 'administrador'";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['usuario' => $usuario_ingresado]);

        $usuario_encontrado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario_encontrado && password_verify($password_ingresada, $usuario_encontrado['contraseña'])) {
            $_SESSION["usuario"] = $usuario_encontrado;

            header("Location: administrativo-pagina.php");
            exit();
        } else {
            echo "<h3>Error: Usuario o contraseña incorrectos.</h3>";
            echo '<br><a href="index.php">Volver a intentar</a>';
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>