<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	$RIF=$_SESSION[$SiglasSistema."RIF"];
	
	date_default_timezone_set('America/Caracas');
	
	$ID_BL=$_POST['ID_BL']; 
	
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
	
	$vSQL="EXEC web.SP_VIEW_CONSULTA_ORDEN_CARGA_CONT '$RIF', $ID_BL, '$txtBuscar', $PagActual, $NroReg, '$Orden', '$AscDesc';";
										
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		if($Orden=="ID_ORDEN_PESAJE" and $AscDesc=="ASC")
		{
			$iID_ORDEN_PESAJE="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="ID_ORDEN_PESAJE" and $AscDesc=="DESC")
			{
				$iID_ORDEN_PESAJE="fa-sort-amount-desc";
			}
			else
			{
				$iID_ORDEN_PESAJE="fa-sort";
			}
		}
		
		if($Orden=="CEDULA_CONDUCTOR" and $AscDesc=="ASC")
		{
			$iCEDULA_CONDUCTOR="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="CEDULA_CONDUCTOR" and $AscDesc=="DESC")
			{
				$iCEDULA_CONDUCTOR="fa-sort-amount-desc";
			}
			else
			{
				$iCEDULA_CONDUCTOR="fa-sort";
			}
		}
		
		if($Orden=="NOMBRE" and $AscDesc=="ASC")
		{
			$iNOMBRE="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="NOMBRE" and $AscDesc=="DESC")
			{
				$iNOMBRE="fa-sort-amount-desc";
			}
			else
			{
				$iNOMBRE="fa-sort";
			}
		}
		
		if($Orden=="PLACA_VEHICULO" and $AscDesc=="ASC")
		{
			$iPLACA_VEHICULO="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="PLACA_VEHICULO" and $AscDesc=="DESC")
			{
				$iPLACA_VEHICULO="fa-sort-amount-desc";
			}
			else
			{
				$iPLACA_VEHICULO="fa-sort";
			}
		}
		
		if($Orden=="PLACA_REMOLQUE" and $AscDesc=="ASC")
		{
			$iPLACA_REMOLQUE="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="PLACA_REMOLQUE" and $AscDesc=="DESC")
			{
				$iPLACA_REMOLQUE="fa-sort-amount-desc";
			}
			else
			{
				$iPLACA_REMOLQUE="fa-sort";
			}
		}
		
		if($Orden=="FECHA_CRE" and $AscDesc=="ASC")
		{
			$iFECHA_CRE="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="FECHA_CRE" and $AscDesc=="DESC")
			{
				$iFECHA_CRE="fa-sort-amount-desc";
			}
			else
			{
				$iFECHA_CRE="fa-sort";
			}
		}
		
		if($Orden=="FECHA_ENTRADA" and $AscDesc=="ASC")
		{
			$iFECHA_ENTRADA="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="FECHA_ENTRADA" and $AscDesc=="DESC")
			{
				$iFECHA_ENTRADA="fa-sort-amount-desc";
			}
			else
			{
				$iFECHA_ENTRADA="fa-sort";
			}
		}
