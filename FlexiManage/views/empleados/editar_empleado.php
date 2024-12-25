<?php
// Incluir la conexión a la base de datos
include('../../config/db.php');

// Crear instancia de la clase Database
$db = new Database();
$conn = $db->getConnection();

// Verificar si el ID está presente en la URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Preparar la consulta para obtener los datos del empleado
    $query = "SELECT * FROM empleados WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el empleado
    if ($result->num_rows > 0) {
        $empleado = $result->fetch_assoc();
    } else {
        echo "Empleado no encontrado.";
        exit;
    }
} else {
    echo "ID de empleado no proporcionado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Empleado</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #121212;
            color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #1e1e1e;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
            width: 90%;
            max-width: 500px;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        label {
            font-weight: 500;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border-radius: 6px;
            border: none;
        }

        input[type="text"],
        input[type="number"] {
            background-color: #2e2e2e;
            color: #f4f4f4;
        }

        input[type="file"] {
            background-color: #444;
            color: #f4f4f4;
            cursor: pointer;
        }

        button {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        .image-preview {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            margin-top: 10px;
        }

        .image-preview img {
            max-width: 100%;
            border-radius: 6px;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .back-link:hover {
            color: #0056b3;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h1>Editar Empleado</h1>

        <form action="actualizar_empleado.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" value="<?php echo $empleado['nombre']; ?>" required>

            <label for="ap_paterno">Apellido Paterno:</label>
            <input type="text" name="ap_paterno" id="ap_paterno" value="<?php echo $empleado['ap_paterno']; ?>" required>

            <label for="ap_materno">Apellido Materno:</label>
            <input type="text" name="ap_materno" id="ap_materno" value="<?php echo $empleado['ap_materno']; ?>" required>

            <label for="telefono">Teléfono:</label>
            <input type="text" name="telefono" id="telefono" value="<?php echo $empleado['telefono']; ?>">

            <label for="direccion">Dirección:</label>
            <input type="text" name="direccion" id="direccion" value="<?php echo $empleado['direccion']; ?>">

            <label for="puesto">Puesto:</label>
            <input type="text" name="puesto" id="puesto" value="<?php echo $empleado['puesto']; ?>" required>

            <label for="salario">Salario:</label>
            <input type="number" step="0.01" name="salario" id="salario" value="<?php echo $empleado['salario']; ?>" required>

            <div class="image-preview">
                <label>Imagen actual:</label>
                <img src="assets/img/<?php echo $empleado['imagen']; ?>" alt="Imagen del empleado">
            </div>

            <label for="imagen">Actualizar Imagen:</label>
            <input type="file" name="imagen" id="imagen" accept="image/*">

            <button type="submit">Actualizar</button>
        </form>

        <a href="listar_empleados.php" class="back-link">Volver a la lista de empleados</a>
    </div>
</body>

</html>