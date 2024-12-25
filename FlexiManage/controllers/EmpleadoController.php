<?php
// controllers/EmpleadoController.php

// Incluir el archivo de conexión a la base de datos
include('../../config/db.php');

// Asegurarse de que no haya salida accidental
ob_start();

// Verificar si el método de solicitud es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Método de solicitud no permitido.';
    exit;
}

try {
    // Crear una instancia de la conexión a la base de datos
    $db = new Database();
    $conn = $db->getConnection();

    // Obtener los datos del formulario
    $nombre = $_POST['nombre'] ?? null;
    $ap_paterno = $_POST['ap_paterno'] ?? null;
    $ap_materno = $_POST['ap_materno'] ?? null;
    $carnet_identidad = $_POST['carnet_identidad'] ?? null;
    $nacionalidad = $_POST['nacionalidad'] ?? null;
    $direccion = $_POST['direccion'] ?? null;
    $telefono = $_POST['telefono'] ?? null;
    $sector_id = $_POST['sector_id'] ?? null;
    $horario_id = $_POST['horario_id'] ?? null;
    $salario = $_POST['salario'] ?? null;
    $puesto = $_POST['puesto'] ?? null;
    $fecha_ingreso = $_POST['fecha_ingreso'] ?? null;
    $fecha_salario = $_POST['fecha_salario'] ?? null;

    // Validar campos obligatorios
    if (!$nombre || !$ap_paterno || !$carnet_identidad || !$sector_id || !$horario_id || !$salario || !$puesto || !$fecha_ingreso) {
        echo 'Todos los campos obligatorios deben completarse.';
        exit;
    }

    // Manejar la foto (si se envía)
    $foto_path = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true); // Crear el directorio si no existe
        }

        $foto_name = uniqid() . '_' . basename($_FILES['foto']['name']);
        $foto_path = $upload_dir . $foto_name;

        if (!move_uploaded_file($_FILES['foto']['tmp_name'], $foto_path)) {
            echo 'Error al subir la foto.';
            exit;
        }
    }

    // Preparar la consulta SQL para insertar un nuevo empleado
    $query = "INSERT INTO empleados 
                (nombre, ap_paterno, ap_materno, carnet_identidad, nacionalidad, direccion, telefono, sector_id, horario_id, salario, puesto, fecha_ingreso, fecha_salario, foto) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($query);

    if (!$stmt) {
        echo 'Error al preparar la consulta: ' . $conn->error;
        exit;
    }

    // Vincular los parámetros de la consulta
    $stmt->bind_param(
        "sssssssiddssss",
        $nombre,
        $ap_paterno,
        $ap_materno,
        $carnet_identidad,
        $nacionalidad,
        $direccion,
        $telefono,
        $sector_id,
        $horario_id,
        $salario,
        $puesto,
        $fecha_ingreso,
        $fecha_salario,
        $foto_path
    );

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo 'Empleado agregado exitosamente.';
    } else {
        echo 'Error al ejecutar la consulta: ' . $stmt->error;
    }
} catch (Exception $e) {
    // Manejar errores
    echo 'Ocurrió un error: ' . $e->getMessage();
} finally {
    // Limpiar la salida del buffer y cerrar la conexión
    ob_end_clean();
    if (isset($conn)) {
        $conn->close();
    }
}
