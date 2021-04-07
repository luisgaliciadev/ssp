<?php
	$Nivel='../../';
	
	include($Nivel.'includes/PHP/funciones.php');
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$ID_EMPRESA=$_SESSION[$_SESSION['SiglasSistema'].'ID_EMPRESA'];
	$USUARIO_CRE=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
	$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];
	
	$ID					= $_POST['ID'];
	$RIF_OPERADOR		= $_POST['RIF_OPERADOR'];
	$COD_TBENEF_OP		= $_POST['COD_TBENEF_OP'];
	$ID_CLASIF_TCARGA	= $_POST['ID_CLASIF_TCARGA'];
	$parametrosItems	= json_decode($_POST['parametrosItems']);
	$items				= json_decode($_POST['items']);
	
	//var_dump($items);
	
    foreach ($items as $i => $filas) {	
		$NOMBRES_CAMPOS 	= '';
		$TIPOS_CAMPOS_TABLA	= '';
		$VALORES_CAMPOS 	= '';
		$TIENEN_CONSULTA	= '';
		
		foreach ($filas as $j => $VALOR_CAMPO) {
			$NOMBRE_CAMPO		= $parametrosItems[$j]->DATA->NOMBRE_CAMPO;
			$TIPO_CAMPO_TABLA	= $parametrosItems[$j]->DATA->TIPO_CAMPO_TABLA;
			$TIENE_CONSULTA		= $parametrosItems[$j]->DATA->TIENE_CONSULTA;
			$MIN				= $parametrosItems[$j]->DATA->MIN;

			$VALORES_CAMPOS .= ''.$VALOR_CAMPO.'';
			
			$NOMBRES_CAMPOS 	.= ''.$NOMBRE_CAMPO.'';
			$TIPOS_CAMPOS_TABLA 	.= ''.$TIPO_CAMPO_TABLA.'';
			$TIENEN_CONSULTA	.= ''.$TIENE_CONSULTA.'';
			
			if($j<(count($filas)-1)){
				$NOMBRES_CAMPOS 	.= '$';
				$TIPOS_CAMPOS_TABLA	.= '$';
				$VALORES_CAMPOS 	.= '$';
				$TIENEN_CONSULTA	.= '$';
			}
    	}		

		$Conector=Conectar2();
	
		$vSQL=strtoupper('EXEC web.SP_GUARDAR_SULICITUD_MUELLE_WEB \''.$ID.'\', \''.$RIF_OPERADOR.'\', \''.$COD_TBENEF_OP.'\', '.$ID_CLASIF_TCARGA.', \''.$NOMBRES_CAMPOS.'\', \''.$TIPOS_CAMPOS_TABLA.'\', \''.$VALORES_CAMPOS.'\', \''.$TIENEN_CONSULTA.'\'');

		
		$ResultadoEjecutar	= $Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

		$CONEXION			= $ResultadoEjecutar["CONEXION"];
		$ERROR				= $ResultadoEjecutar["ERROR"];
		$MSJ_ERROR			= $ResultadoEjecutar["MSJ_ERROR"];
		$resultPrin			= $ResultadoEjecutar["RESULTADO"];

		if($CONEXION=="NO" or $ERROR=="SI")
		{
			$Arreglo["CONEXION"]	= $CONEXION;
			$Arreglo["ERROR"]		= $ERROR;
			$Arreglo["MSJ_ERROR"]	= $MSJ_ERROR;
			$Arreglo["vSQL"]		= $vSQL;

			echo json_encode($Arreglo);

			$Conector->Cerrar();
			
			exit;
		}else{
			switch (odbc_result($resultPrin, 'VALOR')) {
				case 0:
					$EXISTEN .= ($i+1);
				break;

				case 2:		
					$FILAS_DETALLES[] = array(
						'FILA' 	=> ($i+1),
						'ORDEN' => odbc_result($resultPrin, 'ORDEN')
					);
				break;
			}
		}

		switch (1) {
			case $i<(count($items)-1) && odbc_result($resultPrin, 'VALOR')==0:
				$EXISTEN .= ',';
			break;
		}
    }

	$Arreglo["FILAS_DETALLES"]		= $FILAS_DETALLES;
	$Arreglo["FILAS"]				= $i+1;
	$Arreglo["EXISTEN"]				= $EXISTEN;
	$Arreglo["CONEXION"]			= 'SI';
	$Arreglo["ERROR"]				= 'NO';

	echo json_encode($Arreglo);

	$Conector->Cerrar();
?>