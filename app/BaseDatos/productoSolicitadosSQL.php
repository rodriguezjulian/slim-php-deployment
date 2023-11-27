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
    public static function ObtenerProductosPorTipoEnProceso($rol)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("
        SELECT p.nombre AS nombreProducto, p.tipo, ps.id,ps.estado, ps.unidades
        FROM productossolicitados ps
        JOIN producto p ON ps.idProducto = p.id
        WHERE ps.estado = 'EnProceso'
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
    public static function TraerPedido($idProductoSolicitado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT codigoPedido FROM productossolicitados WHERE idProducto = :idProducto LIMIT 1");
        $consulta->bindValue(':idProducto', $idProductoSolicitado);
        $consulta->execute();

        $pedido = $consulta->fetch(PDO::FETCH_ASSOC);

        if ($pedido) {
            return $pedido['codigoPedido'];
        } else {
            return null;
        }
    }
    public static function VerificarEstadoPedido($codigoPedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
        // Verificar si todos los ProductoSolicitado con el código de pedido están en "EnProceso"
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT COUNT(*) as cantidad FROM productossolicitados WHERE codigoPedido = :codigoPedido AND estado = 'EnProceso'");
        $consulta->bindValue(':codigoPedido', $codigoPedido);
        $consulta->execute();
    
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        if ($resultado['cantidad'] > 0) {
            // Obtener la cantidad total de ProductoSolicitado con el código de pedido
            $consultaTotal = $objetoAccesoDato->RetornarConsulta("SELECT COUNT(*) as total FROM productossolicitados WHERE codigoPedido = :codigoPedido");
            $consultaTotal->bindValue(':codigoPedido', $codigoPedido);
            $consultaTotal->execute();
    
            $total = $consultaTotal->fetch(PDO::FETCH_ASSOC);
    
            if ($resultado['cantidad'] == $total['total']) {
                // Si todos los ProductoSolicitado están en "EnProceso", buscar el tiempo más alto
                $consultaTiempo = $objetoAccesoDato->RetornarConsulta("SELECT MAX(tiempoEstimado) as tiempo_maximo FROM productossolicitados WHERE codigoPedido = :codigoPedido AND estado = 'EnProceso'");
                $consultaTiempo->bindValue(':codigoPedido', $codigoPedido);
                $consultaTiempo->execute();
                $tiempoMaximo = $consultaTiempo->fetch(PDO::FETCH_ASSOC);
    
                return $tiempoMaximo['tiempo_maximo'];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
    
   /* public static function PasarEnProceso($codigoPedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $estadoEnProceso = "Preparacion"; // Definir el estado deseado, puedes ajustarlo según tu lógica

        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedido SET estado = :estado WHERE codigo = :codigoPedido");
        $consulta->bindValue(':estado', $estadoEnProceso);
        $consulta->bindValue(':codigoPedido', $codigoPedido);
        $consulta->execute();
    }*/
    public static function PasarEnProceso($codigoPedido, $tiempoEstimado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $estadoEnProceso = "Preparacion"; // Definir el estado deseado, puedes ajustarlo según tu lógica

        // Actualizar estado y tiempoEstimado en la tabla pedido
        $consulta = $objetoAccesoDato->RetornarConsulta("UPDATE pedido SET estado = :estado, tiempoEstimado = :tiempoEstimado WHERE codigo = :codigoPedido");
        $consulta->bindValue(':estado', $estadoEnProceso);
        $consulta->bindValue(':tiempoEstimado', $tiempoEstimado);
        $consulta->bindValue(':codigoPedido', $codigoPedido);
        $consulta->execute();
    }

}
?>