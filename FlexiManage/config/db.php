<?php
// /config/db.php

class Database
{
    private $host = 'localhost';  // Dirección del servidor de base de datos
    private $user = 'root';       // Usuario de MySQL
    private $password = '';       // Contraseña de MySQL (si no tiene, déjalo vacío)
    private $database = 'sistema_gestion_empleados';  // Nombre de la base de datos
    private $conn;

    // Método para obtener la conexión
    public function getConnection()
    {
        // Si ya existe una conexión activa, retorna esa conexión
        if ($this->conn) {
            return $this->conn;
        }

        // Intentar establecer la conexión con la base de datos
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->database);

        // Verificar si hubo algún error en la conexión
        if ($this->conn->connect_error) {
            // En caso de error, lanzar una excepción con el mensaje de error
            throw new Exception("Conexión fallida: " . $this->conn->connect_error);
        }

        // Retornar el objeto de la conexión
        return $this->conn;
    }

    // Método para cerrar la conexión
    public function closeConnection()
    {
        // Cerrar la conexión si está abierta
        if ($this->conn) {
            $this->conn->close();
            $this->conn = null; // Limpiar la conexión para evitar uso posterior
        }
    }
}
