<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$ID_EMPRESA=$_SESSION[$SiglasSistema.'ID_EMPRESA'];
	$USUARIO_CRE=$_SESSION[$SiglasSistema.'RIF'];
	
	$ID_ORDEN_PESAJE=$_POST['ID_ORDEN_PESAJE'];
	
	$vSQL="EXEC web.BP_ANULAR_ORDEN_PESAJE $ID_ORDEN_PESAJE, '$USUARIO_CRE';";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
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