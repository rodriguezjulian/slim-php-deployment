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
    public static function descargarCsv($request, $response, $args)
    {
        $data=archivosControlador :: DescargarEmpleadosDesdeBD();
        if($data!=null)
        {
            $response = $response
            ->withHeader('Content-Type', 'application/octet-stream')
            ->withHeader('Content-Disposition', 'attachment;filename=empleados.csv')
            ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->withHeader('Cache-Control', 'post-check=0, pre-check=0')
            ->withHeader('Pragma', 'no-cache');
        }
        $response->getBody()->write($data);
        return $response
        ->withHeader('Content-Type', 'application/json');
    }
}
?>