<?php
$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	

$RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];	

$consulta = $_POST["consulta"];
$STIPO_SERV=19;// ENERGIA

if($consulta ==1)
{
	$solicitud 	= $_POST["solicitud"];
	$tipo_benef = $_POST["tipo_benef"];
	$categoria 	= $_POST["categoria"];
	$operador 	= $_POST["operador"];	
	$tipo_servicio	= $_POST["stipo_servicio"];	
	
	 $vSQL="EXEC web.[SP_INSERT_BENEF_SM_SERV] $solicitud,$tipo_benef,$categoria,$STIPO_SERV,'".$operador."'";
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	$Arreglo["CONSULTA"] = $vSQL;
	//$Arreglo["COMBO"] = '<option value="">Seleccione...</option>';

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		while (odbc_fetch_array($resultPrin))
        {		
			$ID_BENEF			=	odbc_result($resultPrin,"ID_BENEF");
			$MENSAJE	=	odbc_result($resultPrin,"MENSAJE");
		
			$Arreglo["ID_BENEF"]=$ID_BENEF;
			$Arreglo["MENSAJE"]=$MENSAJE;
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

if($consulta ==2)
{
	
	$Id_SM 			= $_POST["Id_SM"];
	$Rif_gen 		= $_POST["Rif_gen"];
	$Rif_oper 		= $_POST["Rif_oper"];
	$Ano 			= $_POST["Ano"];
	$Id_solicitud 	= $_POST["Id_solicitud"];
	
	$vSQL="EXEC web.[SP_ANULA_BENEFICIARIO_SM_SERV] $Id_SM,'".$Rif_gen."','".$Rif_oper."',$Ano,$Id_solicitud,$STIPO_SERV";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	//$Arreglo["SQL"] = $vSQL;
	//$Arreglo["COMBO"] = '<option value="">Seleccione...</option>';

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		while (odbc_fetch_array($resultPrin))
        {		
			$CONSULTA	=	odbc_result($resultPrin,"CONSULTA");
			$MENSAJE	=	odbc_result($resultPrin,"MENSAJE");
			$ID_SM	=	odbc_result($resultPrin,"ID_SM");
		
			$Arreglo["CONSULTA"]=$CONSULTA;
			$Arreglo["MENSAJE"]=$MENSAJE;
			$Arreglo["ID_SM"]=$ID_SM;
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

?>