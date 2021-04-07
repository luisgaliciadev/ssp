<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$CEDULA_COND=$_POST['CEDULA_COND'];
			
	$vSQL="EXEC web.SP_WEB_BUSCAR_CONDUCTOR '$CEDULA_COND';";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$EXISTE=odbc_result($resultPrin,"EXISTE");
		$NOMBRE=utf8_encode(odbc_result($resultPrin,"NOMBRE"));
		$F_VENC_LIC=FechaNormal(odbc_result($resultPrin,"F_VENC_LIC"));
		$VIGENCIA_LIC=odbc_result($resultPrin,"VIGENCIA_LIC");
		
		$Arreglo["Existe"]=$EXISTE;
		$Arreglo["NOMBRE"]=$NOMBRE;
		$Arreglo["F_VENC_LIC"]=$F_VENC_LIC;
		$Arreglo["VIGENCIA_LIC"]=$VIGENCIA_LIC;
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