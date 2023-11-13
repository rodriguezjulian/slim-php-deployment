<?php
include ("./Modelo/empleado.php");
include ("./BaseDatos/empleadoSQL.php");
class EmpleadoControlador
{
    public function InsertarEmpleado($request, $response, $args)
    {
        //Obtengo los parametros que el servidor me envio
        $parametros = $request->getParsedBody();
        if(isset($parametros['rol']) && isset($parametros['nombre']) && isset($parametros['disponible']) && isset($parametros['estado']))
        {
            // $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado(`id`, `rol`, `nombre`, `diponible`, `estado`)
            $rol = $parametros['rol'];
            $nombre = $parametros['nombre'];
            $disponible = $parametros['disponible'];
            $estado = $parametros['estado'];
            //Creo el objeto
            $empleado = new Empleado();
            //$pedido->estado = EstadoPedido::from($estado);
            $empleado->rol = Rol::from($rol);
            $empleado->nombre = $nombre;
            $empleado->disponible =$disponible;
            $empleado->estado = EstadoEmpleado::from($estado);
            EmpleadoSQL::InsertarEmpleado($empleado);
            $payload = json_encode(array("mensaje" => "Empleado creado con exito"));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "ERROR, No se puedo dar de alta al empleado nuevo"));
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    } 
    public function TraerEmpleados($request, $response, $args)
    {
        $lista = EmpleadoSQL::ObtenerEmpleados();
        $payload = json_encode(array("listaEmpleados" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
    
    public function ObtenerEmpleadoxId($request, $response, $args)
    {
        $id = $args['id'];
        $empleado = EmpleadoSQL::ObtenerEmpleado($id);
        $payload = json_encode($empleado);

        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
?>



