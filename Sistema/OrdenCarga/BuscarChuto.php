<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$ID_TIPO_CARGA=$_POST['ID_TIPO_CARGA'];
	$PLACA_VEHICULO=$_POST['PLACA_VEHICULO'];
			
	$vSQL="EXEC web.SP_WEB_BUSCAR_VEHICULO '$PLACA_VEHICULO', $ID_TIPO_CARGA";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$EXISTE=odbc_result($resultPrin,"EXISTE");
		$F_VIG_POLIZA=FechaNormal(odbc_result($resultPrin,"F_VIG_POLIZA"));
		$DIAS=odbc_result($resultPrin,"DIAS");
		
		if($ID_TIPO_CARGA>=3)
		{
			if($DIAS>=3)
			{
				$VIGENCIA_POLIZA=1;
			}
			else
			{
				$VIGENCIA_POLIZA=0;
			}
		}
		else
		{
			$VIGENCIA_POLIZA=1;
		}
		
		$Arreglo["Existe"]=$EXISTE;
		$Arreglo["F_VIG_POLIZA"]=$F_VIG_POLIZA;
		$Arreglo["VIGENCIA_POLIZA"]=$VIGENCIA_POLIZA;
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