<?php
enum EstadoProducto
{
    case Realizado;
    case Pendiente;
    case EnProceso;
}

class ProductoPedido
{
    public $id; 
    public $idProducto;
    public $idPedido;
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
    public function __construct3($idProducto, $idPedido, $estado) 
    {
        $this->idProducto = $idProducto;
        $this->idPedido = $idPedido;
        $this->estado = $estado;
    }
}
?>