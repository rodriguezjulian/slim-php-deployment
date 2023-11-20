<?php
include ("archivosControlador.php");
class csvControlador
{
    public static function cargarCsv($request, $response, $args)   
    {
        //echo "a";
        $archivos = $request->getUploadedFiles();
        $archivo=$archivos["empleado"];
        if(pathinfo($archivo->getClientFilename(),PATHINFO_EXTENSION)=="csv")
        {
            //donde esta ubicado temporalmente el archivo por php
            $rutaTemporal=$archivo->getStream()->getMetadata("uri");
            archivosControlador :: SubirEmpleadosDesdeCsv($rutaTemporal);
            $payload = json_encode(array("Base de datos actualizada."));
        }
        $response->getBody()->write($payload);
        return $response
          ->withHeader('Content-Type', 'application/json');

    }
    public static function descargarCsv()
    {

    }


}
?>