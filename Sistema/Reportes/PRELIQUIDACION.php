 <?php 
	$Nivel="../../";
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	if(isset($_GET['id_pre']))
	{
		$id_pre = $_GET['id_pre'];
	}
	else
	{
		$id_pre = $_GET['NroPreliquidacion'];
		//$id_pre = 53326;
	}
	
	$sql = "select direccion,telef1 from TB_LOCALIDAD where ID_LOCALIDAD = (SELECT ID_LOCALIDAD FROM EMPRE_PRELIQUIDACION WHERE ID_PRELIQUIDACION = $id_pre)";
	
	if($rs=$conector->Ejecutar($sql))
	{
		$telefono = odbc_result($rs,"telef1");
		$direc = odbc_result($rs,"direccion"); 
	}
	else
	{
		echo "error";
	}
?>
<html>
	<head>
		<?php echo includes($Nivel);?>
		<title>PRELIQUIDACION</title>
		<style type="text/css">
			.estilo1 
			{
				font-size: 22px;
			}
			
			.estilo2 
			{
				font-weight: bold;
				font-size:12px;
			}
			
			.estilo3 {
				font-family: Arial, Helvetica, sans-serif; 
				font-size: 11px; 
				color: #660099;
			}
		</style>
	</head>
<body>
<div style="width:800px; margin:auto;">
        <br/>
        <br/>
        <br/>
        <br/>
        <table>
			<tr>
				<td rowspan="6" ><p align="center"><img src="<?php echo $Nivel;?>imagen/jodc.png" width="128" height="60" align="left" /> </td>
           	  <td width="550" class="estilo2"><b>BOLIVARIANA DE PUERTOS, BOLIPUERTOS S.A.</b></td>
            </tr>
            <tr>
           	  <td class="estilo2"><B>RIF: J297599070 </b></td>
            </tr>
            <tr>
           	  <td class="estilo2"><b>DIRECCION: <?php echo utf8_encode($direc);?></b></td>
            </tr>
            <tr>
           	  <td class="estilo2"><b>TELEFONO: <?php echo $telefono;?></b></td>
            </tr>
		</table>
    	<br/>
<?php            
            $sql = "SELECT cast(f_preliq as date) as fecha_cre,RAZON_SOCIAL,rif,direcc_fiscal,id_preliquidacion FROM VIEW_RP_CABECERA_REP_PRE WHERE ID_PRELIQUIDACION = $id_pre";
			
            $rs=$conector->Ejecutar($sql);
			
            while (odbc_fetch_row($rs))
			{
                $fecha_cre=fecha_normal(odbc_result($rs,"fecha_cre"));
                $nomb_emp=odbc_result($rs,"RAZON_SOCIAL");
                $rif_emp=odbc_result($rs,"rif");
                $direccion_emp=odbc_result($rs,"direcc_fiscal");
                $id_pre = odbc_result($rs,"id_preliquidacion");
                $ESTATUS = odbc_result($rs,"ESTATUS");
            }
			
			if($ESTATUS)
			{
				$ESTATUS="ACTIVA";
			}
			else
			{
				$ESTATUS="INACTIVA";
			}
?>
        <table width="793" style="border-collapse:collapse;" border="1">
            <tr>
            	<th width="165" align="left">PRELIQUIDACION:</th>  
              	<td width="612"><?php echo $id_pre;?></td>         
            </tr>
            <tr>
            	<th align="left">ESTATUS: </th> 
              	<td><?php echo $ESTATUS;?></td>
            </tr>
            <tr>
            	<th align="left">FEC. CALCULO: </th> 
              	<td><?php echo $fecha_cre;?></td>
            </tr>
            <tr>
            	<th align="left">RIF /PRELIQUIDADO A: </th> 
              	<td><?php echo $rif_emp." / ".$nomb_emp;?></td>
            </tr>
            <tr>
            	<th align="left">DIRECCION FISCAL: </th> 
              	<td><?php echo $direccion_emp;?></td>
            </tr>
        </table>
        <br/>
        <br/>
        <table border='1' style='border-collapse:collapse; margin:auto;'>
            <tr>
            	<th width="100" style="text-align:center" colspan='13'><b>DETALLE DE PRELIQUIDACION</b></th>
            </tr>
            <tr>
                <th width="100" style="text-align:center"><b>CODIGO</b></th>
                <th width="320" style="text-align:left"><b>DESCRIPCION</b></th>
                <th width="50"  style="text-align:left"><b>MONTO </b></th>
                <th width="55" style="text-align:center"><b>CANT. </b></th>
                <th width="70" style="text-align:left"><b>CAMBIO </b></th>
                <th width="80" style="text-align:right"><b>TOTAL </b></th>
            </tr>
