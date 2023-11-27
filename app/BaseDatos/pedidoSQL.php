<?php
include_once ("accesoDatos.php");

class PedidoSQL
{
    public static function InsertarPedido($pedido)
    {
        
        $estado=$pedido->estado->value;
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta ("INSERT into pedido (codigo,nombreCliente,estado,numeroMesa)values(:codigo,:nombreCliente,:estado,:numeroMesa)");
        $consulta->bindValue(':codigo', $pedido->codigo);
        $consulta->bindValue(':nombreCliente', $pedido->nombreCliente);
        $consulta->bindValue(':estado', $estado);
        $consulta->bindValue(':numeroMesa', $pedido->numeroMesa);
        $consulta->execute();
    }
    public static function ObtenerTodos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT * FROM pedido");
        $consulta->execute();

        $pedidos = $consulta->fetchAll(PDO::FETCH_ASSOC);

        return $pedidos;
    }

    public static function ObtenerPedido($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        //$consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM pedido WHERE id = :id");
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT id, nombreCliente, estado, numeroMesa FROM pedido WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->execute();
        return $consulta->fetchObject('pedido');
    }

    public static function ObtenerTiempoEstimadoPedido($codigoPedido)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
    
        $consulta = $objetoAccesoDato->RetornarConsulta("SELECT tiempoEstimado FROM pedido WHERE codigo = :codigoPedido");
        $consulta->bindValue(':codigoPedido', $codigoPedido);
        $consulta->execute();
    
        $tiempoEstimado = $consulta->fetch(PDO::FETCH_ASSOC);
    
        if ($tiempoEstimado) {
            return $tiempoEstimado['tiempoEstimado'];
        } else {
            // Manejar el caso en el que no se encuentra el pedido o no tiene tiempoEstimado
            return null;
        }
    }
    
    


        
       
        
    



}
?>