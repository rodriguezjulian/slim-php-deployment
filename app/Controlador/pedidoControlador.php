<?php
include ("./Modelo/pedido.php");
include ("./BaseDatos/pedidoSQL.php");

class PedidoControlador
{
    public function Insertar($request, $response, $args)
    {
        //Obtengo los parametros que el servidor me envio
        $parametros = $request->getParsedBody();
        if(isset($parametros['nombreCliente']) && isset($parametros['estado'])&& isset($parametros['numeroMesa']))
        {
            $nombreCliente = $parametros['nombreCliente'];
            $estado = $parametros['estado'];
            $numeroMesa = $parametros['numeroMesa'];
            //Creo el objeto
            $pedido = new Pedido();
            $codigoAlfanumerico=Pedido::GenerarCodigo();
            $pedido->codigo = $codigoAlfanumerico;
            $pedido->nombreCliente = $nombreCliente;
            $pedido->estado = EstadoPedido::from($estado);
            $pedido->numeroMesa =$numeroMesa;
            PedidoSQL::InsertarPedido($pedido);
            $payload = json_encode(array("mensaje" => "Pedido $codigoAlfanumerico creado con exito"));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "ERROR, No se puedo dar de alta al pedido nuevo"));
        }
        $response->getBody()->write($payload);
        return $response;
    } 
    public function CalcularTiempoEstimado($productosSolicitados)
    {
        $tiempo=0;
        foreach($productosSolicitados as $productoSolicitado)
        {
            if($tiempo<$productoSolicitado["tiempo"])
            {
                $tiempo=$productoSolicitado["tiempo"];
            }
        }
    }

    public function ObtenerPedidoxId($request, $response, $args)
    {
        $id = $args['id'];
        $pedido = PedidoSQL::ObtenerPedido($id);
        $payload = json_encode($pedido);

        $response->getBody()->write($payload);
        return $response;
         //->withHeader('Content-Type', 'application/json');
    }
    public function TraerTodos($request, $response, $args)
    {
        $lista = pedidoSQL::ObtenerTodos();
        $payload = json_encode(array("listapedidos" => $lista));
        $response->getBody()->write($payload);
        return $response;
          //->withHeader('Content-Type', 'application/json');
    }
}
?>