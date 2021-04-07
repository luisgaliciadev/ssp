<!doctype html>
<?php 
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);
	
	$vNB_MODULO=$_POST["vNB_MODULO"];
	
	$Nivel="";

	$Rif = $_SESSION[$SiglasSistema.'RIF'];
	$STIPO_SERV=16;// DESECHOS
?>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

<link rel="stylesheet" href="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.css">
       
</head>

<body>
<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo $_POST["vNB_MODULO"];?></h2>
		<?php echo construirBreadcrumbs(substr($_POST["vID_MODULO"], 6, strlen($_POST["vID_MODULO"])));?>
	</div>
</div>   
	
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Proveedor de Servicios de Limpieza y Recolecci&oacute;n de Desechos S&oacute;lidos, Peligrosos</h5>
					</div>
					<div class="ibox-content">
						<form role="form" id="form_sm" >
							<div class="form-group col-md-12" >
								<label>Solicitud  </label>
								<select class="form-control" id="solicitud" name="SOLICITUD" required>
							
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
										$ESTATUS_SOLIC=odbc_result($result,'ESTATUS_SOLIC_MUELLE');
										$DES_SM=utf8_encode(odbc_result($result,'DES_SM'));
										$DS_ESTATUSSM=odbc_result($result,'DS_ESTATUSSM');
										
												
										echo "<option value=".$ID."%&".trim($TIPO_BENEF)."%&".trim($ESTATUS_SOLIC)."%&".trim($DS_ESTATUSSM).">$DES_SM </option>";
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
							<div id="info" style="float:right">
							</div>
							<div class="form-group col-md-12" id="div_tipo_benef">
								<label>Tipo Servicio  </label>
								<select class="form-control" id="tipo_benef" name="TIPO BENEFICIARIO" required>
							
									<option value="">Seleccione...</option>
								</select>
							</div>
							
							<div class="form-group col-md-12" id="div_categoria">
								<label>Categor&iacute;a  </label>
								<select class="form-control" id="categoria" name="TIPO BENEFICIARIO" required>
							
									<option value="">Seleccione...</option>
								</select>
							</div>
							
							<div class="form-group col-md-12" id="div_operadores">
								<label>Empresas</label>
								<select class="form-control" id="operador" name="TIPO BENEFICIARIO" required>
							
									<option value="">Seleccione...</option>
								</select>
							</div>
							
                                  
							<div class="row">
								<div class="form-group col-md-12" id="div_btn">				
									<button type="button" class="btn btn-primary" id="guardar_oper" disabled>Guardar</button>				
								</div>
							</div>
							
                                  
							<div class="row">
								<div class="form-group col-md-12" id="div_tabla"></div>	
							</div>	
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>


</body>

<script src="Sistema/OrdenCarga/Historico/moment.min.js"></script>
        <script src="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.js"></script>
