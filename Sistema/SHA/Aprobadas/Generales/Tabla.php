<!doctype html>
<?php 
	$Nivel="../../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar2();
	
	session_start();	
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	$num_sol = $_GET["id"];
	
	
	
?>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>

<link rel="stylesheet" href="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.css">
       
</head>

<body>

<div class="row">
<form role="form" id="form_mod" >
<input type="hidden" class="form-control" id="num_sol" name="VIAJE" required value="<?php echo $num_sol; ?>">
	<div class="col-md-10 col-md-offset-1" style="margin-top:15px;">
    	<div class="box box-primary">  	
            
			<div class="box-body">
				<div class="form-group col-md-12" >
	 				
					<table class="table table-bordered">
	 					<thead>
	 						<th>Tipo Servicio</th>
							<th>Cliente</th>
							<th>Tipo Cliente</th>
							<th>Preliquidaci&oacute;n</th>
							<th>Fecha Reg</th>
						</thead>
						<tbody>
					
							<?php
								$vSQL="exec web.sp_listado_servicios_venta 1,$num_sol";
								$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
						
								$CONEXION=$ResultadoEjecutar["CONEXION"];						
								$ERROR=$ResultadoEjecutar["ERROR"];
								$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
								$result=$ResultadoEjecutar["RESULTADO"];
								
								if($CONEXION=="SI" and $ERROR=="NO")
								{		
									while ($registro=odbc_fetch_array($result))
									{			
										$NB_SERVICIO =odbc_result($result,'NB_STIPO_SERVICIO');
										$NB_PROVEED_BENEF=utf8_encode(odbc_result($result,'NB_PROVEED_BENEF'));
										$DS_TIPO_BENEFICIARIO =odbc_result($result,'DS_TIPO_BENEFICIARIO');
										$FECHA_REG=utf8_encode(odbc_result($result,'FECHA_REG'));
										$BOTONES = '<div class="btn-toolbar" role="toolbar">
														<div class="btn-group">														
													
														<button type="button" class="btn btn-info">
															<span class="glyphicon glyphicon-search"></span>
														</button>													
														
														</div>
													</div>';
										echo "<tr>
												<td>".$NB_SERVICIO."</td>
												<td>".$NB_PROVEED_BENEF."</td>
												<td>".$DS_TIPO_BENEFICIARIO."</td>
												<td>".$BOTONES."</td>
												<td>".$FECHA_REG."</td>
											 </tr>";
										
									}
								}
								else
								{	
									echo $MSJ_ERROR;
									exit;
								}
							?>
						</tbody>
					  </table>
				</div>
			</div>
            
        </div>
       
        
    </div>
</form>
</div>

</body>

<script src="Sistema/OrdenCarga/Historico/moment.min.js"></script>
        <script src="Includes/Plugins/bootstrap-admin-templetes/AdminLTE-2.3.7/plugins/daterangepicker/daterangepicker.js"></script>
<script>
        $( document ).ready(function() {
			
			
			
			window.parent.parent.parent.parent.Cargando(0);
           
		
		});
    </script>
</html>