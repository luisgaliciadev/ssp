<?php
	$Nivel="../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();	
	
	session_start();
	
	$puerto=$_GET['puerto'];
	
	$f_desde_n= $_GET['f_desde'];
	$f_hasta_n= $_GET['f_hasta'];
	
	$f_desde= fecha_sql($_GET['f_desde']);
	$f_hasta= fecha_sql($_GET['f_hasta']);
	
	$vSQL="select * from tb_localidad WHERE id_localidad=$puerto";
	$result=$conector->Ejecutar($vSQL);
	
	$NB_PUERTO=odbc_result($result,'nb_localidad'); 
	
	if($puerto==7)
	{
		$puerto='%';
		$DS_NB_PUERTO='DE TODOS LOS PUERTOS';
	}
	else
	{
		$DS_NB_PUERTO='DEL PUERTO DE '.$NB_PUERTO;
	}
?>
<html>
<head>
<?php echo includes($Nivel);?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>PRELIQUIDACIONES TRANSFERIDAS - SISTEMA DE REGISTRO DE OPERADORES PORTUARIOS</title>
    
	<link href="config/css/owner/style_tabla.css" rel="stylesheet" />

    <script>
        function recargar()
        {
            var puerto=document.getElementById('puerto').value;
            $.ajax({
				url: "REPORTE_ESTATUS_EMPRESAS_RP_COSULTA.php",			
				data: "puerto="+puerto,	
				type: "POST",
				beforeSend: function() 
				{			
					window.parent.$('#Loading').css('display','');
				},			
				success: function(result) 
				{
					window.parent.$('#Loading').css('display','none');
					$('#Resultados').html(result)
				}						
		});
        }
    </script>
    
	<style>
        .Estilo1 {font-weight: bold; color:#000000 }
		
		.tabla
		{
			font-size:12px;
			font-family:Arial, Helvetica, sans-serif;
		}
		
		th
		{
			background-color:#999;
		}
		
		.color
		{
			background-color:#E6E6E6;
		}
    </style>
</head>
<body onLoad="recargar()">
<script>
    function ImpDiv(Id)
    {
        var div=document.getElementById(Id);
        
        var VenImp=window.open(' ','popimpr');
        
        VenImp.document.open();
        //VenImp.document.write("holaaa");
        VenImp.document.write(div.innerHTML);
        VenImp.document.close();
        VenImp.print();
        VenImp.close();
    }
</script>
<input type="button" id="Imprimir" value="Imprimir" onclick="ImpDiv('imprimir');" class="button small btnSistema"/>
<div id="imprimir">
<table width="1046" border="0" align="center" cellpadding="0" cellspacing="0" class="tabla" style="margin:auto">
  <tr>
    <td colspan="4" align="center" scope="row">
    	<p><img src="../../imagen/header.png" width="885" height="52" /></p>
    </td>
  </tr>
    <td height="68" colspan="4" align="center" valign="bottom" scope="row"><strong>
      <h1>PRELIQUIDACIONES TRANSFERIDAS <?php echo $DS_NB_PUERTO;?></h1></strong></td>
  </tr>
  <tr>
    <td height="37" colspan="4" align="center" scope="row">
    <strong><h1>DESDE <?php echo $f_desde_n;?> HASTA  <?php echo $f_hasta_n;?></h1></strong></td>
  </tr>
</table>
<p>&nbsp;</p>

 <table border="1" align="center" style="border-collapse:collapse; margin:auto" class="tabla">
    <tr>
        <th align="center" valign="middle">Nro</th>
        <th align="center" valign="middle">RIF</th>
    <th align="center" valign="middle">Empresa</th>
        <th align="center" valign="middle">Monto</th>
        <th align="center" valign="middle">Tipo</th>
        <th align="center" valign="middle">Fecha Trasferencia</th>
    </tr>
<?php

	$pintar=0;
	
	$vSQL="SELECT * FROM VIEW_RP_PRELIQUIDACIONES_TRANSFERIDAS WHERE FECHA_TRANSFERENCIA>='$f_desde 00:00:00' AND FECHA_TRANSFERENCIA<='$f_hasta 23:59:59' ORDER BY FECHA_TRANSFERENCIA, ID_PRELIQUIDACION, ID_TP_PRELIQ ASC";
	
	$result=$conector->Ejecutar($vSQL);
	
	while(odbc_fetch_row($result))
	{
		$rif = odbc_result($result,"rif");
		$ID_EMPRESA = odbc_result($result,"ID_EMPRESA");
		$ID_PRELIQUIDACION = odbc_result($result,"ID_PRELIQUIDACION");
		$ID_TP_PRELIQ = odbc_result($result,"ID_TP_PRELIQ");
		$NB_EMPRESA = odbc_result($result,"RAZON_SOCIAL");
		$FECHA_TRANSFERENCIA = odbc_result($result,"FECHA_TRANSFERENCIA");
		$DESC_TIPO_PRELIQUIDA = odbc_result($result,"DESC_TIPO_PRELIQUIDA");
		$MONTO_PRELIQ_BS = odbc_result($result,"MONTO_PRELIQ_BS");
		
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="";
			$pintar=1;
		}
		
		$Arreglo[$ID_TP_PRELIQ]['Cantidad']+=1;
		$Arreglo[$ID_TP_PRELIQ]['MONTO_PRELIQ_BS']+=$MONTO_PRELIQ_BS;
		
		$MONTO_PRELIQ_BS = number_format($MONTO_PRELIQ_BS,2,',','.');
?>
        <tr <?php echo $clase;?>>
			<td height="22" align="center" valign="middle"><?php echo $ID_PRELIQUIDACION;?></td>
			<td align="center" valign="middle"><?php echo $rif;?></td>
			<td align="left" valign="middle"><?php echo utf8_encode($NB_EMPRESA);?></td>
			<td align="right" valign="middle"><?php echo $MONTO_PRELIQ_BS;?></td>
			<td align="center" valign="middle"><?php echo $DESC_TIPO_PRELIQUIDA;?></td>
			<td align="center" valign="middle"><?php echo $FECHA_TRANSFERENCIA;?></td>
		</tr>
<?php
	}
	
	/*echo "<PRE>";
	print_r($Arreglo);
	echo "</PRE>";*/
