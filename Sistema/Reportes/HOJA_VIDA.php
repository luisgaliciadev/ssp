<?php
	$Nivel="../../";
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();

	$id_localidad = $_SESSION[$SiglasSistema."id_localidad"]; 
	$CI_USUARIO = $_SESSION[$SiglasSistema."CI_USUARIO"];
	$ID_USUARIO=$_SESSION[$SiglasSistema.'ID_USUARIO'];
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	
	if(isset($_GET["rif"]))
	{
		$AuxRIF=$_GET["rif"];
		
		$sql="SELECT * FROM VIEW_DATOS_EMPRESA WHERE RIF='$AuxRIF'";
		
		if($rs=$conector->Ejecutar($sql))
		{
			$id_empresa		=	odbc_result($rs,"ID_EMPRESA");	
			
			if(!$id_empresa)
			{
				echo "EL RIF NO SE ENCUENTRA REGISTRADO";
				$conector->Cerrar();
				exit;
			}
			
		}
		else
		{
			echo $sql;
		}
	}
	else
	{
		$id_empresa = $_GET["id_empresa"];	
		
		$sql="SELECT * FROM VIEW_DATOS_EMPRESA WHERE id_empresa=$id_empresa";
		
		if($rs=$conector->Ejecutar($sql))
		{
			$AuxRIF		=	odbc_result($rs,"RIF");	
		}
		else
		{
			echo $sql;
		}
	}
	
	if(isset($_GET["ANO_REGISTRO"]))
	{
		$ANO_REGISTRO=$_GET["ANO_REGISTRO"];
	}
	else
	{
		//KATY - BUSCAR EXPEDIENTE ABIERTO SOLO PARA MOSTRARLO EN LA PARTE DE VERIFICACION
		$sql="SELECT ANO_REGISTRO FROM EMPRE_EXPEDIENTE WHERE ID_EMPRESA=$id_empresa AND ESTATUS=1";
		
		if($rs=$conector->Ejecutar($sql))
		{
			$ANO_REGISTRO		=	odbc_result($rs,"ANO_REGISTRO");
		}
	}
	
	$sql="SELECT        
			dbo.TB_LOCALIDAD.NB_LOCALIDAD
		FROM            
			dbo.EMPRE_EXPEDIENTE INNER JOIN
			dbo.TB_LOCALIDAD ON dbo.EMPRE_EXPEDIENTE.ID_LOCALIDAD = dbo.TB_LOCALIDAD.ID_LOCALIDAD
		WHERE        
			dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO AND 
			EMPRE_EXPEDIENTE.ID_EMPRESA=$id_empresa";
		
	if($rs=$conector->Ejecutar($sql))
	{
		$PuertoConsignacion		=	odbc_result($rs,"NB_LOCALIDAD");	
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php echo includes($Nivel);?> 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link type="text/css" href="Sistema/Reportes/css/ui-lightness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />	
<!--<link href="css/owner/style_tabla.css" rel="stylesheet" />-->
<title>HOJA DE VIDA POR EMPRESA</title>
<script>
	$(document).ready(function(e) 
	{
		$( "#accordion" ).show();
		
		$( "#accordion" ).accordion(
		{
			heightStyle: "content",
			active: false,
			collapsible: true
		}); 
		
        window.parent.$("#Loading").css("display","none");
    });
	
	function ver_contrato(id)
	{
		var parametros = 'id='+id;
		
		$.ajax(
		{
			type: "get",
			url: "../Verificacion/Contratos/ver_contrato.php",
			data: parametros,
			cache: false,
			beforeSend: function() 
			{		
				window.parent.$("#Loading").css("display","");
			},
			success: function(html)
			{
				
				
				window.parent.$("#Loading").css("display","none");
				
				parent.AbrirVentana('verContrato2', 'Contrato Definitivo', 'Sistema/Verificacion/Contratos/ver_contrato_consulta.php', '', 600, 1050, 0, 1, 1, 1, 1);
				window.parent.$("#Loading").css("display","none");
			}
		});
	}
</script>
</head>
    
	<style>
		
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
		
		.fuenteP
		{
			font-size:12px;
		}
		
		.Estilo1 
		{
			font-size: 14px;
			color:#000000;
			font-family: Arial, Helvetica, sans-serif;	
			}
			
		.Estilo2
		{
			font-family: Arial, Helvetica, sans-serif;	
			font-weight: bold; 
			font-size: 14px;
		}
		
		#accordion
		{
			padding: 10px;
			font-size: 12px;
			 width:1100px; 
			 margin:auto;
		}
		
		table 
		{
			width: 1100px; 
			font-size: 14px; 
			letter-spacing: 0.08em;
			border-collapse: collapse; 
			margin:0 2% 0.4em 0; 
			border: 1px solid #cccccc; 
		}
		
		h3 {
			color:#333;
			font: 2 em sans-serif, "Times New Roman", Times, serif;
			letter-spacing: 1px;
			padding-left: 35px;
			margin: 18px 0 10px 0;
		}


</style>
<body>
<div align="center">
<div style="text-align:left; margin:auto" align="center">
<!--ENCABEZADO-->	
<table class="table" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:auto">
  <tr>
    <td colspan="8" align="center" scope="row"><p><img src="<?php echo $Nivel;?>imagen/header.png" width="885" height="52" />
	</p>
      <p class="Estilo2">BOLIVARIANA DE PUERTOS (BOLIPUERTOS), S.A</p>
      <p></p>
      <h3  class="Estilo2">HOJA DE VIDA</h3>
      <h3  class="Estilo2">PERIODO <?php echo $ANO_REGISTRO;?></h3>
      <p>&nbsp;</p>
    </TD>
  </tr>
<tr>
</tr>
</table>
<p><!--FIN ENCABEZADO-->
  
  
  <!--EMPRESA-->
  <!--DATOS EMPRESA-->
  
  <?php
$sql="SELECT * FROM VIEW_DATOS_EMPRESA WHERE ID_EMPRESA=$id_empresa";
if($rs=$conector->Ejecutar($sql))
{
	//odbc_fetch_row($rs);
	$rif		=	odbc_result($rs,"RIF");	
	$razon		=	odbc_result($rs,"RAZON_SOCIAL");
	$direccion	=	odbc_result($rs,"DIRECC_FISCAL");	
	$objeto		=	odbc_result($rs,"OBJETO_EMPRESA");
	$telef1		=	odbc_result($rs,"TELEF1");	
	$telef2		=	odbc_result($rs,"TELEF2");	
	$email1		=	odbc_result($rs,"E_MAIL1");	
	$email2		=	odbc_result($rs,"E_MAIL2");	
	$Clasificaion=	odbc_result($rs,"NB_CLASIF_EMPR");	
	$F_VENC_RIF=	odbc_result($rs,"F_VENC_RIF");	
	
	if($F_VENC_RIF)
		$F_VENC_RIF=fecha_normal($F_VENC_RIF);
		
	
	if($telef2<>'')
	{
		$tef=$telef1.' / '.$telef2;
	}
	else
	{
		$tef=$telef1;
	}
	
	if($email2<>'')
	{
		$email=$email1.' / '.$email2;
	}
	else
	{
		$email=$email1;
	}
}
else
{
	echo $sql;
}

$sql="SELECT * FROM VIEW_SUCURSAL_EMPRE WHERE ID_EMPRESA=$id_empresa";

if($rs=$conector->Ejecutar($sql))
{
	$estado		=	odbc_result($rs,"NB_ESTADO");	
	$sucursal	=	($estado.' - '.$sucursal);
}
else
{
	echo $sql;
}
?>
</p>
<!--ACORDION-->

<div id="accordion" style="display:;">
 <h3><strong>DATOS DE LA EMPRESA</strong></h3>
<div>

<table class="table" bordercolor="#CCCCCC" border="1" align="center" cellpadding="0" cellspacing="0" style="margin:auto; border-collapse:collapse; border: 1px solid #CCCCCC; width:1050px">
  <tr>
    <th width="155" align="left" >
      <label    >RAZON SOCIAL</label>:</th>
    <td width="1139" align="left">
      <label  ><?php echo $razon;?></label>
      
    </td>
    </tr>
  <tr>
    <th width="155" align="left">
      <label    >RIF:</label>
      </th>
    <td width="1139" align="left">
      <label  ><?php echo $rif;?></label>
      </td>
    </tr>
  <tr>
    <th width="155" align="left">
      <label   >FECHA VENCE RIF:</label>
      </th>
    <td width="1139" align="left">
      <label  ><?php echo $F_VENC_RIF;?></label></td>
    </tr>
  <tr>
    <th width="155" align="left"><label   >DIRECCI&Oacute;N:</label></th>
    <td width="1139" align="left"><label  ><?php echo $direccion;?></label></td>
    </tr>
  <tr>
    <th width="155" align="left"><label   >SUCURSALES:</label></th>
    <td width="1139" align="left"><label  ><?php echo $sucursal;?></label></td>
  </tr>
</table>
<!--FIN EMPRESA-->
<p>&nbsp;</p>
<table align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" border="1" style="margin:auto; border-collapse:collapse; border: 1px solid #CCCCCC; width:1050px;">
  <tr>
    <th colspan="2" align="center">DATOS GENERALES</th>
    </tr>
  <tr>
    <th width="227" align="left">
      <label>CLASIFICACION</label>
    </th>
    <td width="1071" align="left">
      <label><?php echo $Clasificaion;?></label>
    </td>
    </tr>
  <tr>
    <th width="227" align="left">
      <label>OBJETO DE LA EMPRESA</label>
    </th>
    <td width="1071" align="left">
      <label><?php echo $objeto;?></label>
    </td>
    </tr>
  <tr>
    <th width="227" align="left">
      <label>TEL&Eacute;FONO (S)</label>
    </th>
    <td width="1071" align="left">
      <label><?php echo $tef;?></label></td>
    </tr>
  <tr>
    <th width="227" align="left">
      <label>EMAIL (S)</label>
    </th>
    <td width="1071" align="left">
      <label><?php echo $email;?></label></td>
  </tr>
</table>
<br />
<br />
<table width="885" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="width:1050px; margin:auto;">
  <tr>
   <th colspan="8" align="center">REGISTRO MERCANTIL</th>
   </tr>
 <tr>
    	<th width="130">
        	<div align="left">
        	<label style="text-align:center">CIRCUSCRIPCI&Oacute;N</label>
            </div>
        </th>
       <th width="130">
        	<div align="center">
            <label style="text-align:center">FECHA</label>
            </div>
        </th>
        <th width="130">
        	<div align="center">
        	<label style="text-align:center">N&Uacute;MERO</label>
            </div>
        </th>
        <th width="130">
        	<div align="center">
        	<label style="text-align:center">TOMO</label>
            </div>
        </th>
        
        <th width="130">
        	<div align="center">
        	<label style="text-align:center">ACTA DE ASAMBLEA</label>
            </div>
        </th>
         <th width="130">
        	<div align="center">
        	<label style="text-align:center">FECHA ASAMBLEA</label>
            </div>
        </th>
         <th width="130">
        	<div align="center">
        	<label style="text-align:center">N&Uacute;MERO ASAMBLEA</label>
            </div>
        </th>
        <th width="130">
        	<div align="center">
        	<label style="text-align:center">TOMO ASAMBLEA</label>
            </div>
        </th>
</tr>

<?php
$sql="SELECT * FROM VIEW_REGMER_EMPRE WHERE ID_EMPRESA=$id_empresa";

if($rs=$conector->Ejecutar($sql))
{
while (odbc_fetch_row($rs))  
{ 
	$nro_reg		=	odbc_result($rs,"NRO_REG");	
	$tomo_reg		=	odbc_result($rs,"TOMO_REG");	
	
	if(($nro_reg<>0) &&($tomo_reg<>0))
	{
		
			$nro_reg_def	=$nro_reg;
			$tomo_reg_def	=$tomo_reg;
			$circu		=	odbc_result($rs,"CIRCUNSCRIP");	
			$nb_estado	=	odbc_result($rs,"NB_ESTADO");
			$f_reg_merc	=	odbc_result($rs,"F_REG_MERC"); 
			
			if($f_reg_merc)
				$f_reg_merc	=	fecha_normal($f_reg_merc); 
		
	}
	else
	{
			$acta_asam	=	odbc_result($rs,"ACTA_ASAMB");	
			$f_asamb	=	odbc_result($rs,"F_ASAMB"); 	
			$nro_asamb	=	odbc_result($rs,"NRO_ASAMB");	
			$tomo		=	odbc_result($rs,"TOMO_ASAMB");	
			
			if($f_asamb)
				$f_asamb	=	fecha_normal($f_asamb);
	}
}

}
else
{
	echo $sql;
}
?>


<tr style="background-color:#E9E9E9">
  	<td width="130">
        	<div align="left">
        	<label style="text-align:center"><?php echo $circu;?></label>
            </div>
        </td>
       <td width="130">
        	<div align="center">
            <label style="text-align:center"><?php echo $f_reg_merc;?></label>
            </div>
        </td>
        <td width="130">
        	<div align="center">
        	<label style="text-align:center"><?php echo $nro_reg_def;?></label>
            </div>
        </td>
         <td width="130">
        	<div align="center">
        	<label style="text-align:center"><?php echo $tomo_reg_def;?></label>
            </div>
        </td>
         <td width="130">
        	<div align="center">
        	<label style="text-align:center"><?php echo $acta_asam;?></label>
            </div>
        </td>
         <td width="130">
        	<div align="center">
        	<label style="text-align:center"><?php echo $f_asamb;?></label>
            </div>
        </td>
        <td width="130">
        	<div align="center">
        	<label style="text-align:center"><?php echo $nro_asamb;?></label>
            </div>
        </td>
        <td width="130">
        	<div align="center">
        	<label style="text-align:center"><?php echo $tomo;?></label>
            </div>
        </td>
        
</tr>
</table>  
<br />
<br />
<?php
$sql="SELECT COUNT(CI_REP_LEGAL) AS CONT_REPRE FROM VIEW_REPRE_EMP WHERE ID_EMPRESA=$id_empresa";
if($rs=$conector->Ejecutar($sql))
{
while (odbc_fetch_row($rs))  
{ 
	$cont_repre	= odbc_result($rs,"CONT_REPRE");
}
}
else
{
	echo $sql;
}

if($cont_repre>0)
{
?>
<br />
<br />
<!--REPRESENTANTES -->
<table width="885" border="1" align="center" cellpadding="0" cellspacing="0"  bordercolor="#CCCCCC" style="width:1050px; margin:auto;" >
  <tr>
    <th colspan="6" align="center">REPRESENTANTE LEGAL</th>
    </tr>
  <tr>
    	<th width="170">
        	<div align="center">
        	<label style="text-align:center">C.I. REPRESENTANTE</label>
            </div>
        </th>
       <th width="170">
        	<div align="center">
            <label style="text-align:center">NOMBRE REPRESENTANTE</label>
            </div>
        </th>
        <th width="170">
        	<div align="center">
            <label style="text-align:center">CARGO </label>
            </div>
        </th>
         <th width="170">
        	<div align="center">
            <label style="text-align:center">DIRECCI&Oacute;N</label>
            </div>
        </th>
         <th width="170">
        	<div align="center">
            <label style="text-align:center">EMAIL </label>
            </div>
        </th>
          <th width="170">
        	<div align="center">
            <label style="text-align:center">TEL&Eacute;FONO </label>
            </div>
        </th>
       
</tr>
<?php
$sql="SELECT * FROM VIEW_REPRE_EMP WHERE ID_EMPRESA=$id_empresa";
if($rs=$conector->Ejecutar($sql))
{
	$pintar=0;
while (odbc_fetch_row($rs))  
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	} 
	
	$ci_repre		=	odbc_result($rs,"CI_REP_LEGAL");	
	$nob_repre		=	odbc_result($rs,"NB_REPR_LEGAL");	
	$cargo_repre	=	odbc_result($rs,"NB_CARGO_REPRES");	
	$telf_repre		=	odbc_result($rs,"TELEF1");	
	$email_repre	=	odbc_result($rs,"EMAIL_REPRE");	
	$direccion_rep	=	odbc_result($rs,"DIRECCION");	
	?>
	<tr <?php echo $clase;?>>
  		<td width="170">
        	<div align="center">
        	<label style="text-align:center"><?php echo $ci_repre;?></label>
            </div>
        </td>
       <td width="170">
        	<div align="center">
            <label style="text-align:center"><?php echo $nob_repre;?></label>
            </div>
        </td>
        <td width="170">
        	<div align="center">
        	<label style="text-align:center"><?php echo $cargo_repre;?></label>
            </div>
        </td>
        
         <td width="170">
        	<div align="center">
        	<label style="text-align:center"><?php echo $direccion_rep;?></label>
            </div>
        </td>
         <td width="170">
        	<div align="center">
        	<label style="text-align:center"><?php echo $email_repre;?></label>
            </div>
        </td>
         <td width="170">
        	<div align="center">
        	<label style="text-align:center"><?php echo $telf_repre;?></label>
            </div>
        </td>
</tr>
<?php
}
}
else
{
	echo $sql;
}
?>
</table>
<?php
}

