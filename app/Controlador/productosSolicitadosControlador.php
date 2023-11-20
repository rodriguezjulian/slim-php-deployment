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
            $productoSolicitado= new ProductoPedido();
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
            // $parametros = $request->getQueryParams();
             $data=AutentificadorJWT::ObtenerData($token);
             $rol=$data->rol;
             $lista= productoSolicitadosSQL :: ObtenerProductosPorTipo($rol);
             $payload = json_encode(array("Lista productos pendiente para $rol: =>$lista"));
        }
    }

?>