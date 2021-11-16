<?php
require_once './models/Venta.php';
require_once './models/Usuario.php';
require_once './models/Crypto.php';
require_once './service/Pdf.php';

class VentaController extends Venta 
{
    public function CargarUno($request, $response, $args)
    {
      //$parametros = $request->getParsedBody();
      $parametros = $request->getParsedBody()["body"];

      $id_cliente = $parametros['id_cliente'];
      $id_crypto = $parametros['id_crypto'];
      $cantidad = $parametros['cantidad'];
      $archivo = $request->getUploadedFiles();

      if (!isset($parametros) || !isset($id_cliente) || !isset($id_crypto) || !isset($cantidad)) {
        $payload = json_encode(array("error" => "Faltan ingresar datos."));
        $response = $response->withStatus(400);
      } else {

        $usuario = Usuario::obtenerUsuario($id_cliente);
        $crypto = CryptoController::listarCryptoPorId($id_crypto);
        $ruta = "";


        if($usuario != null && $crypto != null){

            if ($archivo["foto"]) {
                $destino = "./FotosCrypto/";
                $extension = explode(".",$archivo["foto"]->getClientFileName());
                $extension = array_reverse($extension)[0];
                $urlFoto = $usuario[0]->nombre."-".$crypto[0]->nombre."-".date('Y-m-d').".". $extension;
                $archivoFoto = $archivo["foto"];
                $archivoFoto->moveTo($destino . $urlFoto);
                $ruta = $urlFoto;
            }
      
              $venta = new Venta();
              $venta->id_cliente = $id_cliente;
              $venta->id_crypto = $id_crypto;
              $venta->cantidad = $cantidad;
              $venta->foto = $ruta;
              $venta->crearVenta();
              $payload = json_encode(array("mensaje" => "Venta creada con exito."));
              $response = $response->withStatus(201);
        }else{
            $payload = json_encode(array("mensaje" => "Id Usuario o Id Crypto, INEXISTENTES"));
        }
      }
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function TreaerVentasAlemanas($request, $response, $args){
        $ventas = Venta::obtenerVentasAlemanas();
        $response->getBody()->write(json_encode(array("Lista Ventas Alemanas" => $ventas)));
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function TreaerUsuariosQueCompraron($request, $response, $args){
        $moneda= $args['UsuariosQueCompraron'];
        $ventas = Venta::usuariosQueCompraron($moneda);
        $response->getBody()->write(json_encode(array("Lista Usuarios Que Compraron :".$moneda => $ventas)));
      return $response->withHeader('Content-Type', 'application/json');
    }

    public function ObtenerPdf($request, $response, $args)
    {
      ob_clean();
      ob_start();
      $ventas = Venta::obtenerVentas();
      $pdf = new PdfServicio();
      $pdf->SetTitle("Ventas");
      $pdf->AddPage();
      $pdf->Cell(150, 10, 'Ventas: ', 0, 1);
      foreach ($ventas as $v) {
        $pdf->Cell(150, 10, Venta::toString($v));
        $pdf->Ln();
      }
      $pdf->Output('F','PDF_VENTAS.pdf',false); 
      ob_end_flush();
  
      $payload = json_encode(array("mensaje" => "Descargado"));
      $response->getBody()->write($payload);
      return $response->withHeader('Content-Type', 'application/pdf');
    }

}

?>