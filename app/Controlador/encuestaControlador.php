<?php
include ("./Modelo/encuesta.php");
include ("./BaseDatos/encuestaSQL.php");

class EncuestaControlador
{
    public function Insertar($request, $response, $args)
    {
        //Obtengo los parametros que el servidor me envio
        $parametros = $request->getParsedBody();
        if( isset($parametros['nombreCliente']) && isset($parametros['descripcion']) && isset($parametros['puntuacionMesa']) && isset($parametros['puntuacionMozo']) && isset($parametros['puntuacionCocinero']) && isset($parametros['puntuacionRestaurant']))
        {
            $nombreCliente = $parametros['nombreCliente'];
            $descripcion = $parametros['descripcion'];
            $puntuacionMesa = $parametros['puntuacionMesa'];
            $puntuacionMozo = $parametros['puntuacionMozo'];
            $puntuacionCocinero = $parametros['puntuacionCocinero'];
            $puntuacionRestaurant = $parametros['puntuacionRestaurant']; 
            //Creo el objeto
            $encuesta = new Encuesta();
            $encuesta->nombreCliente = $nombreCliente;
            $encuesta->descripcion = $descripcion;
            $encuesta->puntuacionMesa = $puntuacionMesa;
            $encuesta->puntuacionMozo = $puntuacionMozo;
            $encuesta->puntuacionCocinero = $puntuacionCocinero;
            $encuesta->puntuacionRestaurant = $puntuacionRestaurant;
            EncuestaSQL::InsertarEncuesta($encuesta);
            $payload = json_encode(array("mensaje" => "Encuesta creada con exito"));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "ERROR, No se puedo dar de alta la encuesta nuevo"));
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    } 
    public function TraerEncuestas($request, $response, $args)
    {
        $lista = encuestaSQL::TraerEncuestas();
        $payload = json_encode(array("listapedidos" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    public function ObtenerEncuestaxId($request, $response, $args)
    {
        $id = $args['id'];
        $encuesta = EncuestaSQL::ObtenerEncuesta($id);
        $payload = json_encode($encuesta);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
?>


