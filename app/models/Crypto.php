<?php

class Crypto
{
    public $id;
    public $precio;
    public $nombre;
    public $foto;
    public $nacionalidad;


    public function crearCrypto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("INSERT INTO crypto (precio,nombre,foto,nacionalidad) 
                                                        VALUES (:precio,:nombre,:foto,:nacionalidad)");
        
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
  
        $consulta->execute();

        return $objAccesoDatos->obtenerUltimoId();
    }

    public static function listarCrypto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT *
                                                        FROM crypto");
        $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Crypto');
    }

    public static function listarCryptoPorNacionalidad($nacionalidad)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT *
                                                        FROM crypto
                                                        WHERE nacionalidad = :nacionalidad");
        $consulta->bindValue(':nacionalidad', $nacionalidad, PDO::PARAM_STR); 
         $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Crypto');
    }

    public static function listarCryptoPorId($id)
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT *
                                                        FROM crypto
                                                        WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR); 
         $consulta->execute();
        return $consulta->fetchAll(PDO::FETCH_CLASS, 'Crypto');
    }

    public static function borrarPorId($id)
    { 
        $objAccesoDato = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDato->prepararConsulta("DELETE 
                                                        FROM crypto 
                                                        WHERE id = :id");
        $consulta->bindValue(':id', $id, PDO::PARAM_STR);
        $consulta->execute();
    }

    public function modificarCrypto()
    {
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("UPDATE crypto 
                                                        SET precio = :precio,
                                                        nombre = :nombre,
                                                        foto = :foto,
                                                        nacionalidad = :nacionalidad
                                                       WHERE id = :id");
        
        $consulta->bindValue(':id', $this->id, PDO::PARAM_STR);
        $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
        $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
        $consulta->bindValue(':foto', $this->foto, PDO::PARAM_STR);
        $consulta->bindValue(':nacionalidad', $this->nacionalidad, PDO::PARAM_STR);
        $consulta->execute();
        return $objAccesoDatos->obtenerUltimoId();
    }


    public static function obtenerCryptoPorFoto($nombreFoto)
    { 
        $objAccesoDatos = AccesoDatos::obtenerInstancia();
        $consulta = $objAccesoDatos->prepararConsulta("SELECT * 
                                                        FROM crypto 
                                                        WHERE foto = :foto");
        $consulta->bindValue(':foto', $nombreFoto, PDO::PARAM_INT);
        $consulta->execute();

        return $consulta->fetchAll(PDO::FETCH_OBJ);
    }




}