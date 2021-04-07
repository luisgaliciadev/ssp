<?php
$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	

$RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];	

$tipo_solicitud = $_POST["tipo_solicitud"];
$buque = $_POST["buque"];
$viaje = $_POST["viaje"];
$capitan = $_POST["capitan"];
$c_proa =$_POST["c_proa"];
$c_popa = $_POST["c_popa"];
$armador = $_POST["armador"];
$linea = $_POST["linea"];
$pto_proc = $_POST["pto_proc"];
$pto_destino = $_POST["pto_destino"];
$muelle = $_POST["muelle"];
$nivel = $_POST["nivel"];
$fecha_d = $_POST["fecha_d"];
$fecha_h = $_POST["fecha_h"];
$num_sol = $_POST["num_sol"];


	 $vSQL="EXEC SP_UPDATE_SOLICITUD '$RIF', $buque, '$c_popa', '$c_proa', '$fecha_d', '$capitan', '$viaje', $muelle, $pto_proc, $pto_destino, '$fecha_h',$nivel,$armador,$linea,$tipo_solicitud,'$USUARIO_CRE_WEB',5,8,$num_sol";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{				
		$MENSAJE=odbc_result($resultPrin,"MENSAJE");
		$ID_SM=odbc_result($resultPrin,"ID_SM");
		
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