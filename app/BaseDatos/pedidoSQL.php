<?php
include ("accesoDatos.php");

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
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT id, nombreCliente, estado, numeroMesa FROM pedido");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Pedido');
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


        
       
        
    



}
?>