?>
</table>

<p>&nbsp;</p>
 <table border="1" align="center" style="border-collapse:collapse; margin:auto" class="tabla">
    <tr>
      <th colspan="6" align="center" valign="middle">Resumen de Preliquidaciones</th>
    </tr>
    <tr>
        <th width="352" align="center" valign="middle">Tipo Preliquidacion</th>
        <th width="130" align="center" valign="middle">Cantidad</th>
    	<th width="139" align="center" valign="middle">Monto</th>
   </tr>
<?php

	$pintar=0;
	
	$vSQL="SELECT *
			FROM            TB_TP_PRELIQ
			WHERE        (FG_ACTIVA = 1)
			ORDER BY DESC_TIPO_PRELIQUIDA";

	$result=$conector->Ejecutar($vSQL);
	
	while(odbc_fetch_row($result))
	{
		$ID_TP_PRELIQ = odbc_result($result,"ID_TP_PRELIQ");
		$DESC_TIPO_PRELIQUIDA = odbc_result($result,"DESC_TIPO_PRELIQUIDA");
		
		$Cantidad=$Arreglo[$ID_TP_PRELIQ]['Cantidad'];
		
		if(!$Cantidad)
			$Cantidad=0;
			
		$MONTO_PRELIQ_BS=$Arreglo[$ID_TP_PRELIQ]['MONTO_PRELIQ_BS'];
		
		if(!$MONTO_PRELIQ_BS)
			$MONTO_PRELIQ_BS=0;
	
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="";
			$pintar=1;
		}
		
		$MONTO_PRELIQ_BS = number_format($MONTO_PRELIQ_BS,2,',','.');
		
		echo'
				<tr '.$clase.'>
					<td align="left" valign="middle"><strong>'.$DESC_TIPO_PRELIQUIDA.'</strong></td>
					<td align="center" valign="middle">'.$Cantidad.'</td>
					<td align="right" valign="middle">'.$MONTO_PRELIQ_BS.'</td>
			   </tr>
		';
	}
	
	$conector->Cerrar();
?>
</table>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
</div>  
</body>
</html>