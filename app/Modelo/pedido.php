<?php

enum EstadoPedido: string
{
    case Pendiente="Pendiente";
    case Preparacion="Preparacion";
    case Cancelado="Cancelado";
    case Entregado="Entregado";
}
class Pedido
{
    public $id;
    public $codigo; //alfanumerico
    public $nombreCliente;
    public $totalPrecio;
    public $estado;
    public $tiempoEstimado;
    public $numeroMesa;

    public function __construct()
    {
        $params = func_get_args();
        $num_params = func_num_args();
        $funcion_constructor ='__construct'.$num_params;
        if (method_exists($this,$funcion_constructor)) {
         
            call_user_func_array(array($this,$funcion_constructor),$params);
        }
    }

    public function __construct6($id,$nombreCliente, $totalPrecio, $estado = EstadoPedido::Preparacion, $tiempoEstimado, $numeroMesa) 
    {
        $this->id = $id;
        $this->codigo = self::GenerarCodigo();
        $this->nombreCliente = $nombreCliente;
        $this->totalPrecio = $totalPrecio;
        $this->estado = $estado;
        $this->tiempoEstimado = $tiempoEstimado;
        $this->numeroMesa = $numeroMesa;
    }
    public static function GenerarCodigo()
    {
        $id = "";
        $caracteres = "0123456789abcdefghijklmnopqrstuvwxyz";

        for($i = 0; $i < 5; $i++)
        {
            $id .= $caracteres[rand(0, strlen($caracteres)-1)];
        }

        return $id;
    }

}





?>