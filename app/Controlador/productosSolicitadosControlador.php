<?php
include ("./Modelo/productosSolicitados.php");
include ("./BaseDatos/productoSolicitadosSQL.php");

class ProductoSolicitadoControlador
{
    public function Insertar($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        if(isset($parametros['idProducto']) && isset($parametros['codigoPedido']) && isset($parametros['unidades']))
        {
            $idProducto=$parametros['idProducto'];
            $codigoPedido=$parametros['codigoPedido'];
            $unidades=$parametros['unidades'];
            $productoSolicitado= new ProductoSolicitado();
            $productoSolicitado->idProducto=$idProducto;
            $productoSolicitado->codigoPedido=$codigoPedido;
            $productoSolicitado->unidades=$unidades;
            $productoSolicitado->estado="Pendiente";
            productoSolicitadosSQL :: InsertarProductoSolicitado($productoSolicitado);
            $payload = json_encode(array("Producto agregado al pedido."));
        }
        else
        {
            $payload = json_encode(array("Error al agregar producto al pedido."));
        }
            $response->getBody()->write($payload);
            return $response;
        }
        public function ListarPorTipo($request, $response, $args)
        {
            $header = $request->getHeaderLine('Authorization');
            $token = trim(explode("Bearer", $header)[1]);
            AutentificadorJWT::VerificarToken($token);
             $data=AutentificadorJWT::ObtenerData($token);
             $rol=$data->rol;
             $lista= productoSolicitadosSQL :: ObtenerProductosPorTipo($rol);
             $payload = json_encode(array("Lista productos pendiente para $rol:" =>$lista));
             $response->getBody()->write($payload);
             return $response
             ->withHeader('Content-Type', 'application/json');
        }

        public function CambiarEstado($request, $response, $args)
        {
            $parametros = $request->getParsedBody();
            if(isset($parametros['id']) && isset($parametros['tiempo']))
            {
                
                $header = $request->getHeaderLine('Authorization');
                $token = trim(explode("Bearer", $header)[1]);
                AutentificadorJWT::VerificarToken($token);
                $data=AutentificadorJWT::ObtenerData($token);
                $rol=$data->rol;
                $idProductoSolicitado=$parametros['id'];
                $tiempo=$parametros['tiempo'];
                $tipoProducto="";
                $estadoActualProductoSolicitado="";
                $listaProductos = ProductoSQL::TraerProductos();
                $listaProductosSolicitados=ProductoSolicitadosSQL::TraerProductos();
              

                foreach($listaProductosSolicitados as $ProductoSolicitado)
                {
                    if($ProductoSolicitado->id == $idProductoSolicitado)
                    {
                        $estadoActualProductoSolicitado=$ProductoSolicitado->estado;
                        foreach($listaProductos as $producto)
                        {
                            if($ProductoSolicitado->idProducto == $producto->id)
                            {
                                $tipoProducto=$producto->tipo;
                                break;
                            }
                        }
                        
                    }
                }
                if($tipoProducto==$rol && $estadoActualProductoSolicitado=="Pendiente")
                {
                    ProductoSolicitadosSQL :: CambiarEnProceso($idProductoSolicitado,$tiempo);
                }
                else
                {
                    if($tipoProducto==$rol && $estadoActualProductoSolicitado=="En preparacion")
                    {

                    }
                }

                $payload = json_encode(array("Producto solicitado en proceso"));
            }
            $response->getBody()->write($payload);
            return $response
            ->withHeader('Content-Type', 'application/json');
        }
    }

?>