$sql="SELECT COUNT(ID_EMPRESA) AS CONT_EMP FROM VIEW_SOCIO_EMPRE WHERE ID_EMPRESA=$id_empresa";
if($rs=$conector->Ejecutar($sql))
{
while (odbc_fetch_row($rs))  
{	
	$cont_socio	=	odbc_result($rs,"CONT_EMP");	
	if($cont_socio>0)
	{
		?> 
		<br />
<br />
            <!--SOCIOS-->
        <table width="885" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC"  style="width:1050px; margin:auto;" >
            	<tr>
            	  <th colspan="3" align="center">SOCIOS</th>
           	  </tr>
            	<tr> 
                 <th width="170">
                    <div align="center">
                    <label style="text-align:center">RIF</label>
                    </div>
        		 </th>
                 <th width="170">
                    <div align="center">
                    <label style="text-align:center">NOMBRE SOCIO</label>
                    </div>
        		 </th>
                 <th width="170">
                    <div align="center">
                    <label style="text-align:center">TIPO CLASIF.</label>
                    </div>
        		 </th>
              	</tr>
                <?php
				$sql="SELECT * FROM VIEW_SOCIO_EMPRE WHERE ID_EMPRESA=$id_empresa";
				$pintar=0;
				if($rs2=$conector->Ejecutar($sql))
				{
				while (odbc_fetch_row($rs2))  
				{
					if($pintar)
					{
						$clase="class='color'";
						$pintar=0;
					}
					else
					{
						$clase="class='Normal'";
						$pintar=1;
					} 
					
					$rif			=	odbc_result($rs2,"RIF");	
					$nob_socio		=	odbc_result($rs2,"NOMBRE_SOCIO");	
					$clasif			=	odbc_result($rs2,"NB_CLASIF_EMPR");	
					
				?>
                <tr <?php echo $clase;?>>
                   <td width="170">
                            <div align="center">
                            <label style="text-align:center"><?php echo $rif;?></label>
                            </div>
                  </td>
                    <td width="170">
                            <div align="center">
                            <label style="text-align:center"><?php echo $nob_socio;?></label>
                            </div>
                    </td>
                    <td width="170">
                            <div align="center">
                            <label style="text-align:center"><?php echo $clasif;?></label>
                            </div>
                    </td>
                </tr>        
                    
                <?php
					
				}
				}
				else
				{
					echo $sql;
				}
				?>
        </table>
            <!--SOCIOS-->
		<?php
	 }
}
}
else
{
	echo $sql;
}

