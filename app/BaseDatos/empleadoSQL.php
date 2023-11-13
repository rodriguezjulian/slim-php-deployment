<?php
class EmpleadoSQL
{
   public static function InsertarEmpleado($empleado)
    {
        $rol = $empleado->rol->value;
        $estado = $empleado->estado->value;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        
        // Corregir la consulta SQL y las vinculaciones de valores
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleados(id, rol, nombre, disponible, estado) VALUES (:id,:rol, :nombre, :disponible, :estado)");

        $consulta->bindValue(':id', $empleado->id);
        $consulta->bindValue(':rol', $rol);
        $consulta->bindValue(':nombre', $empleado->nombre);
        $consulta->bindValue(':disponible', $empleado->disponible);
        $consulta->bindValue(':estado', $estado);

        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public static function ObtenerEmpleados()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT id, rol, nombre, disponible, estado FROM empleados");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'empleado');
        
    }
    public static function ObtenerEmpleado($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM empleados WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->execute();
        return $consulta->fetchObject('empleado');
    }
}
?>