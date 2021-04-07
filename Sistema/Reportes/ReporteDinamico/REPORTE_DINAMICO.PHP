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
			var ArrayColumnasID_REP_DIN_CAMPOS=[];
			var ArrayColumnasNB_CAMPO=[];
			var ArrayColumnasNB_CAMPO_SQL=[];
			var ArrayColumnasTIPO_CAMPO_HTML=[];
			var ArrayColumnasSELECT_FLAG=[];
			
			
			var ArrayFiltrosID_REP_DIN_CAMPOS=[];
			var ArrayFiltrosNB_CAMPO=[];
			var ArrayFiltrosNB_CAMPO_SQL=[];
			var ArrayFiltrosTIPO_CAMPO_HTML=[];	
			var ArrayFiltrosID_CAMPO_SELECT=[];	
			
			function MoscarID_REP_DIN()
			{	
				ArrayColumnasID_REP_DIN_CAMPOS=[];		
				ArrayColumnasNB_CAMPO=[];
				ArrayColumnasNB_CAMPO_SQL=[];
				ArrayColumnasTIPO_CAMPO_HTML=[];
				ArrayColumnasSELECT_FLAG=[];
				
				ArrayFiltrosID_REP_DIN_CAMPOS=[];
				ArrayFiltrosNB_CAMPO=[];
				ArrayFiltrosNB_CAMPO_SQL=[];
				ArrayFiltrosTIPO_CAMPO_HTML=[];	
				ArrayFiltrosID_CAMPO_SELECT=[];
				
				$("#Filtros").html('<input name="VistaPrevia" type="button" id="VistaPrevia" value="Vista Previa" class="button small btnSistema" onClick="VistaPrevia();"/>');	
				
				$("#TABLA thead").html("");
				$("#TABLA tbody").html("");
				
				ID_REP_DIN=parseInt($("#ID_REP_DIN").val());		
				
				if(ID_REP_DIN)
				{
					$("#AgregarColumnas").show();
					
					$("#AgregarFiltros").hide();
					
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
				
				ID_REP_DIN_CAMPOS="&ID_REP_DIN_CAMPOS="+ArrayColumnasID_REP_DIN_CAMPOS.toString();
				Columnas="&Columnas="+ArrayColumnasNB_CAMPO.toString();
				CamposColumnas="&CamposColumnas="+ArrayColumnasNB_CAMPO_SQL.toString();
				
				Parametros=ID_REP_DIN+Columnas+CamposColumnas+ID_REP_DIN_CAMPOS;
				
				if(ID_REP_DIN=="&ID_REP_DIN=0")
				{
					window.parent.toastr.error("Disculpe, debe seleccionar el Reporte");
					return;
				}
				
				parent.AbrirVentana('AgregarColumnas', 'Agregar Columnas', 'Sistema/Reportes/ReporteDinamico/COLUMNAS.php', 'IdVentanaP=<?php echo "iframe".$IdVentana;?>'+Parametros, 540, 600, 1, 1, 1, 1, 1);
			}
			
			function AgregarColumnasD()
			{
				$("#TABLA thead").html("");
				$("#TABLA tbody").html("");
				
				CadColumnas="";
				
				for (var Ite in ArrayColumnasNB_CAMPO) 
				{
					CadColumnas+="<th>"+ArrayColumnasNB_CAMPO[Ite]+"</th>";
				}
				
				$("#TABLA thead").html(CadColumnas);
				
				if(ArrayColumnasNB_CAMPO.length)
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
				ColumnasFiltros="&ColumnasFiltros="+ArrayFiltrosNB_CAMPO.toString();
				CamposFiltros="&CamposFiltros="+ArrayFiltrosNB_CAMPO_SQL.toString();
				ID_REP_DIN_CAMPOS="&ID_REP_DIN_CAMPOS="+ArrayFiltrosID_REP_DIN_CAMPOS.toString();
				
				Parametros=ID_REP_DIN+ColumnasFiltros+CamposFiltros+ID_REP_DIN_CAMPOS;
				
				if(ID_REP_DIN=="&ID_REP_DIN=0")
				{
					window.parent.toastr.error("Disculpe, debe seleccionar el Reporte");
					return;
				}
				
				parent.AbrirVentana('AgregarFiltros', 'Agregar Filtros', 'Sistema/Reportes/ReporteDinamico/FILTROS.php', 'IdVentanaP=<?php echo "iframe".$IdVentana;?>'+Parametros, 540, 600, 1, 1, 1, 1, 1);
			}
			
			function AgregarColumnasFiltrosD()
			{
				$("#TABLA tbody").html("");
				
				CadFiltros="";
				
				for (var Ite in ArrayFiltrosID_REP_DIN_CAMPOS) 
				{
					CadFiltros+=IncluirFiltro(ArrayFiltrosID_REP_DIN_CAMPOS[Ite], ArrayFiltrosTIPO_CAMPO_HTML[Ite], ArrayFiltrosNB_CAMPO[Ite], ArrayFiltrosNB_CAMPO_SQL[Ite]);
				}
				
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
									  '<td><input type="text" id="Fil'+ID_REP_DIN_CAMPOS+'" name="Fil'+ID_REP_DIN_CAMPOS+'"></td>'+
									'</tr>'+
								  '</tbody>'+
							  '</table>';
					break;
					
					case "SELECT":
					
						ID_REP_DIN_CAMPOSa="ID_REP_DIN_CAMPOS="+ID_REP_DIN_CAMPOS;
						
						Parametros=ID_REP_DIN_CAMPOSa;
						
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
									  	'<select id="Fil'+ID_REP_DIN_CAMPOS+'" name="Fil'+ID_REP_DIN_CAMPOS+'">'+
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
				Columnas="&Columnas="+ArrayColumnasNB_CAMPO.toString();
				CamposColumnas="&CamposColumnas="+ArrayColumnasNB_CAMPO_SQL.toString();
				sTIPO_CAMPO_HTML="&TIPO_CAMPO_HTML="+ArrayColumnasTIPO_CAMPO_HTML.toString();
				SELECT_FLAG="&SELECT_FLAG="+ArrayColumnasSELECT_FLAG.toString();
				
				if(ID_REP_DIN=="ID_REP_DIN=0")
				{
					window.parent.toastr.error("Disculpe, debe seleccionar el Reporte");
					return;
				}
				
				CadBusqueda="";
				
				for (var Ite in ArrayFiltrosID_REP_DIN_CAMPOS) 
				{
					NB_CAMPO="&NB_CAMPO"+Ite+"="+ArrayFiltrosNB_CAMPO[Ite];
					NB_CAMPO_SQL="&NB_CAMPO_SQL"+Ite+"="+ArrayFiltrosNB_CAMPO_SQL[Ite];
					TIPO_CAMPO_HTML="&TIPO_CAMPO_HTML"+Ite+"="+ArrayFiltrosTIPO_CAMPO_HTML[Ite];
					ID_CAMPO_SELECT="&ID_CAMPO_SELECT"+Ite+"="+ArrayFiltrosID_CAMPO_SELECT[Ite];
					VALOR="&VALOR"+Ite+"="+$("#Fil"+ArrayFiltrosID_REP_DIN_CAMPOS[Ite]).val();
					
					CadBusqueda+=NB_CAMPO+NB_CAMPO_SQL+TIPO_CAMPO_HTML+ID_CAMPO_SELECT+VALOR;
				}
				
				Parametros=ID_REP_DIN+Columnas+CamposColumnas+sTIPO_CAMPO_HTML+SELECT_FLAG+CadBusqueda;
				
				//alert(CadBusqueda);
				
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
				Columnas="&Columnas="+ArrayColumnasNB_CAMPO.toString();
				CamposColumnas="&CamposColumnas="+ArrayColumnasNB_CAMPO_SQL.toString();
				sTIPO_CAMPO_HTML="&TIPO_CAMPO_HTML="+ArrayColumnasTIPO_CAMPO_HTML.toString();
				SELECT_FLAG="&SELECT_FLAG="+ArrayColumnasSELECT_FLAG.toString();
				
				if(ID_REP_DIN=="ID_REP_DIN=0")
				{
					window.parent.toastr.error("Disculpe, debe seleccionar el Reporte");
					return;
				}
				
				CadBusqueda="";
				
				for (var Ite in ArrayFiltrosID_REP_DIN_CAMPOS) 
				{
					NB_CAMPO="&NB_CAMPO"+Ite+"="+ArrayFiltrosNB_CAMPO[Ite];
					NB_CAMPO_SQL="&NB_CAMPO_SQL"+Ite+"="+ArrayFiltrosNB_CAMPO_SQL[Ite];
					TIPO_CAMPO_HTML="&TIPO_CAMPO_HTML"+Ite+"="+ArrayFiltrosTIPO_CAMPO_HTML[Ite];
					ID_CAMPO_SELECT="&ID_CAMPO_SELECT"+Ite+"="+ArrayFiltrosID_CAMPO_SELECT[Ite];
					VALOR="&VALOR"+Ite+"="+$("#Fil"+ArrayFiltrosID_REP_DIN_CAMPOS[Ite]).val();
					
					CadBusqueda+=NB_CAMPO+NB_CAMPO_SQL+TIPO_CAMPO_HTML+ID_CAMPO_SELECT+VALOR;
				}
				
				TituloReporte="&TituloReporte="+$("#ID_REP_DIN option:selected").text()
				
				Parametros=ID_REP_DIN+Columnas+CamposColumnas+sTIPO_CAMPO_HTML+SELECT_FLAG+CadBusqueda+TituloReporte;
        
				VenImp=window.open('REPORTE_DINAMICO_CONSULTA_EXCEL.php?'+Parametros,'popimpr');
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
      <select name="ID_REP_DIN" id="ID_REP_DIN" onChange="MoscarID_REP_DIN()" style="width:500px;">
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
    </body>
</html>