?>
</div>
<?php
if($ID_ROL!=30)
{
?>
 <h3><strong>EXPEDIENTE - PRELIQUIDACIONES</strong></h3>
<div>
 	<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="border-collapse:collapse; width:1000px;">
    	<tr> 
           <th width="70" align="center" valign="middle">
                    <label style="text-align:center">NRO. PRE</label>
        	</th>
           <th width="70" align="center" valign="middle">
                    <label style="text-align:center">TIPO PRELIQ</label>
        	</th>
            <th width="100" align="center" valign="middle">
                    <label style="text-align:center">F. RESGISTRO</label>
        	</th>
            <th width="100" align="center" valign="middle">
                    <label style="text-align:center">F. PRELIQUI</label>
        	</th>
            <th width="80" align="center" valign="middle">
                    <label style="text-align:center">BASE IMPO.</label>
        	</th>
            <th width="80" align="center" valign="middle">
                    <label style="text-align:center">MONTO EXEN.</label>
        	</th>
            <th width="80" align="center" valign="middle">
                    <label style="text-align:center">IVA %</label>
        	</th>
            <th width="80" align="center" valign="middle">
                    <label style="text-align:center">MTO. IVA</label>
        	</th>
            <th width="80" align="center" valign="middle">
                    <label style="text-align:center">TOTAL</label>
        	</th>
            <th width="170" align="center" valign="middle">
                    <label style="text-align:center">LOCALIDAD</label>
        	</th>
            <th width="50" align="center" valign="middle">
                    <label style="text-align:center">NRO. FACT.</label>
        	</th>
            <th width="50" align="center" valign="middle">
                    <label style="text-align:center">SALDO PRE.</label>
        	</th>
            <th width="50" align="center" valign="middle">
                    <label style="text-align:center">FACTURADA</label>
        	</th>
            <th width="50" align="center" valign="middle">
                    <label style="text-align:center">ESTATUS</label>
        	</th>
          </tr>
 
 <?php
				
	$sql="SELECT *
FROM            VIEW_PRELIQUIDACIONES_EMPRESAS
WHERE        ID_EMPRESA = $id_empresa and ANO_REGISTRO=$ANO_REGISTRO
";
			
	if($rs2=$conector->Ejecutar($sql))
	{
	$det = '';
	$pintar=0;
	while (odbc_fetch_row($rs2))  
	{
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="class='Normal'";
			$pintar=1;
		}
	
		$ID_PRELIQUIDACION	=	odbc_result($rs2,"ID_PRELIQUIDACION");
		$BASE_IMPONIBLE	  	=	number_format(odbc_result($rs2,"BASE_IMPONIBLE"),2,",",".");	
		$MONTO_EXENTO		=	number_format(odbc_result($rs2,"MONTO_EXENTO"),2,",",".");	
		$VALOR_IVA			=	number_format(odbc_result($rs2,"VALOR_IVA") * 100,2,",",".");	
		$MONTO_IVA		  	=	number_format(odbc_result($rs2,"MONTO_IVA"),2,",",".");	
		$MONTO_PRELIQ_BS	=	number_format(odbc_result($rs2,"MONTO_PRELIQ_BS"),2,",",".");	
		$NB_LOCALIDAD		=	odbc_result($rs2,"NB_LOCALIDAD");
		$NRO_FACTURA		=	odbc_result($rs2,"NRO_FACTURA");
		$SALDO		=	odbc_result($rs2,"SALDO");	
		$ESTATUS		=	odbc_result($rs2,"ESTATUS");	
		$FG_FACTURADO		=	odbc_result($rs2,"FG_FACTURADO");	
		$ID_TP_PRELIQ		=	odbc_result($rs2,"ID_TP_PRELIQ");	
		$DESC_TIPO_PRELIQUIDA		=	odbc_result($rs2,"DESC_TIPO_PRELIQUIDA");	
		$F_REGISTRO	=	(odbc_result($rs2,"F_REGISTRO"));
		$F_PRELIQ			=	(odbc_result($rs2,"F_PRELIQ"));	
		
		if($F_REGISTRO)
				$F_REGISTRO	=	fecha_normal($F_REGISTRO);
		
		if($F_PRELIQ)
				$F_PRELIQ	=	fecha_normal($F_PRELIQ);
		$FACTURADA="NO";
		
		if($FG_FACTURADO)
		{
			$FACTURADA="SI";
		}
		
		$CAD_ESTATUS="ANULADA";
		
		if($ESTATUS)
		{
			$CAD_ESTATUS="ACTIVA";
		}
		
		if($ID_TP_PRELIQ==2)
		{
			$NB_TIPO="EMPLEADOS";
			
			$sql="SELECT DISTINCT dbo.EMPRE_ACTA.NRO_ACTA, dbo.EMPRE_EMPLEADO.ID_PRELIQUIDACION
FROM            dbo.EMPRE_ACTA INNER JOIN
                         dbo.EMPRE_EMPLEADO ON dbo.EMPRE_ACTA.ID_EMPR_ACTA = dbo.EMPRE_EMPLEADO.ID_EMPR_ACTA
WHERE        (dbo.EMPRE_EMPLEADO.ID_PRELIQUIDACION = $ID_PRELIQUIDACION)";
			$rs222=$conector->Ejecutar($sql);
			
			$NRO_ACTA		=	odbc_result($rs222,"NRO_ACTA");	
		}
		else
		{
			if($ID_TP_PRELIQ==3 or $ID_TP_PRELIQ==4)
			{
				$NB_TIPO="VEHÍCULOS";
					
				$sql="SELECT        dbo.EMPRE_ACTA.NRO_ACTA, dbo.EMPRE_VEHICULO.ID_PRELIQUIDACION 
						FROM            dbo.EMPRE_ACTA INNER JOIN
                         dbo.EMPRE_VEHICULO ON dbo.EMPRE_ACTA.ID_EMPR_ACTA = dbo.EMPRE_VEHICULO.ID_EMPR_ACTA
						WHERE        (dbo.EMPRE_VEHICULO.ID_PRELIQUIDACION = $ID_PRELIQUIDACION)";
						
				$rs222=$conector->Ejecutar($sql);
				
				$NRO_ACTA		=	odbc_result($rs222,"NRO_ACTA");	
			}
		}
		
		//$Enlace="<a href='".$Nivel."Sistema/Reportes/PRELIQUIDACION.php?id_pre=$ID_PRELIQUIDACION' target='_blank'>$ID_PRELIQUIDACION</a>";	
		$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"Preliquidacion\", \"Preliquidacion\", \"Sistema/Reportes/PRELIQUIDACION.php\", \"id_pre=$ID_PRELIQUIDACION\", 600, 1000, 0, 1, 1, 1, 1);'>$ID_PRELIQUIDACION</a>";		
		
		$det .= "<tr $clase>
					<td align=\"left\">$Enlace</td>
					<td align=\"left\"> ".($DESC_TIPO_PRELIQUIDA)." </td>
					<td align=\"left\"> $F_REGISTRO </td>
					<td align=\"left\"> $F_PRELIQ </td>
					<td align=\"right\"> $BASE_IMPONIBLE </td>
					<td align=\"right\"> $MONTO_EXENTO </td>
					<td align=\"right\"> $VALOR_IVA </td>
					<td align=\"right\"> $MONTO_IVA </td>
					<td align=\"right\"> $MONTO_PRELIQ_BS </td>
					<td align=\"center\"> $NB_LOCALIDAD </td>
					<td align=\"right\"> $NRO_FACTURA </td>
					<td align=\"right\"> $SALDO </td>
					<td align=\"center\"> $FACTURADA </td>
					<td align=\"right\"> $CAD_ESTATUS</td>
				 </tr>";
	}
	}
	else
	{
		echo $sql;
	}
 	
	echo $det;
 ?>	
 	
    </table>
</div>


