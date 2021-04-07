<?php
	$Nivel='../../';
	
	include($Nivel.'includes/PHP/funciones.php');
	
	session_start();
	
	date_default_timezone_set('America/Caracas');
	
	$ID_EMPRESA=$_SESSION[$_SESSION['SiglasSistema'].'ID_EMPRESA'];
	$USUARIO_CRE=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
	$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];
	
	$ID   = $_POST['ID'];
	
    $Conector = Conectar2();
    
    $vSQL='UPDATE 
                WEB_CARGA_SOLIC_MUELLE 
            SET
                FG_ACTIVO = 0, 
                FH_INACTIVO = GETDATE()           
            WHERE
				ID_SOL='.$ID;

    $ResultadoEjecutar = $Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA='SI', $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

    $CONEXION	= $ResultadoEjecutar['CONEXION'];
    $ERROR		= $ResultadoEjecutar['ERROR'];
    $MSJ_ERROR	= $ResultadoEjecutar['MSJ_ERROR'];
    $result	    = $ResultadoEjecutar['RESULTADO'];

    if($CONEXION == 'SI' and $ERROR == 'NO'){
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
		$Arreglo['MSJ_ERROR']	= $MSJ_ERROR;        
	}else{
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
		$Arreglo['MSJ_ERROR']	= $MSJ_ERROR;
	}

	echo json_encode($Arreglo);

	$Conector->Cerrar();
?>