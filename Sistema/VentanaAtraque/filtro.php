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
	$STIPO_SERV=21;// REPARACION
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
						<h5>Ventana de Atraque</h5>
					</div>
					<div class="ibox-content">
						<form role="form" id="form_sm" >
														
							<div class="form-group col-md-12" id="div_cantidad">
								<label>Cantidad de Toques:  </label>
								
								<input type="text " class="form-control number" id="cantidad" name="cantidad" required maxlength="2">
							</div>
							
							<div class="form-group col-md-12" id="div_detalle">
								<label>Tiempo de Permanencia  </label>
								
								<input type="text" class="form-control" id="t_permanencia" name="detalle" required>
							</div>							
							
							<div class="form-group col-md-12 ">								
								<label>Hora:  </label>
								<div class="input-group clockpicker" data-autoclose="true">
									<input type="text" class="form-control" id="hora" value="09:30" >
									<span class="input-group-addon">
										<span class="fa fa-clock-o"></span>
									</span>
								</div>
                        	</div>

							<div class="form-group col-md-12" id="data_1">
								<label >D&iacute;a:</label>
								<div class="input-group date">
									<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
									<input class="form-control" value="<?php echo date("d/m/Y"); ?>" type="text" id="fecha">
								</div>
							</div>
							
                                  
							<div class="row">
								<div class="form-group col-md-12" id="div_btn">				
									<button type="button" class="btn btn-primary" id="guardar" >Guardar</button>				
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


<script>
        $( document ).ready(function() {
			window.parent.parent.Cargando(0);
			$('#div_tipo_benef').hide();
			$('#div_categoria').hide();
			$('#div_operadores').hide();
			$('#div_tabla').show();	
			actualiza_tabla()
					
			$('#data_1 .input-group.date').datepicker({
                todayBtn: "linked",
                keyboardNavigation: false,
                forceParse: false,
                calendarWeeks: true,
                autoclose: true
            });

			$('.clockpicker').clockpicker();

			$(".number").on({
				"focus": function(event) {
					$(event.target).select();
				},
				"keyup": function(event) {
					$(event.target).val(function(index, value) {
					return value.replace(/\D/g, "")
						.replace(/\B(?=(\d{3})+(?!\d)\.?)/g);
					});
				}
			});

			
			
			$('#guardar').click(function(){
				
				
				cantidad	= $('#cantidad').val();
				
				t_permanencia 	= $('#t_permanencia').val();
				
				hora 	= $('#hora').val();				
				
				fecha 	= $('#fecha').val();
				
				if ((cantidad == '') || (t_permanencia == '') || (hora == '') || (fecha == '')) {
					MostrarMensaje("Rojo", "Disculpe, Existe campos en blanco");
					return false
				}
				Parametros="consulta=1&cantidad="+cantidad+"&t_permanencia="+t_permanencia+"&hora="+hora+"&fecha="+fecha;
		
				
				
				
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/VentanaAtraque/ScriptGuardar.php",			
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
										$('#cantidad').val('');
										$('#t_permanencia').val('');
										$('#hora').val('');				
										$('#fecha').val('');
										actualiza_tabla()

									}
								}
							}
								
							
						}						
					});	
				
				
				
			})
			
         });
		  

 
function actualiza_tabla()
{	

	
	$("#div_tabla").load('Sistema/VentanaAtraque/FormTabla.php');
	
}


</script>
</html>