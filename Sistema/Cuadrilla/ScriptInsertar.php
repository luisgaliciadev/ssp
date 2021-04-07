<?php
$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	

$RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];	

$operador = $_POST["operador"];		
$categoria = $_POST["categoria"];	
$cedula1 = $_POST["cedula"];
$id_solic_muelle1 = $_POST["id_solic_muelle"];
$nombre = $_POST["nombre"];
$cargo = $_POST["cargo"];	
$tp_operador = $_POST["tipo_op"];	


	 $vSQL="EXEC web.SP_GUARDAR_EMPLEADO_SM $id_solic_muelle1,1,$tp_operador,'$operador',$categoria,'$cedula1','$nombre','$cargo'";
	
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