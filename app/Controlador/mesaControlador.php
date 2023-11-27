<?php
include ("./Modelo/mesa.php");
include ("./BaseDatos/mesaSQL.php");
class MesaControlador
{
    public function InsertarMesa($request, $response, $args)
    { 
      
        $parametros = $request->getParsedBody();
        if(isset($parametros['idPedido']) && isset($parametros['idMozo']) && isset($parametros['estado']))
        {
            $idPedido = $parametros['idPedido'];
            $idMozo = $parametros['idMozo'];
            $estado = $parametros['estado'];
            //Creo el objeto
            $mesa = new Mesa();
            $mesa->idPedido = $idPedido;
            $mesa->idMozo = $idMozo;
            $mesa->estado =EstadoMesa::from($estado);    
            MesaSQL::InsertarMesa($mesa);
            $payload = json_encode(array("mensaje" => "Mesa creada con exito"));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "ERROR al crear la mesa"));
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    } 

    public function TraerMesas($request, $response, $args)
    {
        $lista = mesaSQL::TraerMesas();
        $payload = json_encode(array("listamesas" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    public function ObtenerMesaxId($request, $response, $args)
    {
        $id = $args['id'];
        $mesa = MesaSQL::ObtenerMesa($id);
        $payload = json_encode($mesa);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }


}