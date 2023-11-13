<?php
include ("./Modelo/producto.php");
include ("./BaseDatos/productoSQL.php");
class ProductoControlador
{
    public function InsertarProducto($request, $response, $args)
    {
        //Obtengo los parametros que el servidor me envio
        $parametros = $request->getParsedBody();
        if(isset($parametros['nombre']) && isset($parametros['precio']) && isset($parametros['tipo']) && isset($parametros['tiempo']))
        {
            // $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO empleado(`id`, `rol`, `nombre`, `diponible`, `estado`)
            $nombre = $parametros['nombre'];
            $precio = $parametros['precio'];
            $tipo = $parametros['tipo'];
            $tiempo = $parametros['tiempo'];
            //Creo el objeto
            $producto = new Producto();
            $producto->nombre = $nombre;
            $producto->precio =$precio;
            $producto->tipo =tipoProducto::from($tipo);
            $producto->tiempo =$tiempo;
            ProductoSQL::InsertarProducto($producto);
            $payload = json_encode(array("mensaje" => "Producto creado con exito"));
        }
        else
        {
            $payload = json_encode(array("mensaje" => "ERROR, No se puedo dar de alta al producto nuevo"));
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    } 

    public function TraerProductos($request, $response, $args)
    {
        $lista = productoSQL::TraerProductos();
        $payload = json_encode(array("listaproductos" => $lista));
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');    
    }
    public function ObtenerProductoxId($request, $response, $args)
    {
        $id = $args['id'];
        $producto = productoSQL::ObtenerProducto($id);
        $payload = json_encode($producto);
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');
    }
}
?>