<h3><strong>DEPOSITOS APLICADOS A PRELIQUIDACIONES ACTIVAS</strong></h3>
<div>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="70" align="center" valign="middle">
           		<div align="center">
                    <label style="text-align:center">NRO. PRE</label>
              </div>
        	</th>
            <th width="250" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">BANCO</label>
              </div>
        	</th>
            <th width="120" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">Nº. CTA. BANC.</label>
              </div>
        	</th>
            <th width="80" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">TIPO.MOV.</label>
              </div>
        	</th>
            <th width="120" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">REFERENCIA</label>
              </div>
        	</th>
            <th width="80" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">FECHA</label>
              </div>
        	</th>
            <th width="120" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">MONTO</label>
              </div>
        	</th>
            <th width="120" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">SALDO</label>
              </div>
        	</th>            
          </tr>
     <?php 
     $sql = "SELECT id_preliquidacion,NB_BANCO,nro_cta_banc,siglas_msl,referencia,f_aplic_pago,mto_usado,MTO_SALDO FROM VIEW_RP_DEP_PRE WHERE id_empresa=$id_empresa";
		 
		if($rs=$conector->Ejecutar($sql))
		{
			$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$id_preliquidacion	=odbc_result($rs,"id_preliquidacion");
			$NB_BANCO			=odbc_result($rs,"NB_BANCO");
			$nro_cta_banc		=odbc_result($rs,"nro_cta_banc");
			$siglas_msl			=odbc_result($rs,"siglas_msl");
			$referencia			=odbc_result($rs,"referencia");
			$f_aplic_pago		=(odbc_result($rs,"f_aplic_pago"));
			$mto_usado			=number_format(odbc_result($rs,"mto_usado"),2,",",".");
			$mto_saldo			=number_format(odbc_result($rs,"MTO_SALDO"),2,",",".");
			
			if($f_aplic_pago)
				$f_aplic_pago=fecha_normal($f_aplic_pago);
			
			$res.=" <tr $clase>
				<td align=\"right\"  >$id_preliquidacion</td>
				<td align=\"center\">$NB_BANCO</td>
				<td align=\"center\">$nro_cta_banc</td>
				<td align=\"center\">$siglas_msl</div></td>
				<td align=\"center\">$referencia</td>
				<td align=\"center\">$f_aplic_pago</td>
				<td align=\"right\">$mto_usado</td>
				<td align=\"right\">$mto_saldo</td>
			  </tr>";
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
</div>

<h3><strong>MOVIMIENTOS BANCARIOS</strong></h3>
<div>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="70" align="center" valign="middle">
           		<div align="center">
                    <label style="text-align:center">NRO. REF</label>
              </div>
        	</th>
            <th width="250" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">DESCRIPCION</label>
              </div>
        	</th>
            <th width="120" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">FECHA</label>
              </div>
        	</th>
            <th width="80" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">MONTO</label>
              </div>
        	</th>
            <th width="120" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">USADO</label>
              </div>
        	</th>
            <th width="80" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">MONTO USADO</label>
              </div>
        	</th>
            <th width="120" align="center" valign="middle">
              <div align="center">
                    <label style="text-align:center">SALDO</label>
              </div>
        	</th> 
                    
          </tr>
     <?php 
     	$sql = "SELECT distinct 
				REFERENCIA_MOV
				,DESC_MOV
				,FECHA_MOV
				,MTO_MOV
				,FG_USADO
				,SALDO
				,MTO_USADO
			FROM DETALLE_MOVIMIENTO_BANCARIOS
			WHERE rif_cliente like '$AuxRIF'";
			
		if($rs=$conector->Ejecutar($sql))
		{
			$res = "";
			$pintar=0;
			while (odbc_fetch_row($rs))
			{
				if($pintar)
				{
					$clase="class='color'";
					$pintar=0;
				}
				else
				{
					$clase="class='Normal'";
					$pintar=1;
				}
			
				$REFERENCIA_MOV	=odbc_result($rs,"REFERENCIA_MOV");
				$DESC_MOV		=odbc_result($rs,"DESC_MOV");
				$FECHA_MOV		=(odbc_result($rs,"FECHA_MOV"));
				$MTO_MOV		=number_format(odbc_result($rs,"MTO_MOV"),2,",",".");
				$FG_USADO		=odbc_result($rs,"FG_USADO");
				$MTO_USADO		=number_format(odbc_result($rs,"MTO_USADO"),2,",",".");
				$SALDO			=number_format(odbc_result($rs,"SALDO"),2,",",".");
				
				if($FECHA_MOV)
					$FECHA_MOV=fecha_normal($FECHA_MOV);
				
				if($FG_USADO)
				{
					$USADO="SI";
				}
				else
				{
					$USADO="NO";
				}
				
				$res.=" 
						<tr $clase>
							<td align=\"right\"  >$REFERENCIA_MOV</td>
							<td align=\"center\">$DESC_MOV</td>
							<td align=\"center\">$FECHA_MOV</td>
							<td align=\"center\">$MTO_MOV</div></td>
							<td align=\"center\">$USADO</td>
							<td align=\"center\">$SALDO</td>
							<td align=\"right\">$MTO_USADO</td>
						</tr>";
			}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
</div>

<h3><strong>ACTAS DE DOCUMENTOS</strong></h3>
<div>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align="right">
           		<div align="center">
                    <label style="text-align:center">NRO.</label>
              </div>
        	</th>
            <th width="226" align="center">
              <div align="center">
                    <label style="text-align:center">LOCALIDAD</label>
              </div>
        	</th>
            <th width="114" align="right">
              <div align="center">
                    <label style="text-align:center">F. REGISTRO.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. ANULACION.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">F. RECEP.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. RECEP.</label>
              </div>
        	</th>   
            <th width="74" align="right">
              <div align="center">
                    <label style="text-align:center">F. ASIG.</label>
              </div>
        	</th>
            <th width="108" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. ASIG.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. CONFORME</label>
              </div>
        	</th>     
            <th width="141" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. COMFORME.</label>
              </div>
        	</th>    
            <th width="94" align="right">
              <div align="center">
                    <label style="text-align:center">ESTATUS</label>
              </div>
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 1 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$F_ANULACION		=odbc_result($rs,"F_ANULACION");
			$F_RECEP			=(odbc_result($rs,"F_RECEP"));
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$F_ASIG				=(odbc_result($rs,"F_ASIG"));
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$F_APROB			=(odbc_result($rs,"F_APROB"));
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			if($F_RECEP)
				$F_RECEP=fecha_normal($F_RECEP);
			
			if($F_ASIG)
				$F_ASIG=fecha_normal($F_ASIG);
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='ACTA_DOCUMENTO.php?id_empr_acta=".odbc_result($rs,"id_empr_acta")."&id_empresa=$id_empresa'/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"ActaDeDocumentos\", \"Acta de Documentos\", \"Sistema/Reportes/ACTA_DOCUMENTO.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";	
			
			$res.=" <tr $clase>
				<td align=\"right\"  >$Enlace</td>
				<td align=\"center\">$NB_LOCALIDAD</td>
				<td align=\"center\">$F_REGISTRO</td>
				<td align=\"center\">$F_ANULACION</td>
				<td align=\"center\">$F_RECEP</td>
				<td align=\"center\">$NB_ABG_RECEP</td>
				<td align=\"center\">$F_ASIG</div></td>
				<td align=\"center\">$NB_ABG_ASIG</td>
				<td align=\"center\">$F_APROB</td>
				<td align=\"center\">$NB_ABG_APROB</td>
				<td align=\"center\">$ESTATUS</td>
			  </tr>";
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
</div>
<h3><strong>ACTAS DE GARANTIAS</strong></h3>
<div>

<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align="right">
           		<div align="center">
                    <label style="text-align:center">NRO.</label>
              </div>
        	</th>
            <th width="226" align="center">
              <div align="center">
                    <label style="text-align:center">LOCALIDAD</label>
              </div>
        	</th>
            <th width="114" align="right">
              <div align="center">
                    <label style="text-align:center">F. REGISTRO.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. ANULACION.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">F. RECEP.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. RECEP.</label>
              </div>
        	</th>   
            <th width="74" align="right">
              <div align="center">
                    <label style="text-align:center">F. ASIG.</label>
              </div>
        	</th>
            <th width="108" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. ASIG.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. CONFORME</label>
              </div>
        	</th>     
            <th width="141" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. COMFORME.</label>
              </div>
        	</th>    
            <th width="94" align="right">
              <div align="center">
                    <label style="text-align:center">ESTATUS</label>
              </div>
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 2 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$F_ANULACION		=odbc_result($rs,"F_ANULACION");
			$F_RECEP			=(odbc_result($rs,"F_RECEP"));
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$F_ASIG				=(odbc_result($rs,"F_ASIG"));
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$F_APROB			=(odbc_result($rs,"F_APROB"));
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if($F_RECEP)
				$F_RECEP=fecha_normal($F_RECEP);
			
			if($F_ASIG)
				$F_ASIG=fecha_normal($F_ASIG);
				
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			$ESTATUS="";
				
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='DETALLE_GARANTIA.php?id_empr_acta=".odbc_result($rs,"ID_EMPR_ACTA")."&id_empresa=$id_empresa '/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"ActaDeGarantias\", \"Acta de Garantias\", \"Sistema/Reportes/ACTA_GARANTIA.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
			$res.=" <tr $clase>
				<td align=\"center\"  >$Enlace</td>
				<td align=\"center\">$NB_LOCALIDAD</td>
				<td align=\"center\">$F_REGISTRO</td>
				<td align=\"center\">$F_ANULACION</td>
				<td align=\"center\">$F_RECEP</td>
				<td align=\"center\">$NB_ABG_RECEP</td>
				<td align=\"center\">$F_ASIG</div></td>
				<td align=\"center\">$NB_ABG_ASIG</td>
				<td align=\"center\">$F_APROB</td>
				<td align=\"center\">$NB_ABG_APROB</td>
				<td align=\"center\">$ESTATUS</td>
			  </tr>";
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
</div>
<?php
}
?>
<h3><strong>SOLICITUDES DE EMPLEADOS</strong></h3>
<div>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align="right">
           		<div align="center">
                    <label style="text-align:center">NRO.</label>
              </div>
        	</th>
            <th width="226" align="center">
              <div align="center">
                    <label style="text-align:center">LOCALIDAD</label>
              </div>
        	</th>
            <th width="114" align="right">
              <div align="center">
                    <label style="text-align:center">F. REGISTRO.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. ANULACION.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">F. RECEP.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. RECEP.</label>
              </div>
        	</th>   
            <th width="74" align="right">
              <div align="center">
                    <label style="text-align:center">F. ASIG.</label>
              </div>
        	</th>
            <th width="108" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. ASIG.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. CONFORME</label>
              </div>
        	</th>     
            <th width="141" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. COMFORME.</label>
              </div>
        	</th>    
            <th width="94" align="right">
              <div align="center">
                    <label style="text-align:center">ESTATUS</label>
              </div>
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 3 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if(odbc_result($rs,"F_ANULACION"))
			{
				$F_ANULACION			=fecha_normal(odbc_result($rs,"F_ANULACION"));
			}
			else
			{
				$F_ANULACION="";
			}
			
			if(odbc_result($rs,"F_RECEP"))
			{
				$F_RECEP			=fecha_normal(odbc_result($rs,"F_RECEP"));
			}
			else
			{
				$F_RECEP="";
			}
			
			if(odbc_result($rs,"F_ASIG"))
			{
				$F_ASIG			=fecha_normal(odbc_result($rs,"F_ASIG"));
			}
			else
			{
				$F_ASIG="";
			}
			
			if(odbc_result($rs,"F_APROB"))
			{
				$F_APROB			=fecha_normal(odbc_result($rs,"F_APROB"));
			}
			else
			{
				$F_APROB="";
			}
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='DETALLE_EMPLEADO.php?id_empr_acta=".odbc_result($rs,"id_empr_acta")."&id_empresa=$id_empresa'/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"SolicituddeEmpleados\", \"Solicitud de Empleados\", \"Sistema/Reportes/ACTA_EMPLEADO.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
			$res.=" <tr $clase>
				<td align=\"right\"  >$Enlace</td>
				<td align=\"center\">$NB_LOCALIDAD</td>
				<td align=\"center\">$F_REGISTRO</td>
				<td align=\"center\">$F_ANULACION</td>
				<td align=\"center\">$F_RECEP</td>
				<td align=\"center\">$NB_ABG_RECEP</td>
				<td align=\"center\">$F_ASIG</div></td>
				<td align=\"center\">$NB_ABG_ASIG</td>
				<td align=\"center\">$F_APROB</td>
				<td align=\"center\">$NB_ABG_APROB</td>
				<td align=\"center\">$ESTATUS</td>
			  </tr>";
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    </table> 
    <br />
    <br />
    <table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
        <thead>
            <tr>
                <th>NRO. ACTA</th>
                <th>CEDULA</th>
                <th>NOMBRE</th>
                <th>CARGO</th>
                <th>PRELIQUIDACION</th>
                <th>ACTIVO</th>
                <th>ESTATUS</th>
            </tr>
        </thead>
<?php	

$sql="SELECT     dbo.EMPRE_EXPEDIENTE.ID_EMPEXP, dbo.EMPRE_EMPLE_GRAL.CI_EMPLEADO, dbo.EMPRE_EMPLE_GRAL.NB_EMPLEADO, 
                         dbo.EMPRE_EMPLEADO.ID_LOCALIDAD, dbo.EMPRE_EMPLEADO.ID_EMPRESA, dbo.TB_CARGO_EMPLEADO.NB_CARGO, dbo.EMPRE_ACTA.NRO_ACTA, 
                         dbo.EMPRE_ACTA.F_ANULACION, dbo.EMPRE_ACTA.ID_EMPR_ACTA, dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_EMPLEADO.ID_PRELIQUIDACION, 
                         dbo.EMPRE_EMPLEADO.FG_CONFORME, dbo.EMPRE_EMPLEADO.FG_ACTIVO AS FG_ACTIVOE, dbo.TB_PERIODO.FG_ACTIVO
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_CARGO_EMPLEADO INNER JOIN
                         dbo.EMPRE_EMPLEADO INNER JOIN
                         dbo.EMPRE_EMPLE_GRAL ON dbo.EMPRE_EMPLEADO.CI_EMPLEADO = dbo.EMPRE_EMPLE_GRAL.CI_EMPLEADO INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_EMPLEADO.ID_EMPR_ACTA = dbo.EMPRE_ACTA.ID_EMPR_ACTA ON 
                         dbo.TB_CARGO_EMPLEADO.ID_CARGO_EMPLE = dbo.EMPRE_EMPLEADO.CARGO ON 
                         dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_ACTA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO
WHERE        (dbo.EMPRE_EMPLEADO.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_ACTA.ID_TACTA = 3) AND (dbo.TB_PERIODO.FG_ACTIVO = 1)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

$sql="SELECT      dbo.EMPRE_EXPEDIENTE.ID_EMPEXP, dbo.EMPRE_EMPLE_GRAL.CI_EMPLEADO, dbo.EMPRE_EMPLE_GRAL.NB_EMPLEADO, 
                         dbo.EMPRE_EMPLEADO.ID_LOCALIDAD, dbo.EMPRE_EMPLEADO.ID_EMPRESA, dbo.TB_CARGO_EMPLEADO.NB_CARGO, dbo.EMPRE_ACTA.NRO_ACTA, 
                         dbo.EMPRE_ACTA.F_ANULACION, dbo.EMPRE_ACTA.ID_EMPR_ACTA, dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_EMPLEADO.ID_PRELIQUIDACION, 
                         dbo.EMPRE_EMPLEADO.FG_CONFORME, dbo.EMPRE_EMPLEADO.FG_ACTIVO AS FG_ACTIVOE, dbo.TB_PERIODO.FG_ACTIVO, 
                         dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_CARGO_EMPLEADO INNER JOIN
                         dbo.EMPRE_EMPLEADO INNER JOIN
                         dbo.EMPRE_EMPLE_GRAL ON dbo.EMPRE_EMPLEADO.CI_EMPLEADO = dbo.EMPRE_EMPLE_GRAL.CI_EMPLEADO INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_EMPLEADO.ID_EMPR_ACTA = dbo.EMPRE_ACTA.ID_EMPR_ACTA ON 
                         dbo.TB_CARGO_EMPLEADO.ID_CARGO_EMPLE = dbo.EMPRE_EMPLEADO.CARGO ON 
                         dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_ACTA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO
WHERE        (dbo.EMPRE_EMPLEADO.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_ACTA.ID_TACTA = 3) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$NRO_ACTA=odbc_result($cn2,'NRO_ACTA');
	$ci_empleado=odbc_result($cn2,'ci_empleado');
	$nb_empleado=odbc_result($cn2,'nb_empleado');
	$nb_cargo=odbc_result($cn2,'nb_cargo');
	$id_preliquidacion = odbc_result($cn2,'id_preliquidacion');
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVOE');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORME');
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
            <td ><?php echo $NRO_ACTA;?></td>
            <td ><?php echo $ci_empleado;?></td>
            <td ><?php echo $nb_empleado;?></td>
            <td ><?php echo $nb_cargo;?></td>
            <td ><?php echo $id_preliquidacion;?></td>
            <td ><?php echo $ACTIVO;?></td>
            <td ><?php echo $CONFORME;?></td>
        </tr>
