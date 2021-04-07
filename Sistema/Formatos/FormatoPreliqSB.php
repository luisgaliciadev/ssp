<?php
	//include("../reportes/MPDF57/mpdf.php");
	$Nivel="../../";
	include($Nivel."includes/plugins/MPDF57/mpdf.php");
	include($Nivel."includes/PHP/funciones.php");
	$Conector=Conectar2();
	
	

	
	$sql = "select * from web.View_Web_Rpt_SolMuelle where id =23561";
	 $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	 $CONEXION=$ResultadoEjecutar["CONEXION"];						
     $ERROR=$ResultadoEjecutar["ERROR"];
     $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
      $result=$ResultadoEjecutar["RESULTADO"];
			
       while ($registro=odbc_fetch_array($result))
       {
		  $nro_solicitud = odbc_result($result,'solicitud'); 
		  $agente = odbc_result($result,'NB_PROVEED_BENEF'); 
		  $rif = odbc_result($result,'RIF_CED_GENERA');
		  
		  $NB_BUQUE = odbc_result($result,'NB_BUQUE'); 
		  $ID_BUQUE_LLOYD = odbc_result($result,'ID_BUQUE_LLOYD'); 
		  $NACIONALIDAD = odbc_result($result,'NACIONALIDAD');
		  
		  $ESLORA = odbc_result($result,'ESLORA'); 
		  $TRB = odbc_result($result,'TRB'); 
		  $CALADO_POPA = odbc_result($result,'CALADO_POPA');
		  $CALADO_PROA = odbc_result($result,'CALADO_PROA');
		  
		  $NRO_VIAJE = odbc_result($result,'NRO_VIAJE'); 
		  $CAPITAN = odbc_result($result,'CAPITAN'); 
		  $NB_BIEN = odbc_result($result,'NB_BIEN');
		  
		  $FECHA_ETA = odbc_result($result,'FECHA_ETA'); 
		  $FECHA_REG = odbc_result($result,'FECHA_REG'); 
		  $FECHA_ETD = odbc_result($result,'FECHA_ETD'); 
		  
		  $PUERTO_PROC = odbc_result($result,'PUERTO_PROC'); 
		  $PUERTO_DESTINO= odbc_result($result,'PUERTO_DESTINO'); 
		  
		  $cod_qr = odbc_result($result,'COD_SEGURIDAD'); 
		  
		  
		  
		  
		   
		   	
      }
	
		
	
                        
     $Conector->Cerrar();
	 
	$date = date("Y/m/d H:i"); 
    //$date = explode("/", $date); 
	//$hora = date("H:i");



$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'qrtemp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'qrtemp/';

    include "../reportes/qr_lib/qrlib.php";    
    
    //ofcourse we need rights to create temp dir
    if (!file_exists($PNG_TEMP_DIR))
        mkdir($PNG_TEMP_DIR);
    
    
    $filename = $PNG_TEMP_DIR.'test.png';
    
    //processing form input
    //remember to sanitize user input in real-life solution !!!
	$errorCorrectionLevel = 'M';
	
	$matrixPointSize = 2;
	 
	$data= $cod_qr;
	 
	 $filename = $PNG_TEMP_DIR.'test'.md5($data.'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
	
	QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);   
	
	  $qr= '<img src="'.$PNG_WEB_DIR.basename($filename).'" />'; 



$cabecera='
';


$cuerpo='

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/bootstrap.css"  rel="stylesheet"/> 

<style>

table {
  border-collapse: collapse;
}

body{
	font-size:13px;
}

.border{	
	height: 307px;
}

.border img{
	width: 100%;
	height: 307px;
	
}


.div{
	border:1px solid #000;
}

.letras{
	font-size: 9px;
}

.imagen{
	height:100%;
	padding-top:20px;
	
}
.imagen img{
	 WIDTH:100%;
	 height:100%;
}



</style>

