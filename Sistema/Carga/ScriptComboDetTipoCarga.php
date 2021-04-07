<?php
	$Nivel='../../';
	
	include($Nivel.'includes/PHP/funciones.php');
	
	session_start();

    $ID_CLASIF_TCARGA = $_POST['ID_CLASIF_TCARGA'];
    $ID_TIPO_CARGA = $_POST['ID_TIPO_CARGA'];

	$Conector = Conectar2();

	$vSQL='SELECT
				*
			FROM
                CLASIF_TCARGA_ARCHIVO
			WHERE
                COLUMNA=\'DETALLE_CARGA\' AND
				ID_CLASIF_TCARGA='.$ID_CLASIF_TCARGA;

	$ResultadoEjecutar = $Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA='SI', $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION	= $ResultadoEjecutar['CONEXION'];
	$ERROR		= $ResultadoEjecutar['ERROR'];
	$MSJ_ERROR	= $ResultadoEjecutar['MSJ_ERROR'];
	$result	= $ResultadoEjecutar['RESULTADO'];

	if($CONEXION == 'SI' and $ERROR == 'NO'){

        $SELECT_HTML = odbc_result($result,"SELECT_HTML");
        
        $vSQL=$SELECT_HTML.$ID_TIPO_CARGA;
                                            
        $ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

        $CONEXION=$ResultadoEjecutar["CONEXION"];

        $ERROR=$ResultadoEjecutar["ERROR"];
        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
        $result=$ResultadoEjecutar["RESULTADO"];

        if($CONEXION=="SI" and $ERROR=="NO"){

            while(odbc_fetch_row($result)){
                $VALUE	= odbc_result($result,"VALUE");
                $TEXT	= odbc_result($result,"TEXT");

                $OPTION['VALUE'][]  = $VALUE;
                $OPTION['TEXT'][]   = $TEXT;
            }
            
            $Arreglo['vSQL']	    = $vSQL;
            $Arreglo['OPTION']	    = $OPTION;
            $Arreglo['CONEXION']	= $CONEXION;
            $Arreglo['ERROR']		= $ERROR;
        }else{					
            $Arreglo['CONEXION']	= $CONEXION;
            $Arreglo['ERROR']		= $ERROR;
            $Arreglo['MSJ_ERROR']	= $MSJ_ERROR;
        }        
        
	}else{
		$Arreglo['CONEXION']	= $CONEXION;
		$Arreglo['ERROR']		= $ERROR;
		$Arreglo['MSJ_ERROR']	= $MSJ_ERROR;
	}

	echo json_encode($Arreglo);

	$Conector->Cerrar();
?>