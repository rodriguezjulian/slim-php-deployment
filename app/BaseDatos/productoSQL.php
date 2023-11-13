<?php
//include ("accesoDatos.php");
class ProductoSQL
{
    public static function InsertarProducto($producto)
    {
        $tipo=$producto->tipo->value;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO producto (nombre,precio,tipo,tiempo) VALUES('$producto->nombre','$producto->precio','$tipo','$producto->tiempo')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    //TraerProductos
    public static function TraerProductos()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT id, nombre, precio, tipo,tiempo FROM producto");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'producto');
    }

    public static function ObtenerProducto($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM producto WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->execute();
        return $consulta->fetchObject('producto');
    }
}
?>