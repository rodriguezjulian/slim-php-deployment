<?php
include ("./Modelo/empleado.php");
include ("./BaseDatos/empleadoSQL.php");
include_once ("./Modelo/interfazGenerica.php");
class EmpleadoControlador implements InterfazGen
{
    public function Insertar($request, $response, $args)
    {
        //Obtengo los parametros que el servidor me envio
        $parametros = $request->getParsedBody();
        if(isset($parametros['rol']) && isset($parametros['nombre'])
        &&isset($parametros['clave']))
        {
            $rol = $parametros['rol'];
            $nombre = $parametros['nombre'];
            $clave = $parametros['clave'];
            //Creo el objeto
            $empleado = new Empleado();
            $empleado->rol = Rol::from($rol);
            $empleado->nombre = $nombre;
            $empleado->activo =1;
            $empleado->clave =$clave;
            $idRetornado=EmpleadoSQL::InsertarEmpleado($empleado);
            echo $idRetornado;
            $payload = json_encode(array("mensaje" => "Empleado creado con exito"));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "ERROR, No se puedo dar de alta al empleado nuevo"));
        }
        $response->getBody()->write($payload);
        return $response;
          //->withHeader('Content-Type', 'application/json');
    } 
    public function ObtenerTodos($request, $response, $args)
    {
        $lista = EmpleadoSQL::ObtenerEmpleados();
        $payload = json_encode(array("listaEmpleados" => $lista));
        $response->getBody()->write($payload);
        return $response;
         // ->withHeader('Content-Type', 'application/json');
    }
    
    public function ObtenerUnoxId($request, $response, $args)
    {
        $id = $args['id'];
        $empleado = EmpleadoSQL::ObtenerEmpleado($id);
        $payload = json_encode($empleado);

        $response->getBody()->write($payload);
        return $response;
          //->withHeader('Content-Type', 'application/json');
    }
    public function Modificar($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        $id = $args['id'];
        $empleado = EmpleadoSQL::ObtenerEmpleado($id);

        if(isset($parametros['rol']) && isset($parametros['nombre']))
        {
            $rol = $parametros['rol'];
            $nombre = $parametros['nombre'];
            $estado = $parametros['estado'];

            $empleado->rol = Rol::from($rol);
            $empleado->nombre = $nombre;
            EmpleadoSQL::ModificarEmpleado($empleado);
            $payload = json_encode(array("Empleado modificado exitosamente."));
        }
        else
        {
            $payload = json_encode(array("ERROR, No se pudo modificar el empleado."));
        }
        $response->getBody()->write($payload);
        return $response;
    }
    public function Borrar($request, $response, $args)
    {
       // $parametros = $request->getParsedBody();
        $id = $args['id'];
        $empleado = EmpleadoSQL::ObtenerEmpleado($id);    
        $empleado->activo = false;
        $empleado->estado = "Ausente";

        EmpleadoSQL::BorrarEmpleado($empleado);
        $payload = json_encode(array("Empleado dado de baja exitosamente."));
        $response->getBody()->write($payload);
        return $response;
    }
}
?>



