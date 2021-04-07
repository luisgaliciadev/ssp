<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	$USUARIO_CRE=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
	
	date_default_timezone_set('America/Caracas');
	
	$ID_BL=$_POST['ID_BL'];
	
	$vSQL="exec [web].[SP_WEB_TOTALES_ORDEN_CARGA_CARG_SUEL] $ID_BL, $USUARIO_CRE";
	
	$resultPrin=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$resultPrin["CONEXION"];

	$ERROR=$resultPrin["ERROR"];
	$MSJ_ERROR=$resultPrin["MSJ_ERROR"];
	$resultPrin=$resultPrin["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$CANT_ORDEN_CARGA=odbc_result($resultPrin,"CANT_ORDEN_CARGA");
		$CANT_ESTATUS1=odbc_result($resultPrin,"CANT_ESTATUS1");
		$CANT_ESTATUS2=odbc_result($resultPrin,"CANT_ESTATUS2");
		$CANT_ESTATUS3=odbc_result($resultPrin,"CANT_ESTATUS3");
		$CANT_ANULADAS=odbc_result($resultPrin,"CANT_ANULADAS");
		
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		
		$Arreglo["CANT_ORDEN_CARGA"]=$CANT_ORDEN_CARGA;
		$Arreglo["CANT_ESTATUS1"]=$CANT_ESTATUS1;
		$Arreglo["CANT_ESTATUS2"]=$CANT_ESTATUS2;
		$Arreglo["CANT_ESTATUS3"]=$CANT_ESTATUS3;
		$Arreglo["CANT_ANULADAS"]=$CANT_ANULADAS;
			
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