<?php	
}
?>
	</table>
    <br>
    <br>
    <!--<a href="DETALLE_EMPLEADO_SA.php?id_empresa=<?php echo $id_empresa;?>" target="_blank">LISTADO DE EMPLEADOS SIN SOLICITUDES</a>-->
</div>

<h3><strong>SOLICITUDES DE VEHICULOS</strong></h3>
<div>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align="right">
           		<div align="center">
                    <label style="text-align:center">NRO.</label>
              </div>
        	</th>
            <th width="226" align="center">
              <div align="center">
                    <label style="text-align:center">LOCALIDAD</label>
              </div>
        	</th>
            <th width="114" align="right">
              <div align="center">
                    <label style="text-align:center">F. REGISTRO.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. ANULACION.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">F. RECEP.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. RECEP.</label>
              </div>
        	</th>   
            <th width="74" align="right">
              <div align="center">
                    <label style="text-align:center">F. ASIG.</label>
              </div>
        	</th>
            <th width="108" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. ASIG.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. CONFORME</label>
              </div>
        	</th>     
            <th width="141" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. COMFORME.</label>
              </div>
        	</th>    
            <th width="94" align="right">
              <div align="center">
                    <label style="text-align:center">ESTATUS</label>
              </div>
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 4 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if(odbc_result($rs,"F_ANULACION"))
			{
				$F_ANULACION			=fecha_normal(odbc_result($rs,"F_ANULACION"));
			}
			else
			{
				$F_ANULACION="";
			}
			
			if(odbc_result($rs,"F_RECEP"))
			{
				$F_RECEP			=fecha_normal(odbc_result($rs,"F_RECEP"));
			}
			else
			{
				$F_RECEP="";
			}
			
			if(odbc_result($rs,"F_ASIG"))
			{
				$F_ASIG			=fecha_normal(odbc_result($rs,"F_ASIG"));
			}
			else
			{
				$F_ASIG="";
			}
			
			if(odbc_result($rs,"F_APROB"))
			{
				$F_APROB			=fecha_normal(odbc_result($rs,"F_APROB"));
			}
			else
			{
				$F_APROB="";
			}
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='DETALLE_VEHICULO.php?id_empr_acta=".odbc_result($rs,"id_empr_acta")."&id_empresa=$id_empresa'/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"SolicituddeVehiculos\", \"Solicitud de Vehiculos\", \"Sistema/Reportes/ACTA_VEHICULO.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
			$res.=" <tr $clase>
				<td align=\"right\"  >$Enlace</td>
				<td align=\"center\">$NB_LOCALIDAD</td>
				<td align=\"center\">$F_REGISTRO</td>
				<td align=\"center\">$F_ANULACION</td>
				<td align=\"center\">$F_RECEP</td>
				<td align=\"center\">$NB_ABG_RECEP</td>
				<td align=\"center\">$F_ASIG</div></td>
				<td align=\"center\">$NB_ABG_ASIG</td>
				<td align=\"center\">$F_APROB</td>
				<td align=\"center\">$NB_ABG_APROB</td>
				<td align=\"center\">$ESTATUS</td>
			  </tr>";
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table>   
    <br>
    <br>
    <table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
        <thead>
            <tr>
                <th>NRO. ACTA</th>
                <th>PLACA</th>
                <th>MODELO</th>
                <th>TIPO DE VEHICULO</th>
                <th>COLOR</th>
                <th>PRELIQUIDACION</th>
                <th>ACTIVO</th>
                <th>ESTATUS</th>
            </tr>
        </thead>
<?php

    $sql="SELECT        dbo.EMPRE_VEHICULO.PLACA, dbo.TB_MODELO_VEH.NB_MODELO_VEH, dbo.TB_TIPO_VEHICULO.NB_TVEHICULO, 
                         dbo.EMPRE_VEHICULO.COLOR, dbo.EMPRE_VEHICULO.ID_EMPR_ACTA, dbo.EMPRE_VEHICULO.ID_EMPRESA, dbo.EMPRE_ACTA.NRO_ACTA, 
                         dbo.EMPRE_ACTA.ID_LOCALIDAD, dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_ACTA.ID_EMPEXP, dbo.EMPRE_VEHICULO.ID_PRELIQUIDACION, 
                         dbo.EMPRE_VEHICULO.FG_ACTIVO AS FG_ACTIVOE, dbo.EMPRE_VEHICULO.FG_CONFORME, dbo.TB_PERIODO.FG_ACTIVO
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_ACTA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO RIGHT OUTER JOIN
                         dbo.EMPRE_VEHICULO INNER JOIN
                         dbo.TB_TIPO_VEHICULO ON dbo.EMPRE_VEHICULO.ID_TVEHICULO = dbo.TB_TIPO_VEHICULO.ID_TVEHICULO INNER JOIN
                         dbo.TB_MODELO_VEH ON dbo.EMPRE_VEHICULO.ID_MODELO_VEH = dbo.TB_MODELO_VEH.ID_MODELO_VEH ON 
                         dbo.EMPRE_ACTA.ID_EMPR_ACTA = dbo.EMPRE_VEHICULO.ID_EMPR_ACTA
