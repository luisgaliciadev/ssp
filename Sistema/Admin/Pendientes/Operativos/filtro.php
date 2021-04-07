<!doctype html>
<?php 
	$Nivel="../../../../";
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
							<label> Numero de Solicitd de Muelle</label>
							<select class="form-control" id="num_sm"  required>
								<option value="">Seleccione...</option>
								<?php 
									$vSQL="exec web.SP_LISTADO_SM_ADMIN";
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
	window.parent.parent.parent.parent.Cargando(0);
	
	$("#consultar" ).click(function() {
		var num_sm = $("#num_sm").val();
		if (num_sm == ''){
			window.parent.MostrarMensaje("rojo", "Disculpe, debe seleccionar una Solicitud de muelle");
			return 0
		}
		
		$("#consulta").load('Sistema/Admin/Pendientes/Operativos/Tabla.php?id='+num_sm);
		window.parent.parent.parent.parent.Cargando(1);
		
	});

	

});
	
	
    </script>
</html>