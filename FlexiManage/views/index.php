<?php
session_start();
// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    // Si no está autenticado, redirigir al login
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['usuario']; // Nombre del usuario
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Empleados</title>

    <!-- Bootstrap, FontAwesome y AOS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

    <style>
        /* Estilo de la cabecera */
        .header-container {
            background-color: #1a1a2e;
            color: #fff;
            padding: 80px 0;
            text-align: center;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            margin-bottom: 50px;
        }

        .header-container h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.4);
        }

        .header-container p {
            font-size: 1.3rem;
            color: #b2bec3;
        }

        /* Estilos de las tarjetas */
        .card {
            border: none;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            border-radius: 12px;
            position: relative;
            cursor: pointer;
            background-color: #f9f9f9;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 40px rgba(0, 0, 0, 0.15);
        }

        .card-body {
            text-align: center;
            padding: 30px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* Iconos */
        .icon-container {
            font-size: 3.5rem;
            margin-bottom: 20px;
            color: #007bff;
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .icon-container:hover {
            transform: scale(1.1);
            color: #ee6f57;
        }

        /* Título de la tarjeta */
        .card-title {
            font-size: 1.7rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 15px;
            transition: color 0.3s ease;
        }

        .card-title:hover {
            color: #007bff;
        }

        /* Descripción de la tarjeta */
        .card-text {
            font-size: 1.1rem;
            color: #555;
            opacity: 0;
            transition: opacity 0.3s ease, transform 0.3s ease;
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(20px);
            width: 80%;
            text-align: center;
            padding: 15px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
        }

        .card:hover .card-text {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        /* Fondo personalizado */
        .bg-primary-custom {
            background-color: #007bff;
            color: white;
            padding: 100px 0;
            border-radius: 10px;
        }

        /* Animación de fade-in */
        .fade-in {
            opacity: 0;
            animation: fadeIn 1.5s ease-in-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        /* Título de la sección */
        .section-title {
            font-size: 2rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 40px;
        }

        /* Estilos responsivos */
        @media (max-width: 767px) {
            .header-container h1 {
                font-size: 2rem;
            }

            .header-container p {
                font-size: 1rem;
            }

            .card-body {
                padding: 20px;
            }

            .card-title {
                font-size: 1.3rem;
            }

            .icon-container {
                font-size: 2.5rem;
            }
        }

        /* Estilo del botón de cerrar sesión */
        .logout-card {
            background-color: #e74c3c;
            color: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            text-align: center;
            transition: background-color 0.3s ease;
            padding: 20px;
            margin-top: 40px;
        }

        .logout-card:hover {
            background-color: #c0392b;
        }

        .logout-card i {
            font-size: 1.5rem;
        }
    </style>
</head>

<body>

    <div class="header-container" data-aos="fade-up">
        <h1>Bienvenido a nuestro Sistema de Gestión</h1>
        <p>Optimiza la administración de empleados, control de asistencia y más.</p>
    </div>

    <div class="container mt-5 fade-in" data-aos="fade-up">
        <div class="section-title text-center">Módulos de Gestión</div>
        <div class="row">

            <!-- Tarjetas -->
            <div class="col-md-4 col-sm-6 mb-4" data-aos="flip-left" data-aos-duration="1000">
                <div class="card bg-light" onclick="window.location.href='empleados/listar.php';">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-users"></i>
                        </div>
                        <h5 class="card-title">Gestionar Empleados</h5>
                        <p class="card-text">Administra todos los aspectos relacionados con los empleados de tu empresa.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 mb-4" data-aos="flip-left" data-aos-duration="1200">
                <div class="card bg-light" onclick="window.location.href='views/asistencia/reporte.php';">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h5 class="card-title">Control de Asistencia</h5>
                        <p class="card-text">Lleva un control preciso de la asistencia de tus empleados en tiempo real.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 mb-4" data-aos="flip-left" data-aos-duration="1400">
                <div class="card bg-light" onclick="window.location.href='views/planillas/generar.php';">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <h5 class="card-title">Planilla de sueldos y salarios</h5>
                        <p class="card-text">Calcula y genera planillas salariales de manera eficiente y precisa.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 mb-4" data-aos="flip-left" data-aos-duration="1600">
                <div class="card bg-light" onclick="window.location.href='views/planillas/finiquitos.php';">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <h5 class="card-title">Finiquitos y Quinquenios</h5>
                        <p class="card-text">Genera reportes de finiquitos y quinquenios de manera sencilla.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 mb-4" data-aos="flip-left" data-aos-duration="1800">
                <div class="card bg-light" onclick="window.location.href='views/sectores/listar.php';">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h5 class="card-title">Gestionar Sectores</h5>
                        <p class="card-text">Organiza y administra los diferentes sectores de tu empresa.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-6 mb-4" data-aos="flip-left" data-aos-duration="2000">
                <div class="card bg-light" onclick="window.location.href='views/configuracion/general.php';">
                    <div class="card-body">
                        <div class="icon-container">
                            <i class="fas fa-cogs"></i>
                        </div>
                        <h5 class="card-title">Configuración</h5>
                        <p class="card-text">Configura los parámetros generales del sistema según tus necesidades.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de cerrar sesión al final -->
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6">
                <form action="logout.php" method="POST">
                    <button type="submit" class="btn btn-link p-0">
                        <div class="card logout-card">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Cerrar sesión</p>
                        </div>
                    </button>
                </form>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        AOS.init();
    </script>
</body>

</html>