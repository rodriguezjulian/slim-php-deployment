<?php
include ("./Modelo/pedido.php");
include ("./BaseDatos/pedidoSQL.php");

class PedidoControlador
{
    public function Insertar($request, $response, $args)
    {
        //Obtengo los parametros que el servidor me envio
        $parametros = $request->getParsedBody();
        if(isset($parametros['nombreCliente']) && isset($parametros['totalPrecio']) && isset($parametros['estado'])&& isset($parametros['numeroMesa']) && isset($parametros['productosSolicitados']))
        {
            // $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado(`id`, `rol`, `nombre`, `diponible`, `estado`)
            $nombreCliente = $parametros['nombreCliente'];
           // $idProductoPedido = $parametros['idProductoPedido'];
            $totalPrecio = $parametros['totalPrecio'];
            $estado = $parametros['estado'];
            //CALCULAR TIEMPO ESTIMADO
            //$tiempoEstimado = $parametros['tiempoEstimado'];
            $numeroMesa = $parametros['numeroMesa'];
            //Creo el objeto
            $pedido = new Pedido();
            $pedido->id = Pedido::GenerarId();
            $pedido->nombreCliente = $nombreCliente;
            $pedido->totalPrecio =$totalPrecio;
            $pedido->estado = EstadoPedido::from($estado);
           // $pedido->tiempoEstimado =$tiempoEstimado;
            $pedido->numeroMesa =$numeroMesa;
            PedidoSQL::InsertarPedido($pedido);
            PedidoControlador :: InsertarProductosSolicitados($pedido->id,$parametros['productosSolicitados']);
            $payload = json_encode(array("mensaje" => "Pedido creado con exito"));
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
    public function InsertarProductosSolicitadosSQL($id,$productoSolicitado)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $estado="Pendiente";
        $unidades= $productoSolicitado["unidades"];
        $idProducto=$productoSolicitado["idProducto"];
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO productossolicitados (idProducto,idPedido,estado,unidades) VALUES('$idProducto','$id','$estado','$unidades')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();

    }
    public function InsertarProductosSolicitados($id,$productosSolicitados)
    {
       // $productosSol= json_decode($productosSolicitados,true);
        if(is_array($productosSolicitados))
        {
            foreach($productosSolicitados as $producto)
            {   
                PedidoControlador :: InsertarProductosSolicitadosSQL($id,$producto);
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