<?php
class LoginSQL
{
    public static function VerificarLogin($nombre , $clave, $rol)
    {
        $objAccesoDatos = AccesoDatos::dameUnObjetoAcceso();
        $consulta = $objAccesoDatos->RetornarConsulta("SELECT * FROM empleados WHERE nombre = :nombre AND rol = :rol AND activo = 1");
        $consulta->bindValue(':nombre', $nombre);
        $consulta->bindValue(':rol', $rol);
        $consulta->execute();
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return $resultado;
    }
}
?>