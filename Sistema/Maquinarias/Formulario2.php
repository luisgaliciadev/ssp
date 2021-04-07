<?php
	$Nivel="../../";
	
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$Rif = $_SESSION[$SiglasSistema.'RIF'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta charset="utf-8">
        <style>
			.jqte_tool_label
			{
				height:25px;
			}
		</style>
</head>
<body>
		<form role="form" id="form_sm" >
		  <div class="col-md-10 col-md-offset-1" style="margin-top:15px;">
		  <div class="box box-primary">
		  <div class="box-header with-border">
		    <h3 class="box-title">Ingreso de Personal</h3>
		    <div>
		      <div class="box-body">
		        <div class="form-group col-md-12" >
		          <label> Seleccione Solicitud</label>
		          <select class="form-control" id="SOLICITUD" name="SOLICITUD" required="required">
		            <option value="">Seleccione...</option>
		             <?php 
							
                            $vSQL="exec web.[SP_CONSULTA_X_IDSM] '$Rif' ";
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
								
                                        
                                echo "<option value=".$ID."%&".trim($TIPO_BENEF).">$DES_SM </option>";
                            }
                        }
                        else
                        {	
                            echo $MSJ_ERROR;
                            exit;
                        }
                        
                        $Conector->Cerrar();
							?>
	              </select>
	            </div>
		        <div class="form-group col-md-12" >Empresa
		          <select class="form-control" id="EMPRESA" name="EMPRESA" required="required">
		            <option value="">Seleccione...</option>
		           
                     
	              </select>
		        </div>
		        <div class="form-group col-md-12" >Categoria
		          <select class="form-control" id="CATEGORIA" name="CATEGORIA" required="required">
		            <option value="">Seleccione...</option>
		            
	              </select>
		        </div>
		        <div class="form-group col-md-6"></div>
		        <div class="form-group col-md-6"></div>
<div class="form-group col-md-6">
          <label> C&eacute;dula</label>
		          <input type="text" class="form-control" id="CEDULA" name="CEDULA" required="required" />
	             </div>
		        <div class="form-group col-md-6">
		          <label> Nombre</label>
		          <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" required="required" />
	            </div>
		        <div class="form-group col-md-6">  
	           <label> Cargo</label>
		          <input type="text" class="form-control" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO" required="required" />
	            </div>
		        <div class="form-group col-md-6"></div>
</div>
	        </div>
		    <div class="box-footer">
		      <button type="submit" class="btn btn-primary" id="guardar_sm">Guardar</button>
	        </div>
	      </div>
</form>
		<!-- Select2 -->
		<script src="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/select2/select2.full.min.js"></script>
        <script>
			$(document).ready(function(e) 
			{	
				window.parent.parent.Cargando(0);
					
				$("#ID_TIPO_NOTIFICACION").focus();
				
				$('#vForm').on('submit', function(e) 
				{
					e.preventDefault();
					
					Registrar();
				});
				
				//Initialize Select2 Elements
    			$(".select2").select2();
				
				
            });
			
			function Registrar()
			{
				var	ID_ORDEN_PESAJE=$("#ID_ORDEN_PESAJE").val().trim();
				var	ID_TIPO_NOTIFICACION=$("#ID_TIPO_NOTIFICACION").val();	
				var	DS_NOTIFICACION=$("#DS_NOTIFICACION").val().trim();
				
				if(!ID_ORDEN_PESAJE.trim())
				{
					window.parent.MostrarMensaje("Amarillo", "Disculpe, debe seleccionar la orden de pesaje.");
					$("#ID_ORDEN_PESAJE").focus();
					return;
				}
				
				//alert($("#ID_TIPO_NOTIFICACION").val());
				
				if(!ID_TIPO_NOTIFICACION)
				{
					window.parent.MostrarMensaje("Amarillo", "Disculpe, debe seleccionar la notificacion.");
					$("#ID_TIPO_NOTIFICACION").focus();
					return;
				}
				
				if(!DS_NOTIFICACION.trim())
				{
					window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar la descripción.");
					$("#DS_NOTIFICACION").focus();
					return;
				}

				swal({
					title: "¿Estas seguro?",
					text: "¿Desea enviar la notificacion?, de ser afirmativa su respuesta la Orden de Carga sera bloqueada hasta no ser procesada por Bolipuertos!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Aceptar",
					cancelButtonText: "Cancelar",
					closeOnConfirm: true
				}, function () {
					Parametros="ID_ORDEN_PESAJE="+ID_ORDEN_PESAJE+"&ID_TIPO_NOTIFICACION="+ID_TIPO_NOTIFICACION+"&DS_NOTIFICACION="+DS_NOTIFICACION;
					
					$.ajax(
					{
						type: "POST",
						url: "Sistema/Notificaciones/GuardarNotificacion.PHP",			
						data: Parametros,	
						beforeSend: function() 
						{
							window.parent.parent.Cargando(1);
						},						
						success: function(Resultado)
						{
							window.parent.parent.Cargando(0);
							
							//alert(Resultado);
							if(window.parent.ValidarConexionError(Resultado)==1)
							{
								var Arreglo=jQuery.parseJSON(Resultado);
							
								var ID_NOTIFICAION=Arreglo['ID_NOTIFICAION'];
								
								window.parent.MostrarMensaje("Verde", "Notificacion Registrada Exitosamente.");
								
								$("#btbCancelar").click();
								
								window.parent.FiltroConsulta(1);
							}
						}						
					});		
				});
			}
        </script>
</body>
</html>