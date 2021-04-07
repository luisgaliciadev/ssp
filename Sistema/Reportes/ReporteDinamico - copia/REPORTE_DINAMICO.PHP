<?php
	$Nivel="../../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	$ID_USUARIO=$_SESSION[$SiglasSistema.'ID_USUARIO'];
	
	$IdVentana=$_GET['IdVentana'];	
?>
<!doctype html>
<html lang="en">
    <head>
        <title>Campos</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <?php echo includes($Nivel);?>
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
      
        <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.0/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">-->
        
        <style>
            #sortable1, #sortable2 
            {
                border: 1px solid #eee;
                width: 220px;
                min-height: 20px;
                list-style-type: none;
                margin: 0;
                padding: 5px 0 0 0;
                float: left;
                margin-right: 10px;
                min-height:333px;
            }
            
            #sortable1 li, #sortable2 li 
            {
                margin: 0 5px 5px 5px;
                padding: 5px;
                font-size: 1.2em;
                width: auto;
                cursor:pointer;
            }
        </style>
        
        <!--<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"></script>-->
        
        <script>
			var ArrCamColumnasNB_CAMPO=[];
			var ArrCamColumnasNB_CAMPO_SQL=[];				
			
			var ArrCamColumnasNB_CAMPO=[];
			var ArrCamColumnasNB_CAMPO_SQL=[];	
			
			function recorrer()
			{				
				for (var Ite in ArrCamColumnasNB_CAMPO) 
				{
					alert(ArrCamColumnasNB_CAMPO[Ite]+":"+ArrCamColumnasNB_CAMPO_SQL[Ite]);
				}
			}
			
			function MoscarID_REP_DIN()
			{
				ID_REP_DIN=parseInt($("#ID_REP_DIN").val());
				
				$("#Columnas").val('');
				$("#CamposColumnas").val('');
				$("#ColumnasFiltros").val('');
				$("#CamposFiltros").val('');
				
				$("#Filtros").html('<input name="VistaPrevia" type="button" id="VistaPrevia" value="Vista Previa" class="button small btnSistema" onClick="VistaPrevia();"/>');	
				
				$("#TABLA thead").html("");
				$("#TABLA tbody").html("");
				
				if(ID_REP_DIN)
				{
					$("#AgregarColumnas").show();
					
					$("#Filtros").hide();
					
					$("#divTABLA").hide();
				}
				else
				{
					$("#AgregarColumnas").hide();		
								
					$("#AgregarFiltros").hide();				
					
					$("#Filtros").hide();
					$("#Filtros").html('<input name="VistaPrevia" type="button" id="VistaPrevia" value="Vista Previa" class="button small btnSistema" onClick="VistaPrevia();"/>');					
					
					$("#divTABLA").hide();
				}
			}			
			
            function AgregarColumnas()
			{	
				ID_REP_DIN="&ID_REP_DIN="+$("#ID_REP_DIN").val();
				Columnas="&Columnas="+$("#Columnas").val();
				CamposColumnas="&CamposColumnas="+$("#CamposColumnas").val();
				
				Parametros=ID_REP_DIN+Columnas+CamposColumnas;
				
				if(ID_REP_DIN=="&ID_REP_DIN=0")
				{
					window.parent.toastr.error("Disculpe, debe seleccionar el Reporte");
					return;
				}
				
				parent.AbrirVentana('AgregarColumnas', 'Agregar Columnas', 'Sistema/Reportes/ReporteDinamico/COLUMNAS.php', 'IdVentanaP=<?php echo "iframe".$IdVentana;?>'+Parametros, 540, 600, 1, 1, 1, 1, 1);
			}
			
			function AgregarColumnasD(Columnas)
			{
				$("#TABLA thead").html("");
				$("#Columnas").val("");
				$("#CamposColumnas").val("");
				$("#TABLA tbody").html("");
				
				//alert(Columnas);
				
				ArregloColumnasC=Columnas.split(";");
				
				var ArregleColumna = new Array();
				var ArregleCamposColumnas = new Array();
				
				for(Ite=0; Ite<ArregloColumnasC.length; Ite++)
				{
					Posi=parseInt(ArregloColumnasC[Ite].indexOf("&"));
					
					if(Posi>0)
					{
						//alert(Posi);
						
						ArregleColumna[Ite]=ArregloColumnasC[Ite].substr(0,Posi);
						ArregleCamposColumnas[Ite]=ArregloColumnasC[Ite].substr(Posi+1,ArregloColumnasC[Ite].length);
						
						//alert(ArregloColumnasC[Ite].substr(0,Posi));
						//alert(ArregloColumnasC[Ite].substr(Posi+1,ArregloColumnasC[Ite].length));
					}
					else
					{
						break;	
					}
				}
				
				CadColumnasA="";
				CadCamposColumnas="";
				CadColumnas="";
				
				for(Ite=0; Ite<ArregleColumna.length; Ite++)
				{
					if((Ite+1)==ArregleColumna.length)
					{
						CadColumnasA+=ArregleColumna[Ite];
						CadCamposColumnas+=ArregleCamposColumnas[Ite];
					}
					else
					{
						CadColumnasA+=ArregleColumna[Ite]+",";
						CadCamposColumnas+=ArregleCamposColumnas[Ite]+",";
					}
					
					CadColumnas+="<th>"+ArregleColumna[Ite]+"</th>";
				}
				
				$("#TABLA thead").html(CadColumnas);
				$("#Columnas").val(CadColumnasA);
				$("#CamposColumnas").val(CadCamposColumnas);
				
				if(CadColumnasA)
				{
					$("#AgregarFiltros").show();
					
					$("#Filtros").show();					
					
					$("#divTABLA").show();
				}
				else
				{
					$("#AgregarFiltros").hide();
					
					$("#Filtros").hide();					
					
					$("#divTABLA").hide();
				}
			}
			
            function AgregarFiltros()
			{	
				ID_REP_DIN="&ID_REP_DIN="+$("#ID_REP_DIN").val();
				ColumnasFiltros="&ColumnasFiltros="+$("#ColumnasFiltros").val();
				CamposFiltros="&CamposFiltros="+$("#CamposFiltros").val();
				
				Parametros=ID_REP_DIN+ColumnasFiltros+CamposFiltros;
				
				if(ID_REP_DIN=="&ID_REP_DIN=0")
				{
					window.parent.toastr.error("Disculpe, debe seleccionar el Reporte");
					return;
				}
				
				parent.AbrirVentana('AgregarFiltros', 'Agregar Filtros', 'Sistema/Reportes/ReporteDinamico/FILTROS.php', 'IdVentanaP=<?php echo "iframe".$IdVentana;?>'+Parametros, 540, 600, 1, 1, 1, 1, 1);
			}
			
			function AgregarColumnasFiltrosD(Columnas)
			{
				//$("#TABLA thead").html("");
				$("#ColumnasFiltros").val("");
				$("#CamposFiltros").val("");
				$("#TABLA tbody").html("");
				
				//alert(Columnas);
				
				ArregloColumnasC=Columnas.split(";");
				
				var ArregleColumna = new Array();
				var ArregleCamposColumnas = new Array();
				
				for(Ite=0; Ite<ArregloColumnasC.length; Ite++)
				{
					Posi=parseInt(ArregloColumnasC[Ite].indexOf("&"));
					
					if(Posi>0)
					{
						//alert(Posi);
						
						ArregleColumna[Ite]=ArregloColumnasC[Ite].substr(0,Posi);
						ArregleCamposColumnas[Ite]=ArregloColumnasC[Ite].substr(Posi+1,ArregloColumnasC[Ite].length);
						
						//alert(ArregloColumnasC[Ite].substr(0,Posi));
						//alert(ArregloColumnasC[Ite].substr(Posi+1,ArregloColumnasC[Ite].length));
					}
					else
					{
						break;	
					}
				}
				
				CadColumnasA="";
				CadCamposColumnas="";
				CadColumnas="";
				CadFiltros="";
				
				for(Ite=0; Ite<ArregleColumna.length; Ite++)
				{
					if((Ite+1)==ArregleColumna.length)
					{
						CadColumnasA+=ArregleColumna[Ite];
						CadCamposColumnas+=ArregleCamposColumnas[Ite];
					}
					else
					{
						CadColumnasA+=ArregleColumna[Ite]+",";
						CadCamposColumnas+=ArregleCamposColumnas[Ite]+",";
					}
					
					CadColumnas+="<th>"+ArregleColumna[Ite]+"</th>";
					
					PosiF=parseInt(ArregleCamposColumnas[Ite].indexOf("*"));
					
					TIPO_CAMPO_HTML_AXU=ArregleCamposColumnas[Ite].substr(PosiF+1,ArregleCamposColumnas[Ite].length);					
					
					Posi_AXU=parseInt(TIPO_CAMPO_HTML_AXU.indexOf("*"));
					
					ID_REP_DIN_CAMPOS=TIPO_CAMPO_HTML_AXU.substr(Posi_AXU+1,TIPO_CAMPO_HTML_AXU.length);	
					
					TIPO_CAMPO_HTML=TIPO_CAMPO_HTML_AXU.substr(0,Posi_AXU);
					
					//alert(ID_REP_DIN_CAMPOS+TIPO_CAMPO_HTML);					
					
					CadFiltros+=IncluirFiltro(ID_REP_DIN_CAMPOS, TIPO_CAMPO_HTML, ArregleColumna[Ite], ArregleCamposColumnas[Ite]);
				}
				
				//$("#TABLA thead").html(CadColumnas);
				$("#ColumnasFiltros").val(CadColumnasA);
				$("#CamposFiltros").val(CadCamposColumnas);				
				
				$("#Filtros").html('<div id="DivCamposFiltros">'+CadFiltros+'</div><input name="VistaPrevia" type="button" id="VistaPrevia" value="Vista Previa" class="button small btnSistema" onClick="VistaPrevia();"/>');
			}
			
			function IncluirFiltro(ID_REP_DIN_CAMPOS, TIPO_CAMPO_HTML, NB_CAMPO, NB_CAMPO_SQL)
			{
				switch(TIPO_CAMPO_HTML)
				{
					case "TEXT":
						return '<table style="float:left;">'+
								  '<tbody>'+
									'<tr>'+
									  '<td>'+NB_CAMPO+':</td>'+
									  '<td><input type="text" id="'+NB_CAMPO_SQL+'" name="'+NB_CAMPO_SQL+'"></td>'+
									'</tr>'+
								  '</tbody>'+
							  '</table>';
					break;
					
					case "SELECT":
					
						ID_REP_DIN_CAMPOS="ID_REP_DIN_CAMPOS="+ID_REP_DIN_CAMPOS;
						
						Parametros=ID_REP_DIN_CAMPOS;
						
						CadOption="";
						
						$.ajax(
						{
							type: "GET",
							url: "SELECT.php",
							data: Parametros,
							async: false,
							beforeSend: function() 
							{			
								window.parent.$("#Loading").css("display","");
							},
							success: function(html)
							{
								window.parent.$("#Loading").css("display","none");	
						
								CadOption=html;
								//alert(html);
							}
						});
						
						return '<table style="float:left;">'+
								  '<tbody>'+
									'<tr>'+
									  '<td>'+NB_CAMPO+':</td>'+
									  '<td>'+
									  	'<select id="'+NB_CAMPO_SQL+'" name="'+NB_CAMPO_SQL+'">'+
									  		''+CadOption+''+
									  	'</select>'+
									  '</td>'+
									'</tr>'+
								  '</tbody>'+
							  '</table>';
					break;
				}	
			}
			
			function VistaPrevia()
			{
				ID_REP_DIN="ID_REP_DIN="+$("#ID_REP_DIN").val();
				Columnas="&Columnas="+$("#Columnas").val();
				CamposColumnas="&CamposColumnas="+$("#CamposColumnas").val();
				
				if(ID_REP_DIN=="ID_REP_DIN=0")
				{
					window.parent.toastr.error("Disculpe, debe seleccionar el Reporte");
					return;
				}
				
				if(CamposColumnas=="&CamposColumnas=")
				{
					window.parent.toastr.error("Disculpe, debe agregar las Columnas del Reporte");
					return;
				}
				
				CadBusqueda="";
				Ite=0;
				
				$('#DivCamposFiltros').find('select, input').each(function(index) 
				{
					Ite++;
					
					ID=$(this).attr('id')
					VALOR=$(this).val()
					
					CadBusqueda+="&CamBus"+Ite+"="+ID+"&ValBus"+Ite+"="+VALOR;
				});
				
				Parametros=ID_REP_DIN+Columnas+CamposColumnas+CadBusqueda;
				
				$.ajax(
				{
					type: "GET",
					url: "REPORTE_DINAMICO_CONSULTA.php",
					data: Parametros,
					beforeSend: function() 
					{			
						window.parent.$("#Loading").css("display","");
					},
					success: function(html)
					{
						window.parent.$("#Loading").css("display","none");	
				
						//alert(html);					
						
						$("#TITULO").html("REPORTE DE "+$("#ID_REP_DIN option:selected").text());
						
						
    					btn='<tr>'+
								'<td colspan="50" align="center"></td>'+
							'</tr>'+
							'<tr>'+
								'<td colspan="50" align="center">'+
									'<input name="GenerarReporteExcel" type="button" id="GenerarReporteExcel" value="Generar Reporte Excel" class="button small btnSistema" onClick="GenerarReporteExcel();"/>'+
								'</td>'+
							'</tr>';
						
						$("#TABLA tbody").html(html+btn);
					}
				});
			}
			
			function GenerarReporteExcel()
			{
				ID_REP_DIN="ID_REP_DIN="+$("#ID_REP_DIN").val();
				Columnas="&Columnas="+$("#Columnas").val();
				CamposColumnas="&CamposColumnas="+$("#CamposColumnas").val();
				
				if(ID_REP_DIN=="ID_REP_DIN=0")
				{
					window.parent.toastr.error("Disculpe, debe seleccionar el Reporte");
					return;
				}
				
				if(CamposColumnas=="&CamposColumnas=")
				{
					window.parent.toastr.error("Disculpe, debe agregar las Columnas del Reporte");
					return;
				}
				
				CadBusqueda="";
				Ite=0;
				
				$('#DivCamposFiltros').find('select, input').each(function(index) 
				{
					Ite++;
					
					ID=$(this).attr('id')
					VALOR=$(this).val()
					
					CadBusqueda+="&CamBus"+Ite+"="+ID+"&ValBus"+Ite+"="+VALOR;
				});
				
				TituloReporte="&TituloReporte="+$("#ID_REP_DIN option:selected").text()
				
				Parametros=ID_REP_DIN+Columnas+CamposColumnas+CadBusqueda+TituloReporte;
        
				VenImp=window.open('REPORTE_DINAMICO_CONSULTA_EXCEL.php?'+Parametros,'popimpr');
				
				/*$.ajax(
				{
					type: "GET",
					url: "REPORTE_DINAMICO_CONSULTA_EXCEL.php",
					data: Parametros,
					beforeSend: function() 
					{			
						window.parent.$("#Loading").css("display","");
					},
					success: function(html)
					{
						window.parent.$("#Loading").css("display","none");	
						
						alert(html);
					}
				});*/
			}
        </script>
    </head>
    <body>
    	<div id="excel">
        </div>
    	<input type="hidden" id="Columnas">
		<input type="hidden" id="CamposColumnas">
		<input type="hidden" id="ColumnasFiltros">
		<input type="hidden" id="CamposFiltros">
        
	<div id="COLUMNA">
        	
      <label for="select">Reporte:</label>
      <select name="ID_REP_DIN" id="ID_REP_DIN" onChange="MoscarID_REP_DIN()">
        <option value="0">SELECCIONE...</option>
        <?php 
            $vSQL="SELECT        
                        *
                    FROM            
                        TB_REP_DIN 
                    WHERE 
                        FG_ACTIVO=1";
            
            if($result=$conector->Ejecutar($vSQL))
            {
                while(odbc_fetch_row($result))
                {
                    $ID_REP_DIN=odbc_result($result,'ID_REP_DIN');
                    $NB_REPORTE_DINAMICO=odbc_result($result,'NB_REPORTE_DINAMICO');
        ?> 
        <option value="<?php echo $ID_REP_DIN;?>"><?php echo $NB_REPORTE_DINAMICO;?></option>
        <?php 
                }
            }
            else
            {
                echo $vSQL;
            }
        ?> 
      </select>
			<input name="AgregarColumnas" type="button" id="AgregarColumnas" value="Agregar Columnas" class="button small btnSistema" onClick="AgregarColumnas();" style="display:none"/>
			<input name="AgregarFiltros" type="button" id="AgregarFiltros" value="Agregar Filtros" class="button small btnSistema" onClick="AgregarFiltros();" style="display:none"/>
	</div>
    <p>&nbsp;</p>
    <div id="Filtros" style="width:1100px; height:auto; border:#000000 1px solid; margin:auto; display:none">
    	<input name="VistaPrevia" type="button" id="VistaPrevia" value="Vista Previa" class="button small btnSistema" onClick="VistaPrevia();"/>
    </div>
	<div id="divTABLA" style="display:none">
        	<p>&nbsp;</p>
        	<div id="TITULO" style="font-weight:bold; margin:auto; font-size:20px; width:800px; text-align:center;"></div>
        	<p>&nbsp;</p>
        	<p>&nbsp;</p>
       	  <table id="TABLA" style="margin:auto; width:1100px">
            	<thead>
                </thead>
                <tbody></tbody>
            </table>
        </div>
        <input name="AgregarColumnas" type="button" id="AgregarColumnas" value="prueba" class="button small btnSistema" onClick="recorrer()"/>
    </body>
</html>