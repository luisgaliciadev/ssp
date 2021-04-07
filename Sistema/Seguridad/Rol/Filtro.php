<?php 
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);

	$vNB_MODULO=$_POST["vNB_MODULO"];
	
	$Nivel="";
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
            
    <input type="hidden" id="Orden" value="NB_ROL"/>
    <input type="hidden" id="AscDesc" value="ASC"/>
    
    <!-- Content Header (Page header) -->
    
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2><?php echo $vNB_MODULO;?></h2>
			<?php echo construirBreadcrumbs(substr($_POST["vID_MODULO"], 6, strlen($_POST["vID_MODULO"])));?>
		</div>
	</div>  
	
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
					<div class="ibox-content">
						<div class="box-header with-border">
							<div class="form-inline" class="row">
								<div class="col-sm-6">
									<div class="form-group">
										<label class="control-label">Ver </label>
										<select id="NroReg" class="form-control" onChange="FiltroConsulta(1)">
											<option value="10">10</option>
											<option value="25">25</option>
											<option value="50">50</option>
											<option value="100">100</option>
										</select>
										<label class="control-label"> registros</label>
									</div>
								</div>
								<div class="col-sm-6 text-right">
									<div class="form-group">
										<label>Buscar: </label>
										<input type="text" id="txtBuscar" class="form-control" placeholder="Buscar..." onKeyUp="EvaluarTeclaFiltro(event)">

										<button class="btn btn-ms btn-primary" id="btnFiltroBuscar" onClick="FiltroConsulta(1); $('#btnFiltroBuscar').hide(); $('#btnFiltroQuitar').show(); $('#txtBuscar').attr('disabled', true);">
											<i class="fa fa-search"></i>
										</button>

										<button class="btn btn-ms btn-danger" id="btnFiltroQuitar" onClick="$('#btnFiltroQuitar').hide(); $('#btnFiltroBuscar').show(); $('#txtBuscar').val(''); $('#txtBuscar').focus(); $('#txtBuscar').attr('disabled', false); FiltroConsulta(1);" style="display:none;">
											<i class="fa fa-minus-circle"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
						<div id="FiltroConsulta">
						</div>
                    </div>
                </div>
            </div>
		</div>
	</div>
    
    <!-- Modal -->
    <div class="modal fade" id="vModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
        <script>
			$(document).ready(function(e) 
			{
                FiltroConsulta(1);
            });		
			
			function FiltroConsulta(PagActual)
			{				
				var PagActual= "PagActual="+PagActual;
				var txtBuscar= "&txtBuscar="+$("#txtBuscar").val();
				var NroReg= "&NroReg="+$("#NroReg").val();
				var Orden= "&Orden="+$("#Orden").val();
				var AscDesc= "&AscDesc="+$("#AscDesc").val();
				
				var parametros=PagActual+txtBuscar+NroReg+Orden+AscDesc;
				
				$.ajax(
				{
					url: 'Sistema/Seguridad/Rol/FiltroConsulta.php',
					data: parametros,
					type: 'post',
					beforeSend: function() 
					{			
						window.parent.parent.Cargando(1);
					},
					success: function(Resultado)
					{
						//alert(Resultado);
						
						window.parent.parent.Cargando(0);
						
						if(Resultado != "")
						{
							$("#FiltroConsulta").html(Resultado)
						}
						else
						{
							window.parent.MostrarMensaje("Rojo", "No retorno ningun valor!");
						}
					}
				});		
			}	
			
			function Eliminar(ID)
			{
				var ID="ID="+ID;
				swal({
					title: "¿Estas seguro?",
					text: "Estas seguro de anular este rol!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Aceptar",
					cancelButtonText: "Cancelar",
					closeOnConfirm: true
				}, function () {
					
					$.ajax({
						url: "Sistema/Seguridad/Rol/ScriptEliminar.php",
						data: ID,
						type: 'post',
						beforeSend: function() 
						{			
							window.parent.parent.Cargando(1);
						},
						success: function(Resultado)
						{
							//alert(Resultado);	
							
							if(window.parent.ValidarConexionError(Resultado)==1)
							{			
								FiltroConsulta(1);
									
								window.parent.MostrarMensaje("Verde", "Operacion realizada exitosamente!");
							}
						}
					});			
				});
			}	
			
			function vModal(URl, Titulo)
			{
				$("#vModalTitulo").html(Titulo);
				$("#vModalContenido").load(URl);
				$("#vModal").modal();
			}
	
			function EvaluarTeclaFiltro(e)
			{
				var key=e.keyCode || e.which;
				
				if (key==13)
				{
					FiltroConsulta(1);
					$('#btnFiltroBuscar').hide(); 
					$('#btnFiltroQuitar').show(); 
					$('#txtBuscar').attr('disabled', true);
				}
				
				e.preventDefault();	
			}	
	
			function Ordenar(ID)
			{
				ID=ID.substring(2, ID.length);
				
				if($('#Orden').val()==ID && $('#AscDesc').val()=='DESC')
				{
					$('#AscDesc').val('ASC');
				}
				else
				{
					if($('#Orden').val()==ID && $('#AscDesc').val()=='ASC')
					{						
						$('#AscDesc').val('DESC');
					}
					else
					{
						$('#AscDesc').val('ASC');
					}
				}
				
				$('#Orden').val(ID);
				
				FiltroConsulta(1);
			}
			
			function PaginaSiguiente(Pagina)
			{
				var Pagina= parseInt(Pagina)+1;
				window.parent.FiltroConsulta(Pagina);
			}
			
			function PaginaAtras(Pagina)
			{
				var Pagina= parseInt(Pagina)-1;
				window.parent.FiltroConsulta(Pagina);
			}
			
			function PrimeraPagina()
			{
				window.parent.FiltroConsulta(1);
			}
			
			function ultimaPagina(Pagina)
			{
				var Pagina= parseInt(Pagina);
				window.parent.FiltroConsulta(Pagina);
			}
			
			function AsignarPagina(Pagina)
			{
				window.parent.FiltroConsulta(Pagina);
			}
        </script>
    </body>
</html>