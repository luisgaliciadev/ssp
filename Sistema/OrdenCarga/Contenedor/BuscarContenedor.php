<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$ID_BL=$_POST['ID_BL'];
	$COD_CONTE=$_POST['COD_CONTE'];
			
	$vSQL="EXEC web.SP_CONSULTA_CONTENEDOR_DR $ID_BL, '$COD_CONTE';";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$EXISTE=odbc_result($resultPrin,"EXISTE");
		$FG_ORDEN=odbc_result($resultPrin,"FG_ORDEN");
		$COD_ALMA=odbc_result($resultPrin,"COD_ALMA");
		$ALMACEN=odbc_result($resultPrin,"ALMACEN");
		
		$Arreglo["Existe"]=$EXISTE;
		$Arreglo["FG_ORDEN"]=$FG_ORDEN;
		$Arreglo["COD_ALMA"]=$COD_ALMA;
		$Arreglo["ALMACEN"]=$ALMACEN;
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