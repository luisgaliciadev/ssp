<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	date_default_timezone_set('America/Caracas');

	$ID_MODULO_P=$_POST['ID_MODULO_P'];
	$FG_SUB_MODULO=$_POST['FG_SUB_MODULO'];
	$NB_MODULO=$_POST['NB_MODULO'];
	$TIPO_MENU=$_POST['TIPO_MENU'];
	$ICONO=$_POST['ICONO'];
	$RUTA=$_POST['RUTA'];
	$Enlace=$_POST['Enlace'];
	
	$vSQL="EXEC SP_TB_ADMIN_USU_MODULO_INSERTAR $ID_MODULO_P, $TIPO_MENU, '$NB_MODULO', $FG_SUB_MODULO, '$ICONO', '$RUTA', '$Enlace';";	
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];
	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$result=$ResultadoEjecutar["RESULTADO"];
	
	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$Arreglo["CONEXION"]=$CONEXION;	
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