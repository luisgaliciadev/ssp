<?php
    include("MPDF57/mpdf.php");
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");

    $Conector = conectar2();
	$Conector2 = conectar3();
    $ID_SOLIC = $_GET["SOLIC"];
    $sql = "exec [web].[SP_SOLIC_DUSMU_ENCAB] $ID_SOLIC ";
    $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
    $CONEXION=$ResultadoEjecutar["CONEXION"];						
    $ERROR=$ResultadoEjecutar["ERROR"];
    $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
    $result=$ResultadoEjecutar["RESULTADO"];
           
    while ($registro=odbc_fetch_array($result))
	{
        $BUQUE 	= utf8_encode(odbc_result($result,'BUQUE')); 
        $IMO 	= 	odbc_result($result,'IMO'); 
        $BANDERA = utf8_encode(odbc_result($result,'BANDERA')); 
        $ESLORA = odbc_result($result,'ESLORA'); 
        $TRB = odbc_result($result,'TRB'); 
        $CALADO_PROA = odbc_result($result,'CALADO_PROA'); 
        $CALADO_POPA = odbc_result($result,'CALADO_POPA'); 
        $VIAJE = odbc_result($result,'VIAJE'); 
        $CAPITAN = utf8_encode(odbc_result($result,'CAPITAN')); 
        $MUELLE = utf8_encode(odbc_result($result,'MUELLE')); 
        $ETA = odbc_result($result,'ETA'); 
        $ETD = odbc_result($result,'ETD'); 
        $PROCEDENCIA = utf8_encode(odbc_result($result,'PROCEDENCIA')); 
        $DESTINO = utf8_encode(odbc_result($result,'DESTINO')); 
        $TIPO_OPERACION = utf8_encode(odbc_result($result,'TIPO_OPERACION')); 
		$CODIGO = utf8_encode(odbc_result($result,'CODIGO')); 
		$FECHA = odbc_result($result,'FECHA_REG'); 

    }

 $cabecera = '
		<div align="right" style="font-size:11px;">
			<b><i>P&aacute;g. {PAGENO}<i></b>
		</span>';



$cuerpo='
        <style>
            table{
                width: 100%;
                border: 1px solid black;
                border-collapse: collapse;
                margin-bottom:5px;
            }
        </style>