WHERE        (dbo.EMPRE_ACTA.ID_EMPRESA = $id_empresa) AND (dbo.TB_PERIODO.FG_ACTIVO = 1)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

    $sql="SELECT        TOP (100) PERCENT dbo.EMPRE_VEHICULO.PLACA, dbo.TB_MODELO_VEH.NB_MODELO_VEH, dbo.TB_TIPO_VEHICULO.NB_TVEHICULO, 
                         dbo.EMPRE_VEHICULO.COLOR, dbo.EMPRE_VEHICULO.ID_EMPR_ACTA, dbo.EMPRE_VEHICULO.ID_EMPRESA, dbo.EMPRE_ACTA.NRO_ACTA, 
                         dbo.EMPRE_ACTA.ID_LOCALIDAD, dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_ACTA.ID_EMPEXP, dbo.EMPRE_VEHICULO.ID_PRELIQUIDACION, 
                         dbo.EMPRE_VEHICULO.FG_ACTIVO AS FG_ACTIVOE, dbo.EMPRE_VEHICULO.FG_CONFORME, dbo.TB_PERIODO.FG_ACTIVO, 
                         dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_ACTA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO RIGHT OUTER JOIN
                         dbo.EMPRE_VEHICULO INNER JOIN
                         dbo.TB_TIPO_VEHICULO ON dbo.EMPRE_VEHICULO.ID_TVEHICULO = dbo.TB_TIPO_VEHICULO.ID_TVEHICULO INNER JOIN
                         dbo.TB_MODELO_VEH ON dbo.EMPRE_VEHICULO.ID_MODELO_VEH = dbo.TB_MODELO_VEH.ID_MODELO_VEH ON 
                         dbo.EMPRE_ACTA.ID_EMPR_ACTA = dbo.EMPRE_VEHICULO.ID_EMPR_ACTA
WHERE        (dbo.EMPRE_ACTA.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

//echo $sql;
$cn2=$conector->Ejecutar($sql);
$id_preliquidacion = 0;
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$NRO_ACTA			=odbc_result($cn2,"NRO_ACTA");
	$placa=utf8_encode (odbc_result($cn2,'placa'));
	$nb_modelo_veh=utf8_encode (odbc_result($cn2,'nb_modelo_veh'));
	$nb_tvehiculo=utf8_encode (odbc_result($cn2,'nb_tvehiculo'));
	$color=utf8_encode (odbc_result($cn2,'color'));
	$id_preliquidacion = odbc_result($cn2,'id_preliquidacion');
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVOE');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORME');
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
				<td ><?php echo $NRO_ACTA;?></td>
				<td ><?php echo $placa;?></td>
				<td ><?php echo $nb_modelo_veh;?></td>
				<td ><?php echo $nb_tvehiculo;?></td>
				<td ><?php echo $color;?></td>
				<td ><?php echo $id_preliquidacion;?></td>
				<td ><?php echo $ACTIVO;?></td>
				<td ><?php echo $CONFORME;?></td>
		  </tr>
<?php	
}
?>
		</table>
    <!--<a href="DETALLE_VEHICULO_SA.php?id_empresa=<?php echo $id_empresa;?>" target="_blank">LISTADO DE VEHICULOS SIN SOLICITUDES</a>-->
</div>

