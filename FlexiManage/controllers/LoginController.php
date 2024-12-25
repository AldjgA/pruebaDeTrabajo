<?php
session_start();
require_once '../config/db.php'; // Incluir la clase Database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Crear una instancia de la base de datos y obtener la conexión
    $db = new Database();
    $conn = $db->getConnection();

    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consultar la base de datos para verificar si el usuario existe
    $sql = "SELECT * FROM usuarios WHERE username = ? LIMIT 1";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die('Error en la preparación de la consulta: ' . $conn->error);
    }

    $stmt->bind_param("s", $username); // Vincular parámetro (nombre de usuario)
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña (comparar el hash)
        if (password_verify($password, $user['password'])) { //Para cuando funcione el encriptar
            // if ($password === $user['password']) {
            // Iniciar sesión y guardar los datos del usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role']; // Guardar el rol del usuario
            $_SESSION['usuario'] = $user['username']; // Guardar el nombre de usuario

            // Redirigir según el rol
            if ($user['role'] == 'admin') {
                header("Location: ../views/index.php"); // Página principal del admin
                exit;
            } else if ($user['role'] == 'empleado') {
                header("Location: ../views/empleado_dashboard.php"); // Página principal del empleado
                exit;
            } else {
                // Mostrar un mensaje emergente y no hacer nada
                echo "<script>
                    alert('Error: ID de rol no identificado.');
                    window.history.back(); // Volver a la página anterior
                </script>";
                exit; // Terminar el script después del mensaje
            }
        } else {
            // Contraseña incorrecta
            $_SESSION['error'] = "Contraseña incorrecta.";
            header("Location: ../views/login.php"); // Volver a la página de login
            exit;
        }
    } else {
        // El usuario no existe
        $_SESSION['error'] = "El usuario no existe.";
        header("Location: ../views/login.php"); // Volver a la página de login
        exit;
    }
} else {
    // Si no es una petición POST, redirigir al login
    header("Location: ../views/login.php");
    exit;
}
