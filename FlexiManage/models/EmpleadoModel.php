<?php

class EmpleadoModel
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function obtenerEmpleados($filtro = null)
    {
        $sql = "SELECT * FROM empleados";
        if ($filtro) {
            $sql .= " WHERE estado = :estado";
        }
        $stmt = $this->db->prepare($sql);
        if ($filtro) {
            $stmt->bindParam(':estado', $filtro, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function crearEmpleado($datos)
    {
        $sql = "INSERT INTO empleados (nombre, cedula_identidad, direccion, cargo, salario, estado, fecha_ingreso, sector_id) 
                VALUES (:nombre, :cedula, :direccion, :cargo, :salario, :estado, :fecha_ingreso, :sector_id)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($datos);
    }

    public function editarEmpleado($id, $datos)
    {
        $sql = "UPDATE empleados 
                SET nombre = :nombre, cedula_identidad = :cedula, direccion = :direccion, cargo = :cargo, salario = :salario, estado = :estado, sector_id = :sector_id
                WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $datos['id'] = $id;
        return $stmt->execute($datos);
    }

    public function eliminarEmpleado($id)
    {
        $sql = "DELETE FROM empleados WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