<?php
if($ID_ROL!=30)
{
?>
<h3><strong>SOLICITUDES DE MAQUNARIAS Y EQUIPOS</strong></h3>
<div>

<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align="right">
           		<div align="center">
                    <label style="text-align:center">NRO.</label>
              </div>
        	</th>
            <th width="226" align="center">
              <div align="center">
                    <label style="text-align:center">LOCALIDAD</label>
              </div>
        	</th>
            <th width="114" align="right">
              <div align="center">
                    <label style="text-align:center">F. REGISTRO.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. ANULACION.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">F. RECEP.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. RECEP.</label>
              </div>
        	</th>   
            <th width="74" align="right">
              <div align="center">
                    <label style="text-align:center">F. ASIG.</label>
              </div>
        	</th>
            <th width="108" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. ASIG.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. CONFORME</label>
              </div>
        	</th>     
            <th width="141" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. COMFORME.</label>
              </div>
        	</th>    
            <th width="94" align="right">
              <div align="center">
                    <label style="text-align:center">ESTATUS</label>
              </div>
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 5 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if(odbc_result($rs,"F_ANULACION"))
			{
				$F_ANULACION			=fecha_normal(odbc_result($rs,"F_ANULACION"));
			}
			else
			{
				$F_ANULACION="";
			}
			
			if(odbc_result($rs,"F_RECEP"))
			{
				$F_RECEP			=fecha_normal(odbc_result($rs,"F_RECEP"));
			}
			else
			{
				$F_RECEP="";
			}
			
			if(odbc_result($rs,"F_ASIG"))
			{
				$F_ASIG			=fecha_normal(odbc_result($rs,"F_ASIG"));
			}
			else
			{
				$F_ASIG="";
			}
			
			if(odbc_result($rs,"F_APROB"))
			{
				$F_APROB			=fecha_normal(odbc_result($rs,"F_APROB"));
			}
			else
			{
				$F_APROB="";
			}
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
				
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"SolicituddeMaquinariasEquipos\", \"Solicitud de Maquinarias y Equipos\", \"Sistema/Reportes/ACTA_MAQ_EQUIP.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
			$res.=" <tr $clase>
				<td align=\"center\"  >$Enlace</td>
				<td align=\"center\">$NB_LOCALIDAD</td>
				<td align=\"center\">$F_REGISTRO</td>
				<td align=\"center\">$F_ANULACION</td>
				<td align=\"center\">$F_RECEP</td>
				<td align=\"center\">$NB_ABG_RECEP</td>
				<td align=\"center\">$F_ASIG</div></td>
				<td align=\"center\">$NB_ABG_ASIG</td>
				<td align=\"center\">$F_APROB</td>
				<td align=\"center\">$NB_ABG_APROB</td>
				<td align=\"center\">$ESTATUS</td>
			  </tr>";
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
    <br>
    <br>
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
				<thead>
					<tr>
					<th>NRO. ACTA</th>
					<th>SERIAL</th>
					<th>DESCRIPCIÓN</th>
					<th>PROPIETARIO</th>
					<th>TIPO MAQUINA</th>
					<th>MARCA</th>
					<th>ACTIVO</th>
					<th>ESTATUS</th>
					</tr>
				</thead>
    <?php
    $sql="SELECT        dbo.EMPRE_MAQEQUIP.ID_EMPR_ACTA, dbo.EMPRE_MAQEQUIP.ID_EMPRESA, dbo.EMPRE_MAQEQUIP.SERIAL, 
                         dbo.EMPRE_MAQEQUIP.CAPACIDAD, dbo.EMPRE_MAQEQUIP.DS_MAQEQUIP, dbo.EMPRE_MAQEQUIP.FG_ACTIVO AS FG_ACTIVOE, 
                         dbo.EMPRE_MAQEQUIP.NB_PROPIETARIO, dbo.EMPRE_ACTA.NRO_ACTA, dbo.TB_TIPO_MAQEQUIP.NB_TIPO_MAQEQUIP, 
                         dbo.TB_MARCA_MAQEQUIP.NB_MARCA_MAQEQUIP, dbo.EMPRE_ACTA.ID_LOCALIDAD, dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_ACTA.F_ANULACION, 
                         dbo.TB_PERIODO.FG_ACTIVO AS Expr1, dbo.EMPRE_MAQEQUIP.FG_CONFORME
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_ACTA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO RIGHT OUTER JOIN
                         dbo.EMPRE_MAQEQUIP INNER JOIN
                         dbo.TB_TIPO_MAQEQUIP ON dbo.EMPRE_MAQEQUIP.ID_TIPO_MAQEQUIP = dbo.TB_TIPO_MAQEQUIP.ID_TIPO_MAQEQUIP INNER JOIN
                         dbo.TB_MARCA_MAQEQUIP ON dbo.EMPRE_MAQEQUIP.ID_MARCA_MAQEQUIP = dbo.TB_MARCA_MAQEQUIP.ID_MARCA_MAQEQUIP ON 
                         dbo.EMPRE_ACTA.ID_EMPR_ACTA = dbo.EMPRE_MAQEQUIP.ID_EMPR_ACTA
WHERE        (dbo.EMPRE_MAQEQUIP.ID_EMPRESA = $id_empresa) AND (dbo.TB_PERIODO.FG_ACTIVO = 1)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";


    $sql="SELECT        TOP (100) PERCENT dbo.EMPRE_MAQEQUIP.ID_EMPR_ACTA, dbo.EMPRE_MAQEQUIP.ID_EMPRESA, dbo.EMPRE_MAQEQUIP.SERIAL, 
                         dbo.EMPRE_MAQEQUIP.CAPACIDAD, dbo.EMPRE_MAQEQUIP.DS_MAQEQUIP, dbo.EMPRE_MAQEQUIP.FG_ACTIVO AS FG_ACTIVOE, 
                         dbo.EMPRE_MAQEQUIP.NB_PROPIETARIO, dbo.EMPRE_ACTA.NRO_ACTA, dbo.TB_TIPO_MAQEQUIP.NB_TIPO_MAQEQUIP, 
                         dbo.TB_MARCA_MAQEQUIP.NB_MARCA_MAQEQUIP, dbo.EMPRE_ACTA.ID_LOCALIDAD, dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_ACTA.F_ANULACION, 
                         dbo.TB_PERIODO.FG_ACTIVO AS Expr1, dbo.EMPRE_MAQEQUIP.FG_CONFORME, dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_ACTA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO RIGHT OUTER JOIN
                         dbo.EMPRE_MAQEQUIP INNER JOIN
                         dbo.TB_TIPO_MAQEQUIP ON dbo.EMPRE_MAQEQUIP.ID_TIPO_MAQEQUIP = dbo.TB_TIPO_MAQEQUIP.ID_TIPO_MAQEQUIP INNER JOIN
                         dbo.TB_MARCA_MAQEQUIP ON dbo.EMPRE_MAQEQUIP.ID_MARCA_MAQEQUIP = dbo.TB_MARCA_MAQEQUIP.ID_MARCA_MAQEQUIP ON 
                         dbo.EMPRE_ACTA.ID_EMPR_ACTA = dbo.EMPRE_MAQEQUIP.ID_EMPR_ACTA
WHERE        (dbo.EMPRE_MAQEQUIP.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

//echo $sql;
$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{	
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
	
	$SERIAL=utf8_encode (odbc_result($cn2,'SERIAL'));
	$DS_MAQEQUIP=utf8_encode (odbc_result($cn2,'DS_MAQEQUIP'));
	$NB_PROPIETARIO=utf8_encode (odbc_result($cn2,'NB_PROPIETARIO'));
	$NB_TIPO_MAQEQUIP=utf8_encode (odbc_result($cn2,'NB_TIPO_MAQEQUIP'));
	$NB_MARCA_MAQEQUIP=utf8_encode (odbc_result($cn2,'NB_MARCA_MAQEQUIP'));
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVOE');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORME');
	$NRO_ACTA			=odbc_result($cn2,"NRO_ACTA");
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
				<td ><?php echo $NRO_ACTA;?></td>
				<td ><?php echo $SERIAL;?></td>
				<td ><?php echo $DS_MAQEQUIP;?></td>
				<td ><?php echo $NB_PROPIETARIO;?></td>
				<td ><?php echo $NB_TIPO_MAQEQUIP;?></td>
				<td ><?php echo $NB_MARCA_MAQEQUIP;?></td>
				<td ><?php echo $ACTIVO;?></td>
				<td ><?php echo $CONFORME;?></td>
		  </tr>
<?php

}
?>
</table>
    <!--<a href="DETALLE_MAQ_EQUIP_SA.php?id_empresa=<?php echo $id_empresa;?>" target="_blank">LISTADO DE MAQUNARIAS Y EQUIPOS SIN SOLICITUDES</a>-->
</div>

<h3><strong>CATEGORIAS POR PUERTOS</strong></h3>
<div>
<table bordercolor="#CCCCCC" width="800" border="1" align="center" cellpadding="0" cellspacing="0" style="width:1050px; margin:auto;" >
    	<tr>
    	  <th colspan="9" align="center">PUERTO DE CONSIGNACION: <?php echo $PuertoConsignacion;?></th>
    	  </tr>
    	<tr> 
           <th width="300" align="right">
           		<div align="center">
                    <label style="text-align:center">CATEGORIA</label>
              </div>
        	</th>
            <th width="70" align="center">
              <div align="center">
                    <label style="text-align:center">PTO. CABELLO</label>
              </div>
        	</th>
            <th width="70" align="right">
              <div align="center">
                    <label style="text-align:center">LA GUAIRA</label>
              </div>
        	</th>
            <th width="70" align="right">
              <div align="center">
                    <label style="text-align:center">GUANTA</label>
              </div>
        	</th>
            <th width="70" align="right">
              <div align="center">
                    <label style="text-align:center">GUAMACHE</label>
              </div>
        	</th> 
            <th width="70" align="right">
              <div align="center">
                    <label style="text-align:center">MARACAIBO</label>
              </div>
        	</th>
            
            <th width="70" align="right">
              <div align="center">
                    <label style="text-align:center">LA CEIBA</label>
              </div>
        	</th>
            
            <th width="70" align="right">
              <div align="center">
                    <label style="text-align:center">ACTIVA</label>
              </div>
        	</th> 
            
            <th width="70" align="right">
              <div align="center">
                    <label style="text-align:center">PRELIQUIDACION</label>
              </div>
        	</th>           
          </tr>
     <?php 
     //$sql = "SELECT * FROM VIEW_CATEG_X_PTO WHERE id_empresa=$id_empresa";
     
	 $sql = "SELECT   * FROM VIEW_CATEGORIAS_POR_PUERTOS WHERE id_empresa=$id_empresa AND ANO_REGISTRO=$ANO_REGISTRO ";
		if($rs=$conector->Ejecutar($sql))
		
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$CATEGORIA			=odbc_result($rs,"CATEGORIA");
			$PTO_CABELLO		=odbc_result($rs,"PTO_CABELLO");
			$LAGUAIRA			=odbc_result($rs,"LAGUAIRA");
			$GUANTA				=odbc_result($rs,"GUANTA");
			$GUAMACHE			=odbc_result($rs,"GUAMACHE");
			$MARACAIBO			=odbc_result($rs,"MARACAIBO");
			$CEIBA				=odbc_result($rs,"CEIBA");
			$FG_ACTIVO				=odbc_result($rs,"FG_ACTIVO");
			$ID_PRELIQUIDACION				=odbc_result($rs,"ID_PRELIQUIDACION");
			$ID_EMPCATEG				=odbc_result($rs,"ID_EMPCATEG");
	
			if($FG_ACTIVO)
				$ACTIVO="ACTIVO";
			else
				$ACTIVO="INACTIVO";
			
			$res.=" <tr $clase>
				<td align=\"left\"  >$CATEGORIA</td>
				<td align=\"center\">$PTO_CABELLO</td>
				<td align=\"center\">$LAGUAIRA</td>
				<td align=\"center\">$GUANTA</div></td>
				<td align=\"center\">$GUAMACHE</td>
				<td align=\"center\">$MARACAIBO</td>
				<td align=\"center\">$CEIBA</td>
				<td align=\"center\">$ACTIVO</td>
				<td align=\"center\">$ID_PRELIQUIDACION</td>
			  </tr>";
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
</div>

<h3><strong>ESTATUS DE LA EMPRESA</strong></h3>
<div>
<table width="800" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
            <th width="65" align="right">
           		<div align="center">
                    <label style="text-align:center">NRO.</label>
              </div>
        	</th>
           <th width="300" align="right">
       		  <div align="center">
                    <label style="text-align:center">TIPO DOC.</label>
              </div>
        	</th>
            <th width="226" align="center">
              <div align="center">
                    <label style="text-align:center">LOCALIDAD</label>
              </div>
        	</th>
            <th width="114" align="right">
              <div align="center">
                    <label style="text-align:center">F. REGISTRO.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. ANULACION.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">F. RECEP.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. RECEP.</label>
              </div>
        	</th>   
            <th width="74" align="right">
              <div align="center">
                    <label style="text-align:center">F. ASIG.</label>
              </div>
        	</th>
            <th width="108" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. ASIG.</label>
              </div>
        	</th>
            <th width="115" align="right">
              <div align="center">
                    <label style="text-align:center">F. CONFORME</label>
              </div>
        	</th>     
            <th width="141" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. COMFORME.</label>
              </div>
        	</th>    
            <th width="94" align="right">
              <div align="center">
                    <label style="text-align:center">ESTATUS</label>
              </div>
        	</th>                  
          </tr>
     <?php 
	 
     $sql = "
	 		SELECT 
	 			*
 			FROM 
				VIEW_RP_STAT_EMPRE 
			WHERE 
				id_empresa=$id_empresa AND
				ID_TACTA<>6 AND
				ANO_REGISTRO=$ANO_REGISTRO 
			order by 
				id_tacta 
			asc";
 	
		//echo $sql;
		
		if($result=$conector->Ejecutar($sql))
		{
			$res="";
			$pintar=0;
			while (odbc_fetch_row($result))
			{
				if($pintar)
				{
					$clase="class='color'";
					$pintar=0;
				}
				else
				{
					$clase="class='Normal'";
					$pintar=1;
				}
				
				$NRO_ACTA			=odbc_result($result,"NRO_ACTA");
				$NB_TACTA			=odbc_result($result,"NB_TACTA");
				$NB_LOCALIDAD		=odbc_result($result,"NB_LOCALIDAD");
				$F_REGISTRO		    =odbc_result($result,"F_REGISTRO");
				$NB_ABG_RECEP			=odbc_result($result,"NB_USUARIO")." ".odbc_result($result,"AP_ABG_RECEP");
				$F_ASIG				=odbc_result($result,"F_ASIG");
				$F_RASIG				=odbc_result($result,"F_RASIG");
				$NB_ABG_APROB			=odbc_result($result,"ABG_APROB")." ".odbc_result($result,"AP_ABG_APROB");
			
				if($F_REGISTRO)
					$F_REGISTRO=fecha_normal($F_REGISTRO);
				
				if($F_RASIG)
					$NB_ABG_RASIG			=odbc_result($result,"ABG_RASIG")." ".odbc_result($result,"AP_ABG_RASIG");
				else
					$NB_ABG_RASIG			=odbc_result($result,"ABG_ASIG")." ".odbc_result($result,"AP_ABG_ASIG");
			
				if(odbc_result($result,"F_ANULACION"))
				{
					$F_ANULACION			=fecha_normal(odbc_result($result,"F_ANULACION"));
				}
				else
				{
					$F_ANULACION="";
				}
				
				if(odbc_result($result,"F_RECEP"))
				{
					$F_RECEP			=fecha_normal(odbc_result($result,"F_RECEP"));
				}
				else
				{
					$F_RECEP="";
				}
				
				if(odbc_result($result,"F_ASIG"))
				{
					$F_ASIG			=fecha_normal(odbc_result($result,"F_ASIG"));
				}
				else
				{
					$F_ASIG="";
				}
				
				if(odbc_result($result,"F_APROB"))
				{
					$F_APROB			=fecha_normal(odbc_result($result,"F_APROB"));
				}
				else
				{
					$F_APROB="";
				}
				
				$ESTATUS="SIN RECEPCIONAR";
				
				if($F_ANULACION)
				{
					$ESTATUS="ANULADA";
				}
				else
				{
					$F_ANULACION="N/A";
					
					if($F_APROB)
					{
						$ESTATUS="APROBADO";
					}
					else
					{
						if($F_ASIG or $F_RASIG)
						{
							$ESTATUS="ASIGNADO";
						}
						else
						{
							if($F_RECEP)
							{
								$ESTATUS="RECEPCIONADO";
							}
						}
					}
				}
				
				$res.=" <tr $clase>
					<td align=\"left\"  >$NRO_ACTA</td>
					<td align=\"left\"  >$NB_TACTA</td>
					<td align=\"center\">$NB_LOCALIDAD</td>
					<td align=\"center\">$F_REGISTRO</td>
					<td align=\"center\">$F_ANULACION</td>
					<td align=\"center\">$F_RECEP</td>
					<td align=\"center\">$NB_ABG_RECEP</td>
					<td align=\"center\">$F_ASIG</div></td>
					<td align=\"center\">$NB_ABG_ASIG</td>
					<td align=\"center\">$F_APROB</td>
					<td align=\"center\">$NB_ABG_APROB</td>
					<td align=\"center\">$ESTATUS</td>
				  </tr>";
			}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    </table> 
</div>


<h3><strong>CONTRATOS</strong></h3>
<div>
  <table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP"  style="width:1050px; margin:auto;">
    <thead>
      <tr>
        <th width="250">NRO. CONTRATO</th>
        <th width="446" align="center">CATEGORIA</th>
        <th width="250">ABOGADO</th>
        <th width="101">FECHA REGISTRO</th>
        <th width="100">FECHA FIRMA</th>
        <th width="99">ESTATUS</th>
        </tr>
    </thead>
    <?php
    $sql="SELECT        dbo.EMPRE_DOCLEGAL.ID_EDOC_LEGAL, dbo.EMPRE_DOCLEGAL.ID_EMPCATEG, dbo.EMPRE_DOCLEGAL.ID_LOCALIDAD, 
                         dbo.EMPRE_DOCLEGAL.ID_TDOC_LEGAL, dbo.EMPRE_DOCLEGAL.ID_EDOC_LEGAL_ORIG, dbo.EMPRE_DOCLEGAL.ID_EMPEXP, 
                         dbo.EMPRE_DOCLEGAL.NRO_DOC_LEGAL, dbo.EMPRE_DOCLEGAL.F_EMISION, dbo.EMPRE_DOCLEGAL.F_FIRMA, dbo.EMPRE_DOCLEGAL.F_VIG_DESDE, 
                         dbo.EMPRE_DOCLEGAL.F_VIG_HASTA, dbo.EMPRE_DOCLEGAL.F_ENVIO, dbo.EMPRE_DOCLEGAL.ESTATUS, dbo.EMPRE_DOCLEGAL.FG_RENOVACION, 
                         dbo.EMPRE_DOCLEGAL.FG_RENOVADO, dbo.EMPRE_DOCLEGAL.MTO_CONTRATO, dbo.EMPRE_DOCLEGAL.CI_ABOGADO, dbo.EMPRE_DOCLEGAL.ID_CONTRATO, 
                         dbo.EMPRE_DOCLEGAL.NB_DOC_GENERADO, dbo.EMPRE_DOCLEGAL.CI_ABOG_CARGA_DOC, dbo.EMPRE_DOCLEGAL.NB_DIR_CONTRATO, 
                         dbo.EMPRE_DOCLEGAL.F_REGISTRO, dbo.EMPRE_DOCLEGAL.DESC_CONTRATO, dbo.EMPRE_DOCLEGAL.ULTIMA_FECHA_UPBO, 
                         dbo.EMPRE_DOCLEGAL.FG_DEFINITIVO, dbo.EMPRE_DOCLEGAL.FECHA_EMISION_DEF, dbo.EMPRE_DOCLEGAL.CORRELATIVO_SEGURIDAD, 
                         dbo.EMPRE_DOCLEGAL.FG_GUARDADO, dbo.EMPRE_DOCLEGAL.ID_BITACORA, dbo.TB_CATEGORIA.NB_CATEGORIA, dbo.TB_CATEGORIA.ID_CATEGORIA, 
                         dbo.EMPRE_CATEGORIA.ID_EMPRESA, dbo.USUARIO.NB_USUARIO, dbo.USUARIO.AP_USUARIO, dbo.TB_PERIODO.FG_ACTIVO, 
                         dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO
FROM            dbo.EMPRE_DOCLEGAL INNER JOIN
                         dbo.EMPRE_CATEGORIA ON dbo.EMPRE_DOCLEGAL.ID_EMPCATEG = dbo.EMPRE_CATEGORIA.ID_EMPCATEG INNER JOIN
                         dbo.TB_CATEGORIA ON dbo.EMPRE_CATEGORIA.ID_CATEGORIA = dbo.TB_CATEGORIA.ID_CATEGORIA INNER JOIN
                         dbo.USUARIO ON dbo.EMPRE_DOCLEGAL.CI_ABOGADO = dbo.USUARIO.CI_USUARIO INNER JOIN
                         dbo.EMPRE_EXPEDIENTE ON dbo.EMPRE_DOCLEGAL.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO
WHERE        (dbo.EMPRE_CATEGORIA.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO)";

//echo $sql;

    $sql="select * from VIEW_CONTRATOS where id_empresa =$id_empresa and ANO_REGISTRO = $ANO_REGISTRO";

$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$ID_EMPCATEG=utf8_encode (odbc_result($cn2,'ID_EMPCATEG'));
	$ID_CATEGORIA=utf8_encode (odbc_result($cn2,'ID_CATEGORIA'));
	$NB_CATEGORIA=utf8_encode (odbc_result($cn2,'NB_CATEGORIA'));
	$ID_LOCALIDAD=utf8_encode (odbc_result($cn2,'ID_LOCALIDAD'));
	$ID_EDOC_LEGAL=utf8_encode (odbc_result($cn2,'ID_EDOC_LEGAL'));
	$F_REGISTRO=utf8_encode (odbc_result($cn2,'F_REGISTRO'));
	$F_FIRMA=utf8_encode (odbc_result($cn2,'F_FIRMA'));
	$FG_DEFINITIVO=utf8_encode (odbc_result($cn2,'FG_DEFINITIVO'));
	$NB_ABOGADO=utf8_encode (odbc_result($cn2,'NB_USUARIO')." ".odbc_result($cn2,'AP_USUARIO'));	
	
	if($FG_DEFINITIVO)
	{
		$ESTATUS="DEFINITIVO";
		
		$HREF="../Verificacion/Contratos/ver_contrato.php?id=".$ID_EDOC_LEGAL;
		
		$SQL="SELECT RIGHT('000' + CONVERT(VARCHAR(4), dbo.EMPRE_DOCLEGAL.NRO_DOC_LEGAL), 4) AS NRO_DOC_LEGAL 
				FROM 
					EMPRE_DOCLEGAL WHERE FG_DEFINITIVO=1 AND ID_EMPCATEG=$ID_EMPCATEG";
				
		$cn22=$conector->Ejecutar($SQL);
		
		$NRO_DOC_LEGAL=utf8_encode (odbc_result($cn22,'NRO_DOC_LEGAL'));
					
		$SQL="SELECT ANO_REGISTRO FROM EMPRE_DOCLEGAL WHERE FG_DEFINITIVO=1 AND  ID_EMPCATEG=$ID_EMPCATEG";
					
		$cn22=$conector->Ejecutar($SQL);
		
		$ANO_REGISTRO=utf8_encode (odbc_result($cn22,'ANO_REGISTRO'));
					
		$SQL="SELECT SIGLAS_LOC FROM TB_LOCALIDAD  WHERE ID_LOCALIDAD=$ID_LOCALIDAD";
		
		//echo $SQL;
					
		$cn22=$conector->Ejecutar($SQL);
		
		$SIGLAS_LOC=utf8_encode (odbc_result($cn22,'SIGLAS_LOC'));
					
		$SQL="SELECT SIGLAS_CATEG FROM TB_CATEGORIA  WHERE ID_CATEGORIA=$ID_CATEGORIA";
		
		//echo $SQL;
					
		$cn22=$conector->Ejecutar($SQL);
		
		$SIGLAS_CATEG=str_replace('-','',odbc_result($cn22,'SIGLAS_CATEG'));
		
		$COD_CONTRATO="$SIGLAS_LOC-ROP-$SIGLAS_CATEG-$NRO_DOC_LEGAL-$ANO_REGISTRO";
	}
	else
	{
		$COD_CONTRATO="S/N";
		$ESTATUS="BORRADOR";
		$HREF="../Verificacion/Contratos/ver_contrato.php?id=".$ID_EDOC_LEGAL;
	}
	
	if($F_REGISTRO)
		$F_REGISTRO=fecha_normal($F_REGISTRO);
	
	if($F_FIRMA)
		$F_FIRMA=fecha_normal($F_FIRMA);
?>
    <tr <?php echo $clase;?>>
      <td ><a href="javascript:" onclick="ver_contrato(<?php echo $ID_EDOC_LEGAL;?>)"><?php echo $COD_CONTRATO;?></a></td>
      <td ><?php echo $NB_CATEGORIA;?></td>
      <td ><?php echo $NB_ABOGADO;?></td>
      <td ><?php echo ($F_REGISTRO);?></td>
      <td ><?php echo ($F_FIRMA);?></td>
      <td ><?php echo $ESTATUS;?></td>
      </tr>
    <?php

}
?>
  </table>
</div>

<h3><strong>INCONFORMIDADES</strong></h3>
<div>
<table border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align="right">
           		<div align="center">
                    <label style="text-align:center">NRO.</label>
              </div>
        	</th>
            <th width="226" align="center">
              <div align="center">
                    <label style="text-align:center">LOCALIDAD</label>
              </div>
        	</th>
            <th width="114" align="right">
              <div align="center">
                    <label style="text-align:center">F. REGISTRO.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">F. RECEP.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">F. ALULACION.</label>
              </div>
        	</th>
            <th width="110" align="right">
              <div align="center">
                    <label style="text-align:center">ABG. RECEP.</label>
              </div>
        	</th>
            <th width="94" align="right">
              <div align="center">
                    <label style="text-align:center">ESTATUS</label>
              </div>
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 6 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_ANULACION		=odbc_result($rs,"F_ANULACION");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			$F_APROB			=(odbc_result($rs,"F_APROB"));
			$F_ASIG				=(odbc_result($rs,"F_ASIG"));
			$F_RECEP			=(odbc_result($rs,"F_RECEP"));
			$F_REGISTRO		    =(odbc_result($rs,"F_REGISTRO"));
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			if($F_ASIG)
				$F_ASIG=fecha_normal($F_ASIG);
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			if($F_ANULACION)
				$F_ANULACION=fecha_normal($F_ANULACION);
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_RECEP)
			{
				$ESTATUS="RECEPCIONADA";
			}
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADO POR EL USUARIO";
			}
				
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"Inconformidades\", \"Inconformidades\", \"Sistema/Reportes/INCONFORMIDAD.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
			$res.=" <tr $clase>
				<td align=\"center\"  >$Enlace</td>
				<td align=\"center\">$NB_LOCALIDAD</td>
				<td align=\"center\">$F_REGISTRO</td>
				<td align=\"center\">$F_RECEP</td>
				<td align=\"center\">$F_ANULACION</td>
				<td align=\"center\">$NB_ABG_RECEP</td>
				<td align=\"center\">$ESTATUS</td>
			  </tr>";
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    </table> 
    <br />
    <br />
    
</div>
<?php
}
$conector->Cerrar();
?>
</div>
     <br />
     <br />
<!--FIN ACORDION-->
</div>
<!--FIN ALIGN CENTER-->
</div>
<!--FIN ALIGN CENTER GENERAL-->
</body>
</html>
