<?php
// Incluir la conexión a la base de datos
include('../../config/db.php');

// Crear instancia de la clase Database
$db = new Database();
$conn = $db->getConnection();

// Consulta SQL para obtener los datos de los empleados/artistas
$query = "SELECT * FROM empleados"; // Cambiar el nombre de la tabla según tu base de datos
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Empleados</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Material+Icons" rel="stylesheet">
    <style>
        /* Estilos Generales */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: #121212;
            font-family: 'Roboto', sans-serif;
            color: #f4f4f4;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            padding: 30px;
            min-height: 100vh;
        }

        header {
            width: 100%;
            background: linear-gradient(90deg, #1e1e1e, #282828);
            padding: 20px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.5);
            position: fixed;
            top: 0;
            z-index: 1000;
        }

        header h1 {
            font-size: 1.8rem;
            color: #ffffff;
        }

        .add-button {
            background-color: #007bff;
            color: white;
            font-size: 1rem;
            padding: 10px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .add-button:hover {
            background-color: #0056b3;
        }

        .add-button .material-icons {
            font-size: 1.5rem;
        }

        .container {
            margin-top: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
        }

        .card-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
            width: 100%;
        }

        .card {
            width: 300px;
            height: 360px;
            background-color: #1e1e1e;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
        }

        .card .portada {
            width: 100%;
            height: 160px;
            background: linear-gradient(90deg, #333, #444);
        }

        .card .wrapper {
            margin-top: -40px;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 20px;
        }

        .card .profile {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            border: 4px solid #121212;
            object-fit: cover;
        }

        .card .data {
            text-align: center;
            margin-top: 10px;
            color: #f4f4f4;
        }

        .card .artistname {
            font-size: 20px;
            font-weight: 700;
        }

        .card .originalname {
            font-size: 14px;
            color: #aaa;
        }

        .buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }

        .button {
            background-color: #333;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 14px;
            color: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .button:hover {
            background-color: #444;
        }

        .button.view:hover {
            background-color: #007bff;
        }

        .button.edit:hover {
            background-color: #ffc107;
        }

        .button.delete:hover {
            background-color: #dc3545;
        }

        @media (max-width: 768px) {
            header h1 {
                font-size: 1.5rem;
            }

            .card-container {
                gap: 15px;
            }

            .add-button {
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Lista de Empleados</h1>
        <a href="formulario_empleado.php" class="add-button">
            <span class="material-icons">add</span> Agregar Empleado
        </a>
    </header>

    <div class="container">
        <div class="card-container">
            <?php
            // Verificar si hay resultados
            if ($result->num_rows > 0) {
                // Recorrer los resultados y generar las tarjetas
                while ($row = $result->fetch_assoc()) {
                    // Asumiendo que los campos en la base de datos son: id, nombre, apellido, imagen
                    $id = $row['id'];
                    $nombre = $row['nombre'];
                    $apellido = $row['ap_paterno']; // O el campo que represente el apellido en tu tabla

                    $imagen = $row['imagen']; // La imagen puede ser una URL o nombre de archivo
            ?>

                    <div class="card">
                        <div class="portada"></div>
                        <div class="wrapper">
                            <img src="assets/img/<?php echo $imagen; ?>" alt="Profile Image" class="profile">
                            <div class="data">
                                <h3 class="artistname"><?php echo $nombre; ?></h3>
                                <p class="originalname"><?php echo $apellido; ?></p>
                            </div>
                        </div>

                        <div class="buttons">
                            <a href="#" class="button view">
                                <span class="material-icons">visibility</span> Ver
                            </a>
                            <a href="editar_empleado.php?id=<?php echo $id; ?>" class="button edit">
                                <span class="material-icons">edit</span> Editar
                            </a>

                            <a href="#" class="button delete">
                                <span class="material-icons">delete</span> Eliminar
                            </a>
                        </div>
                    </div>

            <?php
                }
            } else {
                echo "<p>No hay empleados/artistas para mostrar.</p>";
            }
            ?>
        </div>
    </div>

</body>

</html>

<?php
// Cerrar la conexión
$db->closeConnection();
?>