 <?php 
		$Nivel="../../";
		include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
		
		session_start();
		
		$id_pre = $_GET['id_pre'];
		
		$sql = "select direccion,telef1 from TB_LOCALIDAD where ID_LOCALIDAD = (SELECT ID_LOCALIDAD FROM EMPRE_PRELIQUIDACION WHERE ID_PRELIQUIDACION = $id_pre)";
		$rs=$conector->Ejecutar($sql);
		$telefono = odbc_result($rs,"telef1");
		$direc = odbc_result($rs,"direccion"); 
?>
<html>
	<head>
		<?php echo includes($Nivel);?>
		<title>PRELIQUIDACI&Oacute;N</title>
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
            <td rowspan="6" ><p align="center"><img src="http://imageshack.com/a/img4/6326/5bjm.png" width="128" height="60" align="left" /> </td>
            <td width="550" class="estilo2"><b>BOLIVARIANA DE PUERTOS, BOLIPUERTOS S.A.</b></td>
          </tr>
          <tr>
            <td class="estilo2"><B>RIF: J297599070 </b></td>
          </tr>
          <tr>
            <td class="estilo2"><b>DIRECCION: <?php echo $direc;?></b></td>
          </tr>
          <tr>
            <td class="estilo2"><b>TELEFONO: <?php echo $telefono;?></b></td>
          </tr>
    </table>
<p>&nbsp;</p>
    <p>
      <?php
		
		$sql = "SELECT cast(f_preliq as date) as fecha_cre,RAZON_SOCIAL,rif,direcc_fiscal,id_preliquidacion FROM VIEW_RP_CABECERA_REP_PRE WHERE ID_PRELIQUIDACION = $id_pre";
		$rs=$conector->Ejecutar($sql);
		while (odbc_fetch_row($rs)){
			$fecha_cre=fecha_normal(odbc_result($rs,"fecha_cre"));
			$nomb_emp=odbc_result($rs,"RAZON_SOCIAL");
			$rif_emp=odbc_result($rs,"rif");
			$direccion_emp=odbc_result($rs,"direcc_fiscal");
			$id_pre = odbc_result($rs,"id_preliquidacion");
		}
?>
    </p>
        <table>
          <tr>
            <td class="estilo1"><div style="height:50px;"></div>
              <b>PRELIQUIDACI&Oacute;N:</b> <?php echo $id_pre;?>            
          </tr>
          <tr>
            <td><b>FEC. C&Aacute;LCULO:</b> <?php echo $fecha_cre;?></td>
          </tr>
          <tr>
            <td><b>RIF /PRELIQUIDADO A:</b> <?php echo $rif_emp." / ".$nomb_emp;?></td>
          </tr>
          <tr>
            <td><b>DIRECCI&Oacute;N FISCAL</b>: <?php echo $direccion_emp;?></td>
          </tr>
    </table>
    <br/>
    <br/>
        <table border='1' style='border-collapse:collapse; margin:auto;'>
          <tr>
            <th width="100" style="text-align:center" colspan='10'><b>DETALLE DE PRELIQUIDACI&Oacute;N</b></th>
          </tr>
          <tr>
            <th width="100" style="text-align:center"><b>C&Oacute;DIGO</b></th>
            <th width="320" style="text-align:left"><b>DESCRIPCI&Oacute;N</b></th>
            <th width="50"  style="text-align:left"><b>MONTO </b></th>
            <th width="55" style="text-align:center"><b>CANT. </b></th>
            <th width="70" style="text-align:left"><b>CAMBIO </b></th>
            <th width="80" style="text-align:right"><b>TOTAL </b></th>
          </tr>
          <?php

		
		$sql = "SELECT * FROM VIEW_RP_DET_PRELIQUIDACION WHERE id_preliquidacion=$id_pre";
		$rs=$conector->Ejecutar($sql);
		while (odbc_fetch_row($rs)){
			
			$codigo_regimen=odbc_result($rs,"cod_regimen");
			$categoria=odbc_result($rs,"NB_categoria");
			$monto=number_format(odbc_result($rs,"monto_DOLAR"),2,",",".");
			$valor=number_format(odbc_result($rs,"valor_cambio"),2,",",".");
			$monto_bs=number_format(odbc_result($rs,"MONTO_BS"),2,",",".");
			$cantidad = odbc_result($rs,"CANTIDAD");
?>
          <tr>
            <td width="100"><div align="center">
              <?php echo $codigo_regimen;?></td>
            <td width="520"><div align="left">
              <?php echo $categoria;?></td>
            <td width="50"><div align="center">
              <?php echo $monto;?></td>
            <td width="55" style="text-align:center"><?php echo $cantidad;?></td>
            <td width="70" align="center"><?php echo $valor;?></td>
            <td width="80"><div align="right">
              <?php echo $monto_bs;?></td>
          </tr>
          <?php
		}
?>
        </table>
    <br/>
    <br/>
      <table border='1' align="right" style='border-collapse:collapse'>
        <?php
		
		$sql = "SELECT base_imponible,isnull(monto_iva,0) as monto_iva ,valor_cambio,mto_preliq,monto_exento,MONTO_PRELIQ_BS FROM EMPRE_PRELIQUIDACION WHERE id_preliquidacion=$id_pre";
		$rs=$conector->Ejecutar($sql);
		
		$base_imponible=odbc_result($rs,"base_imponible");
		$monto_iva=odbc_result($rs,"monto_iva");
		$monto_exento=odbc_result($rs,"monto_exento") * odbc_result($rs,"valor_cambio");
		$monto_total=odbc_result($rs,"MONTO_PRELIQ_BS");
		$cambio = odbc_result($rs,"valor_cambio");
		$monto_bs = odbc_result($rs,"MONTO_PRELIQ_BS");
		$sub_total = odbc_result($rs,"base_imponible") + $monto_exento;
