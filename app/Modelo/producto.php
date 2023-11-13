<?php
enum tipoProducto:string
{
    case Bartender="Bartender";
    case Cervecero="Cervecero";
    case Cocinero="Cocinero";
}

class Producto
{
    public $id;
    public $nombre;
    public $precio;
    public $tipo; 
    public $tiempo;//minutos

    public function __construct()
    {
        $params = func_get_args();
        $num_params = func_num_args();
        $funcion_constructor ='__construct'.$num_params;
        if (method_exists($this,$funcion_constructor)) {
         
            call_user_func_array(array($this,$funcion_constructor),$params);
        }
    }
    public function __construct4($nombre, $precio, $tipo, $tiempo) 
    {
        $this->nombre = $nombre;
        $this->precio = $precio;
        $this->tipo = $tipo;
        $this->tiempo = $tiempo;
    }
}
?>