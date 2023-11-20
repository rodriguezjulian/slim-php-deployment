<?php

include("/xampp/htdocs/slim-php-deployment/app/Utilidades/AutentificadorJWT.php");
include ("./BaseDatos/loginSQL.php");
include_once ("./BaseDatos/empleadoSQL.php");
class LoginControlador 
{
    //tener en cuenta que el usuario este activo para poder loguearse
    public static function VerificarExistenciaUsuario($request, $response, $args)
    {
        $parametros = $request->getParsedBody();
        if(isset($parametros['nombre']) && isset($parametros['clave']) && isset($parametros['rol']))
        {
           $retorno = LoginSQL :: VerificarLogin($parametros['nombre'],$parametros['clave'],$parametros['rol']);
     
           if($retorno!=null)
           {
                if(password_verify($parametros['clave'],$retorno['clave']))
                {
                    $datos=array('nombre'=>$parametros['nombre'],'rol'=>$parametros['rol']);
                    $token = AutentificadorJWT::CrearToken($datos);
                    $payload = json_encode(array('jwt' => $token));
                }
                else
                {
                    $payload = json_encode(array('ERROR' => "Posible error en : Usuario | clave | rol | empleado inactivo"));
                }
           }
           else
           {
                $payload = json_encode(array('ERROR, revise datos ingresados'));
           }    
        }
        else
        {
            $payload = json_encode(array('ERROR' => 'Faltan ingresar datos'));
        }
        $response->getBody()->write($payload);
        return $response;
    }
}












?>