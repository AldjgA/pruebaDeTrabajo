<?php
// Incluir la conexión a la base de datos
include('../../config/db.php');

$db = new Database();
$conn = $db->getConnection();

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los datos del formulario
    $id = $_POST['id']; // ID del empleado
    $nombre = $_POST['nombre'];
    $ap_paterno = $_POST['ap_paterno'];
    $ap_materno = $_POST['ap_materno'];
    $imagen = $_FILES['imagen']['name']; // Nombre de la imagen subida
    $target_dir = "../../assets/img/"; // Directorio donde se subirá la imagen
    $target_file = $target_dir . basename($imagen); // Ruta completa del archivo

    // Si se ha subido una nueva imagen, moverla al directorio
    if ($_FILES['imagen']['name']) {
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $target_file)) {
            echo "La imagen ha sido subida correctamente.";
        } else {
            echo "Error al subir la imagen.";
        }
    }

    // Si no se sube una nueva imagen, mantenemos la anterior
    if (empty($imagen)) {
        // Si no se sube una nueva imagen, no actualizamos el campo imagen
        $query = "UPDATE empleados SET nombre = ?, ap_paterno = ?, ap_materno = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $nombre, $ap_paterno, $ap_materno, $id);
    } else {
        // Si se sube una nueva imagen, actualizamos el campo imagen también
        $query = "UPDATE empleados SET nombre = ?, ap_paterno = ?, ap_materno = ?, imagen = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $nombre, $ap_paterno, $ap_materno, $imagen, $id);
    }

    // Ejecutar la consulta
    if ($stmt->execute()) {
        echo "Empleado actualizado correctamente.";
        // Redirigir a la lista de empleados después de la actualización
        header("Location: listar.php");
        exit();
    } else {
        echo "Error al actualizar el empleado: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
