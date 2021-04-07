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

	$RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
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
			<h2><?php echo $vNB_MODULO;?></h2>
			<?php echo construirBreadcrumbs(substr($_POST["vID_MODULO"], 6, strlen($_POST["vID_MODULO"])));?>
		</div>
	</div>    
	
	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Modificar Solicitud de Muelle</h5>
					</div>
					<div class="ibox-content">
					<form role="form" id="form_sm" >
						
						<div class="form-group col-md-12" >
							<label> N&uacute;mero de Solicitd de Muelle</label>
							<select class="form-control" id="num_sm"  required>
								<option value="">Seleccione...</option>
								<?php 
									$vSQL="exec web.SP_CONSULTA_X_IDSM '".$RIF."'";
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
											$DES_SM=utf8_encode(odbc_result($result,'DES_SM'));
											
											echo "<option value=".$ID.">$DES_SM</option>";
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
                                  
						<div class="row">
							<div class="form-group col-md-12" >
								<button type="BUTTON" class="btn btn-primary" id="consultar">Consultar</button>		
							</div>	
						</div>	

						<div class="row">
							<div class="form-group col-md-12" >	
								<div  id="consulta"></div>
							</div>	
						</div>	
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>

<script src="Sistema/OrdenCarga/Historico/moment.min.js"></script>
        <script src="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.js"></script>
<script>
        $( document ).ready(function() {
			window.parent.parent.Cargando(0);
            var today = new Date(); 
			var dd = today.getDate(); 
			var mm = today.getMonth()+1; //January is 0! 
			var yyyy = today.getFullYear(); 
			var HH = today.getHours(); 
			var MM = today.getSeconds(); 
			var HHEND =  today.getHours() + 2 ; 
			if(dd<10){ dd='0'+dd } 
			if(mm<10){ mm='0'+mm } 
			var today = dd+'/'+mm+'/'+yyyy+' '+HH+':'+01; 
				
				$('#RangoFecha').daterangepicker(
				{
					timePicker : true,
					timePicker24Hour: true,
					timePickerIncrement: 10,
					minDate: today,	
					endDate: moment().add(2, 'hours'),			
					"locale": 
					{
						"format": "DD/MM/YYYY HH:mm ",
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
				
				$("#consultar" ).click(function() {
					var num_sm = $("#num_sm").val();
					var estatus = $("#num_sm option:selected").text().split(",");
					if (num_sm == ''){
						window.parent.MostrarMensaje("rojo", "Disculpe, debe seleccionar una Solicitud de muelle");
						return 0
					}
					$("#info").html('<h4 ><p class="text-green">'+estatus[2]+'</p></h4>')
					$("#consulta").load('Sistema/ModificarSolicitud/FormModificar.php?id='+num_sm);
					window.parent.parent.Cargando(1);
					
				});

				$("#gen_pre" ).click(function() {
					var num_sm = $("#num_sm").val();
					
					if (num_sm == ''){
						window.parent.MostrarMensaje("rojo", "Disculpe, debe seleccionar una Solicitud de muelle");
						return 0
					}

					Parametros = 'num_sm='+num_sm;
					$.ajax(
					{
						type: "POST",
						dataType:"html",
						url: "Sistema/ModificarSolicitud/ScriptGenPre.php",			
						data: Parametros,	
						beforeSend: function() 
						{
							window.parent.parent.Cargando(1);
						},												
						cache: false,			
						success: function(Resultado)
						{
							window.parent.parent.Cargando(0);
							var Arreglo=jQuery.parseJSON(Resultado);

							console.log(Arreglo);
							alert(Arreglo['MENSAJE']);
						
							//alert(Resultado);
							
						}						
					});
					window.parent.parent.Cargando(1);
					
				});

        });

		function NumCheck(e, field) {
            key = e.keyCode ? e.keyCode : e.which
            // backspace
            if (key == 8) return true
            // 0-9
            if (key > 47 && key < 58) {
                if (field.value == "") return true
                regexp = /.[0-9]{2}$/
                return !(regexp.test(field.value))
            }
            // .
            if (key == 46) {
                if (field.value == "") return false
                regexp = /^[0-9]+$/
                return regexp.test(field.value)
            }
            // other key
            return false
        
        }

		function soloLetras(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toString();
            letras = " áéíóúabcdefghijklmnñopqrstuvwxyzÁÉÍÓÚABCDEFGHIJKLMNÑOPQRSTUVWXYZ";//Se define todo el abecedario que se quiere que se muestre.
            especiales = [8, 37, 39, 46, 6]; //Es la validación del KeyCodes, que teclas recibe el campo de texto.

            tecla_especial = false
            for(var i in especiales) {
                if(key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if(letras.indexOf(tecla) == -1 && !tecla_especial){
                return false;
            }
        }
    </script>
</html>