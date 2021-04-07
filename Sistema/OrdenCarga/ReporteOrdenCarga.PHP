<?php
	$Nivel="../../";
	
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$LOGIN=$_SESSION[$SiglasSistema.'LOGIN'];
	$NB_LOCALIDAD=$_SESSION[$SiglasSistema.'NB_LOCALIDAD'];
	$RIF=$_SESSION[$SiglasSistema.'RIF'];
	
	$Conector=Conectar2();
	
	$ID_ORDEN_PESAJE=$_GET["ID_ORDEN_PESAJE"];
	
	$vSQL="EXEC web.SP_VIEW_CONFIGURACION;";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$version=odbc_result($resultPrin,"version");
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
		
		echo json_encode($Arreglo);
		exit;
	}
	
	$Conector->Cerrar();
	$Conector=Conectar2();
	
	$vSQL="EXEC web.VISTA_NEW $ID_ORDEN_PESAJE, $version";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		$FECHA_CRE=FechaHoraNormal(odbc_result($resultPrin,"FECHA_CRE"));
		$LLAVE=odbc_result($resultPrin,"LLAVE");
		$ID_TIPO_CARGA=odbc_result($resultPrin,"ID_TIPO_CARGA");
		$DESCRIP_TIPO=odbc_result($resultPrin,"DESCRIP_TIPO"); 
		$ACTIVIDAD_PORT=odbc_result($resultPrin,"ACTIVIDAD_PORT"); 
		
		$NOMBRE_CLI=odbc_result($resultPrin,"nb_proveed_benef");
		$NB_BUQUE=odbc_result($resultPrin,"NB_BUQUE");		
		$NUM_VIAJE=odbc_result($resultPrin,"NUM_VIAJE");	
		$FECHA_ATRAQUE=FechaNormal(odbc_result($resultPrin,"FECHA_ATRAQUE"));
		$NB_MUELLE=odbc_result($resultPrin,"NB_MUELLE");
		$NB_ALMACEN=odbc_result($resultPrin,"NB_ALMACEN");
		$ID_BL=odbc_result($resultPrin,"ID_BL");
		$COD_BL=odbc_result($resultPrin,"COD_BL");
		$MERCANCIA=odbc_result($resultPrin,"MERCANCIA");	
		
		$CEDULA_CONDUCTOR=odbc_result($resultPrin,"CEDULA_CONDUCTOR");
		$NOMBRE=odbc_result($resultPrin,"NB_CONDUCTOR");
		$F_VENC_LIC=FechaNormal(odbc_result($resultPrin,"F_VENC_LIC"));
		
		$PLACA_VEHICULO=odbc_result($resultPrin,"PLACA_VEHICULO");
		$CLASIFICACION=odbc_result($resultPrin,"CLASIFICACION");
		$F_VIG_POLIZA=FechaNormal(odbc_result($resultPrin,"F_VIG_POLIZA"));
		
		$PLACA_REMOLQUE=odbc_result($resultPrin,"PLACA_REMOLQUE");
		$CLASIFICACION_REMOLQUE=odbc_result($resultPrin,"CLASIFICACION_REMOLQUE");
		$F_VIG_POLIZAR=FechaNormal(odbc_result($resultPrin,"F_VIG_POLIZAR"));
		
		$NB_EMP_VEHICULO=odbc_result($resultPrin,"NB_EMP_VEHICULO");
		
		$NOMBRE_USU=odbc_result($resultPrin,"NOMBRE_USU");
		$CEDULA=odbc_result($resultPrin,"CEDULA");
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
		
		echo json_encode($Arreglo);
		exit;
	}
			
	if($ID_TIPO_CARGA==3)
	{
		$NB_MUELLE_ALMACE="MUELLE";
		$VALOR_MUELLE_ALMACE=$NB_MUELLE;
		
		$NB_PRODUCTO_CONTENEDOR="PRODUCTO";
		$VALOR_PRODUCTO_CONTENEDOR=$MERCANCIA;
		
		$NB_SELLO="COSTADO DE BUQUE";
	}
	else
	{
		if($ID_TIPO_CARGA==1)
		{
			$NB_MUELLE_ALMACE="ALMACEN";
			$VALOR_MUELLE_ALMACE=$NB_ALMACEN;
			
			$NB_PRODUCTO_CONTENEDOR="NRO. CONTENEROR";
			$VALOR_PRODUCTO_CONTENEDOR=$MERCANCIA;
			
			$NB_SELLO="ALMACEN";
		}
		else
		{
			$NB_MUELLE_ALMACE="ALMACEN";
			$VALOR_MUELLE_ALMACE=$NB_ALMACEN;
			
			$NB_PRODUCTO_CONTENEDOR="NRO. DR";
			$VALOR_PRODUCTO_CONTENEDOR=$MERCANCIA;
			
			$NB_SELLO="ALMACEN";
		}
	}
	
	$Plantilla='
		<table width="1056" border="0" align="center">
			<tbody>
				<tr>
					<td valign="top" align="left">
						<table border="0" align="left">
							<tr>
								<td align="center" rowspan="3"><img src="'.$Nivel.'Includes/Imagenes/logo.png" alt="" height="80"/></td>
							</tr>
							<tr>
								<td align="center" width="400"><strong>BOLIVARIANA DE PUERTOS, BOLIPUERTOS S.A</strong></td>
							</tr>
							<tr>
								<td align="center"><strong>RIF:</strong> J-29759907-0</td>
							</tr>
						</table>
					</td>
					<td valign="top" align="right">
						<table border="0" align="right">
							<tr>
								<td align="center">
									<strong>ORDEN DE PESAJE Y CARGA</strong>
								</td>
							</tr>
							<tr>
								<td align="center">
									<barcode code="'.$LLAVE.'" type="I25" class="barcode" />
								</td>
							</tr>
							<tr>
								<td align="center">
									'.$LLAVE.'
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<table border="1" style="border-collapse:collapse; width:100%; border:#000 solid 1px; background:#F7F7F7; margin-bottom:10px;">
							<tr>
								<td align="left">
									<strong>DATOS DE LA CARGA</strong>
									<table border="1" style="border-collapse:collapse; width:100%; background: #FFF; margin:5px;">
										<tr>
											<th width="140" align="right">NRO. ORDEN:</th>
											<td align="left">'.str_pad($ID_ORDEN_PESAJE, 10, "0", STR_PAD_LEFT).'</td>
											<th width="100" align="right">F. EMISION:</th>
											<td width="160" align="left">'.$FECHA_CRE.'</td>
											<th width="130" align="right">TIPO DE CARGA:</th>
											<td width="100" align="left">'.$DESCRIP_TIPO .'</td>
											<th width="140" align="right">TIPO ACTIVIDAD:</th>
											<td width="100" align="left">'.$ACTIVIDAD_PORT.'</td>
										</tr>
										<tr>
											<th align="right">PUERTO:</th>
											<td colspan="7" align="left">'.$NB_LOCALIDAD.'</td>
										</tr>
										<tr>
											<th align="right">CONSIGNATARIO:</th>
										  <td colspan="7" align="left">'.$NOMBRE_CLI.'</td>
										</tr>
										<tr>
											<th align="right">BUQUE:</th>
											<td align="left">'.$NB_BUQUE.'</td>
											<th align="right">VIAJE:</th>
											<td align="left">'.$NUM_VIAJE.'</td>
											<th align="right">F. ATRAQUE:</th>
											<td align="left">'.$FECHA_ATRAQUE.'</td>
											<th align="right">'.$NB_MUELLE_ALMACE.':</th>
											<td align="left">'.$VALOR_MUELLE_ALMACE.'</td>
										</tr>
										<tr>
											<th align="right">BL:</th>
											<td colspan="2" align="left">'.$COD_BL.'</td>
											<th colspan="1" align="right">'.$NB_PRODUCTO_CONTENEDOR.':</th>
											<td colspan="4" align="left">'.$VALOR_PRODUCTO_CONTENEDOR.'</td>
										</tr>
									</table>
								</tr>
							</td>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<table border="1" style="border-collapse:collapse; width:100%; border:#000 solid 1px; background:#F7F7F7; margin-bottom:10px;">
							<tr>
								<td align="left">
									<strong>LOGISTICA DE TRANSPORTE</strong>
									<table border="1" style="border-collapse:collapse; width:100%; background: #FFF; margin:5px;">
										<tr style="background: #ccc;">
											<th colspan="4" align="center">TRANSPORTE</th>
										</tr>
										<tr>
											<th width="140" align="right">RAZON SOCIAL:</th>
											<td align="left">'.$NB_EMP_VEHICULO.'</td>
											<th width="90" align="right">RIF:</th>
											<td width="100" align="left">'.$RIF.'</td>
										</tr>
									</table>
									
									<table border="1" style="border-collapse:collapse; width:100%; background: #FFF; margin:5px;">
										<tr style="background: #ccc;">
											<th colspan="6" align="center">CONDUCTOR</th>
										</tr>
										<tr>
											<th width="90" align="right">NOMBRE:</th>
											<td align="left">'.$NOMBRE.'</td>
											<th width="90" align="right">CEDULA:</th>
											<td width="100" align="left">'.$CEDULA_CONDUCTOR.'</td>
											<th width="160" align="right">FECHA LICENCIA:</th>
											<td width="100" align="left">'.$F_VENC_LIC.'</td>
										</tr>
									</table>
									
									<table border="1" style="border-collapse:collapse; width:100%; background: #FFF; margin:5px;">
										<tr style="background: #ccc;">
											<th colspan="6" align="center">VEHICULO</th>
										</tr>
										<tr>
											<th width="90" align="right">PLACA:</th>
											<td width="120" align="left">'.$PLACA_VEHICULO.'</td>
											<th width="90" align="right">TIPO:</th>
											<td align="left">'.$CLASIFICACION.'</td>
											<th width="140" align="right">FECHA POLIZA:</th>
											<td width="100" align="left">'.$F_VIG_POLIZA.'</td>
										</tr>
									</table>
									
									<table border="1" style="border-collapse:collapse; width:100%; background: #FFF; margin:5px;">
										<tr style="background: #ccc;">
											<th colspan="4" align="center">REMOLQUE</th>
										</tr>
										<tr>
											<th width="90" align="right">PLACA:</th>
											<td width="120" align="left">'.$PLACA_REMOLQUE.'</td>
											<th width="90" align="right">TIPO:</th>
											<td align="left">'.$CLASIFICACION_REMOLQUE.'</td>
										</tr>
									</table>
								</tr>
							</td>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<table border="1" style="border-collapse:collapse; width:100%; border:#000 solid 1px; background:#F7F7F7;">
							<tr>
								<td align="left">
									<strong>SELLOS</strong>
									<table border="1" style="border-collapse:collapse; width:100%; background: #FFF; margin:5px;">
										<tbody>
											<tr style="background: #ccc;">
												<th>TRANSPORTE</th>
												<th>BOLIPUERTOS</th>
												<th>'.$NB_SELLO.'</th>
												<th>G.N.B.</th>
											</tr>
											<tr>
												<th height="80">
													FIRMA:____________________
													<br>
													<br>
													FECHA:____________________
												</th>
												<th>
													FIRMA:____________________
													<br>
													<br>
													FECHA:____________________
												</th>
												<th>
													FIRMA:____________________
													<br>
													<br>
													FECHA:____________________
												</th>
												<th>
													FIRMA:____________________
													<br>
													<br>
													FECHA:____________________
												</th>
											</tr>
										</tbody>
									</table>
								</tr>
							</td>
						</table>
					</td>
				</tr>
				<tr>
					<td colspan="3" align="center">
						<table width="100%" border="0">
							<tbody>
								<tr>
									<td align="left"><strong>ELABORADO POR</strong>: '.$NB_EMP_VEHICULO.", RIF: ".$LOGIN.'</td>
									<td align="right"><strong>IMPRESO:</strong> '.date("d/m/Y h:i:s a").'</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>';
	
	$HTML='
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<meta charset="utf-8">
			<title></title>		
		</head>
		<body>
			'.$Plantilla.'	
			<br>
			'.$Plantilla.'	
		</body>
	</html>';
	
	//echo $HTML;
	
	$Arreglo["HTML"]=$HTML;
	
	echo json_encode($Arreglo);
	
	$_SESSION[$SiglasSistema."ReporteOrdenCarga"]=$HTML;
	
	$Conector->Cerrar();
?>