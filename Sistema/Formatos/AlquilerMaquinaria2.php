<?php 


$Nivel="../../";
include($Nivel."includes/plugins/MPDF57/mpdf.php");
include($Nivel."includes/PHP/funciones.php");

$id_preliq = $_GET["id_preliq"];

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
		  
		  $DS_TIPO_SOLICITUD = odbc_result($result,'DS_TIPO_SOLICITUD'); 
		  $RENAVE = odbc_result($result,'RENAVE'); 
		  
      }	              
$Conector->Cerrar();

$Conector=Conectar3();
	$sql = "select * from VIEW_ENCABEZADO_PRE_WEB where id_preliquidacion = $id_preliq";
	 $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	 $CONEXION=$ResultadoEjecutar["CONEXION"];						
     $ERROR=$ResultadoEjecutar["ERROR"];
     $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
      $result=$ResultadoEjecutar["RESULTADO"];
			
       while ($registro=odbc_fetch_array($result))
       {
		 
		  $ID_PRELIQUIDACION = odbc_result($result,'ID_PRELIQUIDACION'); 
		  $ID_SOLIC_MUELLE = odbc_result($result,'ID_SOLIC_MUELLE'); 
		  $NOMBRE = odbc_result($result,'NOMBRE'); 
		  $RIF = odbc_result($result,'RIF'); 
		  $DESCRIP = odbc_result($result,'DESCRIP'); 
		  $VALOR = odbc_result($result,'VALOR'); 
		  $VALOR_MONEDA = odbc_result($result,'VALOR_MONEDA');
		  $SUBTOTAL_CAMBIO = odbc_result($result,'SUBTOTAL_CAMBIO');
		  $MONTO_TOTAL = odbc_result($result,'MONTO_TOTAL');
		  $MONTO_IVA = odbc_result($result,'MONTO_IVA');
		  $FECHA_CRE = odbc_result($result,'FECHA_CRE');
		  
		  $TOTAL_BS_LETRA = odbc_result($result,'TOTAL_BS_LETRA');
		  $SUB_TOTAL_DOLAR = odbc_result($result,'SUB_TOTAL_DOLAR');
		  $TOTAL_DOLAR = odbc_result($result,'TOTAL_DOLAR');
		  $IVA_DOLAR = odbc_result($result,'IVA_DOLAR');
		  $TOTAL_DS_LETRA = odbc_result($result,'TOTAL_DS_LETRA');
      }	  
	  
	  
	 $sql = "select * from VIEW_DETA_PRE_WEB where id_preliquidacion = $id_preliq";
	 $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	 $CONEXION=$ResultadoEjecutar["CONEXION"];						
     $ERROR=$ResultadoEjecutar["ERROR"];
     $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
      $result=$ResultadoEjecutar["RESULTADO"];
			
       while ($registro=odbc_fetch_row($result))
       {
		 
		  $ID_PRELIQUIDACION = odbc_result($result,'ID_PRELIQUIDACION'); 
		  $ID_SOLIC_MUELLE = odbc_result($result,'ID_SOLIC_MUELLE'); 
		  $CODIGO_CUENTA = odbc_result($result,'CODIGO_CUENTA'); 
		  $DS_CONCEPTO = odbc_result($result,'DS_CONCEPTO'); 
		  $CANTIDAD = odbc_result($result,'CANTIDAD'); 
		  $PRECIO_UNT = odbc_result($result,'PRECIO_UNT'); 
		  $VALOR_MONEDA = odbc_result($result,'VALOR_MONEDA');
		  $MONTO_SC = odbc_result($result,'MONTO_SC');
          $BASE = odbc_result($result,'BASE');	
		  $SUB_TOTAL_DOLAR_DETA = odbc_result($result,'SUB_TOTAL_DOLAR_DETA');
		  $TOTAL_DOLAR_DETA = odbc_result($result,'TOTAL_DOLAR_DETA');
          
          $tabla.= '
                <tr >              
                    <td>'.$CODIGO_CUENTA.'</td>               
                    <td>'.$DS_CONCEPTO.'</td>  
                    <td>'.$BASE.'</td> 
                    <td>'.$CANTIDAD.'</td>
                    <td>'.$PRECIO_UNT.'</td>               
                    <td>0</td>  
                    <td>'.$VALOR_MONEDA.'</td> 				
                    <td>'.$MONTO_SC.'</td>  
					<td>'.$SUB_TOTAL_DOLAR.'</td>  
                  
                </tr>';
      }	  
	  
	  
 		
			
	        
