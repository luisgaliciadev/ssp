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
                <label >Buque:</label>
                <select name="ID_BL" id="ID_BL" style="width:95%" onChange="FiltroConsulta(1)">
                    <option value="0" disabled selected>Seleccione Buque...</option>
<?php
                    $vSQL="EXEC web.SP_VIEW_WEB_USUARIO_BL '$RIF', 3;";
					//$vSQL="SELECT * FROM web.VIEW_WEB_USUARIO_BL WHERE RIF='$RIF' AND TIPO_CARGA=3;";
                    
                    $ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="NO", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                    
                    $CONEXION=$ResultadoEjecutar["CONEXION"];

                    $ERROR=$ResultadoEjecutar["ERROR"];
                    $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
                    $resultPrin=$ResultadoEjecutar["RESULTADO"];
                
                    if($CONEXION=="SI" and $ERROR=="NO")
                    {
                        while (odbc_fetch_row($resultPrin))  
                        {
                            $ID_BL=odbc_result($resultPrin,"ID_BL");
                            $NB_BUQUE=odbc_result($resultPrin,"NB_BUQUE");
                            $COD_BL=odbc_result($resultPrin,"COD_BL");
                            $NUM_VIAJE=odbc_result($resultPrin,"NUM_VIAJE");
                            $FECHA_HORA_REAL_ATRAQUE=odbc_result($resultPrin,"FECHA_HORA_REAL_ATRAQUE");
                            
                            $MOSTAR=$NB_BUQUE." - BL: ".$COD_BL." - VIAJE: ".$NUM_VIAJE." - FRA: ".FechaHoraNormal($FECHA_HORA_REAL_ATRAQUE);
?>
                            <option value="<?php echo $ID_BL;?>"><?php echo $MOSTAR;?></option>
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
            <div class="box-body">
                <div class="CargaDatos" style=" display:none;">
                <table width="100%" border="0" align="center" style="border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td width="9%" align="right"><span style="color:#000; font-weight:bold;">Manifestada:</span></td>
                            <td width="9%" id="CANT_MANIFESTADA">1</td>
                            <td width="9%" align="right"><span style="color:#000; font-weight:bold;">Pesada:</span></td>
                            <td width="9%" id="CANTIDAD_PESADA">1</td>
                            <td width="9%" align="right"><span style="color:#000; font-weight:bold;">ROB:</span></td>
                            <td width="9%" id="ROB">1</td>
                            <td width="20%" align="right"><span style="color:#000; font-weight:bold;">Ordenes de Carga Disponibles:</span></td>
                            <td width="7%" id="OCD">2</td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <table width="776" border="0" align="center">
                    <tbody>
                        <tr>
                            <td width="200" align="right" style="color:#000; font-weight:bold;">No ha entrado al Puerto:</td>
                            <td width="19">
                              <div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#FFFFFF; margin:auto;"></div>
                          </td>
                            <td width="202" align="right" style="color:#000; font-weight:bold;">En Proceso de Carga:</td>
                            <td width="19">
                              <div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#E5DF32; margin:auto;"></div>
                          </td>
                            <td width="154" align="right" style="color:#000; font-weight:bold;">Salio del Puerto:</td>
                            <td width="19">
                              <div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#31A268; margin:auto;"></div>
                            </td>
                            <td width="105" align="right" style="color:#000; font-weight:bold;">Anulada:</td>
                            <td width="24">
                              <div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#CD1F22; margin:auto;"></div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <div class="form-inline row">
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
                
                <div id="FiltroConsulta">
                </div>    
                            
                <hr>
                <table width="100%" border="0" align="center" style="border-collapse:collapse;">
                    <tbody>
                        <tr>
                            <td width="115" align="right"><span style="color:#000; font-weight:bold;">Cant. Ordenes: </span></td>
                            <td width="40" id="CANT_ORDEN_CARGA" style="padding-left:5px;"></td>
                            <td width="190" align="right"><span style="color:#000; font-weight:bold;">No ha entrado al Puerto: </span></td>
                            <td width="40" id="CANT_ESTATUS1" style="padding-left:5px;"></td>
                            <td width="200" align="right"><span style="color:#000; font-weight:bold;">En Proceso de Carga: </span></td>
                            <td width="40" id="CANT_ESTATUS2" style="padding-left:5px;"></td>
                            <td width="140" align="right"><span style="color:#000; font-weight:bold;">Salio del Puerto: </span></td>
                            <td width="40" id="CANT_ESTATUS3" style="padding-left:5px;"></td>
                            <td width="107" align="right"><span style="color:#000; font-weight:bold;">Anuladas: </span></td>
                            <td width="40" id="CANT_ANULADAS" style="padding-left:5px;"></td>
                        </tr>
                    </tbody>
                </table>
                </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      
    </section>
    <!-- /.content --> 
     
		<script>	
			$(document).ready(function(e) 
			{
				$("#ID_BL").focus();
				window.parent.parent.Cargando(0);
            });
					
			function FiltroConsulta(PagActual)
			{			
				$("#TablaOrdenCarga tbody").html("");
				
				ID_BL=$("#ID_BL").val();
							
				if(ID_BL.trim())
				{
					var PagActual= "&PagActual="+PagActual;
					var txtBuscar= "&txtBuscar="+$("#txtBuscar").val();
					var NroReg= "&NroReg="+$("#NroReg").val();
					var Orden= "&Orden="+$("#Orden").val();
					var AscDesc= "&AscDesc="+$("#AscDesc").val();
					
					var Parametros="ID_BL="+ID_BL+PagActual+txtBuscar+NroReg+Orden+AscDesc;
					
					//alert(Parametros);
					
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/OrdenCarga/Granel/FiltroConsulta.PHP",			
						data: Parametros,
						async: false,	
						beforeSend: function() 
						{
							window.parent.parent.Cargando(1);
						},												
						cache: false,			
						success: function(Resultado)
						{
							//alert(Resultado);
							
							$(".CargaDatos").show();
							$("#FiltroConsulta").html(Resultado);
					
							Totales();
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
						url: "Sistema/OrdenCarga/Granel/AnularOrdenCarga.PHP",			
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
			
			function Totales()
			{
				ID_BL=$("#ID_BL").val();
				
				Parametros="ID_BL="+ID_BL;
				
				$.ajax(
				{
					type: "POST",
					dataType:"html",
					url: "Sistema/OrdenCarga/Granel/Totales.PHP",			
					data: Parametros,	
					beforeSend: function() 
					{
						
					},												
					cache: false,			
					success: function(Resultado)
					{
						window.parent.parent.Cargando(0);
						
						//alert(Resultado);
						
						if(window.parent.ValidarConexionError(Resultado)==1)
						{
							var Arreglo=jQuery.parseJSON(Resultado);					
						
							var CANT_ORDEN_CARGA=Arreglo['CANT_ORDEN_CARGA'];	
							var CANT_ESTATUS1=Arreglo['CANT_ESTATUS1'];	
							var CANT_ESTATUS2=Arreglo['CANT_ESTATUS2'];	
							var CANT_ESTATUS3=Arreglo['CANT_ESTATUS3'];	
							var CANT_ANULADAS=Arreglo['CANT_ANULADAS'];	
							var CANT_MANIFESTADA=Arreglo['CANT_MANIFESTADA'];	
							var CANTIDAD_PESADA=Arreglo['CANTIDAD_PESADA'];	
							var ROB=Arreglo['ROB'];	
							var OCD=Arreglo['OCD'];	
							
							$("#CANT_ORDEN_CARGA").html(CANT_ORDEN_CARGA);
							$("#CANT_ESTATUS1").html(CANT_ESTATUS1);
							$("#CANT_ESTATUS2").html(CANT_ESTATUS2);
							$("#CANT_ESTATUS3").html(CANT_ESTATUS3);
							$("#CANT_ANULADAS").html(CANT_ANULADAS);
							$("#CANT_MANIFESTADA").html(CANT_MANIFESTADA);
							$("#CANTIDAD_PESADA").html(CANTIDAD_PESADA);
							$("#ROB").html(ROB);
							$("#OCD").html(OCD);
						}
					}					
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
				window.parent.parent.Cargando(1);
				
				$("#vModalTitulo2").html("");
				$("#vModalContenido2").html("");
				
				$("#vModalTitulo2").html(Titulo);
				$("#vModalContenido2").load(URl);
				$("#vModal2").modal();
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
	
			function ReporteOrdenCarga(ID_ORDEN_PESAJE)
			{
				ID_BL=$("#ID_BL").val();
				
				$("#vModalTitulo").html("");
				$("#vModalContenido").html("");
						
				Parametros="ID_ORDEN_PESAJE="+ID_ORDEN_PESAJE;
				
				$.ajax(
				{
					type: "get",
					url: "Sistema/OrdenCarga/ReporteOrdenCarga.php",
					data: Parametros,
					cache: false,
					beforeSend: function() 
					{		
						window.parent.parent.Cargando(1);
					},
					success: function(Resultado)
					{
						window.parent.parent.Cargando(0);
						
						if(window.parent.ValidarConexionError(Resultado)==1)
						{		
							$("#vModalTitulo").html('Orden de Carga Nro: '+ID_ORDEN_PESAJE);
							
							$("#vModalContenido").html('<iframe height="500" width="100%" frameborder="0" style="border:#999 solid 0px; margin-left:0px; margin-top:0px; border-radius:0px;background:#FFF;" scrolling="auto" src="Sistema/OrdenCarga/ReporteOrdenCargaConsulta.php?ID_ORDEN_PESAJE='+ID_ORDEN_PESAJE+'" name="iframe" id="iframe"></iframe>');
														
							$("#vModal").modal();
						}
					}
				});				
			}
        </script>
	</body>
</html>
