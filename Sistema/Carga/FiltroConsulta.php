<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	date_default_timezone_set('America/Caracas');
	
	$ID=$_POST['ID']; 
	
	$Conector=Conectar2();

	$vSQL='select * from web.VIEW_DETALLE_CARGA_SM WHERE ID='.$ID;
								
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{			
		while (odbc_fetch_row($resultPrin))  
		{					
			$ID_CARGA				= odbc_result($resultPrin,"ID_CARGA");
			$ID_CLASIF_TCARGA		= odbc_result($resultPrin,"ID_CLASIF_CARGA");
			$SOLIC_MUELLE			= odbc_result($resultPrin,"ANO_EJERCICIO").'-'.odbc_result($resultPrin,"ID_SOLIC_MUELLE");
			$OPERADOR				= odbc_result($resultPrin,"OPERADOR");
			$RIF_OP					= odbc_result($resultPrin,"RIF_OP");
			$DS_ACTIV_PORT			= utf8_encode(odbc_result($resultPrin,"DS_ACTIV_PORT"));
			$BL						= odbc_result($resultPrin,"BL");
			$TIPO_CARGA				= utf8_encode(odbc_result($resultPrin,"TIPO_CARGA"));
			$CARGA					= utf8_encode(odbc_result($resultPrin,"CARGA"));
			$TAMANO					= odbc_result($resultPrin,"TAMANO");
			$SIGLAS					= odbc_result($resultPrin,"SIGLAS");
			$LINEA					= odbc_result($resultPrin,"LINEA");
			$COD_CARGA_PELIGROSA	= odbc_result($resultPrin,"COD_CARGA_PELIGROSA");
			$CANTIDAD				= odbc_result($resultPrin,"CANTIDAD");
			$PESO					= odbc_result($resultPrin,"PESO");
			$GOBIERNO				= odbc_result($resultPrin,"GOBIERNO");
			$CONSOLIDAR				= odbc_result($resultPrin,"CONSOLIDAR");
			$CONSIGNATARIO			= odbc_result($resultPrin,"CONSIGNATARIO");
			$PELIGROSA				= odbc_result($resultPrin,"PELIGROSA");
			
			//if($FG_ANULADO==0)
//			{
//				$controles='
//					<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Modificar" style=" cursor: pointer;" onClick="callFormModificar('.$ID_CARGA.', '.$ID_CLASIF_TCARGA.');">
//						<i class="fa fa-pencil"></i>
//						<span>Editar<span>
//					</button>
//					<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular" style=" cursor: pointer;" onClick="anular('.$ID_CARGA.');">
//						<i class="fa fa-trash"></i>
//						<span>Anular<span>
//					</button>';
//			}
			
			
			
			
			if($FG_ANULADO==0)
			{
				$controles='
					
					<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular" style=" cursor: pointer;" onClick="anular('.$ID_CARGA.');">
						<i class="fa fa-trash"></i>
						<span>Anular<span>
					</button>';
			}
			else
			{				
				$controles='
				
					<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular" disabled>
						<i class="fa fa-trash"></i>
						<span>Anular<span>
					</button>';
			}

			
		//	$controles='
//					<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Modificar" disabled>
//						<i class="fa fa-pencil"></i>
//						<span>Editar<span>
//					</button>
//					<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular" disabled>
//						<i class="fa fa-trash"></i>
//						<span>Anular<span>
//					</button>';
//			
			
			
			$REGISTROS[] = array(
				$controles,
				$SOLIC_MUELLE,
				$OPERADOR,
				$RIF_OP,
				$DS_ACTIV_PORT,
				$BL,
				$TIPO_CARGA,
				$PELIGROSA,
				$CARGA,
				$TAMANO,
				$SIGLAS,
				$LINEA,
				$COD_CARGA_PELIGROSA,
				$CANTIDAD,
				$PESO,
				$GOBIERNO,
				$CONSIGNATARIO
			);
		}

		$Arreglo['REGISTROS'] = $REGISTROS;

		echo json_encode($Arreglo);
	}
	else
	{
		echo $vSQL;
	}
	
	$Conector->Cerrar();
?>