<?php
require_once 'lib/dompdf/autoload.inc.php';
  // reference the Dompdf namespace
  use Dompdf\Dompdf;
    
    $cotizacion = devolverValorQuery("SELECT *,date_format(creado, '%d-%m-%Y') as creado FROM ".DB_PREFIJO."cotizacion WHERE id".DB_PREFIJO."cotizacion=".$_GET['id']." ");

    $productos = "SELECT * FROM ".DB_PREFIJO."cotizacion_has_producto WHERE id".DB_PREFIJO."cotizacion=".$_GET['id']." ";
    $resProductos = mysqli_query($conexion,$productos);

    $cadenaURL = $cotizacion['folio'];
    $cadena_limpia= limpiar_cadena($cadenaURL);

    $pdf_name = "cotizacion_".$cadena_limpia;

    $html_content="
    <html>
    <title></title>
    <head>
        <style type=\"text/css\">
            @page {
              margin: .4cm 1cm;
            }

            body {
              font-family: sans-serif;
              /*margin: 1.5cm 1.5cm 0 1.5cm;*/
              text-align: justify;
              position:relative;
            }

            div.hoja-membretada{
              position:absolute;
              /*top:-2.5cm;
              left:-2.8cm;*/
              top:0;
              left:-.8cm;
              width:140%;
              height:120%;
              z-index:-1;
              background:url(../img/machote_cotizacion.jpg);
              background-repeat:no-repeat;
              background-size:100% !important;
            }

            #header,
            #footer {
              position: fixed;
              left: 0;
              right: 0;
              color: #aaa;
              font-size: 0.9em;
            }

            #header {
              top: 0px;
              left:20%;
              background:F00;
            }

            #footer {
              bottom: 0;
              border-top: 0.1pt solid #aaa;
            }

            #header table,
            #footer table {
              width: 100%;
              border-collapse: collapse;
              border: none;
            }

            #header td,
            #footer td {
              padding: 0;
              width: 50%;
            }

            hr {
              page-break-after: always;
              border: 0;
            }
            .encabezado {position:relative; width:90%; height:60px; margin:128px 0 0 80px; font-size:12px; }
            .nombre{width:295px; height:37px; float:left; line-height:20px;}
            .telefono{float:left;  height:37px; line-height:20px; margin-left:10px;}
            .correo{width:200px; float:left; margin-top:50px;}
            .estado{width:150px; float:left; margin-left:10px;}
            .creado{width:120px; float:left; margin-left:15px;}
            .folio{width:100px; float:left; margin-left:60px; font-size:24px; margin-top:-10px;}
            .productos{width:100%; margin:50px auto 0 auto; }
            table{margin:0; padding:0;}
            table tr td{padding:5px 0; color:#777; font-size:15px;}
            table tr td:first-child{padding-left:15px;}
            .clear{clear:both;}

        </style>
    </head>
    <body>
        <div class=\"hoja-membretada\"></div>
        <div id=\"header\"></div>
        <div class=\"page_content\">
            <div class=\"encabezado\">
               <div class=\"nombre\">".utf8_encode($cotizacion['nombre'])."</div>
               <div class=\"telefono\">".$cotizacion['telefono']."</div>
               <div class=\"clear\"></div>
               <div class=\"correo\">".utf8_encode($cotizacion['correo'])."</div>
               <div class=\"estado\">".mostrarNombreEstado(utf8_encode($cotizacion['id'.DB_PREFIJO.'estado']))."</div>
               <div class=\"creado\">".utf8_encode($cotizacion['creado'])."</div>
               <div class=\"folio\">C".$cotizacion['folio']."</div>
            </div>
            <div class=\"productos\">
             <table>
             ";
                 while($rowProducto = mysqli_fetch_array($resProductos)){ 
                    $producto = devolverValorQuery("SELECT * FROM ".DB_PREFIJO."producto WHERE id".DB_PREFIJO."producto=".$rowProducto['id'.DB_PREFIJO.'producto']."");
            $html_content.="
                            <tr>
                                <td width=\"80\">".utf8_encode($producto['clave'])."</td>
                                <td width=\"280\">".utf8_encode($producto['nombre'])."</td>
                                <td width=\"120\" align=\"center\">".utf8_encode(mostrarProductoMarca($producto['id'.DB_PREFIJO.'categoria']))."</td>
                                <td align=\"center\">".utf8_encode($rowProducto['cantidad'])."</td>
                            </tr>";
                    }

    $html_content.="</table></div>
        </div>
    </body>
</html>";



      // instantiate and use the dompdf class
      $dompdf = new Dompdf();
      

      $dompdf->loadHtml($html_content);

      // (Optional) Setup the paper size and orientation
      $dompdf->setPaper('letter', 'portrait');

      // Render the HTML as PDF
      $dompdf->render();

      // Output the generated PDF to Browser

      $dompdf->stream($pdf_name,array('Attachment'=>0));

      echo $html_content;

?>