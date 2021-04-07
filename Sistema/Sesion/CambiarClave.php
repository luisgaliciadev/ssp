<?php
	session_start();	
	
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$CODIGOS=$_SESSION[$SiglasSistema.'CODIGO'];	
	
	date_default_timezone_set('America/Caracas');
	
	$LOGIN=$_POST['LOGIN'];
	$CODIGO=$_POST['CODIGO'];
	$CLAVEN=$_POST['CLAVEN'];
	
	if($CODIGO===$CODIGOS)
	{
		$vSQL="EXEC SP_SESION_CAMBIAR_CLAVE '$LOGIN','$CLAVEN';";	
	
		$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
		$CONEXION=$ResultadoEjecutar["CONEXION"];
	
		$ERROR=$ResultadoEjecutar["ERROR"];
		$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
		$result=$ResultadoEjecutar["RESULTADO"];
	
		if($CONEXION=="SI" and $ERROR=="NO")
		{	
			$Arreglo["RESULTADO"]=1;
		}
		else
		{			
			$Arreglo["CONEXION"]="NO";
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
		}
	}
	else
	{
		$Arreglo["RESULTADO"]=0;
	}
	
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
?>