<?php
    
            
            $sql = "SELECT * FROM VIEW_RP_DET_PRELIQUIDACION WHERE id_preliquidacion=$id_pre";
            $rs=$conector->Ejecutar($sql);
            while (odbc_fetch_row($rs))
            {
                
                $codigo_regimen=odbc_result($rs,"cod_regimen");
                $categoria=odbc_result($rs,"NB_categoria");
                $monto=number_format(odbc_result($rs,"monto_DOLAR"),2,",",".");
                $valor=number_format(odbc_result($rs,"valor_cambio"),2,",",".");
                $monto_bs=number_format(odbc_result($rs,"MONTO_BS"),2,",",".");
                $cantidad = odbc_result($rs,"CANTIDAD");
?>
            <tr>
                <td width="100"><div align="center"> <?php echo $codigo_regimen;?></td>
                <td width="520"><div align="left"><?php echo $categoria;?></td>
                <td width="50"><div align="center"><?php echo $monto;?></td>
                <td width="55" style="text-align:center"><?php echo $cantidad;?></td>
                <td width="70" align="center"><?php echo $valor;?></td>
                <td width="80"><div align="right"><?php echo $monto_bs;?></td>
            </tr>
<?php
            }
?>
		</table>
        <br/>
        <br/>
    <?php
            
            $sql = "SELECT base_imponible,isnull(monto_iva,0) as monto_iva ,valor_cambio,mto_preliq,monto_exento,MONTO_PRELIQ_BS FROM EMPRE_PRELIQUIDACION WHERE id_preliquidacion=$id_pre";
            $rs=$conector->Ejecutar($sql);
            
            $base_imponible=odbc_result($rs,"base_imponible");
            $monto_iva=odbc_result($rs,"monto_iva");
           $monto_exento=odbc_result($rs,"monto_exento");
		    //$monto_exento=odbc_result($rs,"monto_exento") * odbc_result($rs,"valor_cambio");
            $monto_total=odbc_result($rs,"MONTO_PRELIQ_BS");
            $cambio = odbc_result($rs,"valor_cambio");
            $monto_bs = odbc_result($rs,"MONTO_PRELIQ_BS");
            $sub_total = odbc_result($rs,"base_imponible") + $monto_exento;
    ?>
          <table border='1' align="right" style='border-collapse:collapse'>
            <tr>
                <th align="right"><strong>VALOR DEL CAMBIO</strong>:</th>
                <td align="right" width="80"><?php echo number_format($cambio,2,",",".");?></td>
            </tr>
            <tr>
                <th align="right"><strong>BASE IMPONIBLE(BS)</strong>:</th>
                <td align="right" width="80"><?php echo number_format($base_imponible,2,",",".");?></td>
            </tr>
            <tr>
                <th align="right"><strong>TOTAL EXENTO (BS)</strong>:</th>
                <td align="right" width="80"><?php echo number_format($monto_exento,2,",",".");?></td>
            </tr>
            <tr>
                <th align="right"><strong>IVA(12%)</strong>:</th>
                <td align="right" width="80"><?php echo number_format($monto_iva,2,",",".");?></td>
            </tr>
            <tr>
                <th align="right"><strong>SUBTOTAL</strong>:</th>
                <td align="right" width="80"><?php echo number_format($sub_total,2,",",".");?></td>
            </tr>
            <tr>
                <th align="right"><strong>TOTAL (BS) </strong>:</th>
                <td align="right" width="80"><?php echo number_format($monto_bs,2,",",".");?></td>
            </tr>
        </table>
		<br/>
		<br/>
		<br/>
        <br/>
        <br/>
        <br/>
