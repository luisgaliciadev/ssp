<?php 

$Nivel="../../";
include($Nivel."includes/plugins/MPDF57/mpdf.php");
include($Nivel."includes/PHP/funciones.php");

$id_preliq = $_GET["id_preliq"];

$Conector=Conectar2();
$sql = "select CODIGO_PRELIQ,
FECHA_EMISION, 
NB_PROVEED_BENEF,
RIF_CED,
NB_BUQUE,
ESLORA,
TRB,
RENAVE,
NACIONALIDAD,
CODIGO,
DS_TIPO_SOLICITUD,
FECHA_ETA,
FECHA_ETZ,
DS_DIVISA,
FECHA_DIVISA,
CAMBIO_DIVISA,
MONTO_NETO_CAMBIO,
MONTO_NETO,
ID_TIPO_CTA

	from [web].[VIEW_ENCAB_PRELIQ_SERVICIO_PORTUARIO] where ID_PRELIQ =$id_preliq";
	 $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	 $CONEXION=$ResultadoEjecutar["CONEXION"];						
     $ERROR=$ResultadoEjecutar["ERROR"];
     $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
     $result=$ResultadoEjecutar["RESULTADO"];
			
       while ($registro=odbc_fetch_array($result))
       {
		  $nro_solicitud = odbc_result($result,'solicitud'); 
		  $agente 	= utf8_encode (odbc_result($result,'NB_PROVEED_BENEF')); 
		  $rif 		= odbc_result($result,'RIF_CED');
		  $CODIGO_PRELIQ= odbc_result($result,'CODIGO_PRELIQ');
		  $NB_BUQUE = utf8_encode (odbc_result($result,'NB_BUQUE')); 
		  $ID_BUQUE_LLOYD = odbc_result($result,'ID_BUQUE_LLOYD'); 
		  $NACIONALIDAD = utf8_encode(odbc_result($result,'NACIONALIDAD'));
		  
		  $ESLORA = odbc_result($result,'ESLORA'); 
		  $TRB = odbc_result($result,'TRB'); 
		  $CALADO_POPA = odbc_result($result,'CALADO_POPA');
		  $CALADO_PROA = odbc_result($result,'CALADO_PROA');
		  
		  $NRO_VIAJE = odbc_result($result,'NRO_VIAJE'); 
		  $CAPITAN = odbc_result($result,'CAPITAN'); 
		  $NB_BIEN = odbc_result($result,'NB_BIEN');
		  
		  $FECHA_ETA = (odbc_result($result,'FECHA_ETA')); 
		   
		   
		  $FECHA_ETA= date("d/m/Y",strtotime($FECHA_ETA)).' '.date("H:i:s",strtotime($FECHA_ETA));
		  $FECHA_REG = FechaNormal(odbc_result($result,'FECHA_EMISION')); 
		  
		   $FECHA_ETD = (odbc_result($result,'FECHA_ETZ')); 
		  
		   $FECHA_ETD= date("d/m/Y",strtotime($FECHA_ETD)).' '.date("H:i:s",strtotime($FECHA_ETD));
		   
		   $PUERTO_PROC = odbc_result($result,'PUERTO_PROC'); 
		  $PUERTO_DESTINO= odbc_result($result,'PUERTO_DESTINO'); 
		  
		  
		  
		  $DS_TIPO_SOLICITUD = utf8_encode(odbc_result($result,'DS_TIPO_SOLICITUD')); 
		  $RENAVE = odbc_result($result,'RENAVE'); 
		  $CODIGO = odbc_result($result,'CODIGO'); 
		  $DS_DIVISA = utf8_encode(odbc_result($result,'DS_DIVISA')); 
		   
		  $FECHA_DIVISA = (odbc_result($result,'FECHA_DIVISA'));
		  
		  $CAMBIO_DIVISA = (odbc_result($result,'CAMBIO_DIVISA'));
		   
		  $SUBTOTALBS = (odbc_result($result,'MONTO_NETO_CAMBIO'));
		  $MONTONETO = (odbc_result($result,'MONTO_NETO'));
          $ID_TIPO_CTA = odbc_result($result,'ID_TIPO_CTA');
        
          if($ID_TIPO_CTA==1)
          {
            
			   $SUBTOTALBS = $MONTONETO;
			  $MONTONETO=0;
          }
			
		  
      }	              
$Conector->Cerrar();

$Conector=Conectar2();
$sql = "
SELECT [DS_PERIODO]
      ,[TARIFA]
      ,[PORCENTAJE_APLICAR]
      ,[COD_TARIFA]
      ,[DS_CONCEPTO]
      ,[CAMBIO_DIVISA]
      ,[TARIFA_DOLAR]
      ,[SUB_TOTAL]
      ,[BASE_CALC]
      ,[PERIODO]
      ,[MONTO_LIQUIDACION]
      ,[SUB_TOTAL_CAMBIO]
      ,[MONTO_LIQUID_CAMBIO],
	  TARIFAC
  FROM [web].[VIEW_DETALLE_PRELIQ_SERVICIO_PORTUARIO] where ID_PRELIQ =$id_preliq";

$ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
$CONEXION=$ResultadoEjecutar["CONEXION"];						
$ERROR=$ResultadoEjecutar["ERROR"];
$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
$result=$ResultadoEjecutar["RESULTADO"];
			
while ($registro=odbc_fetch_row($result))
 {
	  $COD_TARIFA 	= odbc_result($result,'COD_TARIFA'); 
	  $DS_CONCEPTO 	= odbc_result($result,'DS_CONCEPTO'); 
	  $BASE_CALC 	= odbc_result($result,'BASE_CALC'); 
	  $DS_CONCEPTO 	= odbc_result($result,'DS_CONCEPTO'); 
	  $DS_PERIODO 	= odbc_result($result,'DS_PERIODO'); 
      $PERIODO		 = odbc_result($result,'PERIODO'); 
	  $TARIFA		 = odbc_result($result,'TARIFA'); 
	  $PORCENTAJE_APLICAR = odbc_result($result,'PORCENTAJE_APLICAR'); 
	  $TARIFAC = odbc_result($result,'TARIFAC'); 
	  $MONTO_LIQUID_CAMBIO = odbc_result($result,'MONTO_LIQUID_CAMBIO'); 
	  $MONTO_LIQUIDACION = odbc_result($result,'MONTO_LIQUIDACION'); 
		
	 
	 
	 $VALOR_MONEDA = odbc_result($result,'VALOR_MONEDA');
		  $MONTO_SC = odbc_result($result,'MONTO_SC');
          $BASE = odbc_result($result,'BASE');	
		  $SUB_TOTAL_DOLAR_DETA = odbc_result($result,'SUB_TOTAL_DOLAR_DETA');
		  $TOTAL_DOLAR_DETA = odbc_result($result,'TOTAL_DOLAR_DETA');
          
          $tabla.= '
                <tr >              
                    <td style = "text-align: center;">'.$COD_TARIFA.'</td>               
                    <td style = "text-align: left;">'.utf8_encode($DS_CONCEPTO).'</td>  
                    <td style = "text-align: center;">'.utf8_encode($BASE_CALC).'</td> 
                    <td style = "text-align: center;">'.utf8_encode($DS_PERIODO).' - '.$PERIODO.'</td>
                    <td style = "text-align: center;">'.number_format($TARIFA, 2, ",", ".").'</td>               
                    <td style = "text-align: center;">'.number_format($PORCENTAJE_APLICAR, 2, ",", ".").'</td>  
                    <td style = "text-align:right;">'.number_format($TARIFAC, 2, ",", ".").'</td> 				
                    <td style = "text-align:right;">'.number_format($MONTO_LIQUID_CAMBIO, 2, ",", ".").'</td>  
					<td style = "text-align:right;">'.number_format($MONTO_LIQUIDACION, 2, ",", ".").'</td>  
                  
                </tr>';
      }	  
	  
	  
 		
			
	        
$Conector->Cerrar();

		
$cuerpo = '
<style>

    table{
        width: 100%;
        border: 0.2px solid black;
        border-collapse: collapse;
    }

    table th{
        background-color: #ddd;
        color: black;
        font-weight: 900;
    }

    .margenes{
        margin-bottom:0px;
    }

    .montos{
        height: 70px;        
    }
</style>
<body style="font-family:Courier New; font-size: 12px;">
<table  border="0.5" width="100%" >
		<tr>
			 <td rowspan="3" style = "text-align: center;"><img src="img/Bolivariana_de_puertos.png">
			 </td>
			 <td rowspan="3" style = "text-align: center;">
			 <div align="center"> 
			 	<h2>PRELIQUIDACION DE SERVICIO AL BUQUE</h2>
				</div>
			 </td>
			 </div>
              <td style = "text-align: center;">
			  	<h4>BOLIPUERTOS</h4>
			  </td>
		 </tr>
		 <tr>
		 	<td style = "text-align: center;">
				<h4>Nro.: '.$CODIGO_PRELIQ.'</h4>
			</td>
		 </tr>
		  <tr>
		 	<td style = "text-align: center;">
				<h4>Fecha: '.$FECHA_REG.'</h4>
			</td>
		 </tr>
	</table>
