<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");	
	
	session_start();	

	$Conector=Conectar2();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	$RIF=$_SESSION[$SiglasSistema."RIF"];
	
	ValidarSesion($Nivel);
	
	//$vNB_MODULO=$_POST["vNB_MODULO"];
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
	
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2><?php echo $_POST["vNB_MODULO"];?></h2>
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
                <label >Seleccione solicitud:</label>
                <select name="ID_SOL_SM" id="ID_SOL_SM" style="width:95%" onChange="FiltroConsulta(1)">
                    <option value="0" disabled selected>Seleccione...</option>
    <?php 
							
                            $vSQL="exec web.[SP_CONSULTA_X_IDSM] '$RIF' ";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
                        
                        $CONEXION=$ResultadoEjecutar["CONEXION"];						
                        $ERROR=$ResultadoEjecutar["ERROR"];
                        $MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
                        $result=$ResultadoEjecutar["RESULTADO"];
                        
                        if($CONEXION=="SI" and $ERROR=="NO")
                        {		
                            while ($registro=odbc_fetch_array($result))
                            {			
                                $ID=odbc_result($result,'ID');
								$TIPO_BENEF=odbc_result($result,'COD_TIPO_BENEF_GENERA');
                                $DES_SM=utf8_encode(odbc_result($result,'DES_SM'));
								
                                        
                                echo "<option value=".$ID."&".trim($TIPO_BENEF).">$DES_SM </option>";
                            }
                        }
                        else
                        {	
                            echo $MSJ_ERROR;
                            exit;
                        }
                        
                        $Conector->Cerrar();
							?>           </select>
            </div>
            <div class="box-body">
                <div class="CargaDatos" style=" display:none;">
                <table width="776" border="0" align="center">
                    <tbody>
                        <tr>

                            <td width="202" align="right" style="color:#000; font-weight:bold;">Empleado activo:</td>
                            <td width="19">
                              <div style="border:#000000 2px solid; border-radius:50%; width:15px; height:15px; background:#E5DF32; margin:auto;"></div>
                          </td>

                            <td width="105" align="right" style="color:#000; font-weight:bold;">Empleado inactivo:</td>
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
				//$("#ID_EMP_SOL").focus();
				window.parent.parent.Cargando(0);
            });
					
			function FiltroConsulta(PagActual)
			{			
				$("#TablaOrdenEmp tbody").html("");
				
				ID_SOL_SM=$("#ID_SOL_SM").val();
							
				if(ID_SOL_SM.trim())
				{
					var PagActual= "&PagActual="+PagActual;
					var txtBuscar= "&txtBuscar="+$("#txtBuscar").val();
					var NroReg= "&NroReg="+$("#NroReg").val();
					var Orden= "&Orden="+$("#Orden").val();
					var AscDesc= "&AscDesc="+$("#AscDesc").val();
					
					var Parametros="ID_SOL_SM="+ID_SOL_SM+PagActual+txtBuscar+NroReg+Orden+AscDesc;
					
					//alert(Parametros);
					
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/Cuadrilla/FiltroConsulta.PHP",			
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
							//alert(Resultado);
		
							
							$(".CargaDatos").show();
							$("#FiltroConsulta").html(Resultado);
							
							//Totales();
						}						
					});
				}
				else
				{
					$(".CargaDatos").hide();
				}
			}
			
			function Anularempleado(ID)
			{
					var Parametros="ID="+ID+"&consulta=4";
					
					//alert(Parametros);
					
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/Cuadrilla/ScriptConsultar.PHP",			
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
						
							var Arreglo=jQuery.parseJSON(Resultado);
							
							var CONEXION=Arreglo['CONEXION'];
							
							var EXISTE=Arreglo['EXISTE'];
							
				
							if(CONEXION=="NO")
							{		
								window.parent.Cargando(0);
										
								var MSJ_ERROR=Arreglo['MSJ_ERROR'];	
					<?php
								if(IpServidor()=="10.10.30.54")
								{
					?>	
									//alert(MSJ_ERROR);
					<?php
								}
					?>							
								window.parent.Cargando(0);
								MostrarMensaje("Rojo", "Error, No se puede conectar con el servidor, contacte al personal del departamento de sistemas.");
								
							}
							else
							{
								var ERROR=Arreglo['ERROR'];
								
								if(ERROR=="SI")
								{		
									window.parent.Cargando(0);
											
									var MSJ_ERROR=Arreglo['MSJ_ERROR'];	
					<?php
									if(IpServidor()=="10.10.30.54")
									{
					?>	
										alert(MSJ_ERROR);
					<?php
									}
					?>
									window.parent.Cargando(0);
				
									MostrarMensaje("Rojo", "Error de sentencia SQL, contacte al personal del departamento de sistemas.");
									
								}
								else 
								{   MostrarMensaje("Verde", "Datos eliminados con &eacute;xito");
								 
								
								}
							}
							
						}						
					});
				
				FiltroConsulta(1);
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
	
			
        </script>
	</body>
</html>
