<?php
class ProductoSolicitadosSQL
{
    public static function InsertarProductoSolicitado($producto)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO productossolicitados (idProducto, codigoPedido, estado, unidades) VALUES (:idProducto, :codigoPedido, :estado, :unidades)");
        $consulta->bindValue(':idProducto', $producto->idProducto);
        $consulta->bindValue(':codigoPedido', $producto->codigoPedido);
        $consulta->bindValue(':estado', $producto->estado);
        $consulta->bindValue(':unidades', $producto->unidades);
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    //ObtenerProductosPorTipo
    public static function ObtenerProductosPorTipo($rol)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("
        SELECT p.nombre AS nombreProducto, p.tipo, ps.id,ps.estado, ps.unidades
        FROM productossolicitados ps
        JOIN producto p ON ps.idProducto = p.id
        WHERE ps.estado = 'Pendiente'
        AND p.tipo = :tipoEmpleado");

        $consulta->bindValue(':tipoEmpleado', $rol);
        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $resultados;
    }
    public static function TraerProductos()
    {
       
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT id, idProducto, codigoPedido, estado, unidades FROM productossolicitados");
        $consulta->execute();          
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'ProductoSolicitado');
    }

    public static function CambiarEnProceso($id,$tiempoEstimado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE productossolicitados 
        SET tiempoEstimado = :tiempoEstimado, estado = :estado, horaDeInicio = :horaDeInicio
        WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->bindValue(':tiempoEstimado', $tiempoEstimado);
        $consulta->bindValue(':horaDeInicio',  date("Y-m-d H:i:s"));
        $consulta->bindValue(':estado',  "EnProceso");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'ProductoSolicitado');
    }
}
?>