<body style="font-family:Courier New; font-size: 12px;">

   <table  border="1" width="100%" >
		<tr>
			 <td rowspan="3"><img src="img/Bolivariana_de_puertos.png">
			 </td>
			 <td rowspan="3" style = "text-align: center;">
			 <div align="center"> 
			 	<h2>SOLICITUD DE SERVICIO PORTUARIO</h2>
				</div>
			 </td>
			 </div>
              <td style = "text-align: center;">
			  	<h4>BOLIPUERTOS</h4>
			  </td>
		 </tr>
		 <tr>
		 	<td style = "text-align: center;">
				<h4>Nro.:'.$CODIGO.'</h4>
			</td>
		 </tr>
		  <tr>
		 	<td style = "text-align: center;">
				<h4>Fecha:.'.FechaSQL($FECHA).'.</h4>
			</td>
		 </tr>
	</table>
     <table border="1">
        <tr>
            <td colspan ="4" style = "text-align: center;" ><strong>Datos del Buque</strong> </td>
        </tr>
        <tr>
            <td colspan ="2">Buque: '.$BUQUE.'</td>
            <td>IMO: '.$IMO.'</td>
            <td>Bandera: '.$BANDERA.'</td>
        </tr>
        <tr>
            <td>Eslora: '.$ESLORA.'</td>
            <td>TRB: '.$TRB.'</td>
            <td>Calado Proa: '.$CALADO_PROA.'</td>
            <td>Calado Popa: '.$CALADO_POPA.'</td>
        </tr>
        <tr>
            <td>Viaje: '.$VIAJE.'</td>
            <td colspan="2">Capitan: '.$CAPITAN.'</td>
            <td>Pref. Muelle: '.$MUELLE.'</td>
        </tr>
        <tr>
            <td>ETA: '.$ETA.'</td>
            <td>ETD: '.$ETD.'</td>
            <td>Proc: '.$PROCEDENCIA.'</td>
            <td>Dest: '.$DESTINO.'</td>
        </tr>
        <tr>
            <td colspan ="4">Tipo de Operaci&oacute;n: '.$TIPO_OPERACION.'</td>
        </tr>
     </table>
     <table border="1">
        <tr align="center">
            <td colspan="8" style = "text-align: center;"><strong>Declaraci&oacute;n de la Carga</strong></td>
        </tr>
        <tr>
            <td>Actividad</td>
            <td>Tipo de Carga</td>
            <td>Detalle</td>
            <td style = "text-align: left;">Cant</td>
            <td style = "text-align: left;">Peso</td>
            <td>Temp</td>
            <td>Linea</td>
            <td>IMO</td>
        </tr>';

        $sql = "exec [web].[SP_SOLIC_DUSMU_CARGA] $ID_SOLIC ";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
               
        while ($registro=odbc_fetch_array($result)){
            $ACTIVIDAD = 	utf8_encode(odbc_result($result,'ACTIVIDAD')); 
            $TIPO_CARGA = 	utf8_encode(odbc_result($result,'TIPO_CARGA')); 
            $DETALLE = 		utf8_encode(odbc_result($result,'DETALLE')); 
            $TAMANO = 		utf8_encode(odbc_result($result,'TAMANO')); 
            $TEMPERATURA = 	odbc_result($result,'TEMPERATURA'); 
            $LINEA = 		utf8_encode(odbc_result($result,'LINEA')); 
            $IMO = 			utf8_encode(odbc_result($result,'IMO')); 
            $CANTIDAD = 	number_format(odbc_result($result,'CANTIDAD'), 2, ",", ".");
			$PESO = 	number_format(odbc_result($result,'PESO'), 2, ",", ".");
            

            $cuerpo .='
                <tr>
                    <td>'.$ACTIVIDAD.'</td>
                    <td>'.$TIPO_CARGA.'</td>
                    <td>'.$DETALLE.'</td>
                    <td>'.$CANTIDAD.'</td>
                    <td style = "text-align: left;">'.$PESO.'</td>
                    <td style = "text-align: left;">'.$TEMPERATURA.'</td>
                    <td>'.$LINEA.'</td>
                    <td>'.$IMO.'</td>
                    
                </tr>
            
            ';
    
        }
     
        //arribo 
        $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,1";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
               
        while ($registro=odbc_fetch_array($result)){
            if (odbc_result($result,'VALOR') == 1)
                $valor_arribo = 'X';
            else 
                $valor_arribo = '';
            

            $nb_arribo_valor = odbc_result($result,'NB_VALOR');
        }

        //ATRAQUE
        $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,2";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
               
        while ($registro=odbc_fetch_array($result)){
            if (odbc_result($result,'VALOR') == 1)
                $VALOR_PUESTO_ATRAQUE = 'X';
            else {
                $VALOR_PUESTO_ATRAQUE = '';
            }

            $NB_PUESTO_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
        }

            //REMOLCADORES
        $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,3";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
               
        while ($registro=odbc_fetch_array($result)){
            if (odbc_result($result,'VALOR') == 1)
                $VALOR_REMORCADORES = 'X';
            else {
                $VALOR_REMORCADORES = '';
            }

            $NB_REMOLCADORES_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
        }

        //LANCHAJE
        $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,4";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
               
        while ($registro=odbc_fetch_array($result)){
            if (odbc_result($result,'VALOR') == 1)
                $VALOR_LANCHAJE = 'X';
            else {
                $VALOR_LANCHAJE = '';
            }

            $NB_LANCHAJE_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
        }


        //AMARRE
        $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,7";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
               
        while ($registro=odbc_fetch_array($result)){
            if (odbc_result($result,'VALOR') >=1)
                $VALOR_AMARRE = 'X';
            else {
                $VALOR_AMARRE = '';
            }

            $NB_AMARRE_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
        }

        //ESTIBA
        $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,6";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
		$VALOR_ESTIBA = utf8_encode(odbc_result($result,'VALOR'));
		$NB_ESTIBA_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
        
            if (odbc_result($result,'VALOR') >= 1)
                $VALOR_ESTIBA = 'X';
            else 
                $VALOR_ESTIBA = '';
         

        //MAQUINARIA
        $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,11";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
               
        while ($registro=odbc_fetch_array($result)){
            if ((odbc_result($result,'VALOR') >= 1) )
                $VALOR_MAQUINARIA = 'X';
            else 
			{
                $VALOR_MAQUINARIA = '';
            }

            $NB_MAQUINARIA_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
        }
		 

		//maquinarias 
	$sql = "SELECT DESCRIPCION FROM [dbo].[FN_CONCATENA_MAQUINARIA] (
   $ID_SOLIC)";
       $ResultadoEjecutar=$Conector2->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
       $CONEXION=$ResultadoEjecutar["CONEXION"];						
       
		$ERROR=$ResultadoEjecutar["ERROR"];
		$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
		$DESCRIPCION = utf8_encode(odbc_result($result,'DESCRIPCION'));
		
	//$MAQUINARIA
			


