<?php 
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
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
        <div class="modal-dialog modal-lg">
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
						<div id="FiltroConsulta">
						</div> 
                    </div>
                </div>
            </div>
		</div>
	</div>
     
		<script>		
			$(document).ready(function(e) 
			{
				window.parent.parent.Cargando(0);

				FiltroConsulta(1);
            });

			function FiltroConsulta(PagActual)
			{				
				var Parametros="";
				
				$.ajax(
				{
					type: "POST",
					dataType:"html",
					url: "Sistema/Seguridad/Usuario/FiltroConsulta.PHP",			
					data: Parametros,
					async:false,	
					beforeSend: function() 
					{
						window.parent.parent.Cargando(1);
					},												
					cache: false,			
					success: function(Resultado)
					{
						window.parent.parent.Cargando(0);
						$("#FiltroConsulta").html(Resultado);

						//$('#tablaUsuarios').DataTable();						
				
						$('#tablaUsuarios').DataTable(
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
							"aaSorting":[[0,"asc"]]
						});
					}						
				});
			}
			
			function callFormRegistrar(){
				window.parent.parent.Cargando(1);
				
				vModal('Sistema/Seguridad/Usuario/formRegistrar.php', 'Registrar usuario');
			}
			
			function callFormModificar(ID){
				window.parent.parent.Cargando(1);

				vModal('Sistema/Seguridad/Usuario/formModificar.php?&ID='+ID, 'Modificar usuario');
			}	

			function anular(ID) {
				swal({
					title: "¿Estas seguro?",
					text: "Estas seguro de anular este usuario!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Aceptar",
					cancelButtonText: "Cancelar",
					closeOnConfirm: true
				}, function () {
					var parametros = '&ID='+ID;
						
					$.ajax({
						type: "POST",
						dataType:"html",
						url: "Sistema/Seguridad/Usuario/ScriptAnular.php",			
						data: parametros,
						beforeSend: function(){
							window.parent.parent.Cargando(1);
						},							
						success: function(Resultado){
							if(window.parent.ValidarConexionError(Resultado)==1){							
								Arreglo=jQuery.parseJSON(Resultado);

								FiltroConsulta(1);

								window.parent.MostrarMensaje("Verde", "Operacion realizada exitosamente.");
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
        </script>
	</body>
</html>