$Conector->Cerrar();

		
$cuerpo = '
<style>

    table{
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    table th{
        background-color: #ddd;
        color: black;
        font-weight: 900;
    }

    .margenes{
        margin-bottom:5px;
    }

    .montos{
        height: 70px;        
    }
</style>

<table  border="1" width="100%" >
		<tr>
			 <td rowspan="3"><img src="img/Bolivariana_de_puertos.png">
			 </td>
			 <td rowspan="3" style = "text-align: center;">
			 <div align="center"> 
			 	<h2>PRELIQUIDACION POR SERVICIO ALQUILER DE MAQUINARIAS</h2>
				</div>
			 </td>
			 </div>
              <td style = "text-align: center;">
			  	<h4>BOLIPUERTOS</h4>
			  </td>
		 </tr>
		 <tr>
		 	<td style = "text-align: center;">
				<h4>Nro.: '.$ID_PRELIQUIDACION.'</h4>
			</td>
		 </tr>
		  <tr>
		 	<td style = "text-align: center;">
				<h4>Fecha: '.$FECHA_CRE.'</h4>
			</td>
		 </tr>
	</table>
<table border=1 class="margenes">
    <thead>
        <tr>
            <th>SENORES</th>
            <th>RIF</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>'.$NOMBRE.'</td>
            <td>'.$RIF.'</td>
        </tr>
    </tbody>
</table>


<table border=1 class="margenes">
    <thead>
        <tr>
            <th>Buque</th>
            <th>Eslora</th>
            <th>TRB</th>
            <th>Renave</th>
            <th>Nacionalidad</th>            
        </tr>
    </thead>
    <tbody>
	
        <tr>
            <td>'.$NB_BUQUE.'</td>
            <td>'.$ESLORA.'</td>
            <td>'.$TRB.'</td>
            <td>'.$RENAVE.'</td>
            <td>'.$NACIONALIDAD.'</td>            
        </tr>
    </tbody>
</table>

<table border=1 class="margenes">
    <thead>
        <tr>
            <th>Solicitud de muelle</th>
            <th>Tipo operaci&oacute;n</th>
            <th>F/H Estimada de Atraque</th>
            <th>F/H Estimada de Desatraque</th>           
        </tr>
    </thead>
    <tbody>
        <tr>
		
            <td>'.$ID_SOLIC_MUELLE.'</td>
            <td>'.$DS_TIPO_SOLICITUD.'</td>
            <td>'.$FECHA_ETA.'</td>
            <td>'.$FECHA_ETD.'</td>           
        </tr>
    </tbody>
</table>

<table border=1 class="margenes">
    <thead>
        <tr>
            <th>Divisas</th>
            <th>Fecha Divisa</th>
            <th>Cambio Divisa</th>
            <th>Sub total</th>
            <th>Monto Neto</th> 
            <th>Condici&oacute,n de Pago</th>            
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Dolar ('.$DESCRIP.')</td>
            <td>'.$FECHA_CRE.'</td>
            <td>'.$VALOR.'</td>
            <td>'.$SUB_TOTAL_DOLAR.'</td>
            <td>'.$TOTAL_DOLAR.'</td> 
            <td>CONTADO</td>            
        </tr>
    </tbody>
</table>

<table border=1 class="margenes">
    <thead>
        <tr>
            <th>C&oacute;digo Tarifa</th>
            <th>Concepto</th>
            <th>Base</th>
            <th>Cantidad</th>
            <th>Tarifa ($)</th> 
            <th>% Desc</th> 
            <th>Tasa Cambio</th>
            <th>Tarifa Final (Bs.)</th> 
            <th>Sub Total ($.)</th>            
        </tr>
    </thead>
    <tbody>
        '.$tabla.'
    </tbody>
</table>

<table  class="margenes" border=1>    
    <tbody>
        <tr class="monto">
            <td><strong>La cantidad de (Bol&iacute;vares):</strong><br> '.$TOTAL_BS_LETRA.' </td>
            <td style="text-align:right;"><strong style="font-size:24px"> '.$MONTO_TOTAL.'</strong></td>                               
        </tr>



        <tr class="monto">
            <td><strong>La cantidad de (D&oacute;lares):</strong> <br> '.$TOTAL_DS_LETRA.' </td>
            <td style="text-align:right;"><strong style="font-size:24px"> '.$TOTAL_DOLAR.'</strong></td>                               
        </tr>
    </tbody>
</table>

<table class="margenes">
    <tr>
        <td style="min-height:30px;">
            <strong>Lo cobrado por tarifa de acuerdo a la resolución conjunta N° 065 de fecha 28 de agosto de 2017,
             publicado en Gaceta Oficial N° 41.227 de fecha 01 de septiembre de 2017.</strong>
        </td>
    </tr>
</table>
<table  class="margenes" >    
    <thead>
        <tr>
            <th colspan="4">Datos para Transferencias Internacionales</th>           
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style="text-align:right;"><strong>Banco:</strong></td>
            <td>BANCO BANDES URUGUAY S.A</td>
            <td style="text-align:right;"><strong>Banco:</td>
            <td>BANCO OF CHINA PANAMA B</td>            
        </tr>
        <tr>
            <td style="text-align:right;"><strong>Cuenta Bancaria:</strong></td>
            <td>40014733</td>
            <td style="text-align:right;"><strong>Intermediario:</strong></td>
            <td></td>            
        </tr>
        <tr>
            <td style="text-align:right;"><strong>Beneficiario:</strong></td>
            <td colspan="3">BOLIVARIANS DE PUERTOS S.A. - PUERTO CABELLO</td>           
        </tr>
        <tr>
            <td style="text-align:right;"><strong>Swift:</strong></td>
            <td colspan="3">CFACUYMM</td>           
        </tr>
        <tr>
            <td style="text-align:right;"><strong>Cuenta Nro.(EUR):</strong></td>
            <td></td>
            <td style="text-align:right;"><strong>Swift Bco Int:</strong></td>
            <td>BKCHPAPA</td>            
        </tr>
        <tr>
            <td style="text-align:right;"><strong>Cuenta Nro.(USD):</strong></td>
            <td colspan="3">100300450031195</td>           
        </tr>
    </tbody>
</table>

<table  class="margenes" border=1>    
    <thead>
        <tr>
            <th colspan="4" style="text-aling:center;">OPERACIONES</th>           
        </tr>
    </thead>
    <tbody>
        <tr style="text-align:center;">
            <td><strong>NOMBRE</strong></td>
            <td><strong>CARGO</strong></td>
            <td><strong>FIRMA</strong></td>
            <td><strong>SELLO</strong></td>            
        </tr>
        <tr>
            <td style="height:80px;"></td>
            <td></td>
            <td></td>
            <td></td>            
        </tr>        
    </tbody>
</table>';

$pie='<table  class="margenes" border=1>    
    <thead>
        <tr>
            <th colspan="4" style="text-aling:center;">RECIBIDO POR</th>           
        </tr>
    </thead>
    <tbody>
        <tr style="height:70px;">
            <td colspan="2"><strong>Nombre del Represante</strong></td>
            <td><strong>C.I. del Represante</strong></td>
            <td><strong>Firma del Represante</strong></td>           
        </tr>
        <tr style="height:70px;">
            <td colspan="2"> <strong>Fecha de Recibido</strong></td>
            <td colspan="2"> <strong>Hecha de Recibido</strong></td>                        
        </tr>        
    </tbody>
</table>';


$pie = '';
$mpdf=new mPDF('c','letter');
$mpdf->SetTitle('Solicitud de PBIP');
$mpdf->watermarkTextAlpha = 0.6;
$mpdf->showWatermarkImage = true;  
$mpdf->SetHTMLHeader($cabecera);
$mpdf->SetHTMLFooter($pie.'
				
				<div align="center">
					 Fecha Impresión: {DATE j-m-Y}
				</div>
				<div align="center"><strong>
					Bolivariana de Puertos S.A  
					</strong>
				</div>
			');	
$txt	=	iconv ("ISO-8859-1", "UTF-8", $txt);
$mpdf->WriteHTML($cuerpo);
$mpdf->Output();
?>