$Conector2->Cerrar();


			
        //RRHH
        $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,23";
        $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
        $CONEXION=$ResultadoEjecutar["CONEXION"];						
        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];
               
        while ($registro=odbc_fetch_array($result)){
            if (odbc_result($result,'VALOR') > 1)
                $VALOR_RRHH = 'X';
            else {
                $VALOR_RRHH = '';
            }

            $NB_RRHH_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
        }

         //RECOLECION
         $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,16";
         $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
         $CONEXION=$ResultadoEjecutar["CONEXION"];						
         $ERROR=$ResultadoEjecutar["ERROR"];
         $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
         $result=$ResultadoEjecutar["RESULTADO"];
                
         while ($registro=odbc_fetch_array($result)){
             if (odbc_result($result,'VALOR') > 1)
                 $VALOR_RECOLECCION = 'X';
             else {
                 $VALOR_RECOLECCION = '';
             }
 
             $NB_RECOLECCION_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
         }


         //REPARACION
         $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,24";
         $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
         $CONEXION=$ResultadoEjecutar["CONEXION"];						
         $ERROR=$ResultadoEjecutar["ERROR"];
         $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
         $result=$ResultadoEjecutar["RESULTADO"];
                
         while ($registro=odbc_fetch_array($result)){
             if (odbc_result($result,'VALOR') == 1)
                 $VALOR_REPARACION = 'X';
             else {
                 $VALOR_REPARACION = '';
             }
 
             $NB_REPARACION_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
         }

          //AUTORIDADES
          $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,9";
          $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
          $CONEXION=$ResultadoEjecutar["CONEXION"];						
          $ERROR=$ResultadoEjecutar["ERROR"];
          $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
          $result=$ResultadoEjecutar["RESULTADO"];
                 
          while ($registro=odbc_fetch_array($result)){
              if (odbc_result($result,'VALOR')>= 1)
                  $VALOR_AUTORIDADES = 'X';
              else {
                  $VALOR_AUTORIDADES = '';
              }
  
              $NB_AUTORIDADES_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
              $CANTIDAD_AUTORIDADES = utf8_encode(odbc_result($result,'CANTIDAD'));
          }


          //TRIPULATES
          $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,21";
          $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
          $CONEXION=$ResultadoEjecutar["CONEXION"];						
          $ERROR=$ResultadoEjecutar["ERROR"];
          $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
          $result=$ResultadoEjecutar["RESULTADO"];
                 
          while ($registro=odbc_fetch_array($result)){
              if (odbc_result($result,'VALOR') >= 1)
                  $VALOR_TRIPULATES = 'X';
              else {
                  $VALOR_TRIPULATES = '';
              }
  
              $NB_TRIPULATES_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
              $CANTIDAD_TRIPULANTE = utf8_encode(odbc_result($result,'CANTIDAD'));
          }


          //AVITUALLAMIENTO
          $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,17";
          $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
          $CONEXION=$ResultadoEjecutar["CONEXION"];						
          $ERROR=$ResultadoEjecutar["ERROR"];
          $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
          $result=$ResultadoEjecutar["RESULTADO"];
                 
          while ($registro=odbc_fetch_array($result)){
              if (odbc_result($result,'VALOR') >= 1)
                  $VALOR_AVITUALLAMIENTO = 'X';
              else {
                  $VALOR_AVITUALLAMIENTO = '';
              }
  
              $NB_AVITUALLAMIENTO_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
          }

          //COMBUSTIBLE
          $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,20";
          $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
          $CONEXION=$ResultadoEjecutar["CONEXION"];						
          $ERROR=$ResultadoEjecutar["ERROR"];
          $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
          $result=$ResultadoEjecutar["RESULTADO"];
                 
          while ($registro=odbc_fetch_array($result)){
              if (odbc_result($result,'VALOR')>= 1)
                  $VALOR_COMBUSTIBLE = 'X';
              else {
                  $VALOR_COMBUSTIBLE = '';
              }
  
              $NB_COMBUSTIBLE_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
              $CANTIDAD_COMBUSTIBLE = utf8_encode(odbc_result($result,'CANTIDAD'));
          }

          //ENERGIA
          $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,19";
          $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
          $CONEXION=$ResultadoEjecutar["CONEXION"];						
          $ERROR=$ResultadoEjecutar["ERROR"];
          $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
          $result=$ResultadoEjecutar["RESULTADO"];
                 
          while ($registro=odbc_fetch_array($result)){
              if (odbc_result($result,'VALOR') >= 1)
                  $VALOR_ENERGIA = 'X';
              else {
                  $VALOR_ENERGIA = '';
              }
  
              $NB_ENERGIA_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
          }
          
          //AGUA
          $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,18";
          $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
          $CONEXION=$ResultadoEjecutar["CONEXION"];						
          $ERROR=$ResultadoEjecutar["ERROR"];
          $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
          $result=$ResultadoEjecutar["RESULTADO"];
                 
          while ($registro=odbc_fetch_array($result)){
              if (odbc_result($result,'VALOR') >= 1)
                  $VALOR_AGUA = 'X';
              else {
                  $VALOR_AGUA = '';
              }
  
              $NB_AGUA_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
              $CANTIDAD_AGUA = utf8_encode(odbc_result($result,'CANTIDAD'));
          }


 		//REPARACION
          $sql = "exec [web].[SP_SOLIC_DUSMU_SERVICIO] $ID_SOLIC ,24";
          $ResultadoEjecutar=$Conector->Ejecutar($sql, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
          $CONEXION=$ResultadoEjecutar["CONEXION"];						
          $ERROR=$ResultadoEjecutar["ERROR"];
          $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
          $result=$ResultadoEjecutar["RESULTADO"];
                 
          while ($registro=odbc_fetch_array($result)){
              if (odbc_result($result,'VALOR') >= 1)
                  $VALOR_REPA = 'X';
              else {
                  $VALOR_REPA = '';
              }
  
              $NB_REPARACION_VALOR = utf8_encode(odbc_result($result,'NB_VALOR'));
              $CANTIDAD_REPRACION = utf8_encode(odbc_result($result,'CANTIDAD'));
			  $DETALLE = utf8_encode(odbc_result($result,'DETALLE'));
          }
		//REPARACION 


     $cuerpo .='</table>
     <table border="1">
        <tr align="center" style = "text-align: center;">
            <td colspan="11" style = "text-align: center;" ><strong>Servicios Generales</strong></td>
        </tr>
        <tr>
            <td colspan="3">Solicitud de Arribo</td>
            <td colspan="2">'.$valor_arribo.'</td>
            <td colspan="6">'.$nb_arribo_valor.'</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Puesto Atraque</td>
            <td colspan="2">'.$VALOR_PUESTO_ATRAQUE.'</td>
            <td colspan="6">'.$NB_PUESTO_VALOR.'</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Remolcadores</td>
            <td colspan="2">'.$VALOR_REMORCADORES.'</td>
            <td colspan="6">'. $NB_REMOLCADORES_VALOR.'</td>             
        </tr>
        <tr>
            <td colspan="3">Solicitud de Lanchaje</td>
            <td colspan="2">'.$VALOR_LANCHAJE.'</td>
            <td colspan="6">'.$NB_LANCHAJE_VALOR.'</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Deposito Transitorio</td>
            <td colspan="2"></td>
            <td>CANTIDAD</td> 
            <td>TIPO DE CARGA</td> 
            <td>DETALLE DE CARGA</td> 
            <td>PESO</td> 
            <td>TEMP</td> 
            <td>LINEA</td>            
        </tr>
        
     </table>
     <table border="1">
        <tr align="center">
            <td colspan="9" style = "text-align: center;"><strong>Servicios Operativos</strong></td>
        </tr>
        <tr>
            <td colspan="3">Solicitud de Reserva de Ventana de Atraque</td>
            <td colspan="2">X</td>
            <td>Cant. de Toques: </td> 
            <td>Tiemp de Recurrencia:</td> 
            <td>Dia:</td> 
            <td>Hora:</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Amarre y Desamarre</td>
            <td colspan="2">'.$VALOR_AMARRE.'</td>
            <td colspan="4">'.$NB_AMARRE_VALOR.'</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Estiba</td>
            <td colspan="2">'.$VALOR_ESTIBA.'</td>
            <td colspan="4">Operador(es): '.$NB_ESTIBA_VALOR.'</td>            
        </tr>
		
        <tr>
            <td colspan="3">Solicitud de Alquiler Maquinas y Equipos</td>
            <td colspan="2">'.$VALOR_MAQUINARIA.'</td>
            <td colspan="4">'.$NB_MAQUINARIA_VALOR.'    <strong>Maquinas:</strong>'.$DESCRIPCION.'</td>  
			 
        </tr>
        <tr>
            <td colspan="3">Solicitud de RRHH</td>
            <td colspan="2">'.$VALOR_RRHH.'</td>
            <td colspan="4">'.$NB_RRHH_VALOR.'</td>           
        </tr>
        <tr>
            <td colspan="3">Solicitud de Recolecci&oacute;n de Desechos</td>
            <td colspan="2">'.$VALOR_RECOLECCION.'</td>
            <td colspan="4">'.$NB_RECOLECCION_VALOR.'</td>           
        </tr>
        <tr>
            <td colspan="3">Solicitud de Reparaci&oacute;n de Contenedor Refrigerado</td>
            <td colspan="2">'.$VALOR_REPA.'</td>
            <td colspan="1">'.$NB_REPARACION_VALOR.'</td> 
            <td colspan="3">Detalle:'.$DETALLE.'</td>           
        </tr>
        
     </table>

     <table border="1">
        <tr align="center">
            <td colspan="11" style = "text-align: center;"><strong>Servicios Comerciales</strong></td>
        </tr>
        <tr>
            <td colspan="3">Solicitud de Traslado de Autoridades</td>
            <td colspan="2">'.$VALOR_AUTORIDADES.'</td>
            <td colspan="3">Cant. Traslado: '.$CANTIDAD_AUTORIDADES.'</td>
            <td colspan="3">Empresa:'.$NB_AUTORIDADES_VALOR.'</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Traslado de Tripulantes</td>
            <td colspan="2">'.$VALOR_TRIPULATES.'</td>
            <td colspan="3">Cant. Traslado: '.$CANTIDAD_TRIPULANTE.'</td>
            <td colspan="3">Empresa:'.$NB_TRIPULATES_VALOR.'</td>                
        </tr>
        <tr>
            <td colspan="3">Avituallamiento</td>
            <td colspan="2">'.$VALOR_AVITUALLAMIENTO.'</td>
            <td colspan="6">Requerimiento: '.$NB_AVITUALLAMIENTO_VALOR.'</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Suministro de Combustible</td>
            <td colspan="2">'.$VALOR_COMBUSTIBLE.'</td>
            <td colspan="3">Cant. Estimada: '.$CANTIDAD_COMBUSTIBLE.' </td>
            <td colspan="3">Empresa: '.$NB_COMBUSTIBLE_VALOR.'</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Suministro de Electricidad al Buque</td>
            <td colspan="2">'.$VALOR_ENERGIA.'</td>
            <td colspan="6">Empresa: '.$NB_ENERGIA_VALOR.'</td>            
        </tr>
        <tr>
            <td colspan="3">Solicitud de Suministro de Agua Potable</td>
            <td colspan="2">'.$VALOR_AGUA.'</td>
            <td colspan="3">Cant. Estimada: '.$CANTIDAD_AGUA.'</td>
            <td colspan="3">Empresa:'.$NB_AGUA_VALOR.'</td>            
        </tr>
        
     </table>
</body>
    ';

$pie = '';
$mpdf=new mPDF('c','letter');
$mpdf->SetTitle('Solicitud de Servicios');
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