<?php
// Incluir el archivo de la clase Database
include('../../config/db.php');

// Crear una instancia de la clase Database
$database = new Database();

// Obtener la conexión a la base de datos
$conn = $database->getConnection();

// Verificar si la conexión fue exitosa (esto solo es necesario si deseas depurar)
if (!$conn) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultas para obtener los sectores y horarios desde la base de datos
$querySectores = "SELECT * FROM sectores";
$resultSectores = $conn->query($querySectores);

$queryHorarios = "SELECT * FROM horarios";
$resultHorarios = $conn->query($queryHorarios);

// Cerrar la conexión
$database->closeConnection();
?>

<!DOCTYPE html>
<html lang="es-BO">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Empleado</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #333;
            color: #f0f0f0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 40px;
            background-color: #444;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        h2 {
            text-align: center;
            font-size: 32px;
            font-weight: bold;
            color: #fff;
            margin-bottom: 30px;
            border-bottom: 3px solid #007bff;
            padding-bottom: 10px;
        }

        .form-group {
            margin-bottom: 25px;
        }

        label {
            font-size: 16px;
            font-weight: 500;
            color: #d1d1d1;
            margin-bottom: 8px;
            display: inline-block;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #555;
            border-radius: 8px;
            background-color: #333;
            color: #f0f0f0;
            font-size: 16px;
            transition: border-color 0.3s ease, background-color 0.3s ease;
        }

        .form-control:focus {
            border-color: #007bff;
            background-color: #444;
            outline: none;
        }

        select.form-control {
            height: 45px;
        }

        .btn {
            width: 100%;
            padding: 15px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #444;
            text-align: center;
            padding: 20px;
            font-size: 14px;
            color: #bbb;
            position: absolute;
            bottom: 0;
            width: 100%;
        }

        .loading {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #007bff;
        }

        @media (max-width: 768px) {
            .container {
                padding: 20px;
                margin: 30px;
            }

            h2 {
                font-size: 24px;
            }
        }

        .photo-preview {
            width: 3.5cm;
            height: 3.5cm;
            object-fit: cover;
            border: 1px solid #555;
            border-radius: 50%;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Agregar Nuevo Empleado</h2>
        <form action="../../controllers/EmpleadoController.php" method="POST" id="formEmpleado" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="ap_paterno">Apellido Paterno:</label>
                <input type="text" class="form-control" id="ap_paterno" name="ap_paterno" required>
            </div>
            <div class="form-group">
                <label for="ap_materno">Apellido Materno:</label>
                <input type="text" class="form-control" id="ap_materno" name="ap_materno" required>
            </div>
            <div class="form-group">
                <label for="carnet_identidad">Carnet de Identidad:</label>
                <input type="text" class="form-control" id="carnet_identidad" name="carnet_identidad" required>
            </div>
            <div class="form-group">
                <label for="nacionalidad">Nacionalidad:</label>
                <input type="text" class="form-control" id="nacionalidad" name="nacionalidad" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección:</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono:</label>
                <input type="text" class="form-control" id="telefono" name="telefono" required>
            </div>
            <div class="form-group">
                <label for="sector">Sector:</label>
                <select class="form-control" id="sector" name="sector" required>
                    <option value="">Seleccione un sector</option>
                    <?php
                    if ($resultSectores->num_rows > 0) {
                        while ($sector = $resultSectores->fetch_assoc()) {
                            echo "<option value='" . $sector['id'] . "'>" . $sector['descripcion'] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay sectores disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="horario">Horario:</label>
                <select class="form-control" id="horario" name="horario_id" required>
                    <option value="">Seleccione un horario</option>
                    <?php
                    if ($resultHorarios->num_rows > 0) {
                        while ($horario = $resultHorarios->fetch_assoc()) {
                            echo "<option value='" . $horario['id'] . "'>" . $horario['descripcion'] . " (" . $horario['inicio'] . " - " . $horario['fin'] . ")</option>";
                        }
                    } else {
                        echo "<option value=''>No hay horarios disponibles</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="salario">Salario:</label>
                <input type="number" step="0.01" class="form-control" id="salario" name="salario" required>
            </div>
            <div class="form-group">
                <label for="puesto">Puesto:</label>
                <input type="text" class="form-control" id="puesto" name="puesto" required>
            </div>
            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso:</label>
                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" value="<?= date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="fecha_salario">Fecha de Salario:</label>
                <input type="date" class="form-control" id="fecha_salario" name="fecha_salario" value="<?= date('Y-m-d'); ?>" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto (3.5 x 3.5 cm):</label>
                <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                <img id="photoPreview" class="photo-preview" alt="Vista previa de la foto">
            </div>
            <button type="submit" class="btn" id="submitBtn">Agregar Empleado</button>
        </form>
        <div class="loading" id="loading">
            <p>Por favor, espere...</p>
        </div>
    </div>

    <script>
        const form = document.getElementById('formEmpleado');
        const submitBtn = document.getElementById('submitBtn');
        const loadingIndicator = document.getElementById('loading');
        const photoInput = document.getElementById('foto');
        const photoPreview = document.getElementById('photoPreview');

        // Función para mostrar la vista previa de la foto seleccionada
        photoInput.addEventListener('change', function() {
            const file = photoInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    photoPreview.src = e.target.result;
                    photoPreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            loadingIndicator.style.display = 'block';
            submitBtn.disabled = true;

            fetch(form.action, {
                    method: 'POST',
                    body: new FormData(form)
                })
                .then(response => response.text()) // Cambiar a .text() para ver la respuesta completa
                .then(data => {
                    console.log(data); // Imprimir la respuesta completa en la consola
                    try {
                        const jsonData = JSON.parse(data);
                        if (jsonData.success) {
                            alert(jsonData.message);
                        } else {
                            alert('Error al agregar empleado: ' + jsonData.message);
                        }
                    } catch (error) {
                        alert('Error al agregar empleado: ' + error);
                    }
                    loadingIndicator.style.display = 'none';
                    submitBtn.disabled = false;
                    form.reset();
                    photoPreview.style.display = 'none';
                })
                .catch(error => {
                    alert('Error al agregar empleado: ' + error);
                    loadingIndicator.style.display = 'none';
                    submitBtn.disabled = false;
                });
        });
    </script>
</body>

</html>