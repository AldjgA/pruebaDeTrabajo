<?php
include('../../config/db.php');
if (isset($_GET['id'])) {
    $empleado_id = $_GET['id'];
    $sql = "SELECT e.*, s.nombre AS sector FROM empleados e
            JOIN sectores s ON e.sector_id = s.id
            WHERE e.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $empleado_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $empleado = $result->fetch_assoc();
    } else {
        echo "Empleado no encontrado.";
        exit;
    }
} else {
    echo "ID de empleado no especificado.";
    exit;
}
$stmt->close();
$conn->close();
?>

<?php include('../layout/header.php'); ?>
<div class="container">
    <h2>Editar Empleado</h2>
    <form action="../../controllers/EmpleadoController.php" method="POST">
        <input type="hidden" name="id" value="<?php echo $empleado['id']; ?>">
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $empleado['nombre']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ap_paterno">Apellido Paterno:</label>
            <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" value="<?php echo $empleado['ap_paterno']; ?>" required>
        </div>
        <div class="form-group">
            <label for="ap_materno">Apellido Materno:</label>
            <input type="text" class="form-control" id="ap_materno" name="ap_materno" value="<?php echo $empleado['ap_materno']; ?>" required>
        </div>
        <div class="form-group">
            <label for="carnet_identidad">Carnet de Identidad:</label>
            <input type="text" class="form-control" id="carnet_identidad" name="carnet_identidad" value="<?php echo $empleado['carnet_identidad']; ?>" required>
        </div>
        <div class="form-group">
            <label for="sector">Sector:</label>
            <select class="form-control" id="sector" name="sector" required>
                <?php
                include('../../config/db.php');
                $result = $conn->query("SELECT * FROM sectores");
                while ($sector = $result->fetch_assoc()) {
                    $selected = $sector['id'] == $empleado['sector_id'] ? "selected" : "";
                    echo "<option value='" . $sector['id'] . "' $selected>" . $sector['nombre'] . "</option>";
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="salario">Salario:</label>
            <input type="number" step="0.01" class="form-control" id="salario" name="salario" value="<?php echo $empleado['salario']; ?>" required>
        </div>
        <div class="form-group">
            <label for="puesto">Puesto:</label>
            <input type="text" class="form-control" id="puesto" name="puesto" value="<?php echo $empleado['puesto']; ?>" required>
        </div>
        <div class="form-group">
            <label for="fecha_ingreso">Fecha de Ingreso:</label>
            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?php echo $empleado['fecha_ingreso']; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>
<?php include('../layout/footer.php'); ?>