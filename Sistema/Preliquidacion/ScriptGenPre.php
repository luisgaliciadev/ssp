<?php
$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	

$RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];	
$LOCALIDAD=$_SESSION[$_SESSION['SiglasSistema'].'ID_LOCALIDAD'];	

$id_pre = $_POST["id_pre"];
$detalles = $_POST["detalles"];


	 $vSQL="EXEC web.SP_ACTUALIZA_PAGO_PREQ $id_pre,'$detalles','RUTA' ";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{				
		$MENSAJE=odbc_result($resultPrin,"MENSAJE");
		$ID_SM=odbc_result($resultPrin,"ID");
		
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