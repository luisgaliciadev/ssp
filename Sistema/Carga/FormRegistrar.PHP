<?php
	$Nivel="../../";
	
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$ID=$_GET['ID'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta charset="utf-8">
	</head>
	<body>
		<form id="vForm" class="">
			<div class="row">
				<div class="col-lg-12">
					<div class="form-group">
						<label>Operador:</label>
						<select id="RIF_OPERADOR" name="RIF_OPERADOR" class="form-control" required>
							<option value="" disabled selected>SELECCIONE...</option>
<?php
							$Conector=Conectar2();
							
							echo $vSQL='EXEC web.[SP_LISTADO_BENEF_X_SOLC] '.$ID;

							$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

							$CONEXION=$ResultadoEjecutar["CONEXION"];

							$ERROR=$ResultadoEjecutar["ERROR"];
							$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
							$resultPrin=$ResultadoEjecutar["RESULTADO"];

							if($CONEXION=="SI" and $ERROR=="NO"){
								while(odbc_fetch_row($resultPrin)){
									$COD_TBENEF_OP=odbc_result($resultPrin,"BEN_COD_TIPO_BENEFICIARIO");
									$RIF_OPERADOR=odbc_result($resultPrin,"BEN_RIF_CED");
									$NB_BENEF	= utf8_encode(strtoupper(odbc_result($resultPrin,"NB_BENEF")));
?>
									<option value="<?php echo $COD_TBENEF_OP;?>,<?php echo $RIF_OPERADOR;?>"><?php echo $NB_BENEF;?></option>
<?php
								}
							}else{									
								echo $MSJ_ERROR;
							}

							$Conector->Cerrar();
?>
						</select>
					</div>
					<div class="form-group">
						<label>Carga:</label>
						<select id="ID_CLASIF_TCARGA" name="ID_CLASIF_TCARGA" class="form-control" required>
							<option value="" disabled selected>SELECCIONE...</option>
<?php
							$Conector=Conectar2();

							$vSQL='EXEC web.[SP_LISTADO_CLASIF_CARGA]';

							$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

							$CONEXION=$ResultadoEjecutar["CONEXION"];

							$ERROR=$ResultadoEjecutar["ERROR"];
							$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
							$resultPrin=$ResultadoEjecutar["RESULTADO"];

							if($CONEXION=="SI" and $ERROR=="NO"){
								while(odbc_fetch_row($resultPrin)){
									$ID_CLASIF_TCARGA	= odbc_result($resultPrin,"ID_CLASIF_TCARGA");
									$DS_CLASIF_TCARGA	= utf8_encode(strtoupper(odbc_result($resultPrin,"DS_CLASIF_TCARGA")));
?>
									<option value="<?php echo $ID_CLASIF_TCARGA;?>"><?php echo $DS_CLASIF_TCARGA;?></option>
<?php
								}
							}else{									
								echo $MSJ_ERROR;
							}

							$Conector->Cerrar();
?>
						</select>
					</div>
					<div class="divAdjuntarArchivo" style="display:none;">
						<div class="form-group">
							<label>Diccionarios:</label>
							<button type="button" class="btn btn-success btn-xs" onClick="vModalDiccionario('Diccionario para tipo actividad', 'ID_ACTIV_PORT')" id="DIC_ID_ACTIV_PORT">
								<i class="fa fa-book"></i> 
								<span>Tipo actividad portuaria<span>
							</button> 
							<button type="button" class="btn btn-success btn-xs" onClick="vModalDiccionario('Diccionario para tipo de carga', 'ID_DET_TIPO_CARGA')" id="DIC_ID_DET_TIPO_CARGA">
								<i class="fa fa-book"></i> 
								<span>Tipo de carga<span>
							</button> 
							<button type="button" class="btn btn-success btn-xs" onClick="vModalDiccionario('Diccionario para condicion', 'ID_CONDICION')" id="DIC_ID_CONDICION">
								<i class="fa fa-book"></i> 
								<span>Condicion<span>
							</button> 
							<button type="button" class="btn btn-success btn-xs" onClick="vModalDiccionario('Diccionario para lineas', 'LINEA')" id="DIC_LINEA">
								<i class="fa fa-book"></i> 
								<span>lineas<span>
							</button> 
						</div>
						<div class="form-group">
							<label>Adjuntar archivo:</label>
							<input type="file" accept="xlsx/xls" id="fileExcel" name="fileExcel" required onClick="Cargando(1);"/>
						</div>
					</div>
				</div>
			</div>		
			<div class="row">
				<div class="col-lg-12">
					<footer>     
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" id="btbCancelar">Cancelar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
					</footer>
				</div>
			</div>		
			<div class="row">
				<div class="col-lg-12 divAdjuntarArchivo" id="divTablaPreview" style="display:none; overflow-x: auto; border: 0px solid red;">
				</div>
			</div>				
		</form>

		<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>-->
		<!-- js-xlsx-master -->
		<script src="Includes/Plugins/js-xlsx-master/dist/xlsx.core2.min.js"></script>

		<script>	
			$(document).ready(function(e) {
				Cargando(0);

				$('#vForm').on('submit', function(e){
					e.preventDefault();
					
					onSubmit();
				});
				
				$('#fileExcel').on('change', function(e){
					if ($(this).val().length==0) {
						Cargando(0);
					}
					handleFile(e);
				});
				
				$('#ID_CLASIF_TCARGA').on('change', function(e){
					e.preventDefault();

					limpiarPermitidos();
					
					localStorage.removeItem("parametrosItems");	
					localStorage.removeItem("items");

					if($(this).val()==2){
						$("#DIC_ID_CONDICION").hide();
						$("#DIC_LINEA").hide();
					}else{
						$("#DIC_ID_CONDICION").show();
						$("#DIC_LINEA").show();
					}
					
					$("#nombreBtnDescarga").html("DESCARGAR FORMATO PARA "+$("#ID_CLASIF_TCARGA option:selected").text());

					ScriptItemsPorTipoDeArchivo(this);
				});

				limpiarPermitidos();

				localStorage.removeItem("parametrosItems");	
				localStorage.removeItem("items");
            });

			function limpiarPermitidos(){
				if (jQuery.parseJSON(localStorage.getItem("parametrosItems"))) {
					var parametrosItems = jQuery.parseJSON(localStorage.getItem("parametrosItems"));

					for (var index = 0; index < parametrosItems.length; index++) {
						var parametrosItem	= parametrosItems[index];
						var NOMBRE_CAMPO	= parametrosItem["DATA"]["NOMBRE_CAMPO"];	

						if (jQuery.parseJSON(localStorage.getItem("PERMITIDOS_"+NOMBRE_CAMPO))) {
							localStorage.removeItem("PERMITIDOS_"+NOMBRE_CAMPO);
						}																
					}					
				}
			}

			function vModalDiccionario(titulo, diccionario)
			{
				if (jQuery.parseJSON(localStorage.getItem("parametrosItems"))) {
					var parametrosItems = jQuery.parseJSON(localStorage.getItem("parametrosItems"));

					for (var index = 0; index < parametrosItems.length; index++) {
						var parametrosItem	= parametrosItems[index];
						var NOMBRE_CAMPO	= parametrosItem["DATA"]["NOMBRE_CAMPO"];	

						if (jQuery.parseJSON(localStorage.getItem("PERMITIDOS_"+NOMBRE_CAMPO)) && diccionario==NOMBRE_CAMPO) {
							var registros = jQuery.parseJSON(localStorage.getItem("PERMITIDOS_"+NOMBRE_CAMPO));
							break;
						}																
					}					
				}

				var cantRegistros 	= registros.length;
				var tabla 			= '';

				tabla += 	'<table class="table table-bordered table-hover table-striped" role="grid" id="tablaDiccionario">';						
				tabla +=		'<thead>';
				tabla +=			'<tr>';
				tabla +=				'<th>Valores permitidos</th>';
				tabla +=				'<th>Valores permitidos</th>';
				tabla +=				'<th>Valores permitidos</th>';
				tabla +=				'<th>Valores permitidos</th>';
				tabla +=			'</tr>';
				tabla +=		'</thead>';
				tabla +=		'<tbody>';
					
				for (var i = 0; i < cantRegistros; i++) {									
					tabla +=		'<tr>';
					
					for (var j = i; j < i+4; j++) {	
						if (registros[j]==undefined) {
							tabla +=	"<td></td>";							
						} else {
							tabla +=	"<td>"+registros[j]+"</td>";
						}
					}

					i = j-1;
					
					tabla +=		'</tr>';
				}
				
				tabla +=		'</tbody>';
				tabla += 	'</table>';

				if (cantRegistros) {
					$("#vModalContenidoDiccionario").html(tabla);
	
					$('#tablaDiccionario').DataTable();

					$("#vModalTituloDiccionario").html(titulo);
					$("#vModalDiccionario").modal();
				} else {
					window.parent.MostrarMensaje("Rojo", "Disculpe, ocurri&oacute; un error.");
				}
			}
			
			function onSubmit(){
				var arrayOPERADOR	= $("#RIF_OPERADOR").val().trim().split(",");
				
				var	ID					= <?php echo $ID;?>;
				var	COD_TBENEF_OP		= arrayOPERADOR[0];
				var	RIF_OPERADOR		= arrayOPERADOR[1];
				var	ID_CLASIF_TCARGA	= $("#ID_CLASIF_TCARGA").val().trim();
					
				$.ajax({
					type: "POST",
					dataType:"html",
					url: "Sistema/Carga/ScriptRegistrar.PHP",			
					data: {
						'ID' 				: ID,
						'RIF_OPERADOR' 		: RIF_OPERADOR,
						'COD_TBENEF_OP' 	: COD_TBENEF_OP,
						'ID_CLASIF_TCARGA' 	: ID_CLASIF_TCARGA,
						'parametrosItems'	: localStorage.getItem("parametrosItems"),
						'items'				: localStorage.getItem("items")
					},
					beforeSend: function(){
						Cargando(1);
					},												
					cache: false,			
					success: function(Resultado){						
						if(window.parent.ValidarConexionError(Resultado)==1){
							
							Arreglo=jQuery.parseJSON(Resultado);

							localStorage.removeItem("parametrosItems");	
							localStorage.removeItem("items");
							
							window.parent.FiltroConsulta(1);

							if (Arreglo["EXISTEN"]) {	
								var existen = Arreglo["EXISTEN"].split(",");

								if (existen.length==parseInt(Arreglo["FILAS"])) {
									window.parent.MostrarMensaje("Rojo", "Disculpe, todas las cargas contenidas en el excel se encuentran registradas.");
									for (var index = 0; index < existen.length; index++) {
										$("#filaTabla"+existen[index]+">td").addClass("bg-danger");									
									}
								} else {
									window.parent.MostrarMensaje("Rojo", "Disculpe, algunas cargas contenidas en el excel se encuentran registradas.");
									for (var index = 0; index < existen.length; index++) {
										$("#filaTabla"+existen[index]+">td").addClass("bg-danger");									
									}
								}
							}
							
							if (Arreglo["FILAS_DETALLES"]) {
								window.parent.MostrarMensaje("Rojo", "Disculpe, algunas cargas contenidas en el excel tienen campos errados.");
									
								var filasDetalle = Arreglo["FILAS_DETALLES"];
								
								for (var index = 0; index < filasDetalle.length; index++) {
									var fila = filasDetalle[index].FILA;
									var orden = filasDetalle[index].ORDEN-1;
									
									$("#filaTabla"+fila+"").find("td").eq(orden).css("border","2px solid red");										
								}
							} else {
								window.parent.MostrarMensaje("Verde", "Operaci&oacute;n realizada exit&oacute;samente.");

								$("#btbCancelar").click();
							}
							
							if (Arreglo["EXISTEN"] || Arreglo["FILAS_DETALLES"]) {
							} else {
								window.parent.MostrarMensaje("Verde", "Operaci&oacute;n realizada exit&oacute;samente.");

								$("#btbCancelar").click();
							}
						}
					}						
				});
			}
			
			function ScriptItemsPorTipoDeArchivo(Obj){
				var	ID_CLASIF_TCARGA=$(Obj).val().trim();
								
				parametros="&ID_CLASIF_TCARGA="+ID_CLASIF_TCARGA;
					
				$.ajax({
					type: "GET",
					dataType:"html",
					url: "Sistema/Carga/ScriptItemsPorTipoDeArchivo.PHP",			
					data: parametros,	
					beforeSend: function(){
						Cargando(1);
					},												
					cache: false,			
					success: function(Resultado){
						if(window.parent.ValidarConexionError(Resultado)==1){
							Cargando(0);
							
							Arreglo=jQuery.parseJSON(Resultado);
							
							if(Arreglo["ITEMS"]){	
								localStorage.setItem("parametrosItems", JSON.stringify(Arreglo["ITEMS"]));

								var parametrosItems = Arreglo["ITEMS"];

								for (var index = 0; index < parametrosItems.length; index++) {
									var parametrosItem	= parametrosItems[index];
									var NOMBRE_CAMPO	= parametrosItem["DATA"]["NOMBRE_CAMPO"];	

									if (Arreglo["PERMITIDOS_"+NOMBRE_CAMPO]) {
										localStorage.setItem("PERMITIDOS_"+NOMBRE_CAMPO, JSON.stringify(Arreglo["PERMITIDOS_"+NOMBRE_CAMPO]));	
									}																
								}
								
								$(".divAdjuntarArchivo").show();
							}
							else{
								window.parent.MostrarMensaje("Rojo", "Esta carga no posee parametrizaci&oacute;n del archivo excel.");
								
								localStorage.removeItem("parametrosItems");	
								localStorage.removeItem("items");
								
								$("#divTablaPreview").html('');
								
								$(".divAdjuntarArchivo").hide();
							}
						}
					}						
				});
			}
			
			function handleFile(e) {
			 	//Get the files from Upload control
				var files = e.target.files;
				var i, f;
			 	//Loop through files
				for (i = 0, f = files[i]; i != files.length; ++i) {
					
					var reader = new FileReader();
					var name = f.name;
					reader.onload = function (e) {

						var result;
						
						var data 			= e.target.result;
						
						var workbook 		= XLSX.read(data, { type: 'binary' });
						
						var headers = [];
						var sheet = workbook.Sheets["LISTADO"];
						var range = XLSX.utils.decode_range(sheet['!ref']);
						var C, R = range.s.r;
						/* start in the first row */
						/* walk every column in the range */
						for (C = range.s.c; C <= range.e.c; ++C) {
							var cell = sheet[XLSX.utils.encode_cell({c: C, r: R})];
							/* find the cell in the first row */

							var hdr = "UNKNOWN " + C; // <-- replace with your desired default
							if (cell && cell.t) {
								hdr = XLSX.utils.format_cell(cell);
							}
							headers.push(hdr);
						}
						// For each sheets, convert to json.
						var roa = XLSX.utils.sheet_to_json(workbook.Sheets["LISTADO"]);
						
						if (roa.length > 0) {
							roa.forEach(function (row) {
								// Set empty cell to ''.
								headers.forEach(function (hd) {
									if (row[hd] == undefined) {
										row[hd] = '';
									}
								});
							});
							
							rows = roa;
						
							//console.log(headers);
							//console.log(rows);
							
							contruirTabla(headers, rows);

							Cargando(0);
						}
					};
					
					reader.readAsArrayBuffer(f);
				}
			}
			
			function contruirTabla(header, rows)
			{
				//console.log(rows);
				
				if(rows.length>0){					
					var tabla = '';
					
					tabla += '<table class="table table-bordered table-hover table-striped" role="grid" id="tablaPreview">';						
					tabla +=	'<thead>';
					tabla +=		'<tr>';

					for (var col in header) {
						tabla += 		"<th>"+header[col]+"</th>";
					}
					
					tabla +=		'</tr>';
					tabla +=	'</thead>';
					tabla +=	'<tbody>';
					
					var arregloFilas 	= 	[];
					
					for (var row in rows) {					
						var arregloColumnas = [];
						
						tabla +=	'<tr id="filaTabla'+(parseInt(row)+1)+'">';
						
						for (var col in header) {
							var valor = $.trim(rows[row][header[col]]).toUpperCase();

							var res = campoNoValido(col, valor);
							
							if(res==1){
								$("#divTablaPreview").html('');

								alert("Campo no v&aacute;lido en la fila: "+(parseInt(row)+2)+", columna: "+(header[col])+", el valor:"+valor);
								
								window.parent.MostrarMensaje("Rojo", "El archivo debe contener datos correctos.");
								
								$("#fileExcel").val('');

								localStorage.removeItem("items");

								Cargando(0);
								
								return;
							}else
							if(res==2){
								$("#divTablaPreview").html('');

								alert("Campo no v&aacute;lido en la fila: "+(parseInt(row)+2)+", columna: "+(header[col])+", el valor: "+valor+" no se encuentra registrado, ver diccionario ");
								
								window.parent.MostrarMensaje("Rojo", "El archivo debe contener datos correctos.");
								
								$("#fileExcel").val('');
								
								localStorage.removeItem("items");
								
								return;
							}
							
							tabla +=	"<td>"+valor+"</td>";
							
							arregloColumnas[col] = valor;
						}
						
						tabla +=	'</tr>';
						
						arregloFilas[row] = arregloColumnas;
					}
					
					tabla +=	'</tbody>';
					/*tabla +=	'<tfoot>';
					tabla +=		'<tr>';

					for (var col in header) {
						tabla += 		"<th>"+header[col]+"</th>";
					}
					
					tabla +=		'</tr>';
					tabla +=	'</tfoot>';*/
					tabla += '</table>';
					
					localStorage.setItem("items", JSON.stringify(arregloFilas));

					//console.log(tabla);

					$("#divTablaPreview").html(tabla);	
				
					$('#tablaPreview').DataTable(
					{
						"paging": true,
						"lengthChange": true,
						"searching": true,
						"ordering": true,
						"info": true,
						"autoWidth": true,
						"language":
						{
							"sProcessing":     "Procesando...",
							"sLengthMenu":     "Mostrar _MENU_ registros",
							"sZeroRecords":    "No se encontraron resultados",
							"sEmptyTable":     "Ningún dato disponible en esta tabla",
							"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
							"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
							"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
							"sInfoPostFix":    "",
							"sSearch":         "Buscar:",
							"sUrl":            "",
							"sInfoThousands":  ",",
							"sLoadingRecords": "Cargando...",
							"oPaginate": {
								"sFirst":    "Primero",
								"sLast":     "Último",
								"sNext":     "Siguiente",
								"sPrevious": "Anterior"
							},
							"oAria": {
								"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
								"sSortDescending": ": Activar para ordenar la columna de manera descendente"
							}
						},
						"aaSorting": [[0,"asc"]]
					});
				}else{
					$('#fileExcel').val('');
					window.parent.MostrarMensaje("Rojo", "El archivo excel seleccionado no contiene cargas.");
				}
			}
			
			function campoNoValido(orden, valor) {				
				var parametrosItems			= jQuery.parseJSON(localStorage.getItem("parametrosItems"));				
				var parametrosItem			= parametrosItems[orden];
				var NOMBRE_CAMPO			= parametrosItem["DATA"]["NOMBRE_CAMPO"];
				var TIPO_CAMPO_EXCEL		= parametrosItem["DATA"]["TIPO_CAMPO_EXCEL"];
				var MIN						= parametrosItem["DATA"]["MIN"];
				var respuesta				= 0;
				
				switch(true){
					case TIPO_CAMPO_EXCEL == 'NUMERIC':						
						if(valor.length < MIN || isNaN(valor)){
							respuesta = 1;
						}		
						else{
							if(jQuery.parseJSON(localStorage.getItem("PERMITIDOS_"+NOMBRE_CAMPO))){
								if(jQuery.parseJSON(localStorage.getItem("PERMITIDOS_"+NOMBRE_CAMPO)).indexOf(valor)<0){
									respuesta = 2;
								}
							}					
						}
					break;
						
					case TIPO_CAMPO_EXCEL == 'VARCHAR':
						if(valor.length < MIN){
							respuesta = 1;
						}	
						else{
							if(jQuery.parseJSON(localStorage.getItem("PERMITIDOS_"+NOMBRE_CAMPO))){
								if(jQuery.parseJSON(localStorage.getItem("PERMITIDOS_"+NOMBRE_CAMPO)).indexOf(valor)<0){
									respuesta = 2;
								}
							}
						}
					break;
				}
				
				return respuesta;
			}
        </script>
	</body>
</html>