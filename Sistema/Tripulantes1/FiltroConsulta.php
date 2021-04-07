<?php
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
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
		$Orden="NOMBRE";
	
	if(!$AscDesc)
		$AscDesc="ASC";		
	
	$vSQL="SELECT        ID_EMP_SOL, ID_SOL_SM, COD_TIPO_BENEF, RIF_BEN_EMP, ID_CATEGORIA, CI_EMPLEADO, NB_EMPLEADO, CARGO, FG_ACT_EMP, F_REG_EMP,NB_CATEGORIA
FROM            VIEW_EMPLEADO_CATEGORIA WHERE ID_SOL_SM=$ID_SOL_SM AND ID_TP_EMP_SM = 2";

//echo "WHERE ID_SOL_SM=$ID_SOL_SM";
										
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		if($Orden=="ID_EMP_SOL" and $AscDesc=="ASC")
		{
			$iID_ORDEN_EMP="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="ID_EMP_SOL" and $AscDesc=="DESC")
			{
				$iID_ORDEN_EMP="fa-sort-amount-desc";
			}
			else
			{
				$iID_ORDEN_EMP="fa-sort";
			}
		}
		
		if($Orden=="CI_EMPLEADO" and $AscDesc=="ASC")
		{
			$iCEDULA="fa-sort-amount-asc";
		}
		else
		{
			if($Orden=="CI_EMPLEADO" and $AscDesc=="DESC")
			{
				$iCEDULA="fa-sort-amount-desc";
			}
			else
			{
				$iCEDULA="fa-sort";
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
		
		
?>
        <table class="table table-bordered table-hover" role="grid" style="margin-top:20px;">
            <thead>
              <tr>
				  <th>
                  	<div id="thID_SOL_SM" style="cursor:pointer;" onClick="Ordenar(this.id);">
						ID <i class="fa  <?php echo $iID_ORDEN_EMP;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thCEDULA" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Cedula <i class="fa  <?php echo $iCEDULA;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thNOMBRE" style="cursor:pointer;" onClick="Ordenar(this.id);">
						Nombre <i class="fa  <?php echo $iNOMBRE;?>"></i>
					</div>
                   </th>
				  <th>
                  	<div id="thCARGO" style="cursor:pointer;">
						Cargo 
					</div>
                   </th>
				  <th>
                  	<div id="thEMPRESA" style="cursor:pointer;">
						Empresa 
					</div>
                   </th>
				  <th>
                  	<div id="thCATEGORIA" style="cursor:pointer;">
						Categoria
					</div>
                   </th>
				  <th>
                  	<div id="thFECHA_CARGA" style="cursor:pointer;">
						Fecha Registro
					</div>
                   </th>
				  <th>
                  	Estatus
                   </th>
                <!--<th width="20" title="Estatus">Estatus</th>-->
                   <th class="text-center" colspan="3">
					<button type="button" class="btn btn-success btn-xs" onClick="vModal('Sistema/Tripulantes/FormNuevo.php?ID_SOL_SM=<?php echo $ID_SOL_SM;?>', 'Nuevo Empleado');" data-placement="top" data-toggle="tooltip" data-original-title="Nuevo Empleado" style=" cursor: pointer;">
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
			
			$ID_EMP_SOL=odbc_result($resultPrin,"ID_EMP_SOL");
			$ID_SOL_SM=odbc_result($resultPrin,"ID_SOL_SM");
			$CARGO=odbc_result($resultPrin,"CARGO");
			$CEDULA=odbc_result($resultPrin,"CI_EMPLEADO");
			$NOMBRE=odbc_result($resultPrin,"NB_EMPLEADO");
			$EMPRESA=odbc_result($resultPrin,"RIF_BEN_EMP");
			$CATEGORIA=odbc_result($resultPrin,"NB_CATEGORIA");
			//$CARGO=FechaHoraNormal(odbc_result($resultPrin,"CARGO"));
			$FECHA_REGISTRO=FechaHoraNormal(odbc_result($resultPrin,"F_REG_EMP"));

			$FG_ESTADO=odbc_result($resultPrin,"FG_ACT_EMP");
			
			
			//$NroTotal=odbc_result($resultPrin,'CantReg');
	
			//$PagTotal = ceil($NroTotal/$NroReg);
			
			$bgNotificacion='';
			
		if($FG_ESTADO==TRUE)
				{
					$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#398439; margin:auto;"></div>';
						
	
							
					$Eliminar='
						<button type="button" class="btn btn-danger btn-xs" onClick="Anularempleado('.$ID_EMP_SOL.')" data-placement="top" data-toggle="tooltip" data-original-title="Eliminar empleado" style=" cursor: pointer;">
							<i class="fa fa-trash"></i>
						</button>';
				
				}
				
				
			else
			{
				$Estatus='<div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#CD1F22; margin:auto;"></div>';
						

				
				$Eliminar='
					<button type="button" class="btn btn-danger btn-xs" data-placement="top" data-toggle="tooltip" data-original-title="Eliminar empleado" style=" cursor: pointer;" disabled>
						<i class="fa fa-trash"></i>
					</button>';
					

			}
?>
            <tr <?php echo $bgNotificacion; ?>>
                <td align="center"><?php echo $i;?></td>
                <td><?php echo $CEDULA;?></td>
                <td><?php echo utf8_encode($NOMBRE);?></td>
                <td><?php echo $CARGO;?></td>
                <td><?php echo $EMPRESA;?></td>
                <td><?php echo utf8_encode($CATEGORIA);?></td>
                <td><?php echo $FECHA_REGISTRO;?></td>
                <td align="center"><?php echo $Estatus;?></td>
                <td width="10">
                    <?php echo $Notificacion;?>
                </td>

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