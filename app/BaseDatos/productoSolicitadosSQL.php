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
        SELECT ps.id, p.nombre AS nombreProducto, p.precio, ps.unidades, ps.tiempoEstimado
        FROM productossolicitados ps
        JOIN producto p ON ps.idProducto = p.id
        WHERE ps.estado = 'Pendiente'
        AND p.tipo = :tipoEmpleado
    ");
    
    $consulta->bindValue(':tipoEmpleado', $rol);

        $consulta->execute();
        $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultados as $resultado) {
            $idSolicitud = $resultado['id'];
            $nombreProducto = $resultado['nombreProducto'];
            $precio = $resultado['precio'];
            $unidades = $resultado['unidades'];
            $tiempoEstimado = $resultado['tiempoEstimado'];
            var_dump($resultado);
        }
        
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'ProductoPedido');
    }
    /*
  $consulta = $objetoAccesoDato->RetornarConsulta("
    SELECT ps.id AS idSolicitud, p.id AS idProducto, p.nombre AS nombreProducto, p.precio, ps.unidades, ps.tiempoEstimado
    FROM productossolicitados ps
    JOIN producto p ON ps.idProducto = p.id
    WHERE ps.estado = 'Pendiente'
        AND p.tipo = :tipoEmpleado
    ");

    $consulta->bindValue(':tipoEmpleado', $tipoEmpleado);
    $consulta->execute();

    $resultados = $consulta->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultados as $resultado) {
        $idSolicitud = $resultado['idSolicitud'];
        $idProducto = $resultado['idProducto'];
        // Resto de los datos...
}

    
    */
}
?>