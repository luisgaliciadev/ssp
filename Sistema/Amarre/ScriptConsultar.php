<?php
$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	

$RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];	

$consulta = $_POST["consulta"];
$STIPO_SERV=7;// AMARRE 

if($consulta == 1)
{

	 $vSQL="EXEC web.[SP_TIPO_SERVICIO_OPERADORES_SERV] $STIPO_SERV";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	$Arreglo["COMBO"]='<option value="">Seleccione...</option>';

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		while (odbc_fetch_array($resultPrin))
        {		
			$COD_TIPO_BENEF	=	utf8_encode(odbc_result($resultPrin,"COD_TIPO_BENEFICIARIO"));
			$DS_TIPO_BENEF	=	utf8_encode(odbc_result($resultPrin,"DS_TIPO_BENEFICIARIO"));
		
			$Arreglo["COMBO"]	=$Arreglo["COMBO"]."<option value=".$COD_TIPO_BENEF.">$DS_TIPO_BENEF </option>";
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			
		}
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
	}
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
}

if($consulta == 2)
{
	$tipo_benef = $_POST["tipo_benef"];	
	
	 $vSQL="EXEC web.[SP_LISTADO_CATEGORIA_SERV] $tipo_benef,$STIPO_SERV";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	$Arreglo["COMBO"]='<option value="">Seleccione...</option>';

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		while (odbc_fetch_array($resultPrin))
        {		
			$ID_CATEGORIA	=	utf8_encode(odbc_result($resultPrin,"ID_CATEGORIA"));
			$DS_CATEGORIA	=	utf8_encode(odbc_result($resultPrin,"SIGLAS_CATEG"))." - ".utf8_encode(odbc_result($resultPrin,"NB_CATEGORIA"));
		
			$Arreglo["COMBO"]	=$Arreglo["COMBO"]."<option value=".$ID_CATEGORIA.">$DS_CATEGORIA </option>";
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			
		}
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
	}
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
}


if($consulta == 3)
{
	$tipo_benef = $_POST["tipo_benef"];
	$categoria = $_POST["categoria"];	
	
	 $vSQL="EXEC [web].[SP_BENEF_SERV_CONSULTA] $STIPO_SERV";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	//$Arreglo["CONSULTA"] = $vSQL;
	$Arreglo["COMBO"]='<option value="">Seleccione...</option>';
		
	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		while (odbc_fetch_array($resultPrin))
        {		
			$RIF_CED			=	utf8_encode(odbc_result($resultPrin,"RIF_CED"));
			$NB_PROVEED_BENEF	=	utf8_encode(odbc_result($resultPrin,"NB_PROVEED_BENEF"));
		
			$Arreglo["COMBO"]	=$Arreglo["COMBO"]."<option value=".$RIF_CED.">$NB_PROVEED_BENEF </option>";
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			
		}
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
	}
	
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
}


if($consulta == 4)
{
	
	$id_solicitud = $_POST["id_solicitud"];
	
	$vSQL="EXEC web.[SP_LISTADO_OPERADORES_SM_SERV] $RIF, $id_solicitud";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	$Arreglo["TABLA"]='';

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		while (odbc_fetch_array($resultPrin))
        {		
			$DS_TIPO_BENEFICIARIO	=	utf8_encode(odbc_result($resultPrin,"DS_TIPO_BENEFICIARIO"));
			$BEN_RIF_CED	=	utf8_encode(odbc_result($resultPrin,"BEN_RIF_CED"));
			$NB_PROVEED_BENEF	=	utf8_encode(odbc_result($resultPrin,"NB_PROVEED_BENEF"));
			$NB_CATEGORIA	=	utf8_encode(odbc_result($resultPrin,"NB_CATEGORIA"));
				
			$Arreglo["TABLA"]	=$Arreglo["TABLA"]."<tr><td>".$BEN_RIF_CED."</td><td>".$NB_PROVEED_BENEF."</td><td>".$NB_CATEGORIA."</td><td>".$DS_TIPO_BENEFICIARIO."</td><td></td></tr>";
			
			
		}
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
}

?>