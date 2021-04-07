<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	$RIF=$_SESSION[$SiglasSistema."RIF"];
	
	date_default_timezone_set('America/Caracas');
	
	$Conector=Conectar();

	$vSQL='SELECT * FROM VIEW_SROP_EMPRE_USUARIO WHERE FG_ACT=1 AND ID_ROL <> 5';
								
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
			<table class="table table-bordered table-hover" role="grid" id="tablaUsuarios">
				<thead>
					<tr>							
						<th>
							Login
						</th>
						<th>
							Nombre
						</th>
						<th>
							Rol
						</th>
						<th>
							Puerto
						</th>
						<th class="text-center">
							<button type="button" class="btn btn-success btn-xs" onClick="callFormRegistrar();" data-placement="top" data-toggle="tooltip" data-original-title="Agregar" style=" cursor: pointer;">
								<i class="fa fa-plus"></i>
							</button>
						</th>
					</tr>
				</thead>
				<tbody>
<?php
			while (odbc_fetch_row($resultPrin))  
			{
				$Ite++;
				
				$ID = odbc_result($resultPrin,"ID_EMPRESA_USER");
				$RIF = odbc_result($resultPrin,"RIF");
				$RAZON_SOCIAL = utf8_encode(odbc_result($resultPrin,"RAZON_SOCIAL"));
				$NB_ROL = utf8_encode(odbc_result($resultPrin,"NB_ROL"));
				$ID_LOCALIDAD = odbc_result($resultPrin,"ID_LOCALIDAD");					

				if ($ID_LOCALIDAD) {
					$NB_LOCALIDAD = utf8_encode(odbc_result($resultPrin,"NB_LOCALIDAD"));
				} else {
					$NB_LOCALIDAD = "TODOS LOS PUERTOS";
				}					
				
				$Modificar='
					<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Modificar" style=" cursor: pointer;" onClick="callFormModificar('.$ID.');">
						<i class="fa fa-pencil"></i>
					</button>';
				
				$Eliminar='
					<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular" style=" cursor: pointer;" onClick="anular('.$ID.');">
						<i class="fa fa-trash"></i>
					</button>';
?>
					<tr>	
						<td width="10">
							<?php echo $RIF;?>
						</td>
						<td width="10">
							<?php echo $RAZON_SOCIAL;?>
						</td>
						<td width="10">
							<?php echo $NB_ROL;?>
						</td>	
						<td width="10">
							<?php echo $NB_LOCALIDAD;?>
						</td>	
						<td width="10">
							<?php echo $Modificar;?>
							<?php echo $Eliminar;?>
						</td>												
					</tr>
<?php
			}
?>
				</tbody>
			</table>
		</div>
	</div>
    <hr>
<?php
	}
	else
	{
		echo $vSQL;
	}
	
	$Conector->Cerrar();
?>