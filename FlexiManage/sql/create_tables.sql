
CREATE DATABASE IF NOT EXISTS sistema_gestion_empleados;
USE sistema_gestion_empleados;


CREATE TABLE IF NOT EXISTS empleados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    cedula_identidad VARCHAR(20) UNIQUE NOT NULL,
    direccion VARCHAR(255),
    cargo VARCHAR(100),
    salario DECIMAL(10, 2),
    estado ENUM('activo', 'inactivo') DEFAULT 'activo',
    fecha_ingreso DATE,
    sector_id INT,
    FOREIGN KEY (sector_id) REFERENCES sectores(id)
);

-- Tabla de sectores
CREATE TABLE IF NOT EXISTS sectores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT
);

-- Tabla de asistencia
CREATE TABLE IF NOT EXISTS asistencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empleado_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora_entrada TIME,
    hora_salida TIME,
    tipo ENUM('manual', 'automatica') DEFAULT 'manual',
    FOREIGN KEY (empleado_id) REFERENCES empleados(id)
);

-- Tabla de planillas salariales
CREATE TABLE IF NOT EXISTS planillas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empleado_id INT NOT NULL,
    mes INT NOT NULL,
    anio INT NOT NULL,
    salario DECIMAL(10, 2),
    horas_extras DECIMAL(10, 2),
    deducciones DECIMAL(10, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (empleado_id) REFERENCES empleados(id)
);

-- Tabla de finiquitos
CREATE TABLE IF NOT EXISTS finiquitos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empleado_id INT NOT NULL,
    fecha DATE,
    vacaciones_no_gozadas DECIMAL(10, 2),
    aguinaldo_proporcional DECIMAL(10, 2),
    indemnizacion DECIMAL(10, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (empleado_id) REFERENCES empleados(id)
);

-- Tabla de quinquenios
CREATE TABLE IF NOT EXISTS quinquenios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    empleado_id INT NOT NULL,
    fecha DATE,
    antiguedad INT, -- En años
    bonificacion DECIMAL(10, 2),
    FOREIGN KEY (empleado_id) REFERENCES empleados(id)
);


CREATE TABLE IF NOT EXISTS configuracion (
    id INT AUTO_INCREMENT PRIMARY KEY,
    parametro VARCHAR(100) NOT NULL,
    valor VARCHAR(255) NOT NULL
);


CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL
);


CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    rol_id INT NOT NULL,
    FOREIGN KEY (rol_id) REFERENCES roles(id)
);


INSERT INTO configuracion (parametro, valor) VALUES
('nombre_empresa', 'Nombre de la Empresa'),
('representante_legal', 'Nombre del Representante');


INSERT INTO roles (nombre) VALUES
('Administrador'),
('Empleado');


