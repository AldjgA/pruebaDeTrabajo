<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>
    <style>
        /* Estilos Generales */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            margin: 30px 0;
            font-size: 36px;
            color: #333;
            text-transform: uppercase;
        }

        /* Contenedor Principal */
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            margin-top: 20px;
        }

        /* Estilos para cada tarjeta de empleado */
        .card {
            background-color: white;
            width: 250px;
            height: auto;
            margin: 15px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-10px);
        }

        .card .portada {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-bottom: 2px solid #ddd;
        }

        .card .wrapper {
            padding: 20px;
            text-align: center;
        }

        .card .wrapper .artistname {
            font-size: 22px;
            font-weight: bold;
            color: #333;
        }

        .card .wrapper .originalname {
            font-size: 14px;
            color: #777;
        }

        /* Botones de la tarjeta */
        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 15px;
        }

        .buttons .add,
        .buttons .msg {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .buttons .add:hover,
        .buttons .msg:hover {
            background-color: #45a049;
        }

        /* Sección de acción (agregar, etc.) */
        .acciones {
            text-align: center;
            margin-top: 50px;
        }

        .acciones a {
            padding: 10px 25px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .acciones a:hover {
            background-color: #0056b3;
        }

        /* Mensaje de No Empleados */
        .no-empleados {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
            color: #777;
        }
    </style>
</head>

<body>

    <h1>Gestión de Empleados</h1>

    <!-- Sección de Acción: Agregar Empleado -->
    <div class="acciones">
        <a href="/empleados/agregar">Agregar Nuevo Empleado</a>
    </div>

    <!-- Contenedor de las tarjetas de empleados -->
    <div class="container">
        <?php if (count($empleados) > 0): ?>
            <?php foreach ($empleados as $empleado): ?>
                <div class="card">
                    <!-- Foto de portada -->
                    <img src="../public/images/<?= isset($empleado['foto_portada']) ? $empleado['foto_portada'] : 'default.jpg' ?>" alt="Portada" class="portada">

                    <!-- Información del empleado -->
                    <div class="wrapper">
                        <h3 class="artistname"><?= $empleado['nombre'] ?></h3>
                        <p class="originalname"><?= $empleado['cedula_identidad'] ?></p>
                    </div>

                    <!-- Botones para editar y eliminar -->
                    <div class="buttons">
                        <a href="/empleados/editar/<?= $empleado['id'] ?>" class="add">Editar</a>
                        <a href="/empleados/eliminar/<?= $empleado['id'] ?>" class="msg">Eliminar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Mensaje si no hay empleados -->
            <div class="no-empleados">No hay empleados registrados.</div>
        <?php endif; ?>
    </div>

</body>

</html>