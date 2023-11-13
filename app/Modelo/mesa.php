<?php

enum EstadoMesa : string
{
    case Esperando= "Esperando";
    case Comiendo = "Comiendo";
    case Pagando = "Pagando";
    case Cerrado = "Cerrado";
}

class Mesa
{
    public $id;
    public $idPedido;
    public $idMozo;
    public $estado;

    public function __construct()
    {
        $params = func_get_args();
        $num_params = func_num_args();
        $funcion_constructor ='__construct'.$num_params;
        if (method_exists($this,$funcion_constructor)) {
         
            call_user_func_array(array($this,$funcion_constructor),$params);
        }
    }
    public function __construct3($idPedido = null, $idMozo = null, $estado = EstadoMesa::Cerrado) 
    {
        $this->idPedido = $idPedido;
        $this->idMozo = $idMozo;
        $this->estado = $estado;
    }





}









?>