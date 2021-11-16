<?php

use Symfony\Component\Console\CI\GithubActionReporter;

class Venta
{
    public $id;
    public $id_cliente;
    public $id_crypto;
    public $fecha;
    public $cantidad;
    public $foto;

    public function crearVenta()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO ventas (id_cliente,id_crypto,fecha,cantidad,foto) 
                                                                    VALUES (:id_cliente, :id_crypto, :fecha, :cantidad,:foto)");
        $consulta->bindValue(':id_cliente', $this->id_cliente, PDO::PARAM_INT);
        $consulta->bindValue(':id_crypto', $this->id_crypto, PDO::PARAM_INT);
        $consulta->bindValue(':fecha', date('Y-m-d H:i:s'), PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_INT);
        $consulta->execute();
        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function obtenerVentas()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT *
                                                        FROM ventas");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }

    public static function obtenerVentasAlemanas()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT ventas.id_cliente, ventas.id_crypto, ventas.fecha, ventas.cantidad 
                                                        FROM ventas,crypto 
                                                        WHERE ventas.id_crypto = crypto.id 
                                                        AND crypto.nacionalidad = 'alemania'
                                                        AND cast(ventas.fecha AS date) BETWEEN '2021-06-10' AND '2021-06-13'");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Venta');
    }


    public static function usuariosQueCompraron($moneda)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta(" SELECT usuarios.id,usuarios.nombre,usuarios.mail
                                                            FROM usuarios,ventas,crypto 
                                                            WHERE (ventas.id_crypto = crypto.id 
                                                                AND ventas.id_cliente = usuarios.id
                                                                AND crypto.nombre = :moneda )");
        $consulta->bindValue(':moneda',$moneda, PDO::PARAM_STR);
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Usuario');
    }

    public static function toString(Venta $venta){
        return 'Id Venta: ' . $venta->id . '|| Id cliente: '. $venta->id_cliente . '|| Id Crypto: ' . $venta->id_crypto . '|| Fecha: ' . $venta->fecha . '|| Cantidad: ' .$venta->cantidad;
    }


}
?>