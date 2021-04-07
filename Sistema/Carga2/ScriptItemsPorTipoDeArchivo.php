<?php
	$Nivel='../../';
	
	include($Nivel.'includes/PHP/funciones.php');
	
	session_start();

	$ID_CLASIF_TCARGA = $_GET['ID_CLASIF_TCARGA'];

	$Conector = Conectar2();

	$vSQL='EXEC web.[SP_PERMITIDO_X_COLUMNA] '.$ID_CLASIF_TCARGA.'';
	
	$ResultadoEjecutar = $Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA='SI', $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION	= $ResultadoEjecutar['CONEXION'];
	$ERROR		= $ResultadoEjecutar['ERROR'];
	$MSJ_ERROR	= $ResultadoEjecutar['MSJ_ERROR'];
	$resultPrin	= $ResultadoEjecutar['RESULTADO'];

	if($CONEXION == 'SI' and $ERROR == 'NO'){
		$i = 1;
		while(odbc_fetch_row($resultPrin)){
			if ($i==odbc_result($resultPrin, 'CANTIDAD')) {
				$i = 1;

				$registros[] =  utf8_encode(odbc_result($resultPrin, 'CAMPO'));	
				
				$Arreglo['PERMITIDOS_'.odbc_result($resultPrin, 'TIPO')] = $registros;
				
				unset($registros);
				continue;
			}else{
				$registros[] =  utf8_encode(odbc_result($resultPrin, 'CAMPO'));	
			}
			
			$i++;
		}		
	}else{
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
		$Arreglo['MSJ_ERROR']	= $MSJ_ERROR;
		
		echo json_encode($Arreglo);
		exit;
	}

	/*$Conector->Cerrar();
	$Conector = Conectar2();

	$vSQL='EXEC web.[SP_CANT_TIPO_CARGA] '.$ID_CLASIF_TCARGA.'';
	
	$ResultadoEjecutar = $Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA='SI', $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION	= $ResultadoEjecutar['CONEXION'];
	$ERROR		= $ResultadoEjecutar['ERROR'];
	$MSJ_ERROR	= $ResultadoEjecutar['MSJ_ERROR'];
	$resultPrin	= $ResultadoEjecutar['RESULTADO'];

	if($CONEXION == 'SI' and $ERROR == 'NO'){
		$i = 1;
		while(odbc_fetch_row($resultPrin)){			
			$permitidos_tipo_carga[] =  utf8_encode(odbc_result($resultPrin, 'DS_TIPO_CARGA'));	
			
			$i++;
		}		
		
		$Arreglo['PERMITIDOS_ID_DET_TIPO_CARGA']	= $permitidos_tipo_carga;
	}else{
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
		$Arreglo['MSJ_ERROR']	= $MSJ_ERROR;
		
		echo json_encode($Arreglo);
		exit;
	}

	$Conector->Cerrar();
	$Conector = Conectar2();

	$vSQL='EXEC web.[SP_LISTADO_LINEA_JS]';
	
	$ResultadoEjecutar = $Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA='SI', $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION	= $ResultadoEjecutar['CONEXION'];
	$ERROR		= $ResultadoEjecutar['ERROR'];
	$MSJ_ERROR	= $ResultadoEjecutar['MSJ_ERROR'];
	$resultPrin	= $ResultadoEjecutar['RESULTADO'];

	if($CONEXION == 'SI' and $ERROR == 'NO'){
		
		$filas = '';
		$i = 1;
		while(odbc_fetch_row($resultPrin)){			
			$permitidos_linea[] =  utf8_encode(odbc_result($resultPrin, 'NB_EMPRESA_BL'));	
			
			$i++;
		}		
		
		$Arreglo['PERMITIDOS_LINEA']	= $permitidos_linea;
	}else{
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
		$Arreglo['MSJ_ERROR']	= $MSJ_ERROR;
		
		echo json_encode($Arreglo);
		exit;
	}*/

	$Conector->Cerrar();	
	$Conector = Conectar2();
	
	$vSQL='EXEC [web].[SP_ITEMS_X_TIPO_ARCHIVO] '.$ID_CLASIF_TCARGA.'';
	
	$ResultadoEjecutar = $Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA='SI', $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION	= $ResultadoEjecutar['CONEXION'];
	$ERROR		= $ResultadoEjecutar['ERROR'];
	$MSJ_ERROR	= $ResultadoEjecutar['MSJ_ERROR'];
	$resultPrin	= $ResultadoEjecutar['RESULTADO'];

	if($CONEXION == 'SI' and $ERROR == 'NO'){
		
		$filas = '';
		$i = 1;
		while(odbc_fetch_row($resultPrin)){
			if(odbc_result($resultPrin, 'SP_BUSQUEDA')){
				$TIENE_CONSULTA = 'SI';
			}else{
				$TIENE_CONSULTA = 'NO';
			}
			
			$items[] = array(
				"ITEM"	=> $i,
				"DATA"  => array(
					'NOMBRE_CAMPO'		=> odbc_result($resultPrin, 'NOMBRE_CAMPO'),
					'TIENE_CONSULTA'	=> $TIENE_CONSULTA,
					'COLUMNA' 			=> odbc_result($resultPrin, 'COLUMNA'),
					'TIPO_CAMPO_EXCEL'	=> odbc_result($resultPrin, 'TIPO_CAMPO_EXCEL'),
					'TIPO_CAMPO_TABLA'	=> odbc_result($resultPrin, 'TIPO_CAMPO_TABLA'),
					'MIN' 				=> odbc_result($resultPrin, 'MIN'),
				)
			);	
			
			$i++;
		}

		$Arreglo['ITEMS']		= $items;
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
	}else{
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
		$Arreglo['MSJ_ERROR']	= $MSJ_ERROR;
		
		echo json_encode($Arreglo);
		exit;
	}

	echo json_encode($Arreglo);

	$Conector->Cerrar();
?>