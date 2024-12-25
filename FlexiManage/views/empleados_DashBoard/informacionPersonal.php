<?php
require '../../config/db.php';

$db = (new Database())->getConnection();

if (!isset($_GET['id']) || $_GET['id'] == 0) {
    echo "<script>
        alert('Error: El ID del usuario no está definido o es inválido.');
        window.location.href = '../empleado_dashboard.php';
    </script>";
    exit;
}

$id = $_GET['id'];
echo "ID del usuario: " . htmlspecialchars($id) . "<br>"; // Mensaje de depuración

$query = "SELECT * FROM usuarios WHERE id = ?";
$stmt = $db->prepare($query);
if (!$stmt) {
    die('Error en la preparación de la consulta: ' . $db->error);
}
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $password = $_POST['password'];

    // Encriptar la contraseña antes de guardarla
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $query = "UPDATE usuarios SET 
              username = ?, password = ? 
              WHERE id = ?";
    $stmt = $db->prepare($query);
    if (!$stmt) {
        die('Error en la preparación de la consulta de actualización: ' . $db->error);
    }
    $stmt->bind_param('ssi', $nombre, $passwordHash, $id);

    if ($stmt->execute()) {
        echo "Usuario actualizado correctamente.";
        header('Location: ../empleado_dashboard.php');
        exit();
    } else {
        echo "Error al actualizar el usuario: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Información Personal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }
        .form-container h2 {
            margin-bottom: 20px;
        }
        .form-container input[type="text"],
        .form-container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .form-container input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            border: none;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .form-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Actualizar Información Personal</h2>
        <form method="POST">
            <!-- Formulario con campos correspondientes a la tabla -->
            Nombre: <input type="text" name="nombre" value="<?php echo htmlspecialchars($usuario['username'] ?? ''); ?>"><br>
            Contraseña: <input type="password" name="password"><br>
            <input type="submit" value="Actualizar Usuario">
        </form>
    </div>
</body>
</html>