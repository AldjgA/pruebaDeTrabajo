<?php
// Configuración de la base de datos
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'sistema_gestion_empleados';

// Crear conexión con MySQL
$conn = new mysqli($host, $user, $password);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Crear la base de datos si no existe
$sql = "CREATE DATABASE IF NOT EXISTS $database";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear base de datos: " . $conn->error . "\n";
    exit;
}

// Seleccionar la base de datos
$conn->select_db($database);

// Crear la tabla 'sectores'
$sql = "CREATE TABLE IF NOT EXISTS sectores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear tabla 'sectores': " . $conn->error . "\n";
}

// Crear la tabla 'empleadores'
$sql = "CREATE TABLE IF NOT EXISTS empleadores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombres_razon_social VARCHAR(255) NOT NULL,
    numero_identificador_ante_mt VARCHAR(50) NOT NULL,
    nit VARCHAR(20),
    numero_empleador_caja_salud VARCHAR(50),
    mes_ano_planilla VARCHAR(7) NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear tabla 'empleadores': " . $conn->error . "\n";
}

// Crear la tabla 'horarios' para gestionar los turnos
$sql = "CREATE TABLE IF NOT EXISTS horarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(100) NOT NULL,  -- Ej: 'Fijo', 'Mañana', 'Tarde', 'Noche'
    inicio TIME,                        -- Hora de inicio
    fin TIME                           -- Hora de fin
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear tabla 'horarios': " . $conn->error . "\n";
}

// Insertar algunos horarios predeterminados
$sql = "INSERT INTO horarios (descripcion, inicio, fin) VALUES
    ('Fijo', '09:00:00', '17:00:00'),
    ('Mañana', '06:00:00', '14:00:00'),
    ('Tarde', '14:00:00', '22:00:00'),
    ('Noche', '22:00:00', '06:00:00')";
if ($conn->query($sql) !== TRUE) {
    echo "Error al insertar horarios predeterminados: " . $conn->error . "\n";
}

// Crear la tabla 'empleados' (modificada para incluir clave foránea para horarios)
$sql = "CREATE TABLE IF NOT EXISTS empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ap_paterno VARCHAR(100) NOT NULL,
    ap_materno VARCHAR(100) NOT NULL,
    carnet_identidad VARCHAR(20) UNIQUE NOT NULL,
    nacionalidad VARCHAR(50),
    telefono VARCHAR(20),
    direccion VARCHAR(255),
    fecha_ingreso DATE NOT NULL,
    puesto VARCHAR(100) NOT NULL,
    contrato ENUM('indefinido', 'temporal') NOT NULL,
    horario_id INT,  -- Clave foránea que apunta a la tabla 'horarios'
    salario DECIMAL(10, 2),
    horas DECIMAL(10, 2),
    bonificacion DECIMAL(10, 2),
    fecha_salario DATE,
    sector_id INT,
    FOREIGN KEY (sector_id) REFERENCES sectores(id),
    FOREIGN KEY (horario_id) REFERENCES horarios(id)  -- Relación con horarios
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear tabla 'empleados': " . $conn->error . "\n";
}

// Crear la tabla 'usuarios' para gestionar usuarios
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empleado_id INT DEFAULT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'empleado') NOT NULL,
    FOREIGN KEY (empleado_id) REFERENCES empleados(id)
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear tabla 'usuarios': " . $conn->error . "\n";
}

// Crear la tabla 'datos_extras'
$sql = "CREATE TABLE IF NOT EXISTS datos_extras (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empleado_id INT NOT NULL,
    seguro_social VARCHAR(100),
    faltas INT DEFAULT 0,
    retiros INT DEFAULT 0,
    salario_minimo DECIMAL(10, 2) DEFAULT 2500.00,
    FOREIGN KEY (empleado_id) REFERENCES empleados(id)
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear tabla 'datos_extras': " . $conn->error . "\n";
}

// Crear la tabla 'salario_minimo'
$sql = "CREATE TABLE IF NOT EXISTS salario_minimo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    valor DECIMAL(10, 2) NOT NULL,
    fecha_actualizacion DATE NOT NULL
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear tabla 'salario_minimo': " . $conn->error . "\n";
}

// Insertar el valor inicial del salario mínimo
$sql = "INSERT INTO salario_minimo (valor, fecha_actualizacion) VALUES (2500.00, CURDATE())";
if ($conn->query($sql) !== TRUE) {
    echo "Error al insertar valor del salario mínimo: " . $conn->error . "\n";
}

// Crear la tabla 'datos_calculo_especifico'
$sql = "CREATE TABLE IF NOT EXISTS datos_calculo_especifico (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo_calculo ENUM('hora_extra', 'recargo_nocturno', 'bono_antiguedad', 'aporte_nacional_solidario') NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    limite DECIMAL(10, 2) DEFAULT NULL
)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al crear tabla 'datos_calculo_especifico': " . $conn->error . "\n";
}

// Insertar valores iniciales en la tabla 'datos_calculo_especifico'
$sql = "INSERT INTO datos_calculo_especifico (tipo_calculo, valor, limite) VALUES
    ('hora_extra', 1.5, NULL), 
    ('recargo_nocturno', 2.0, NULL), 
    ('bono_antiguedad', 100.00, NULL), 
    ('aporte_nacional_solidario', 1.15, 13000),
    ('aporte_nacional_solidario', 5.74, 25000),
    ('aporte_nacional_solidario', 11.48, 35000)";
if ($conn->query($sql) !== TRUE) {
    echo "Error al insertar valores en 'datos_calculo_especifico': " . $conn->error . "\n";
}

// Crear el usuario administrador de manera segura
$admin_password = password_hash('admin123', PASSWORD_DEFAULT); // Hasheamos la contraseña

$sql = "INSERT INTO usuarios (username, password, role, empleado_id) 
        VALUES ('admin', ?, 'admin', NULL)";

// Preparar y ejecutar la consulta con el hash de la contraseña
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admin_password);

if ($stmt->execute()) {
    echo "Usuario administrador creado exitosamente.";
} else {
    echo "Error al crear usuario administrador: " . $conn->error . "\n";
}

// Cerrar la declaración y la conexión
$stmt->close();
$conn->close();

echo "Base de datos e instancias creadas exitosamente! Usuario administrador creado.";
