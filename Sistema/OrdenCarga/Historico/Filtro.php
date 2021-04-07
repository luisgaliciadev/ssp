<?php 
	$Nivel="../../../";
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
  		<!-- daterange picker -->
  		<link rel="stylesheet" href="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.css">
        <script>	
        </script>
	</head>
	<body>	
            
    <input type="hidden" id="Orden" value="ID_ORDEN_PESAJE"/>
    <input type="hidden" id="AscDesc" value="DESC"/>
    
    	<!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $vNB_MODULO;?>
        <small>Administrar <?php echo $vNB_MODULO;?></small>
      </h1>
    </section>
    
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
    
    <!-- Modal2 -->
    <div class="modal fade" id="vModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
    
    <!-- Main content -->
    <section class="content">        
      <div class="row">
        <div class="col-md-12 col-md-offset-0">
          <div class="box">
          	<div class="box-header with-border">
                <label style="float:left;">Tipo:</label>
                <select style="float:left; margin-right:20px; height:30px; border: #AFAFAF 1px solid;"name="ID_TIPO_CARGA" id="ID_TIPO_CARGA" onChange="FiltroConsulta(1)">
                    <option value="0" disabled selected>Seleccione Tipo...</option>
                    <option value="3">Granel</option>
                    <option value="1">Contenerizada</option>
                    <option value="2">Carga Suelta</option>
                </select>
                
                <label style="float:left;">FECHA DE:</label>
                <select style="float:left; margin-right:20px; height:30px; border: #AFAFAF 1px solid;"name="TIPO_FECHA" id="TIPO_FECHA" onChange="FiltroConsulta(1)">
                    <option value="0" disabled selected>Seleccione Fecha...</option>
                    <option value="FECHA_CRE">Registro</option>
                    <option value="FECHA_ENTRADA">Entrada</option>
                    <option value="FECHA_SALIDA">Salida</option>
                    <option value="FECHA_ANU">Anulacion</option>
                </select>
                
                <label style="float:left;">Rango de fecha:</label>    
                <div class="input-group" style="width:300px; float:left;">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="RangoFecha">
                </div>
                <!-- /.input group -->
              </div>
            
            <div class="CargaDatos" style=" display:none;">          	
            <div class="box-body">
                <div class="form-inline row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Ver </label>
                            <select id="NroReg" class="form-control" onChange="FiltroConsulta(1)">
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
                
                <div id="FiltroConsulta">
                </div>    
            </div>
            <!-- /.box-body -->
            </div>            
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content --> 
    
    <!-- Modal2 -->
    <div class="modal fade" id="vModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
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
     	
        <!-- date-range-picker -->
        <script src="Sistema/OrdenCarga/Historico/moment.min.js"></script>
        <script src="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.js"></script>
		<script>	
			$(document).ready(function(e) 
			{				
				window.parent.parent.Cargando(0);
				
				//Date range picker
				$('#RangoFecha').daterangepicker(
				{
					"locale": 
					{
						"format": "DD/MM/YYYY",
						"separator": " - ",
						"applyLabel": "Aplicar",
						"cancelLabel": "Cancelar",
						"fromLabel": "Desde",
						"toLabel": "Hasta",
						"customRangeLabel": "Custom",
						"daysOfWeek": [
							"Do",
							"Lu",
							"Ma",
							"Mi",
							"Ju",
							"Vi",
							"Sa"
						],
						"monthNames": [
							"Enero",
							"Febrero",
							"Marzo",
							"Abril",
							"Mayo",
							"Junio",
							"julio",
							"Agosto",
							"Septiembre",
							"Octubre",
							"Noviembre",
							"Diciembre"
						],
						"firstDay": 1
					}				
            	});
				
				$("#RangoFecha").change(function()
				{
					FiltroConsulta(1);
				});
            });
					
			function FiltroConsulta(PagActual)
			{			
				$("#TablaOrdenCarga tbody").html("");
				
				if($("#ID_TIPO_CARGA").val()>0 && $("#TIPO_FECHA").val())
				{
					$(".CargaDatos").show();	
					
					var PagActual= "&PagActual="+PagActual;
					var txtBuscar= "&txtBuscar="+$("#txtBuscar").val();
					var NroReg= "&NroReg="+$("#NroReg").val();
					var Orden= "&Orden="+$("#Orden").val();
					var AscDesc= "&AscDesc="+$("#AscDesc").val();
					var ID_TIPO_CARGA= "&ID_TIPO_CARGA="+$("#ID_TIPO_CARGA").val();
					var TIPO_FECHA= "&TIPO_FECHA="+$("#TIPO_FECHA").val();
					var FechaInicio= "&FechaInicio="+$('#RangoFecha').data('daterangepicker').startDate.format('YYYY-MM-DD');
					var FechaFin= "&FechaFin="+$('#RangoFecha').data('daterangepicker').endDate.format('YYYY-MM-DD');
					
					var Parametros=PagActual+txtBuscar+NroReg+Orden+AscDesc+ID_TIPO_CARGA+TIPO_FECHA+FechaInicio+FechaFin;
					
					//alert(Parametros);
					
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/OrdenCarga/Historico/FiltroConsulta.PHP",			
						data: Parametros,
						async:false,	
						beforeSend: function() 
						{
							window.parent.parent.Cargando(1);
						},												
						cache: false,			
						success: function(Resultado)
						{
							//alert(Resultado);
							
							window.parent.parent.Cargando(0);
							
							$("#FiltroConsulta").html(Resultado);
						}						
					});
				}
				else
				{
					$(".CargaDatos").hide();
				}
			}
			
			function AnularOrdenCarga(ID_ORDEN_PESAJE)
			{								
				if(confirm("¿Desea Anular la Orden de Carga?"))
				{
					Parametros="ID_ORDEN_PESAJE="+ID_ORDEN_PESAJE;
					
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/OrdenCarga/Historico/AnularOrdenCarga.PHP",			
						data: Parametros,	
						beforeSend: function() 
						{
							window.parent.parent.Cargando(1);
						},												
						cache: false,			
						success: function(Resultado)
						{
							window.parent.parent.Cargando(0);
						
							//alert(Resultado);
							
							if(window.parent.ValidarConexionError(Resultado)==1)
							{	
								window.parent.MostrarMensaje("Verde", "Orden de Carga Anulada Exitosamente.");
								
								FiltroConsulta(1);
							}
						}						
					});
				}
				else
				{
					//$(".CargaDatos").hide();
				}
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
			
			function vModal2(URl, Titulo)
			{
				window.parent.parent.Cargando(1);
				
				$("#vModalTitulo2").html("");
				$("#vModalContenido2").html("");
				
				$("#vModalTitulo2").html(Titulo);
				$("#vModalContenido2").load(URl);
				$("#vModal2").modal();
			}
        </script>
	</body>
</html>
