<?php
class EmpleadoSQL
{
  public static function InsertarEmpleado($empleado)
    {    // Asegúrate de que $empleado sea una instancia de la clase Empleado
        if (!($empleado instanceof Empleado)) {
            throw new InvalidArgumentException('El parámetro $empleado debe ser una instancia de la clase Empleado.');
        }

        var_dump($empleado);
        $rol = $empleado->rol->value;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        try {
            $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleados( rol, nombre, activo, clave) VALUES ( :rol, :nombre, :activo, :clave);");
            $consulta->bindValue(':rol', $rol);
            $consulta->bindValue(':nombre', $empleado->nombre);
    
            // Manejo de booleanos para la columna activo
            $activo = $empleado->activo ? 1 : 0;
            $consulta->bindValue(':activo', $activo);
            $claveHash = password_hash($empleado->clave, PASSWORD_DEFAULT);
            $consulta->bindValue(':clave', $claveHash);
    
            $consulta->execute();
            return $objetoAccesoDato->RetornarUltimoIdInsertado();
        } catch (PDOException $e) {
            throw new Exception('Error al insertar empleado: ' . $e->getMessage());
        }
    }
    public static function ObtenerEmpleados()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM empleados;");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'empleado');
        
    }
    public static function ObtenerEmpleado($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM empleados WHERE id = :id;");
        $consulta->bindValue(':id', $id);
        $consulta->execute();
        return $consulta->fetchObject('empleado');
    }
    public static function ModificarEmpleado($empleado)
    {
        $rol = $empleado->rol->value;
        $estado = $empleado->estado->value;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleados 
        SET rol = :rol, nombre = :nombre
        WHERE id = :id");
        $consulta->bindValue(':id', $empleado->id);
        $consulta->bindValue(':rol', $rol);
        $consulta->bindValue(':nombre', $empleado->nombre);
        $consulta->execute();
        //return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public static function BorrarEmpleado($empleado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE empleados 
        SET activo = :activo WHERE id = :id");
        
        $activo = $empleado->activo ? 1 : 0;
        $consulta->bindValue(':id', $empleado->id);
        $consulta->bindValue(':activo', $empleado->activo);
        $consulta->execute();
        //return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    /*public static function EliminarEmpleado($empleado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE  empleados SET (activo) VALUES (:activo)");
        $consulta->bindValue(':activo', false);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }*/
}
?>