<body style="font-family: serif; font-size: 10pt;">
<div class="row">
<div  style="float:right" >
	
	<table  border="1" width="100%">
		<tr>
			 <td rowspan="3"><img src="img/logo_pequeno2.jpg">
			 </td>
			 <td rowspan="3" style = "text-align: center;">
			 <div align="center"> 
			 	<h2>PRELIQUIDACION SERVICIO AL BUQUE </h2>
				</div>
			 </td>
			 </div>
              <td>
			  	<h4>BOLIPUERTOS</h4>
			  </td>
		 </tr>
		 <tr>
		 	<td>
				<h4>Nro.:</h4>
			</td>
		 </tr>
		  <tr>
		 	<td>
				<h4>Fecha:</h4>
			</td>
		 </tr>
	</table>
	<table  width="100%">
		<tr>
			<td align="center"> <strong> Datos del Buque </strong></td>
		</tr>
	</table>
	<table border="1" width="100%">
		<tr>
			<td colspan="2"> <strong>BUQUE: </strong>'.$NB_BUQUE.' </td>
			<td><strong>IMO: </strong>'.$ID_BUQUE_LLOYD.'</td>
			<td><strong>BANDERA: </strong>'.$NACIONALIDAD.'</td>
			<td rowspan="4">'.$qr.'</td>
		</tr>
		
		<tr>
			<td><strong>ESLORA: </strong>'.$ESLORA.'</td>
			<td><strong>TRB: </strong>'.$TRB.'</td>
			<td><strong>CALADO PROA: </strong>'.$CALADO_PROA.'</td>
			<td><strong>CALADO POPA: </strong>'.$CALADO_POPA.'</td>
		</tr>
		
		<tr>
			<td><strong>VIAJE: </strong>'.$NRO_VIAJE.'</td>
			<td colspan="2"><strong>CAPITAN: </strong>'.$CAPITAN.'</td>
			<td><strong>PREF. MUELLE: </strong>'.$NB_BIEN.'</td>
		</tr>
		
		<tr>
			<td><strong>ETA: </strong>'.$FECHA_ETA.'</td>
			<td><strong>ETD: </strong>'.$FECHA_ETD.'</td>
			<td><strong>PROC.:</strong> '.$PUERTO_PROC.'</td>
			<td><strong>DEST:</strong> '.$PUERTO_DESTINO.'</td>
		</tr>
	</table>
</div>
</div>
<div>
	<table  width="100%">
		<tr>
			<td align="center"> <strong> Datos de los Operadores </strong></td>
		</tr>
	</table>
		
	
	<table border="1 " width="100%">
		
			<tr>
				<td>RIF</td>
				<td>NOMBRE</td>
				<td>ACTIVIDAD</td>
				<td>FIRMA</td>
				<td>FECHA</td>
			</tr>
		';
		$sql = "exec [web].[SP_LISTADO_BENEF_X_SOL] 23557";
		 $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
		 $CONEXION=$ResultadoEjecutar["CONEXION"];						
		 $ERROR=$ResultadoEjecutar["ERROR"];
		 $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
		  $result=$ResultadoEjecutar["RESULTADO"];
				
		   while ($registro=odbc_fetch_array($result)){
			 $cuerpo .= "<tr>
			 			<td width='10%' >".odbc_result($result,'BEN_RIF_CED')."</td>
						<td width='25%'>".odbc_result($result,'NOMBRE_EMP')."</td>
						<td width='25%'>".odbc_result($result,'ACTIVIDAD')."</td>
						<td width='20%' height='80px;'></td>
						<td width='20%'></td>
				   </tr>
			 
			 ";
		   }
		
	$cuerpo .='</table>
</div>
</body>



</html>';

$pie='<div class="row">
	<div class="col-md-offset-2 col-md-8"  >
	
   	  <table class="table-bordered" width="100%">
        	<tr>
            	<td colspan="6"><h5>Datos del Transportista</h5></td>
                <td colspan="6"><h5>Datos del Chequeador</h5></td>
            </tr>
            <tr>
            	<td colspan="6"><h5>Nombre del Chofer Legible:</h5></td>
                <td colspan="6"><h5>Nombre Legible:</h5></td>
            </tr>
            <tr >
            	<td colspan="4">
                	<table class="table-bordered" width="100%" >
                    	<tr>
                        	<td height="45">CEDULA DE IDENTIDAD</td>
                            <td height="45">PLACA</td>
                        </tr>
                        <tr>
                        	<td colspan="2" height="45">FIRMA</td>
                        </tr>
                    </table>
                </td>
              	<td colspan="2" ><h5>HUELLA:</h5></td>
                <td colspan="4">
                	<table class="table-bordered" width="100%" >
                    	<tr>
                        	<td colspan="2" height="45">CEDULA DE IDENTIDAD</td>
                        </tr>
                        <tr>
                        	<td colspan="2" height="45">FIRMA</td>
                        </tr>
                    </table>
                </td>
              	<td colspan="2" height="90"><h5>HUELLA:</h5></td>
        	</tr>
            
        </table>
        
    
    </div>
	    
    
</div>';

//echo $cuerpo;
//exit;
$mpdf=new mPDF('c','letter');
	$mpdf->SetTitle('Preliquidación Servicio al Buque');
	$mpdf -> SetFont('couriernew');
	$mpdf->watermarkTextAlpha = 0.6;
	$mpdf->showWatermarkImage = true;  
	$mpdf->SetHTMLHeader($cabecera);
	$mpdf->SetHTMLFooter($pie);
	$txt	=	iconv ("ISO-8859-1", "UTF-8", $txt);
	$mpdf->WriteHTML($cuerpo);
	//$mpdf->MultiCell(0,5,$txt,0,'J');
	$mpdf->Output();
?>