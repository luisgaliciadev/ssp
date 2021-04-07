<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	$RIF=$_SESSION[$SiglasSistema."RIF"];
	
	date_default_timezone_set('America/Caracas');
	
	$ID=$_POST['ID']; 
	
	$PagActual=$_POST["PagActual"];		
	$txtBuscar=$_POST["txtBuscar"];
	$NroReg=$_POST["NroReg"];
	$Orden=$_POST["Orden"];
	$AscDesc=$_POST["AscDesc"];
	
	if(!$PagActual)
		$PagActual=1;
	
	if(!$Orden)
		$Orden="NOMBRE";
	
	if(!$AscDesc)
		$AscDesc="ASC";	
	
	$Conector=Conectar2();

	$vSQL='select * from web.VIEW_DETALLE_CARGA_SM WHERE ID='.$ID;
								
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{			
?>
	<div class="row">
		<div class="col-lg-12">
			<br>
			<p>
				<button type="button" class="btn btn-danger btn-xs" onClick="anularTodas()">
					<i class="fa fa-times"></i>
					<span>Eliminar toda la carga<span>
				</button>
			</p>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div style="width : 100%; overflow-x: auto;">	
				<table class="table table-bordered table-hover" role="grid" id="tablaSolicitudes">
					<thead>
						<tr>
							<th class="text-center" colspan="2">
								<button type="button" class="btn btn-success btn-xs" onClick="callFormRegistrar();" data-placement="top" data-toggle="tooltip" data-original-title="Agregar" style=" cursor: pointer;">
									<i class="fa fa-plus"></i>
								</button>
							</th>
							<th>SOLICITUD</th>				
							<th>OPERADOR</th>
							<th>RIF</th>
							<th>ACTIVIDAD</th>
							<th>BL</th>
							<th>CARGA</th>
							<th>PELIGROSA</th>
							<th>CARGA</th>
							<th>TAMAÑO</th>
							<th>SIGLAS</th>
							<th>LINEA</th>
							<th>IMO</th>
							<th>CANTIDAD</th>
							<th>PESO</th>
							<th>GOBIERNO</th>
							<th>CONSIGNATARIO</th>
						</tr>
					</thead>
					<tbody>
		<?php
				while (odbc_fetch_row($resultPrin))  
				{
					$Ite++;
					
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
					$CONSIGNATARIO				= odbc_result($resultPrin,"CONSIGNATARIO");
					$PELIGROSA				= odbc_result($resultPrin,"PELIGROSA");
					
					$NroTotal				= odbc_result($resultPrin,'CantReg');			
					$PagTotal 				= ceil($NroTotal/$NroReg);
					
					if($FG_ANULADO==0)
					{
						if($ID_CLASIF_TCARGA==2){
							$Modificar='
								<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Modificar" style=" cursor: pointer;" onClick="callFormModificar('.$ID_CARGA.', '.$ID_CLASIF_TCARGA.');">
									<i class="fa fa-pencil"></i>
								</button>';
							
						}else{
							$Modificar='
								<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Modificar" disabled>
									<i class="fa fa-pencil"></i>
								</button>';
						}
						
						$Eliminar='
							<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular" style=" cursor: pointer;" onClick="anular('.$ID_CARGA.');">
								<i class="fa fa-trash"></i>
							</button>';
					}
					else
					{				
						$Modificar='
							<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Modificar" disabled>
								<i class="fa fa-pencil"></i>
							</button>';
						
						$Eliminar='
							<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular" disabled>
								<i class="fa fa-trash"></i>
							</button>';
					}
		?>
					<tr>
						<td width="10">
							<?php echo $Modificar;?>
						</td>
						<td width="10">
							<?php echo $Eliminar;?>
						</td>
						<td width="10">
							<?php echo $SOLIC_MUELLE;?>
						</td>
						<td width="10">
							<?php echo $OPERADOR;?>
						</td>
						<td width="10">
							<?php echo $RIF_OP;?>
						</td>
						<td width="10">
							<?php echo $DS_ACTIV_PORT;?>
						</td>
						<td width="10">
							<?php echo $BL;?>
						</td>
						<td width="10">
							<?php echo $TIPO_CARGA;?>
						</td>
						<td width="10">
							<?php echo $PELIGROSA;?>
						</td>
						<td width="10">
							<?php echo $CARGA;?>
						</td>
						<td width="10">
							<?php echo $TAMANO;?>
						</td>
					<td width="10">
							<?php echo  $SIGLAS;?>
						</td>
						
						<td width="10">
							<?php echo $LINEA;?>
						</td>
						<td width="10">
							<?php echo $COD_CARGA_PELIGROSA;?>
						</td>
						<td width="10">
							<?php echo $CANTIDAD;?>
						</td>
						<td width="10">
							<?php echo $PESO;?>
						</td>
						<td width="10">
							<?php echo $GOBIERNO;?>
						</td>
						<td width="10">
							<?php echo $CONSIGNATARIO;?>
						</td>
					</tr>
		<?php
				}
		?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
    <hr>
<?php
		echo Paginador($PagTotal, $PagActual, 5);
	}
	else
	{
		echo $vSQL;
	}
	
	$Conector->Cerrar();
?>