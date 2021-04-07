<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	date_default_timezone_set('America/Caracas');

	$ID_MODULO=$_POST['ID_MODULO'];
	
	$vSQL="EXEC SP_TB_ADMIN_USU_MODULO_ELIMINAR $ID_MODULO;";	
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];
	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$result=$ResultadoEjecutar["RESULTADO"];
	
	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$Arreglo["CONEXION"]=$CONEXION;	
		$Arreglo["ERROR"]=$ERROR;
	}
	else
	{		
		$Arreglo["CONEXION"]=$CONEXION;	
		$Arreglo["ERROR"]=$ERROR;		
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
	}
	
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
?>