<table border=1 class="margenes">
    <thead>
        <tr>
            <th>SE&Ntilde;ORES</th>
            <th>RIF</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>'.$agente.'</td>
            <td style = "text-align: center;">'.$rif.'</td>
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
            <td style = "text-align: center;">'.$ESLORA.'</td>
            <td style = "text-align: center;">'.number_format($TRB, 2, ",", ".").'</td>
            <td style = "text-align: center;">'.$RENAVE.'</td>
            <td style = "text-align: center;">'.$NACIONALIDAD.'</td>            
        </tr>
    </tbody>
</table>

<table border=1 class="margenes">
    <thead>
        <tr>
            <th>Solicitud de Muelle</th>
            <th>Tipo Operaci&oacute;n</th>
            <th>F/H Estimada de Atraque</th>
            <th>F/H Estimada de Desatraque</th>           
        </tr>
    </thead>
    <tbody>
        <tr>
		
            <td style = "text-align: center;">'.$CODIGO.'</td>
            <td style = "text-align: center;">'.$DS_TIPO_SOLICITUD.'</td>
            <td style = "text-align: center;">'.$FECHA_ETA.'</td>
            <td style = "text-align: center;">'.$FECHA_ETD.'</td>           
        </tr>
    </tbody>
</table>

<table border=1 class="margenes">
    <thead>
        <tr>
            <th>Divisa</th>
            <th>Fecha Divisa</th>
            <th style = "text-align:right;">Cambio Divisa</th>
            <th style = "text-align:right;">Monto Neto Bs.</th>
			<th style = "text-align:right;">Monto Neto $</th>
            <th>Condici&oacute;n de Pago</th>    
                     
        </tr>
    </thead>
    <tbody>
        <tr>
            <td style = "text-align: center;">'.$DS_DIVISA.'</td>
            <td style = "text-align: center;">'.FechaNormal($FECHA_DIVISA).'</td>
            <td style = "text-align:right;"> '.number_format($CAMBIO_DIVISA, 2, ",", ".").'</td>
            <td style = "text-align:right;">'.number_format($SUBTOTALBS, 2, ",", ".").'</td>
            <td style = "text-align:right;">'.number_format($MONTONETO, 2, ",", ".").'</td>
            <td style = "text-align:center;">CONTADO</td>    
                      
        </tr>
    </tbody>
</table>

<table border="0.5" class="margenes">
    <thead>
        <tr>
            <th>C&oacute;digo Tarifa</th>
            <th>Concepto</th>
            <th>Base</th>
            <th>Cantidad</th>
            <th>Tarifa ($)</th> 
            <th>% Desc</th> 
            <th>Precio U</th>
            <th>Tarifa Final (Bs.)</th>';
if($ID_TIPO_CTA==1)
{
	
	$cuerpo= $cuerpo.'<th>Sub Total (Bs)</th>';
}
else
{
	$cuerpo=$cuerpo.'<th>Sub Total ($)</th> ';
}
          
     $cuerpo=$cuerpo. ' </tr>
    </thead>
    <tbody>
        '.$tabla.'
    </tbody>
</table>';

$sql = "exec [dbo].[SP_CANTIDADES_PRELIQ] $ID_TIPO_CTA,$id_preliq";
$ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
$CONEXION=$ResultadoEjecutar["CONEXION"];						
$ERROR=$ResultadoEjecutar["ERROR"];
$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
$result=$ResultadoEjecutar["RESULTADO"];
$TABLA_CANT = utf8_encode(odbc_result($result,'TABLA_CANT')); 		

$cuerpo=$cuerpo.$TABLA_CANT.'';



	
$sql = "exec [dbo].[SP_CUENTAS_PRELIQ] $ID_TIPO_CTA";
$ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
$CONEXION=$ResultadoEjecutar["CONEXION"];						
$ERROR=$ResultadoEjecutar["ERROR"];
$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
$result=$ResultadoEjecutar["RESULTADO"];
$TABLA_CUENTA = utf8_encode(odbc_result($result,'NB_VALOR')); 	



$cuerpo=$cuerpo.$TABLA_CUENTA.'';

$sql = "exec 
[dbo].[SP_TEXTO_PRELIQ] $id_preliq";
$ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
$CONEXION=$ResultadoEjecutar["CONEXION"];						
$ERROR=$ResultadoEjecutar["ERROR"];
$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
$result=$ResultadoEjecutar["RESULTADO"];

while ($registro=odbc_fetch_row($result))
{

	$TABLA_TEXTO = utf8_encode(odbc_result($result,'TABLA_VALOR')); 
	$cuerpo=$cuerpo.'
	<table class="margenes">
		<tr>
			<td style="min-height:30px;  "text-align: justify;"">
				<strong>'.$TABLA_TEXTO.'</strong>
			</td>
		</tr>
	</table>';
}


$pie='
</body>';


$pie = '';
$mpdf=new mPDF('c','letter');
$mpdf->SetTitle('Solicitud de Servicio al Buque');
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