<script>
        $( document ).ready(function() {
			window.parent.parent.Cargando(0);
			$('#div_tipo_benef').hide();
			$('#div_categoria').hide();
			$('#div_operadores').hide();
			$('#div_tabla').hide();	
					
		
			
			$('#solicitud').change(function() {
				
				$('#div_tipo_benef').hide();
				$('#categoria').html('');
				$('#div_categoria').hide();
				$('#div_operadores').hide();
				$('#tipo_benef').html('');
				$('#operador').html('');
				$('#div_tabla').show();	
				
  				valor = $('#solicitud').val();
				valores	= valor.split('%&');
				
				ds_estatus = $("#solicitud option:selected").text().split(",");
				
				$("#info").html('<h4 ><p class="text-green">'+ds_estatus[2]+'</p></h4>')
				
				estado_sm = valores[2];
				
				/*Verifico que la solicitud se encuentre en Estatus 0 (EN ELABORACION WEB)*/
				if(estado_sm==0)
				{		
						$('#div_tipo_benef').show();
						cargar_combo_tipo_benef();
						
				}
				else 
				{
					$('#div_tipo_benef').hide();
					$('#div_tabla').hide();
					$("#info").html('');
				}
				
				actualiza_tabla(valores[0]);
			});
				
			$('#tipo_benef').change(function() {
				
				tipo_benef = $('#tipo_benef').val();
				$('#div_operadores').hide();
				
				if(tipo_benef=='')
				{
					$('#div_categoria').hide();
				}
				else
				{
					$('#div_categoria').show();
					cargar_combo_categoria(tipo_benef);		
				}
			});
				
			$('#categoria').change(function() {
				
				var tipo_benef = $('#tipo_benef').val();
				
				var categoria = $('#categoria').val();
				
				$('#div_operadores').show();
				
				if(categoria=='')
				{
					$('#div_operadores').hide();
				}
				else
				{
					cargar_combo_operador(tipo_benef,categoria);		
				}
					
				
			});
			
			$('#operador').change(function(){
				$('#guardar_oper').removeAttr('disabled');
					
			})
			
			$('#guardar_oper').click(function(){
				
				solicitud	= $('#solicitud').val();
				
				id_solici	= solicitud.split('%&');
				
				tipo_benef 	= $('#tipo_benef').val();
				
				categoria 	= $('#categoria').val();
				
				
				operador 	= $('#operador').val();
				Parametros="consulta=1&solicitud="+id_solici[0]+"&tipo_benef="+tipo_benef+"&categoria="+categoria+"&operador="+operador;
		
				
				if(operador == '')
				{}
				else
				{
				
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						async:false,
						url: "Sistema/Desechos/ScriptGuardar.php",			
						data: Parametros,	
						beforeSend: function() 
						{
							window.parent.parent.Cargando(1);
							
						},												
						cache: false,			
						success: function(result)
						{
							window.parent.parent.Cargando(0);
						
							var Arreglo=jQuery.parseJSON(result);
							
							var CONEXION=Arreglo['CONEXION'];
							
							
							
							if(CONEXION=="NO")
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
								{
									
									var Id = Arreglo['ID_BENEF'];
									
									if(Id==0)
									{
										MostrarMensaje("Rojo", Arreglo['MENSAJE']);
									}
									else
									{
										MostrarMensaje("Verde", Arreglo['MENSAJE']);
										
										//$('#categoria').html('');
										//$('#div_categoria').hide();
										//$('#div_operadores').hide();
										//$('#div_tipo_benef').hide();
										//$('#tipo_benef').html('');
										//$('#operador').html('');
										$('#guardar_oper').attr('disabled','disabled');
										actualiza_tabla(id_solici[0]);
										cargar_combo_operador(tipo_benef,categoria);
									}
								}
							}
								
							
						}						
					});	
				
				}
				
			})
			
         });
		  
		  
		  
function cargar_combo_tipo_benef()
{
		Parametros="consulta=1";
		
		$.ajax(
		{
			type: "POST",
			dataType:"html",
			url: "Sistema/Desechos/ScriptConsultar.php",			
			data: Parametros,	
			beforeSend: function() 
			{
				window.parent.parent.Cargando(1);
			},												
			cache: false,			
			success: function(result)
			{
				window.parent.parent.Cargando(0);
			
				var Arreglo=jQuery.parseJSON(result);
				
				var CONEXION=Arreglo['CONEXION'];
							
				if(CONEXION=="NO")
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
					{						
						$('#tipo_benef').html(Arreglo['COMBO']);
					}
				}
			}						
		});
}

function cargar_combo_categoria(tipo_benef)
{
	Parametros="consulta=2&tipo_benef="+tipo_benef;
		
	$.ajax(
	{
		type: "POST",
		dataType:"html",
		url: "Sistema/Desechos/ScriptConsultar.php",			
		data: Parametros,	
		beforeSend: function() 
		{
			window.parent.parent.Cargando(1);
		},												
		cache: false,			
		success: function(result)
		{
			window.parent.parent.Cargando(0);
		
			var Arreglo=jQuery.parseJSON(result);
			
			var CONEXION=Arreglo['CONEXION'];
			
			
			
			if(CONEXION=="NO")
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
				{
					
					$('#categoria').html(Arreglo['COMBO']);
					
				}
			}
				
			
		}						
	});	
	
	
}


function cargar_combo_operador(tipo_benef,categoria)
{
	
	Parametros="consulta=3&tipo_benef="+tipo_benef+"&categoria="+categoria;
		
	$.ajax(
	{
		type: "POST",
		dataType:"html",
		url: "Sistema/Desechos/ScriptConsultar.php",			
		data: Parametros,	
		beforeSend: function() 
		{
			window.parent.parent.Cargando(1);
		},												
		cache: false,			
		success: function(result)
		{
			window.parent.parent.Cargando(0);
		
			var Arreglo=jQuery.parseJSON(result);
			
			var CONEXION=Arreglo['CONEXION'];
			
					
			if(CONEXION=="NO")
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
				{
					
					$('#operador').html(Arreglo['COMBO']);
					
				}
			}
				
			
		}						
	});	
	
}
 
function actualiza_tabla(id_solicitud)
{	

	
	$("#div_tabla").load('Sistema/Desechos/FormTabla.php?id_sm='+id_solicitud);
	
}


</script>
</html>