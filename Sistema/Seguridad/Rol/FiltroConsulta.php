<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	$PagActual=$_POST["PagActual"];		
	$txtBuscar=$_POST["txtBuscar"];
	$NroReg=$_POST["NroReg"];
	$Orden=$_POST["Orden"];
	$AscDesc=$_POST["AscDesc"];
	
	if(!$PagActual)
		$PagActual=1;
	
	if(!$Orden)
		$Orden="NB_ROL";
	
	if(!$AscDesc)
		$AscDesc="ASC";

	/*$vSQL="
			SELECT 
				count(NB_ROL) as CantReg 
			FROM 
				TB_ADMIN_USU_ROL WHERE FG_ACTIVO=1 and 
				NB_ROL like '%$txtBuscar%'";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];
	
	if($CONEXION=="SI")
	{
		$ERROR=$ResultadoEjecutar["ERROR"];
	
		if($ERROR=="NO")
		{
			$result=$ResultadoEjecutar["RESULTADO"];
			
			$reg=odbc_fetch_array($result);
																	
			$NroTotal=odbc_result($result,'CantReg');
		
			$PagTotal = ceil($NroTotal/$NroReg);
		}
		else
		{	
			echo $ResultadoEjecutar["MSJ_ERROR"];
			$Conector->Cerrar();
			exit;
		}
	}
	else
	{	
		echo $ResultadoEjecutar["MSJ_ERROR"];
		$Conector->Cerrar();
		exit;
	}
	
	$vSQL="
			select
				* 
			from 
				TB_ADMIN_USU_ROL
			where 
				FG_ACTIVO=1 and 
				NB_ROL like '%$txtBuscar%'			
			order by 
				$Orden $AscDesc
				OFFSET (($PagActual-1)*$NroReg) ROWS
				FETCH NEXT ($NroReg) ROWS ONLY;";*/
	
	$vSQL="EXEC SP_VIEW_TB_ADMIN_USU_ROL '$txtBuscar', $PagActual, $NroReg, '$Orden', '$AscDesc';";
				
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];
	
	if($CONEXION=="SI")
	{
		$ERROR=$ResultadoEjecutar["ERROR"];
	
		if($ERROR=="NO")
		{
			if($Orden=="NB_ROL" and $AscDesc=="ASC")
			{
				$iNB_ROL="fa-sort-amount-asc";
			}
			else
			{
				if($Orden=="NB_ROL" and $AscDesc=="DESC")
				{
					$iNB_ROL="fa-sort-amount-desc";
				}
				else
				{
					$iNB_ROL="fa-sort";
				}
			}
			
			if($Orden=="FH_REGISTRO" and $AscDesc=="ASC")
			{
				$iFH_REGISTRO="fa-sort-amount-asc";
			}
			else
			{
				if($Orden=="FH_REGISTRO" and $AscDesc=="DESC")
				{
					$iFH_REGISTRO="fa-sort-amount-desc";
				}
				else
				{
					$iFH_REGISTRO="fa-sort";
				}
			}
	?>
		<div class="box-body">
		  <table class="table table-bordered table-hover" role="grid">
			<thead>
				<tr>
				  <th>
					<div id="thNB_ROL" style="cursor:pointer;" onClick="Ordenar(this.id);">
						NOMBRE <i class="fa <?php echo $iNB_ROL;?>"></i>
					</div>
				  </th>
				
				  <th>
					<div id="thFH_REGISTRO" style="cursor:pointer;" onClick="Ordenar(this.id);">
						FECHA REGISTRO <i class="fa  <?php echo $iFH_REGISTRO;?>"></i>
					</div></th>
				  <th class="text-center">
					<button type="button" class="btn btn-success btn-xs" onClick="vModal('Sistema/Seguridad/Rol/FormNuevo.php', 'Nuevo Rol');" data-placement="top" data-toggle="tooltip" data-original-title="Nuevo">
						<i class="fa fa-plus"></i>
					</button>
				  </th>
				</tr>
			</thead>
			<tbody>
	<?php
			$result=$ResultadoEjecutar["RESULTADO"];		
			
			while($registro=odbc_fetch_array($result))
			{			
				$ID_ROL=$registro["ID_ROL"];
				$NB_ROL=utf8_encode(strtoupper(($registro["NB_ROL"])));				
				$FH_REGISTRO=FechaHoraNormal($registro["FH_REGISTRO"]);
				$NroTotal=$registro['CantReg'];
		
				$PagTotal = ceil($NroTotal/$NroReg);
	?>
			  <tr>
						<td>
							<?php echo $NB_ROL;?>
						</td>
						
						<td>
							<?php echo $FH_REGISTRO;?>
						</td>
						<td width="70" class="text-center">                 
							<button type="button" class="btn btn-info btn-xs" onClick="vModal('Sistema/Seguridad/Rol/FormModificar.php?ID_ROL=<?php echo $ID_ROL;?>', 'Modificar Rol');" data-placement="top" data-toggle="tooltip" data-original-title="Modificar">
								<i class="fa fa-edit"></i>
							</button>
							<button type="button" class="btn btn-danger btn-xs" onClick="Eliminar(<?php echo $ID_ROL;?>);" data-placement="top" data-toggle="tooltip" data-original-title="Eliminar">
								<i class="fa fa-trash"></i>
							</button>
						</td>
			  </tr>	
	<?php
			}
	?>
			</tbody>
		  </table>
		</div>
		<div class="box-footer with-border">
	<?php
			echo Paginador($PagTotal, $PagActual, 5);
	?>
		</div>
		<!-- /.box-footer-->
	<?php
		}
		else
		{	
			echo $ResultadoEjecutar["MSJ_ERROR"];	
			$Conector->Cerrar();
			exit;	
		}
	}
	else
	{	
		echo $ResultadoEjecutar["MSJ_ERROR"];
		$Conector->Cerrar();
		exit;		
	}	
	
	$Conector->Cerrar();
?>