<?php
//include ("./Modelo/empleado.php");
//include ("./BaseDatos/empleadoSQL.php");
class archivosControlador
{
    public static function SubirEmpleadosDesdeCsv($ruta)
    {
        $flag=0;
        $archivo=fopen($ruta,"r");
        if($archivo!=null)
        {
            while(($data=fgetcsv($archivo,1000,","))!=false)
            {
                if($flag==1)
                {
                    $empleado = new Empleado();
                    $empleado->id = $data[0];
                    $empleado->rol = $data[1];
                    $empleado->nombre = $data[2];
                    $empleado->activo = $data[3];
                    $empleado->clave = $data[4];
                    //var_dump($empleado);
                    empleadoSQL :: InsertarEmpleado($empleado);
                }
                $flag=1;
            }
        }
       
        fclose($archivo);
    }
    public static function DescargarEmpleadosDesdeBD()
    {
        $listaEmpleados=EmpleadoSQL::ObtenerEmpleados();
        $data="id,rol,nombre,activo,clave\n";
        foreach($listaEmpleados as $empleado)
        {
            $data=$data.$empleado->id . "," .$empleado->rol .",".$empleado->nombre. "," .$empleado->activo."," .$empleado->clave ."\n";
        }
        return $data;
    }

}
?>