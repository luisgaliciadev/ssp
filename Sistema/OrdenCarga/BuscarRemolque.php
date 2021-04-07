<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$PLACA_REMOLQUE=LimpiaEspacios($_POST['PLACA_REMOLQUE']);
			
	$vSQL="EXEC web.SP_WEB_BUSCAR_REMOLQUE '$PLACA_REMOLQUE'";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$EXISTE=odbc_result($resultPrin,"EXISTE");
		
		$Arreglo["Existe"]=$EXISTE;
		$Arreglo["ERROR"]=$ERROR;
			
		echo json_encode($Arreglo);
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
		
		echo json_encode($Arreglo);
	}
	
	$Conector->Cerrar();
?>