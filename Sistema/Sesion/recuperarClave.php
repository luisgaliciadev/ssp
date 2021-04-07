<?php
	session_start();	
	
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	date_default_timezone_set('America/Caracas');

	$LOGIN=$_POST['LOGIN'];
	
	$vSQL="EXEC SP_RECUPERAR_CLAVE '$LOGIN';";	

	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION=$ResultadoEjecutar["CONEXION"];
	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$result=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$RESULTADO=odbc_result($result,"RESULTADO");
		$RAZON_SOCIAL=odbc_result($result,"RAZON_SOCIAL");
		$CLAVE=odbc_result($result,"CLAVE");
		$EMAIL=odbc_result($result,"E_MAILU");

		if ($RESULTADO==1) {
			if(IpServidor()!="10.10.30.52")
				$RAIZ="http://www.zonalotto.com/";
			else
				$RAIZ="http://10.10.30.52/SASPWEB/";

			$ArregloEnviarCorreo	=	EnviarCorreo
			(
				$EmisorCorreo			=	'ssp@bolipuertos.gob.ve', 
				$EmisorNombre			=	'Bolivariana de Puertos, S.A.', 
				$EmisorCorreoResponder	=	'ssp@bolipuertos.gob.ve', 
				$EmisorNombreResponder	=	'Bolivariana de Puertos, S.A.', 
				$DestinatarioCorreo		=	$EMAIL, 
				$DestinatarioNombre		=	$RAZON_SOCIAL, 
				$Asunto					=	'Recuperacion de clave en el SSP realizada exitosamente, '.$RAZON_SOCIAL, 
				$Plantilla				=	$RAIZ.'Sistema/Correo/recuperarClave.php?&LOGIN='.$LOGIN.'&RAZON_SOCIAL='.str_replace(' ', '+', $RAZON_SOCIAL).'&CLAVE='.str_replace(' ', '+', $CLAVE),
				$Nivel					=	$Nivel
            );
            
			if(!$ArregloEnviarCorreo["RESULTADO"])
			{				
				$ERROR					=	"SI";
				$Arreglo["MSJ_ERROR"]	=	"Error de envio de correo: ".$ArregloEnviarCorreo["MSJ_ERROR"];
			}
		}
		
		//$Arreglo["SQL"]=$vSQL;
		$Arreglo["RESULTADO"]=$RESULTADO;
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
	}
	else
	{			
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
	}
	
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
?>