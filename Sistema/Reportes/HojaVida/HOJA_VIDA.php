<?php
	$Nivel="../../../";
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
		
		$sql="SELECT ID_EMPRESA FROM VIEW_DATOS_EMPRESA WHERE RIF='$AuxRIF'";
		
		if($rs=$conector->Ejecutar($sql))
		{
			$id_empresa		=	odbc_result($rs,"ID_EMPRESA");	
			
			if(!$id_empresa)
			{
				echo "EL RIF NO SE ENCUENTRA REGISTRADO";
		
				echo '
						<script>
							window.parent.$("#Loading").css("display","none");
						</script>
					';
			
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
		
		$sql="SELECT RIF FROM VIEW_DATOS_EMPRESA WHERE id_empresa=$id_empresa";
		
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
		$sql="SELECT        dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, dbo.TB_PERIODO.FG_ACTIVO
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO
WHERE        (dbo.EMPRE_EXPEDIENTE.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1) AND (dbo.TB_PERIODO.FG_ACTIVO = 1)";
		
		if($rs=$conector->Ejecutar($sql))
		{
			$ANO_REGISTRO		=	odbc_result($rs,"ANO_REGISTRO");
		}
	}
	
	$sql="SELECT        dbo.TB_LOCALIDAD.NB_LOCALIDAD, dbo.EMPRESA.RIF, dbo.EMPRESA.RAZON_SOCIAL
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_LOCALIDAD ON dbo.EMPRE_EXPEDIENTE.ID_LOCALIDAD = dbo.TB_LOCALIDAD.ID_LOCALIDAD INNER JOIN
                         dbo.EMPRESA ON dbo.EMPRE_EXPEDIENTE.ID_EMPRESA = dbo.EMPRESA.ID_EMPRESA
WHERE (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1) AND (dbo.EMPRE_EXPEDIENTE.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO);";
		
	if($rs=$conector->Ejecutar($sql))
	{
		$PuertoConsignacion		=	odbc_result($rs,"NB_LOCALIDAD");	
		$RIF		=	odbc_result($rs,"RIF");	
		$RAZON_SOCIAL		=	odbc_result($rs,"RAZON_SOCIAL");
	}
	else
	{
		echo $sql;
	}
	
	if(!$RIF)
	{
		echo "DISCULPE, LA EMPRESA NO POSEE EXPEDIENTE E EL PERIODO ".$ANO_REGISTRO;
		
		echo '
				<script>
					window.parent.$("#Loading").css("display","none");
				</script>
			';
			
		$conector->Cerrar();
		exit;
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
                
                //window.parent.$("#Loading").css("display","none");
				
				cHojaVida(1);
				
				$("#TitHohaVida1").click();
            });
            
            function ver_contrato(id , FG_DEFINITIVO)
            {				
                var parametros = 'id='+id;
                
				if(FG_DEFINITIVO==1)
				{				
					$.ajax(
					{
						type: "get",
						url: "../../Verificacion/Contratos/ver_contrato.php",
						data: parametros,
						cache: false,
						beforeSend: function() 
						{		
							window.parent.$("#Loading").css("display","");
						},
						success: function(html)
						{					
							parent.AbrirVentana('verContrato2', 'Contrato Definitivo', 'Sistema/Verificacion/Contratos/ver_contrato_consulta.php', '', 600, 1050, 0, 1, 1, 1, 1);
							
							window.parent.$("#Loading").css("display","none");
						}
					});
				}
				else
				{
					parent.AbrirVentana('verContratoBorrador', 'Borrador Contrato', 'Sistema/Verificacion/Contratos/ver_borrador.php', parametros, 600, 1050, 0, 1, 1, 1, 1);
							
					window.parent.$("#Loading").css("display","none");
				}
            }
			
			function cHojaVida(Opc)
            {
				Activo=$("#CueHohaVida"+Opc).hasClass('ui-accordion-content-active');
				
				if(!Activo)
				{
					var parametros = 'id_empresa=<?php echo $id_empresa;?>&Opc='+Opc+'&ANO_REGISTRO=<?php echo $ANO_REGISTRO;?>';
					$.ajax(
					{
						type: "get",
						url: "cHojaVida.php",
						data: parametros,
						cache: false,
						beforeSend: function() 
						{		
							window.parent.$("#Loading").css("display","");
						},
						success: function(html)
						{
							
							window.parent.$("#Loading").css("display","none");
							$("#CueHohaVida"+Opc).html(html);
						}
					});
				}
            }
        </script>
        
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
	</head>
	<body>
        <div align="center">
            <div style="text-align:left; margin:auto" align="center">
                <table class="table" border="0" align="center" cellpadding="0" cellspacing="0" style="margin:auto">
                    <tr>
                        <td colspan="8" align="center" scope="row"><p><img src="<?php echo $Nivel;?>imagen/header.png" width="885" height="52" />
                            </p>
                            <p class="Estilo2">BOLIVARIANA DE PUERTOS (BOLIPUERTOS), S.A</p>
                          <p></p>
                            <h3  class="Estilo2">HOJA DE VIDA</h3>
                            <h3  class="Estilo2">(<?php echo $RIF;?>) <?php echo $RAZON_SOCIAL;?></h3>
                            <h3  class="Estilo2">PERIODO <?php echo $ANO_REGISTRO;?></h3>
                            <p>&nbsp;</p>
                        </TD>
                    </tr>
                </table>
                <div id="accordion" style="display:;">
                    <h3 id="TitHohaVida1" onclick="cHojaVida(1);"><strong>DATOS DE LA EMPRESA</strong></h3>
                    <div id="CueHohaVida1"></div>
                    
                    <h3 id="TitHohaVida14" onclick="cHojaVida(14);"><strong>REPRESENTANTES LEGAL</strong></h3>
                    <div id="CueHohaVida14"></div>
                    
                    <h3 id="TitHohaVida18" onclick="cHojaVida(18);"><strong>EXPEDIENTES</strong></h3>
                    <div id="CueHohaVida18"></div>
                    
                    <h3 id="TitHohaVida2" onclick="cHojaVida(2);"><strong>EXPEDIENTE - PRELIQUIDACIONES</strong></h3>
                    <div id="CueHohaVida2"></div>
                    
                    <h3 id="TitHohaVida16" onclick="cHojaVida(16);"><strong>DETALLE DE FACTURACION DE PRELIQUIDACIONES</strong></h3>
                    <div id="CueHohaVida16"></div>
                    
                    <h3 id="TitHohaVida3" onclick="cHojaVida(3);"><strong>DEPOSITOS APLICADOS A PRELIQUIDACIONES ACTIVAS</strong></h3>
                    <div id="CueHohaVida3"></div>
                    
                    <h3 id="TitHohaVida17" onclick="cHojaVida(17);"><strong>DETALLE DE RETENCIONES</strong></h3>
                    <div id="CueHohaVida17"></div>
                    
                    <h3 id="TitHohaVida4" onclick="cHojaVida(4);"><strong>MOVIMIENTOS BANCARIOS</strong></h3>
                    <div id="CueHohaVida4"></div>
					
                    <h3 id="TitHohaVida20" onclick="cHojaVida(20);"><strong>ACTA SEGURIDAD LABORAL Y AMBIENTE</strong></h3>
                    <div id="CueHohaVida20"></div>
					
                    <h3 id="TitHohaVida13" onclick="cHojaVida(13);"><strong>ACTAS DE DOCUMENTOS</strong></h3>
                    <div id="CueHohaVida13"></div>
					
                     <h3 id="TitHohaVida21" onclick="cHojaVida(21);"><strong>ACTAS DE DOCUMENTOS - ANEXOS AMBITO GEOGRAFICO</strong></h3>
                    <div id="CueHohaVida21"></div>
                    
                    <h3 id="TitHohaVida5" onclick="cHojaVida(5);"><strong>ACTAS DE GARANTIAS</strong></h3>
                    <div id="CueHohaVida5"></div>
                    
                    <h3 id="TitHohaVida6" onclick="cHojaVida(6);"><strong>SOLICITUDES DE EMPLEADOS</strong></h3>
                    <div id="CueHohaVida6"></div>
                    
                    <h3 id="TitHohaVida15" onclick="cHojaVida(15);"><strong>POLIZAS DE RESPONSABILIDAD CIVIL</strong></h3>
                    <div id="CueHohaVida15"></div>
                    
                    <h3 id="TitHohaVida19" onclick="cHojaVida(19);"><strong>ACTAS DE RENOVACION DE POLIZAS DE RESPONSABILIDAD CIVIL</strong></h3>
                    <div id="CueHohaVida19"></div>
                    
                    <h3 id="TitHohaVida7" onclick="cHojaVida(7);"><strong>SOLICITUDES DE VEHICULOS</strong></h3>
                    <div id="CueHohaVida7"></div>
                    
                    <h3 id="TitHohaVida8" onclick="cHojaVida(8);"><strong>SOLICITUDES DE MAQUNARIAS Y EQUIPOS</strong></h3>
                    <div id="CueHohaVida8"></div>
                    
                    <h3 id="TitHohaVida9" onclick="cHojaVida(9);"><strong>CATEGORIAS POR PUERTOS</strong></h3>
                    <div id="CueHohaVida9"></div>
                  
                    
                    <h3 id="TitHohaVida10" onclick="cHojaVida(10);"><strong>ESTATUS DE LA EMPRESA</strong></h3>
                    <div id="CueHohaVida10"></div>
                    
                    <h3 id="TitHohaVida11" onclick="cHojaVida(11);"><strong>CONTRATOS / ANEXOS</strong></h3>
                    <div id="CueHohaVida11"></div>
                    
                    <h3 id="TitHohaVida12" onclick="cHojaVida(12);"><strong>INCONFORMIDADES</strong></h3>
                    <div id="CueHohaVida12"></div>
                </div>
            </div>
        </div>
        <?php
        $conector->Cerrar();
        ?>
	</body>
</html>
