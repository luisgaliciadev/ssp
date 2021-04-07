<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar3();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	$RIF=$_SESSION[$SiglasSistema."RIF"];
	
	date_default_timezone_set('America/Caracas');
	
	$ID_SOL_SM=$_POST['ID_SOL_SM']; 
	
	$PagActual=$_POST["PagActual"];		
	$txtBuscar=$_POST["txtBuscar"];
	$NroReg=$_POST["NroReg"];
	$Orden=$_POST["Orden"];
	$AscDesc=$_POST["AscDesc"];
	
	if(!$PagActual)
		$PagActual=1;
	
	if(!$Orden)
		$Orden="DS_EVENTO";
	
	if(!$AscDesc)
		$AscDesc="ASC";		
	
	$vSQL="SELECT * from VIEW_RELACION_EVENTOS_WEB where id_solic_muelle = $ID_SOL_SM and 
				DS_EVENTO like '%$txtBuscar%' ";

//echo "WHERE ID_SOL_SM=$ID_SOL_SM";


										
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		if($Orden=="ID_RELACION_EVENTO" and $AscDesc=="ASC")
		{
			$iID_RELACION_EVENTO="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="ID_RELACION_EVENTO" and $AscDesc=="DESC")
			{
				$iID_RELACION_EVENTO="fa-sort-amount-desc";
			}
			else
			{
				$iID_RELACION_EVENTO="fa-sort";
			}
		}
		
		if($Orden=="DS_EVENTO" and $AscDesc=="ASC")
		{
			$iDS_EVENTO="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="DS_EVENTO" and $AscDesc=="DESC")
			{
				$iDS_EVENTO="fa-sort-amount-desc";
			}
			else
			{
				$DS_EVENTO="fa-sort";
			}
		}
		
		if($Orden=="FECHA_EVENTO" and $AscDesc=="ASC")
		{
			$iFECHA_EVENTO="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="FECHA_EVENTO" and $AscDesc=="DESC")
			{
				$iFECHA_EVENTO="fa-sort-amount-desc";
			}
			else
			{
				$FECHA_EVENTO="fa-sort";
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
				$NOMBRE="fa-sort";
			}
		}
				
		
?>
        <table class="table table-bordered table-hover" role="grid" style="margin-top:20px;" id="tb_maq">
            <thead>
              <tr>
				  <th>
                  	<div id="thID_RELACION_EVENTO" style="cursor:pointer;" onClick="Ordenar(this.id);">
						ID <i class="fa  <?php echo $iID_RELACION_EVENTO;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thDS_EVENTO" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Evento <i class="fa  <?php echo $iDS_EVENTO;?>"></i>
					</div>
                   </th>
                   
                   <th>
                  	<div id="thFECHA_EVENTO" style="cursor:pointer;" onClick="Ordenar(this.id);">
						FECHA <i class="fa  <?php echo $iFECHA_EVENTO;?>"></i>
					</div>
                   </th>
				  
				   <th>
                  	<div id="thNOMBRE" style="cursor:pointer;" onClick="Ordenar(this.id);">
						OPERADOR <i class="fa  <?php echo $iNOMBRE;?>"></i>
					</div>
                   </th>
				 
                  	
                   </th>
				
                <!--<th width="20" title="Estatus">Estatus</th>-->
                   <th class="text-center" colspan="3">
					<button type="button" class="btn btn-success btn-xs" onClick="vModal('Sistema/Maquinarias/FormNuevo.php?ID_SOL_SM=<?php echo $ID_SOL_SM;?>', 'Registro de Maquinaria');" data-placement="top" data-toggle="tooltip" data-original-title="Registro de Maquinaria" style=" cursor: pointer;">
						<i class="fa fa-plus"></i>
					</button>
				  </th>
              </tr>
            </thead>
            <tbody>
<?php
		$i = 1;
		while (odbc_fetch_row($resultPrin))  
		{
			$Ite++;
			
			$ID_RELACION_EVENTO=odbc_result($resultPrin,"ID_RELACION_EVENTO");
			$ID_SOLIC_MUELLE=odbc_result($resultPrin,"ID_SOLIC_MUELLE");
			$DS_EVENTO=odbc_result($resultPrin,"DS_EVENTO");			
			$FECHA_EVENTO=odbc_result($resultPrin,"FECHA_EVENTO");
			$NOMBRE=odbc_result($resultPrin,"NOMBRE");
			$FG_FACTURADO=odbc_result($resultPrin,"FG_FACTURADO");
			
			
			
			//$NroTotal=odbc_result($resultPrin,'CantReg');
	
			//$PagTotal = ceil($NroTotal/$NroReg);
			
			$bgNotificacion='';
			
		//if($FG_ESTADO==TRUE)
				{
					$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#398439; margin:auto;"></div>';
						
	
							
					$Eliminar='
						<button type="button" class="btn btn-danger btn-xs" onClick="Anularempleado('.$ID_RELACION_EVENTO.')" data-placement="top" data-toggle="tooltip" data-original-title="Eliminar empleado" style=" cursor: pointer;">
							<i class="fa fa-trash"></i>
						</button>';
				
				}
				
				
			/*else
			{
				$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#CD1F22; margin:auto;"></div>';
						

				
				$Eliminar='
					<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Eliminar empleado" style=" cursor: pointer;" disabled>
						<i class="fa fa-trash"></i>
					</button>';
					

			}*/
?>
            <tr >
                <td align="center"><?php echo $i;?></td>
                <td><?php echo $DS_EVENTO;?></td>               
                <td><?php echo $FECHA_EVENTO;?></td>  
                <td><?php echo $NOMBRE;?></td>  
                <td width="10">
                    <?php echo $Eliminar;?>
                </td>
            </tr>
<?php
		$i++;}
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