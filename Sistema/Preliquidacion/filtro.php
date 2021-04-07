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
	$USUARIO_CRE_WEB=$_SESSION[$_SESSION['SiglasSistema'].'LOGIN'];	


?>
<html>
<head>
<style>
	#tp_pre{
		font-size:18px;
		font-weight:900;
	}
</style>
<meta charset="utf-8">
<title>Documento sin título</title>


       
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
						<h5>Generales</h5>
					</div>
					<div class="ibox-content">
					<form role="form" id="form_sm" >
						
						<div class="form-group col-md-12" >
							<label> N&uacute;mero de Solicitud de Muelle</label>
							<select class="form-control" id="num_sm"  required>
								<option value="">Seleccione...</option>
								<?php 
									$vSQL="exec web.SP_LISTADO_SM_APROB_X_CLIENTE '$RIF'";
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
								<button type="BUTTON" class="btn btn-danger" id="cancelar_sol">Cancelar B&uacute;squeda</button>		
							</div>	
						</div>	

						<div class="row">
							<div class="form-group col-md-12" >	
								<div  id="consulta"></div>
							</div>
							<div class="col-md-8 col-md-offset-2 row detalle" >	

								<div class="form-group detalle">
									<label for="comment">Tipo de Preliquidaci&oacute;n:</label>
									<input type="text" id="tp_pre" class="form-control" disabled>
								</div>
								<div class="form-group detalle">
									<label for="comment">Detalle:</label>
									<input type="hidden" id="pre">
									<textarea class="form-control" rows="5" id="det_pre"></textarea>
								</div>

								
								<div class="form-group">
									<div class="col-sm-offset-4 col-sm-4">
										<button type="button" class="btn btn-primary" id="guardar_detalle">Guardar</button>
										<button type="button" class="btn btn-danger" id="cancelar">Cancelar</button>
									</div>
								</div>

								

							</div>	
						</div>	
					</form>
					</div>
				</div>
			</div>
		</div>
	</div>

</body>


<script>
$( document ).ready(function() {
	window.parent.parent.Cargando(0);
	$(".detalle").hide()
	$("#cancelar_sol").hide();
	
	$("#consultar" ).click(function() {
		var num_sm = $("#num_sm").val();
		if (num_sm == ''){
			window.parent.MostrarMensaje("rojo", "Disculpe, debe seleccionar una Solicitud de muelle");
			return 0
		}
		
		$("#consulta").load('Sistema/Preliquidacion/Tabla.php?id='+num_sm);
		$("#cancelar_sol").show();
		window.parent.parent.Cargando(1);
		
	});

	$("#num_sm" ).change(function() {
		var num_sm = $("#num_sm").val();
		if (num_sm.length == 0){
			limpiar()
		}
		
		
	});

	$("#cancelar_sol" ).click(function() {
		limpiar();
		$("#num_sm").val('');
	});

	$("#cancelar" ).click(function() {
		$(".detalle").hide()
		$("#pre").val()
		$("#tp_prere").val()
	});

	$("#guardar_detalle" ).click(function() {
		id_pre = $("#pre").val();
		detalles = $("#det_pre").val();

		Parametros = 'id_pre='+id_pre+'&detalles='+detalles;
		$.ajax(
		{
			type: "POST",
			dataType:"html",
			url: "Sistema/Preliquidacion/ScriptGenPre.php",			
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

				
				swal("Datos Guardados", Arreglo['MENSAJE'], "success" );
				window.parent.parent.MostrarMensaje("verde", Arreglo['MENSAJE']);
				$(".detalle").hide()
				$("#pre").val()
				$("#tp_prere").val()
			
				//alert(Resultado);
				
			}						
		});
		window.parent.parent.Cargando(1);
	});


	
});

function detalle_pre(id_pre,tp_preliqudacion){

	$(".detalle").show()
	$("#pre").val(id_pre)
	$("#tp_pre").val(tp_preliqudacion)

}

function limpiar(){
	$("#consulta").hide();
	$("#consulta").html('');
	$("#consulta").show();
	$(".detalle").hide()
	$("#pre").val()
	$("#tp_prere").val()
	$("#cancelar_sol").hide();
}



    </script>
</html>