?>
        <table class="table table-bordered table-hover" role="grid" style="margin-top:20px;">
            <thead>
              <tr>
				  <th>
                  	<div id="thID_ORDEN_PESAJE" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Codigo <i class="fa  <?php echo $iID_ORDEN_PESAJE;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thCEDULA_CONDUCTOR" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Cedula <i class="fa  <?php echo $iCEDULA_CONDUCTOR;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thNOMBRE" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Nombre <i class="fa  <?php echo $iNOMBRE;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thPLACA_VEHICULO" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Chuto <i class="fa  <?php echo $iPLACA_VEHICULO;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thPLACA_REMOLQUE" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Remolque <i class="fa  <?php echo $iPLACA_REMOLQUE;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thFECHA_CRE" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Fecha Registro <i class="fa  <?php echo $iFECHA_CRE;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thFECHA_ENTRADA" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Fecha Carga <i class="fa  <?php echo $iFECHA_ENTRADA;?>"></i>
					</div>
                   </th>
				  <th>
                  	Estatus
                   </th>
                <!--<th width="20" title="Estatus">Estatus</th>-->
                   <th class="text-center" colspan="3">
					<button type="button" class="btn btn-success btn-xs" onClick="vModal('Sistema/OrdenCarga/Contenedor/FormNuevo.php?ID_BL=<?php echo $ID_BL;?>', 'Nueva Orden de Carga');" data-placement="top" data-toggle="tooltip" data-original-title="Nueva Orden de Carga" style=" cursor: pointer;">
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
			
			$ID_ORDEN_PESAJE=odbc_result($resultPrin,"ID_ORDEN_PESAJE");
			$CEDULA_CONDUCTOR=odbc_result($resultPrin,"CEDULA_CONDUCTOR");
			$NOMBRE=odbc_result($resultPrin,"NOMBRE");
			$PLACA_VEHICULO=odbc_result($resultPrin,"PLACA_VEHICULO");
			$PLACA_REMOLQUE=odbc_result($resultPrin,"PLACA_REMOLQUE");
			$FECHA_CRE=FechaHoraNormal(odbc_result($resultPrin,"FECHA_CRE"));
			$FECHA_ENTRADA=FechaHoraNormal(odbc_result($resultPrin,"FECHA_ENTRADA"));
			$DS_PRODUCTO=odbc_result($resultPrin,"DS_PRODUCTO");
			$FG_ESTADO=odbc_result($resultPrin,"FG_ESTADO");
			$FG_ANULADO=odbc_result($resultPrin,"FG_ANULADO");
			$FG_NOTIFICACION=odbc_result($resultPrin,"FG_NOTIFICACION");
			$NroTotal=odbc_result($resultPrin,'CantReg');
	
			$PagTotal = ceil($NroTotal/$NroReg);
			
			$bgNotificacion='';
			
			if($FG_ANULADO==0)
			{
				if($FG_ESTADO==1)
				{
					$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#FFFFFF; margin:auto;"></div>';
						
					$Notificacion='
							<button type="button" class="btn btn-warning btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Notificar esta Orden de Carga" style=" cursor: pointer;" disabled>
								<i class="fa fa-bell"></i>
							</button>';		
							
					$Eliminar='
						<button type="button" class="btn btn-danger btn-xs" onClick="AnularOrdenCarga('.$ID_ORDEN_PESAJE.')" data-placement="top" data-toggle="tooltip" data-original-title="Anular Orden de Carga" style=" cursor: pointer;">
							<i class="fa fa-trash"></i>
						</button>';
						
					$Imprimir='
						<button type="button" class="btn btn-primary btn-xs" onClick="ReporteOrdenCarga('.$ID_ORDEN_PESAJE.')" data-placement="top" data-toggle="tooltip" data-original-title="Imprimir Orden de Carga" style=" cursor: pointer;">
							<i class="fa fa-print"></i>
						</button>';	
				}
				else
				{					
					if($FG_ESTADO==2)
					{
						
						if($FG_NOTIFICACION==1)
						{
							$bgNotificacion=' style="background:#f39c12;" ';
							
							$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#E5DF32; margin:auto;"></div>';
						
							$Notificacion='
								<button type="button" class="btn btn-warning btn-xs" onClick="vModal2(\'Sistema/Notificaciones/VerNotificacion.php?ID_ORDEN_PESAJE='.$ID_ORDEN_PESAJE.'\', \'Ver Notificacion\');" data-placement="top" data-toggle="tooltip" data-original-title="Notificar esta Orden de Carga" style=" cursor: pointer;" disabled>
									<i class="fa fa-bell"></i>
								</button>';	
							
							$Imprimir='
								<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Imprimir Orden de Carga" style=" cursor: pointer;" disabled>
									<i class="fa fa-print"></i>
								</button>';	
							
							$Eliminar='
									<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular Orden de Carga" style=" cursor: pointer;" disabled>
										<i class="fa fa-trash"></i>
									</button>';
						}
						else
						{
							$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#E5DF32; margin:auto;"></div>';
						
							$Notificacion='
								<button type="button" class="btn btn-warning btn-xs" onClick="vModal2(\'Sistema/Notificaciones/FormNotificacion.php?ID_ORDEN_PESAJE='.$ID_ORDEN_PESAJE.'\', \'Notificacion\');" data-placement="top" data-toggle="tooltip" data-original-title="Notificar esta Orden de Carga" style=" cursor: pointer;">
									<i class="fa fa-bell"></i>
								</button>';	
							
							$Imprimir='
								<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Imprimir Orden de Carga" style=" cursor: pointer;" disabled>
									<i class="fa fa-print"></i>
								</button>';
							
							$Eliminar='
									<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular Orden de Carga" style=" cursor: pointer;" disabled>
										<i class="fa fa-trash"></i>
									</button>';
						}
					}
					else
					{
						$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#31A268; margin:auto;"></div>';
						
						$Notificacion='
								<button type="button" class="btn btn-warning btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Notificar esta Orden de Carga" style=" cursor: pointer;" disabled>
									<i class="fa fa-bell"></i>
								</button>';
						
						$Imprimir='
							<button type="button" class="btn btn-primary btn-xs" onClick="ReporteOrdenCarga('.$ID_ORDEN_PESAJE.')" data-placement="top" data-toggle="tooltip" data-original-title="Imprimir Orden de Carga" style=" cursor: pointer;">
								<i class="fa fa-print"></i>
							</button>';	
						
						$Eliminar='
								<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular Orden de Carga" style=" cursor: pointer;" disabled>
									<i class="fa fa-trash"></i>
								</button>';
				
					}
				}
			}
			else
			{
				$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#CD1F22; margin:auto;"></div>';
						
				$Notificacion='
						<button type="button" class="btn btn-warning btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Notificar esta Orden de Carga" style=" cursor: pointer;" disabled>
							<i class="fa fa-bell"></i>
						</button>';
				
				$Eliminar='
					<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Anular Orden de Carga" style=" cursor: pointer;" disabled>
						<i class="fa fa-trash"></i>
					</button>';
					
				$Imprimir='
					<button type="button" class="btn btn-primary btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Imprimir Orden de Carga" style=" cursor: pointer;" disabled>
						<i class="fa fa-print"></i>
					</button>';
			}
?>
            <tr <?php echo $bgNotificacion;?>>
                <td align="center"><?php echo $ID_ORDEN_PESAJE;?></td>
                <td><?php echo $CEDULA_CONDUCTOR;?></td>
                <td><?php echo $NOMBRE;?></td>
                <td><?php echo $PLACA_VEHICULO;?></td>
                <td><?php echo $PLACA_REMOLQUE;?></td>
                <td><?php echo $FECHA_CRE;?></td>
                <td><?php echo $FECHA_ENTRADA;?></td>
                <td align="center"><?php echo $Estatus;?></td>
                <td width="10">
                    <?php echo $Notificacion;?>
                </td>
                <td width="10">
                    <?php echo $Imprimir;?>
                </td>
                <td width="10">
                    <?php echo $Eliminar;?>
                </td>
            </tr>
<?php
		}
?>

        </tbody>
    </table>
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