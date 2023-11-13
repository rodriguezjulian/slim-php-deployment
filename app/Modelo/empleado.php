<?php

enum Rol : string
{
    case Bartender = "Bartender" ;
    case Cervecero = "Cervecero" ;
    case Cocinero = "Cocinero" ;
    case Mozo = "Mozo";
}
enum EstadoEmpleado : string
{
    case Presente = "Presente";
    case Ausente = "Ausente";
}

class Empleado
{
    public $id;
    public $rol;
    public $nombre;
    public $disponible; //disponible no disponible
    public $estado; //presente ausente
    public function __construct()
    {
        //obtengo un array con los parámetros enviados a la función
        $params = func_get_args();
        //saco el número de parámetros que estoy recibiendo
        $num_params = func_num_args();
        //cada constructor de un número dado de parámtros tendrá un nombre de función
        //atendiendo al siguiente modelo __construct1() __construct2()...
        $funcion_constructor ='__construct'.$num_params;
        //compruebo si hay un constructor con ese número de parámetros
        if (method_exists($this,$funcion_constructor)) {
            //si existía esa función, la invoco, reenviando los parámetros que recibí en el constructor original
            call_user_func_array(array($this,$funcion_constructor),$params);
        }
    }
    public function __construct4($rol, $nombre, $disponible, $estado) 
    {
        $this->rol = $rol;
        $this->nombre = $nombre;
        $this->disponible = $disponible;
        $this->estado = $estado;
    }
}
?>