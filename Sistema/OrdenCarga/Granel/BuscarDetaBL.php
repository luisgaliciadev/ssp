<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$ID_BL=$_POST['ID_BL'];
			
	$vSQL="EXEC web.SP_VIEW_WEB_USUARIO_BL_DETA $ID_BL";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$ID_MUELLE=odbc_result($resultPrin,"ID_MUELLE");
		$NB_MUELLE=odbc_result($resultPrin,"NB_MUELLE");
		$ID_SILO=odbc_result($resultPrin,"ID_SILO");
		$NB_SILO=odbc_result($resultPrin,"NB_SILO");
		$ID_PRODUCTO=odbc_result($resultPrin,"ID_PRODUCTO");
		$DS_PRODUCTO=odbc_result($resultPrin,"DS_PRODUCTO");
		
		$Arreglo["ERROR"]=$ERROR;	
		
		$Arreglo["ID_MUELLE"]=$ID_MUELLE;
		$Arreglo["NB_MUELLE"]=$NB_MUELLE;
		$Arreglo["ID_SILO"]=$ID_SILO;
		$Arreglo["NB_SILO"]=$NB_SILO;
		$Arreglo["ID_PRODUCTO"]=$ID_PRODUCTO;
		$Arreglo["DS_PRODUCTO"]=$DS_PRODUCTO;
			
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