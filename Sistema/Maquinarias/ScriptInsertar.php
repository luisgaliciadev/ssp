<?php
$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	

	
	session_start();	

$RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];	

$ID_SOLIC_MUELLE = $_POST["ID_SOLIC_MUELLE"];		
$ID_EVENTO = $_POST["ID_EVENTO"];	
$RIF_OPERADOR = $_POST["RIF_OPERADOR"];



$Conector=Conectar3();	
	
	 $vSQL="EXEC SP_GUARDAR_MAQ_WEB $ID_SOLIC_MUELLE,$ID_EVENTO,'$RIF','$RIF_OPERADOR','$RIF'";
	 
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{				
		$MENSAJE=odbc_result($resultPrin,"MENSAJE");
		//$ID_SM=odbc_result($resultPrin,"ID_SM");
		
		$Arreglo["MENSAJE"]=$MENSAJE;
		$Arreglo["ID_SM"]=$ID_SM;
		$Arreglo["ERROR"]=$ERROR;
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
	}

	$Conector->Cerrar();	
	$Conector=Conectar2();	
	
	 $vSQL="EXEC web.[SP_INSERT_BENEF_SM_SERV] $ID_SOLIC_MUELLE,9,8,11,'$RIF_OPERADOR'";
	 
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{				
		$MENSAJE=odbc_result($resultPrin,"MENSAJE");
		//$ID_SM=odbc_result($resultPrin,"ID_SM");
		
		$Arreglo["MENSAJE"]=$MENSAJE;
		$Arreglo["ID_SM"]=$ID_SM;
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