<?php
enum EstadoProducto : string
{
    case Pendiente="Pendiente";
    case EnPreparacion="En preparacion";
    case Realizado="Realizado";
}

class ProductoSolicitado
{
    public $id; 
    public $idProducto;
    public $codigoPedido;
    public $tiempo;
    public $estado;
    public $unidades;
    public $horaDeInicio;
    public $horaDeFinalizacion;

    public function __construct()
    {
        $params = func_get_args();
        $num_params = func_num_args();
        $funcion_constructor ='__construct'.$num_params;
        if (method_exists($this,$funcion_constructor)) {
         
            call_user_func_array(array($this,$funcion_constructor),$params);
        }
    }
    public function __construct4($idProducto, $codigoPedido,$estado, $unidades) 
    {
        $this->idProducto = $idProducto;
        $this->codigoPedido = $codigoPedido;
        $this->estado = $estado;
        $this->unidades = $unidades;
    }
}
?>