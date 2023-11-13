<?php
//include ("accesoDatos.php");
class EncuestaSQL
{
    public static function InsertarEncuesta($encuesta)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO encuesta (nombreCliente,descripcion,puntuacionMesa,puntuacionMozo,puntuacionCocinero,puntuacionRestaurant) VALUES('$encuesta->nombreCliente','$encuesta->descripcion','$encuesta->puntuacionMesa','$encuesta->puntuacionMozo','$encuesta->puntuacionCocinero','$encuesta->puntuacionRestaurant')");
        $consulta->execute();
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
    }
    public static function TraerEncuestas()
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT id,idMesa, nombreCliente, descripcion, puntuacionMesa, puntuacionMozo, puntuacionCocinero, puntuacionRestaurant FROM encuesta");
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_CLASS, 'encuesta');
    }
    

    public static function ObtenerEncuesta($id)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM encuesta WHERE id = :id");
        $consulta->bindValue(':id', $id);
        $consulta->execute();
        return $consulta->fetchObject('encuesta');
    }
}
?>