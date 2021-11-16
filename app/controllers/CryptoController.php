<?php
require_once './models/Crypto.php';

class CryptoController extends Crypto
{
    public function CargarUno($request, $response, $args)
    {
      $parametros = $request->getParsedBody()["body"];

      $precio = $parametros['precio'];
      $nombre = $parametros['nombre'];
      $nacionalidad = $parametros['nacionalidad'];
      $archivo = $request->getUploadedFiles();

      if (!isset($parametros) || !isset($precio) || !isset($nombre) || !isset($nacionalidad)) {
        $payload = json_encode(array("error" => "Faltan ingresar datos."));
        $response = $response->withStatus(400);
      } else {

        $ruta = "";

        if ($archivo["foto"]) {
          $destino = "./FotosCrypto/FOTOS/";
          $extension = explode(".",$archivo["foto"]->getClientFileName());
          $extension = array_reverse($extension)[0];
          $urlFoto = $nombre.".". $extension;
          $archivoFoto = $archivo["foto"];
          $archivoFoto->moveTo($destino . $urlFoto);
          $ruta = $urlFoto;
        }

        $hortaliza = new Crypto();
        $hortaliza->precio = $precio;
        $hortaliza->nombre = $nombre;
        $hortaliza->nacionalidad = $nacionalidad;
        $hortaliza->foto = $ruta;
        $hortaliza->crearCrypto();
        $payload = json_encode(array("mensaje" => "Crypto creada con exito."));
        $response = $response->withStatus(201);
      }
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function listarCryptos($request, $response, $args){
        $crypto = Crypto::listarCrypto();
        $response->getBody()->write(json_encode(array("Lista Cryptos" => $crypto)));
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function listarCryptosPorNacionalidad($request, $response, $args){
      $nacionalidad= $args['nacionalidad'];
      $crypto = Crypto::listarCryptoPorNacionalidad($nacionalidad);
      $response->getBody()->write(json_encode(array("Lista Cryptos ".$nacionalidad.":" => $crypto)));
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function listarPorId($request, $response, $args){
      $id= $args['id'];
      $crypto = Crypto::listarCryptoPorId($id);
      $response->getBody()->write(json_encode(array("Crypto ".$id.":" => $crypto)));
    return $response->withHeader('Content-Type', 'application/json');
  }

  public function BorrarCryptoPorId($request, $response, $args)
  {
      $id = $args['id'];
      Crypto::borrarPorId($id);

      $payload = json_encode(array("mensaje" => "[BAJA]: Crypto ".$id." borrada con exito"));

      $response->getBody()->write($payload);
      return $response
        ->withHeader('Content-Type', 'application/json');
  }

  public function ModificarPorId($request, $response, $args)
  {
    $parametros = $request->getParsedBody()["body"];
      $id = $parametros['id'];
      $precio = $parametros['precio'];
      $nombre = $parametros['nombre'];
      $nacionalidad = $parametros['nacionalidad'];
      $archivo = $request->getUploadedFiles();

      if (!isset($parametros) || !isset($id) || !isset($precio) || !isset($nombre) || !isset($nacionalidad)) {
        $payload = json_encode(array("error" => "Faltan ingresar datos."));
        $response = $response->withStatus(400);
      } else {

        $ruta = "";

        if ($archivo["foto"]){
          $destino = "./FotosCrypto/BACKUP/";
          $extension = explode(".",$archivo["foto"]->getClientFileName());
          $extension = array_reverse($extension)[0];
          $urlFoto = $nombre.".". $extension;
          //Si LA FOTO EXISTE, LA GUARDA EN BACKUP
          if(Crypto::obtenerCryptoPorFoto($urlFoto)!= null){
            $archivoFoto = $archivo["foto"];
            $archivoFoto->moveTo($destino . $urlFoto);
            $ruta = $urlFoto;
          }else{
            //Si LA FOTO NO EXISTE, LA GUARDA EN FotoHortalizas
            $destino = "./FotosCrypto/FOTOS/";
            $archivoFoto = $archivo["foto"];
            $archivoFoto->moveTo($destino . $urlFoto);
            $ruta = $urlFoto;
          }
        }

        $crypto = new Crypto();
        $crypto->id = $id;
        $crypto->precio = $precio;
        $crypto->nombre = $nombre;
        $crypto->nacionalidad = $nacionalidad;
        $crypto->foto = $ruta;
        $crypto->modificarCrypto();
        $payload = json_encode(array("mensaje" => "Crypto modificada con exito."));
        $response = $response->withStatus(201);
      }
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }

      

}