?>
        <tr>
          <th align="right"><strong>VALOR DEL CAMBIO</strong>:</th>
          <td align="right" width="80"><?php echo number_format($cambio,2,",",".");?></td>
        </tr>
    <th align="right"><strong>BASE IMPONIBLE(BS)</strong>:</th>
    <td align="right" width="80"><?php echo number_format($base_imponible,2,",",".");?></td>
  </tr>
    <th align="right"><strong>TOTAL EXENTO (BS)</strong>:</th>
    <td align="right" width="80"><?php echo number_format($monto_exento,2,",",".");?></td>
  </tr>
    <th align="right"><strong>IVA(12%)</strong>:</th>
    <td align="right" width="80"><?php echo number_format($monto_iva,2,",",".");?></td>
  </tr>
    <th align="right"><strong>SUBTOTAL</strong>:</th>
    <td align="right" width="80"><?php echo number_format($sub_total,2,",",".");?></td>
  </tr>
    <th align="right"><strong>TOTAL (BS) </strong>:</th>
    <td align="right" width="80"><?php echo number_format($monto_bs,2,",",".");?></td>
  </tr>
    </table>
      <p><br/>
        <br/>
        <br/>
      </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <table border='1' style='border-collapse:collapse; margin:auto; margin-top:50px;' align='center'> 
						<tr>
							<th colspan="8"><p align="center"><strong>DETALLE DE PAGO</strong></p></th>
						</tr>
						<tr>
							<th><strong>NUMERO PRE</strong></th>
							<th ><strong>BANCO</strong></th>
							<th ><strong>NUMERO CTA. BANC.</strong></th>
							<th ><strong>TIPO.MOV.</strong> </th>
							<th ><strong>REFERENCIA</strong> </th>
							<th ><strong>FECHA</strong> </th>
							<th ><strong>MONTO</strong> </th>
							<th ><strong>SALDO </strong></th>
						</tr>
<?php
  
	$sql = "SELECT * FROM VIEW_RP_DEP_PRE WHERE id_preliquidacion=$id_pre";
		$rs=$conector->Ejecutar($sql);
		while (odbc_fetch_row($rs)){
			
			$id_preliquidacion=odbc_result($rs,"id_preliquidacion");
			$NB_BANCO=odbc_result($rs,"NB_BANCO");
			$nro_cta_banc=odbc_result($rs,"nro_cta_banc");
			$siglas_msl=odbc_result($rs,"siglas_msl");
			$referencia=odbc_result($rs,"referencia");
			$f_aplic_pago=odbc_result($rs,"f_aplic_pago");
			$mto_usado=number_format(odbc_result($rs,"mto_usado"),2,",",".");
			$mto_saldo=number_format(odbc_result($rs,"MTO_SALDO"),2,",",".");
?>
						<tr>
							<td  class="estilo2"><?php $id_preliquidacion;?></td>
							<td  class="estilo2"><?php $NB_BANCO;?></td>
							<td  class="estilo2"><?php $nro_cta_banc;?></td>
							<td  class="estilo2"><?php $siglas_msl;?></td>
							<td  class="estilo2"><?php $referencia;?></td>
							<td  class="estilo2"><?php $f_aplic_pago;?></td>
							<td  class="estilo2" align="right"><?php $mto_usado;?></td>
							<td  class="estilo2" align="right"><?php $mto_saldo;?></td>
						</tr>
<?php
		}
?>
					</table>
					<br>
					<br>
					<br>
					
	<table border='1' style='border-collapse:collapse; margin:auto;' align='center'> 
						<tr>
							<th colspan="8" ><p align="center"><strong>DETALLE DE RETENCIONES</strong></p></th>
						</tr>
		  
						<tr>
							<th ><b>NRORAI RETENCION</b></th>
							<th ><b>TIPO</b></th>
							<th ><b>PORCENTAJE</b></th>
							<th ><b>BASE IMPONIBLE</b></th>
							<th ><b>MONTO RETENIDO</b></th>
							<th ><b>FECHA</b></th>
						</tr>
<?php
  
	$sql = "SELECT * FROM VIEW_RP_RETEN_PRELIQUI WHERE id_preliquidacion=$id_pre";
	/*echo $sql;
	exit;*/
		$rs=$conector->Ejecutar($sql);
		while (odbc_fetch_row($rs))
		{
			$ID_EMPR_DET_RET=odbc_result($rs,"ID_EMPR_DET_RET");
			$NB_TIPO_RETENC=odbc_result($rs,"NB_TIPO_RETENC");
			$PORC_RETENCION=odbc_result($rs,"PORC_RETENCION")."%";
			$BASE_IMPONIBLE=odbc_result($rs,"BASE_IMPONIBLE");
			$MONTO_RETEN=odbc_result($rs,"MONTO_RETEN");
			$FECHA_CREACION=odbc_result($rs,"FECHA_CREACION");
?>
			<tr>
							<td  class="estilo2"><?php echo $ID_EMPR_DET_RET;?></td>
							<td  class="estilo2"><?php echo $NB_TIPO_RETENC;?></td>
							<td  class="estilo2"><?php echo $PORC_RETENCION;?></td>
							<td  class="estilo2"  style='text-align:right;'><?php echo $BASE_IMPONIBLE;?></td>
							<td  class="estilo2"  style='text-align:right;'><?php echo $MONTO_RETEN;?></td>
							<td  class="estilo2"><?php echo $FECHA_CREACION;?></td>
	  </tr>
<?php
		}
		$conector->Cerrar();
?>
	</table>
					<br>
					<br>
    </div>
        
	</body>
</html>