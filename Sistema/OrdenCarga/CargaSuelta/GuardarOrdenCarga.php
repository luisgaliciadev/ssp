<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$ID_EMPRESA=$_SESSION[$_SESSION['SiglasSistema'].'ID_EMPRESA'];
	$USUARIO_CRE=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
	$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];
	
	$ID_BL=$_POST['ID_BL'];
	$NUM_DR=$_POST['NUM_DR'];
	$CEDULA_COND=$_POST['CEDULA_COND'];
	$PLACA_VEHICULO=$_POST['PLACA_VEHICULO'];
	$PLACA_REMOLQUE=$_POST['PLACA_REMOLQUE'];
	$DESTINO=$_POST['DESTINO'];
	$COD_ALMA=$_POST['COD_ALMA'];
	
	$ID_MUELLE=0;
	$ID_PRODUCTO=0;
	$ID_SILO=0;
	
	$vSQL="EXEC web.BP_GENERAR_ORDEN_PESAJE $ID_BL, $ID_PRODUCTO, '$USUARIO_CRE', '$CEDULA_COND', '$PLACA_VEHICULO', '$PLACA_REMOLQUE', $ID_SILO, $ID_MUELLE, '$DESTINO', '$NUM_DR', $COD_ALMA, '$USUARIO_CRE_WEB'";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{				
		$ID_ORDEN_PESAJE=odbc_result($resultPrin,"ID_ORDEN_PESAJE");
		
		$Arreglo["ID_ORDEN_PESAJE"]=$ID_ORDEN_PESAJE;
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