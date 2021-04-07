<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	$RIF=$_SESSION[$SiglasSistema."RIF"];
	
	ValidarSesion($Nivel);
	
	$vNB_MODULO=$_POST["vNB_MODULO"];	
?>
<!DOCTYPE html>
<html >
	<head>
        <script>	
        </script>
	</head>
	<body>	
            
    <input type="hidden" id="Orden" value="ID_ORDEN_PESAJE"/>
    <input type="hidden" id="AscDesc" value="DESC"/>
    
    <!-- Content Header (Page header) -->
    
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2><?php echo $vNB_MODULO;?></h2>
			<?php echo construirBreadcrumbs(substr($_POST["vID_MODULO"], 6, strlen($_POST["vID_MODULO"])));?>
		</div>
	</div>   
    
    <!-- Modal -->
    <div class="modal fade" id="vModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:95% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="vModalTitulo"></h4>
                </div>
                <div class="modal-body" id="vModalContenido">
                </div>
            </div>
        </div>
    </div>	
    
    <!-- Modal2 -->
    <div class="modal fade" id="vModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="vModalTitulo2"></h4>
                </div>
                <div class="modal-body" id="vModalContenido2">
                </div>
            </div>
        </div>
    </div>	
    
    <!-- Modal Diccionario -->
    <div class="modal fade" id="vModalDiccionario" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width:95% !important;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="vModalTituloDiccionario"></h4>
                </div>
                <div class="modal-body" id="vModalContenidoDiccionario">
                </div>
            </div>
        </div>
    </div>	
    
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
					<div class="ibox-content">	
						<div class="form-group">
							<label>Descargar formatos:</label>  
							<button type="button" class="btn btn-success btn-xs" onClick="descargarFormato(1)">
								<i class="fa fa-download"></i> 
								<span>Contenedores<span>
							</button>  
							<button type="button" class="btn btn-success btn-xs" onClick="descargarFormato(8)">
								<i class="fa fa-download"></i> 
								<span>General y RORO<span>
							</button>
							<button type="button" class="btn btn-success btn-xs" onClick="descargarFormato(2)">
								<i class="fa fa-download"></i> 
								<span>Granel<span>
							</button>
							<button type="button" class="btn btn-success btn-xs" onClick="descargarFormato(10)">
								<i class="fa fa-download"></i> 
								<span>Instructivo Declaración de Carga<span>
							</button>	
						</div>	
						<div class="form-group">
							<label >Solicitud de muelle:</label>
							<select name="ID_SOLI_COM" id="ID_SOLI_COM" class="form-control">
								<option value="0" disabled selected>Seleccione Buque...</option>
			<?php
								$vSQL='EXEC web.SP_CONSULTA_X_IDSM '.$RIF;

								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

								$CONEXION=$ResultadoEjecutar["CONEXION"];

								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$resultPrin=$ResultadoEjecutar["RESULTADO"];

								if($CONEXION=="SI" and $ERROR=="NO")
								{
									while (odbc_fetch_row($resultPrin))  
									{
										$ID=odbc_result($resultPrin,"ID");
										$DES_SM=utf8_encode(odbc_result($resultPrin,"DES_SM"));
			?>
										<option value="<?php echo $ID;?>"><?php echo $DES_SM;?></option>
			<?php
									}
								}
								else
								{									
									echo $MSJ_ERROR;
								}

								$Conector->Cerrar();
			?>
							</select>	
						</div>	
						<div class="form-group" style="width : 100%; overflow-x: auto;" id="divTablaSolicitudes">							
						</div>
                    </div>
                </div>
            </div>
		</div>
	</div>

     
		<script>		
			$(document).ready(function(e) 
			{
				Cargando(0);

				$('#ID_SOLI_COM').change(function(event) 
				{
					Cargando(1);
					setTimeout(function() {
						FiltroConsulta(1);
					}, 1);
				});
            });

			function FiltroConsulta(a)
			{
				ID_SOLI_COM=$("#ID_SOLI_COM").val();

				var Parametros="ID="+ID_SOLI_COM;
				
				$.ajax(
				{
					type: "POST",
					dataType:"html",
					url: "Sistema/Carga/FiltroConsulta.PHP",			
					data: Parametros,
					async:false,	
					beforeSend: function() 
					{
						Cargando(1);
					},												
					cache: false,			
					success: function(Resultado)
					{
						if(ValidarConexionError(Resultado)==1){
							Arreglo=jQuery.parseJSON(Resultado);

							var btnAnular = `
								<div class="col-lg-12 text-center">
									<p>
										<button type="button" class="btn btn-danger btn-sm" onClick="anularTodas()">
											<i class="fa fa-times"></i>
											<span>Anular toda la carga<span>
										</button>
									</p>
								</div>
							`;

							var tabla = `
								<table class="table table-bordered table-hover col-lg-12" role="grid" id="tablaSolicitudes">
									<thead>
										<tr>
											<th class="text-center">
												<button type="button" class="btn btn-success btn-xs" onClick="callFormRegistrar();" data-placement="top" data-toggle="tooltip" data-original-title="Agregar" style=" cursor: pointer;">
													<i class="fa fa-plus"></i>
													<span>Agregar<span>
												</button>
											</th>
											<th>SOLICITUD</th>				
											<th>OPERADOR</th>
											<th>RIF</th>
											<th>ACTIVIDAD</th>
											<th>BL</th>
											<th>TIPO_CARGA</th>
											<th>PELIGROSA</th>
											<th>CARGA</th>
											<th>TAMAÑO</th>
											<th>SIGLAS</th>
											<th>LINEA</th>
											<th>IMO</th>
											<th>CANTIDAD</th>
											<th>PESO</th>
											<th>GOBIERNO</th>
											<th>CONSIGNATARIO</th>
										</tr>
									</thead>
									<tbody>
									</tbody>
								</table>
							`;

							if (Arreglo["REGISTROS"]) {
								var REGISTROS = Arreglo["REGISTROS"];
								
								$('#divTablaSolicitudes').html(btnAnular+tabla);

								$('#tablaSolicitudes').DataTable(
								{
									"data": REGISTROS,
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
									"aaSorting":[[0,"asc"]]
								});
							}else{
								$('#divTablaSolicitudes').html(tabla);
							}
						}							
					}						
				});
			}
			
			function callFormRegistrar(){
				Cargando(1);

				var ID_SOLI_COM=$("#ID_SOLI_COM").val();

				//alert(ID_SOLI_COM);
				
				vModal('Sistema/Carga/FormRegistrar.php?ID='+ID_SOLI_COM, 'Declaración de la Carga');
			}
			
			function callFormModificar(ID_CARGA, ID_CLASIF_TCARGA){
				Cargando(1);

				ID_SOLI_COM=$("#ID_SOLI_COM").val();

				vModal('Sistema/Carga/FormModificar.php?&ID='+ID_SOLI_COM+'&ID_CARGA='+ID_CARGA+'&ID_CLASIF_TCARGA='+ID_CLASIF_TCARGA, 'Modificar Declaración Carga');
			}	
			
			function descargarFormato(op){
				var url = 'http://10.10.30.52/SASPWEB/Downloads/';

				switch (op) {
					case 1:
						url+="FormatoGeneralDefcontenedor.xlsx";
	 				break;
					case 8:
						url+="FormatoGeneralDefCargaSuelta.xlsx";
	 				break;
					case 2:
						url+="FormatoGeneralDefGranel.xlsx";
	 				break;
				}

				window.open(url);
			}	

			function anular(ID_CARGA) {
				swal({
					title: "¿Estas seguro?",
					text: "Estas seguro de anular esta carga!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Aceptar",
					cancelButtonText: "Cancelar",
					closeOnConfirm: true
				}, function () {
					var parametros = '&ID_CARGA='+ID_CARGA;
						
					$.ajax({
						type: "POST",
						dataType:"html",
						url: "Sistema/Carga/ScriptAnular.PHP",			
						data: parametros,
						beforeSend: function(){
							Cargando(1);
						},							
						success: function(Resultado){
							if(ValidarConexionError(Resultado)==1){							
								Arreglo=jQuery.parseJSON(Resultado);

								FiltroConsulta(1);
								
								MostrarMensaje("Verde", "Operacion realizada exit&oacute;samente.");
							}
						}						
					});				
				});
			}	

			function anularTodas() {
				swal({
					title: "¿Estas seguro?",
					text: "Estas seguro de anular toda la carga de esta solicitud!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Aceptar",
					cancelButtonText: "Cancelar",
					closeOnConfirm: true
				}, function () {
					var ID_SOLI_COM=$("#ID_SOLI_COM").val();
					
					var parametros = '&ID='+ID_SOLI_COM;
							
					$.ajax({
						type: "POST",
						dataType:"html",
						url: "Sistema/Carga/ScriptAnularTodas.PHP",
						data: parametros,
						beforeSend: function(){
							Cargando(1);
						},
						success: function(Resultado){
							if(ValidarConexionError(Resultado)==1){
								Arreglo=jQuery.parseJSON(Resultado);

								FiltroConsulta(1);
								
								MostrarMensaje("Verde", "Operacion realizada exit&oacute;samente.");
							}
						}						
					});			
				});
			}
			
			function vModal(URl, Titulo)
			{
				$("#vModalTitulo").html("");
				$("#vModalContenido").html("");
				
				$("#vModalTitulo").html(Titulo);
				$("#vModalContenido").load(URl);
				$("#vModal").modal();
			}				
			
			function vModal2(URl, Titulo)
			{
				Cargando(1);
				
				$("#vModalTitulo2").html("");
				$("#vModalContenido2").html("");
				
				$("#vModalTitulo2").html(Titulo);
				$("#vModalContenido2").load(URl);
				$("#vModal2").modal();
			}
        </script>
	</body>
</html>
