<?php
	$Nivel='../../../';
	
	include($Nivel.'includes/PHP/funciones.php');
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$ID_EMPRESA=$_SESSION[$_SESSION['SiglasSistema'].'ID_EMPRESA'];
	$USUARIO_CRE=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
	$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];
	
	$ID_ROL = $_POST['ID_ROL'];
	
	if ($ID_ROL!=1 and $ID_ROL!=2 and $ID_ROL!=3) {
		$Conector = Conectar();
		
		$vSQL='SELECT * FROM VIEW_LOCALIDAD ORDER BY NB_LOCALIDAD ASC';
	
		$ResultadoEjecutar = $Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA='SI', $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
		$CONEXION	= $ResultadoEjecutar['CONEXION'];
		$ERROR		= $ResultadoEjecutar['ERROR'];
		$MSJ_ERROR	= $ResultadoEjecutar['MSJ_ERROR'];
		$RESULTADO  = $ResultadoEjecutar['RESULTADO'];
	
		if($CONEXION == 'SI' and $ERROR == 'NO'){
			$OPTION = '<option value="" disabled selected>SELECCIONE EL PUERTO...</option>';
	
			while (odbc_fetch_row($RESULTADO))  
			{
				$ID_LOCALIDAD   = odbc_result($RESULTADO,"ID_LOCALIDAD");
				$NB_LOCALIDAD   = odbc_result($RESULTADO,"NB_LOCALIDAD");
				
				$OPTION         .= '<option value="'.$ID_LOCALIDAD.'">'.$NB_LOCALIDAD.'</option>';
			}
			
			$Arreglo['OPTION']	    = $OPTION;
			$Arreglo['CONEXION']	= $CONEXION;
			$Arreglo['ERROR']		= $ERROR;        
		}else{
			$Arreglo['CONEXION']	= $CONEXION;
			$Arreglo['ERROR']		= $ERROR;
			$Arreglo['MSJ_ERROR']	= $MSJ_ERROR;
		}
	
		echo json_encode($Arreglo);
	
		$Conector->Cerrar();
	} else {
		$OPTION	.= '<option value="TODOS">TODOS LOS PUERTOS</option>';

		$Arreglo['OPTION']	    = $OPTION;
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
		
		echo json_encode($Arreglo);
	}
?>