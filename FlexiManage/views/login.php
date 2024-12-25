<?php
session_start(); // Iniciar sesión para manejar errores

// Inicializar el mensaje de error como vacío por defecto
$error_message = '';

// Verificar si hay un mensaje de error en la sesión
if (isset($_SESSION['error'])) {
    $error_message = $_SESSION['error'];
    unset($_SESSION['error']); // Limpiar el mensaje de error después de mostrarlo
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Gestión Empresarial</title>
    <style>
        /* Estilo general del body */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #0d1117, #161b22);
            color: #fff;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: #0d1117;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.7);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            font-size: 2rem;
            font-weight: 700;
            color: #e6edf3;
            margin-bottom: 20px;
            text-shadow: 0px 3px 6px rgba(0, 0, 0, 0.4);
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-size: 14px;
            font-weight: bold;
            color: #a6b1e1;
        }

        input[type="text"],
        input[type="password"] {
            padding: 12px;
            font-size: 16px;
            border: 1px solid #30363d;
            border-radius: 8px;
            background-color: #161b22;
            color: #c9d1d9;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.5);
            transition: all 0.3s ease-in-out;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            border: 2px solid #58a6ff;
            background-color: #0d1117;
            box-shadow: 0 0 10px rgba(88, 166, 255, 0.6);
        }

        button {
            background: linear-gradient(135deg, #58a6ff, #1f6feb);
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            border: none;
            border-radius: 8px;
            padding: 12px;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.3s ease;
        }

        button:hover {
            background: linear-gradient(135deg, #1f6feb, #58a6ff);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(88, 166, 255, 0.5);
        }

        .error-message {
            color: #ff4d4d;
            font-size: 14px;
            margin-bottom: 10px;
            font-weight: bold;
            background-color: #2d1c1c;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #ff4d4d;
        }

        button:disabled {
            background: #30363d;
            cursor: not-allowed;
            color: #666;
        }

        @media (max-width: 768px) {
            .login-container {
                padding: 20px;
            }

            h2 {
                font-size: 1.5rem;
            }

            input[type="text"],
            input[type="password"] {
                font-size: 14px;
                padding: 10px;
            }

            button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
</head>

<body>
    <div class="login-container">
        <h2>Acceder al Sistema</h2>

        <?php if ($error_message): ?>
            <div class="error-message"><?php echo htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8'); ?></div>
        <?php endif; ?>

        <form action="../controllers/LoginController.php" method="POST">
            <label for="username">Usuario:</label>
            <input type="text" id="username" name="username" required placeholder="Ingrese su usuario" autocomplete="username">

            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required placeholder="Ingrese su contraseña" autocomplete="current-password">

            <button type="submit" id="login-button">Iniciar Sesión</button>
        </form>
    </div>

    <script>
        const form = document.querySelector('form');
        const button = document.getElementById('login-button');

        form.addEventListener('submit', () => {
            button.disabled = true;
            button.innerText = 'Procesando...';
        });
    </script>
</body>

</html>