<?php
      
        $sql = "SELECT * FROM VIEW_RP_DEP_PRE WHERE id_preliquidacion=$id_pre";
        
        if($rs=$conector->Ejecutar($sql))
        {
            $IteC=0;
            while (odbc_fetch_row($rs))
            {
                $IteC++;
                
                if($IteC==1)
                {
?>
                    <table border='1' style='border-collapse:collapse; margin:auto; margin-top:50px;' align='center'> 
                        <tr>
                            <th colspan="11"><p align="center"><strong>DETALLE DE PAGO</strong></p></th>
                        </tr>
                        <tr>
                            <th style="text-align:center"><strong>NUMERO PRE</strong></th>
                            <th style="text-align:center"><strong>BANCO</strong></th>
                            <th style="text-align:center"><strong>NUMERO CTA. BANC.</strong></th>
                            <th ><strong>TIPO.MOV.</strong> </th>
                            <th ><strong>REFERENCIA</strong> </th>
                            <th ><strong>FECHA</strong> </th>
                            <th ><strong>MONTO</strong> </th>
                            <th ><strong>SALDO </strong></th>
                            <th ><strong>ESTATUS </strong></th>
                        </tr>
<?php	
                }
                
                $id_preliquidacion=odbc_result($rs,"id_preliquidacion");
                $NB_BANCO=odbc_result($rs,"NB_BANCO");
                $nro_cta_banc=odbc_result($rs,"nro_cta_banc");
                $siglas_msl=odbc_result($rs,"siglas_msl");
                $referencia=odbc_result($rs,"referencia");
                $f_aplic_pago=odbc_result($rs,"f_aplic_pago");
                $mto_usado=number_format(odbc_result($rs,"mto_usado"),2,",",".");
                $mto_saldo=number_format(odbc_result($rs,"MTO_SALDO"),2,",",".");
                $ESTATUS=odbc_result($rs,"FG_ACTIVO");
                
                if($f_aplic_pago)
                    $f_aplic_pago=fecha_normal($f_aplic_pago);
			
				if($ESTATUS)
				{
					$ESTATUS="ACTIVA";
				}
				else
				{
					$ESTATUS="INACTIVA";
				}
                
?>
                        <tr>
                            <td style="text-align:center"><?php echo $id_preliquidacion;?></td>
                            <td style="text-align:center"><?php echo $NB_BANCO;?></td>
                            <td style="text-align:center"><?php echo $nro_cta_banc;?></td>
                            <td style="text-align:center"><?php echo $siglas_msl;?></td>
                            <td style="text-align:center"><?php echo $referencia;?></td>
                            <td style="text-align:center"><?php echo $f_aplic_pago;?></td>
                            <td align="right"><?php echo $mto_usado;?></td>
                            <td align="right"><?php echo $mto_saldo;?></td>
                            <td align="right"><?php echo $ESTATUS;?></td>
                        </tr>
<?php
            }
?>
          			</table>
<?php
            }
            else
            {
                echo $sql;
                
            }
?>
            <br>
            <br>
            <br>
                        
        
    <?php
        $sql = "SELECT * FROM VIEW_RP_RETEN_PRELIQUI WHERE id_preliquidacion=$id_pre";
        
        if($rs=$conector->Ejecutar($sql))
        {
            $IteC=0;
            while (odbc_fetch_row($rs))
            {
                $IteC++;
                
                if($IteC==1)
                {
?>
                    <table border='1' style='border-collapse:collapse; margin:auto;' align='center'> 
                        <tr>
                            <th colspan="8" ><p align="center"><strong>DETALLE DE RETENCIONES</strong></p></th>
                        </tr>
                        <tr>
                            <th ><b>NRO COMP RETENCION</b></th>
                            <th ><b>TIPO</b></th>
                            <th ><b>PORCENTAJE</b></th>
                            <th ><b>BASE IMPONIBLE</b></th>
                            <th ><b>MONTO RETENIDO</b></th>
                            <th ><b>FECHA</b></th>
                        </tr>
<?php	
                }
            
                $ID_EMPR_DET_RET=odbc_result($rs,"ID_EMPR_DET_RET");
                $NB_TIPO_RETENC=odbc_result($rs,"NB_TIPO_RETENC");
                $PORC_RETENCION=odbc_result($rs,"PORC_RETENCION")."%";
                $BASE_IMPONIBLE=odbc_result($rs,"BASE_IMPONIBLE");
                $MONTO_RETEN=odbc_result($rs,"MONTO_RETEN");
                $FECHA_CREACION=odbc_result($rs,"FECHA_CREACION");
                
                if($FECHA_CREACION)
                    $FECHA_CREACION=fecha_normal($FECHA_CREACION);
?>
                        <tr>
                          <td style="text-align:center" class="estilo2"><?php echo $ID_EMPR_DET_RET;?></td>
                          <td style="text-align:center" class="estilo2"><?php echo $NB_TIPO_RETENC;?></td>
                          <td style="text-align:center" class="estilo2"><?php echo $PORC_RETENCION;?></td>
                          <td  class="estilo2"  style='text-align:right;'><?php echo $BASE_IMPONIBLE;?></td>
                          <td  class="estilo2"  style='text-align:right;'><?php echo $MONTO_RETEN;?></td>
                          <td  style="text-align:center"class="estilo2"><?php echo $FECHA_CREACION;?></td>
                        </tr>
<?php
            }
?>
    				</table>
<?php
        }
        else
        {
            echo $sql;
            
        }
		
		$conector->Cerrar();
?>
        <br>
        <br>
    </div>
	</body>
</html>