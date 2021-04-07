<?php
	$Nivel="../../";
	
	include($Nivel."includes/PHP/funciones.php");
	
	session_start();
	
	$ID_CARGA			= $_GET['ID_CARGA'];
	$ID_CLASIF_TCARGA	= $_GET['ID_CLASIF_TCARGA'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <meta charset="utf-8">
	</head>
	<body>
		<form id="vForm" class="">
			<div class="row">
<?php
				$Conector=Conectar2();
				
				$vSQL='
					SELECT
						*
					FROM
						CLASIF_TCARGA_ARCHIVO
					WHERE
						ID_CLASIF_TCARGA='.$ID_CLASIF_TCARGA.'
					ORDER BY
						ORDEN
					ASC';

				$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

				$CONEXION=$ResultadoEjecutar["CONEXION"];

				$ERROR=$ResultadoEjecutar["ERROR"];
				$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
				$resultPrin=$ResultadoEjecutar["RESULTADO"];

				if($CONEXION=="SI" and $ERROR=="NO"){
					$FORM_HTML = '';
					$i = 0;

					while(odbc_fetch_row($resultPrin)){
						$i++;
						$COLUMNA		= odbc_result($resultPrin,"COLUMNA");
						$TIPO_HTML		= odbc_result($resultPrin,"TIPO_HTML");
						$NOMBRE_CAMPO	= odbc_result($resultPrin,"NOMBRE_CAMPO");
						$MIN			= odbc_result($resultPrin,"MIN");
						$SELECT_HTML	= odbc_result($resultPrin,"SELECT_HTML");
						$PADRE			= odbc_result($resultPrin,"PADRE");
						$HIJO			= odbc_result($resultPrin,"HIJO");
						$FN_JS			= odbc_result($resultPrin,"FN_JS");
						$CANTIDAD_CAMPOS= odbc_num_rows($resultPrin);
						$cantidadFilas  = ceil($CANTIDAD_CAMPOS/2);

						$CAMPOS_SELECT['CAMPO'][]	= $NOMBRE_CAMPO;
						$CAMPOS_SELECT['HIJO'][]	= $HIJO;
						$CAMPOS_SELECT['FN_JS'][]	= $FN_JS;
						
						$OBJETO_HTML = '';
						
						if ($MIN) {
							$REQUIRED = 'required';
						} else {
							$REQUIRED = '';
						}

						$OPTION = '';

						switch (true) {
							case $TIPO_HTML == 'TEXT':
								$OBJETO_HTML = '
									<input type="text" id="'.$NOMBRE_CAMPO.'" name="'.$NOMBRE_CAMPO.'" class="form-control" '.$REQUIRED.'/>
								';
							break;
							
							case $TIPO_HTML == 'SELECT':
								if (!$PADRE) {
									$vSQL=$SELECT_HTML;
																		
									$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
					
									$CONEXION=$ResultadoEjecutar["CONEXION"];
					
									$ERROR=$ResultadoEjecutar["ERROR"];
									$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
									$result=$ResultadoEjecutar["RESULTADO"];
					
									if($CONEXION=="SI" and $ERROR=="NO"){
	
										while(odbc_fetch_row($result)){
											$VALUE	= odbc_result($result,"VALUE");
											$TEXT	= odbc_result($result,"TEXT");
	
											$OPTION .= '<option value="'.$VALUE.'">'.$TEXT.'</option>';
										}
									}else{									
										echo '<script>alert("'.$vSQL.'");window.parent.parent.Cargando(0);</script>';
										exit;
									}
								}							

								$OBJETO_HTML = '
									<select id="'.$NOMBRE_CAMPO.'" name="'.$NOMBRE_CAMPO.'" class="form-control" '.$REQUIRED.'>
										<option value="" disabled selected>SELECCIONE...</option>
										'.$OPTION.'
									</select>
								';
							break;
						}	
						
						if ($i == 1) {
							$FORM_HTML .= '
								<div class="col-lg-6">
							';
						}

						$FORM_HTML .= '	
							<div class="form-group">
								<label>'.$COLUMNA.':</label>
								'.$OBJETO_HTML.'
							</div>
						';
						
						if ($i == $cantidadFilas) {
							$FORM_HTML .= '
								</div>
								<div class="col-lg-6">
							';
						} else {
							if ($i == $CANTIDAD_CAMPOS) {
								$FORM_HTML .= '
									</div>
								';
							}
						}
					}
					
					/*echo('<pre>');
					var_dump($CAMPOS_SELECT['CAMPO']);
					echo('</pre>');

					echo implode(", ", $CAMPOS_SELECT['CAMPO']);*/
				}else{									
					echo '<script>alert("'.$vSQL.'");window.parent.parent.Cargando(0);</script>';
					exit;
				}

				$Conector->Cerrar();

				echo $FORM_HTML;
?>
			</div>			
			<div class="row">
				<div class="col-lg-12 divAdjuntarArchivo" id="divTablaPreview" style="display:none; overflow-x: auto; border: 0px solid red;">
				</div>
			</div>		
			<div class="row" id="resultado">
			</div>			
			<div class="row">
				<div class="col-lg-12">
					<footer>     
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal" id="btbCancelar" onClick="javascript: localStorage.removeItem('parametrosItems');	localStorage.removeItem('items');">Cancelar</button>
							<button type="submit" class="btn btn-primary">Guardar</button>
						</div>
					</footer>
				</div>
			</div>		
		</form>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.7.7/xlsx.core.min.js"></script>
		
		<script>			
			$(document).ready(function(e) {	
				window.parent.parent.Cargando(0);
<?php
				$Conector=Conectar2();
				
				$vSQL='
					SELECT
						'.implode(', ', $CAMPOS_SELECT['CAMPO']).'
					FROM
						WEB_CARGA_SOLIC_MUELLE
					WHERE
						ID_CARGA='.$ID_CARGA;

				$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

				$CONEXION=$ResultadoEjecutar["CONEXION"];

				$ERROR=$ResultadoEjecutar["ERROR"];
				$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
				$resultPrin=$ResultadoEjecutar["RESULTADO"];

				if($CONEXION=="SI" and $ERROR=="NO"){
					for ($i = 0; $i < $CANTIDAD_CAMPOS; $i++) {
						$CAMPO = $CAMPOS_SELECT['CAMPO'][$i];
						$VALOR = odbc_result($resultPrin, $CAMPO);

						$CAMPOS_VALORES[] = $CAMPO.'='.$VALOR;
						$VALORES[] = $VALOR;

						if ($CAMPOS_SELECT['HIJO'][$i]) {
?>
							$('#<?php echo $CAMPO;?>').val('<?php echo $VALOR;?>');
<?php
							echo $CAMPOS_SELECT['FN_JS'][$i].'('.$VALOR.');';
						} else {
?>
							$('#<?php echo $CAMPO;?>').val('<?php echo $VALOR;?>');
<?php
						}
												
					}
				}else{									
					echo '<script>alert("'.$vSQL.'");window.parent.parent.Cargando(0);</script>';
					exit;
				}
?>
				//$('#resultado').html('<?php echo implode(", ", $CAMPOS_VALORES);?>');

				$('#vForm').on('submit', function(e){
					e.preventDefault();
					
					onSubmit();
				});
            });
			
			function onSubmit(){					
				$.ajax({
					type: "POST",
					dataType:"html",
					url: "Sistema/Carga/ScriptModificar.PHP",			
					data: {
						'ID_CARGA'			: <?php echo $ID_CARGA;?>,
						'COLUMNAS' 			: {
<?php
							for ($i = 0; $i < count($CAMPOS_SELECT['CAMPO']); $i++) {
?>
								'<?php echo $i;?>' : '<?php echo $CAMPOS_SELECT['CAMPO'][$i];?>',	
<?php							
							}
?>
						},
						'VALORES' 			: {
<?php
							for ($i = 0; $i < count($CAMPOS_SELECT['CAMPO']); $i++) {
?>
								'<?php echo $i;?>' : $('#<?php echo $CAMPOS_SELECT['CAMPO'][$i];?>').val(),	
<?php							
							}
?>
						}
					},
					beforeSend: function(){
						window.parent.parent.Cargando(1);
					},												
					cache: false,			
					success: function(Resultado){
						
						if(window.parent.ValidarConexionError(Resultado)==1){
							window.parent.MostrarMensaje("Verde", "Operacion realizada exitosamente.");
							
							Arreglo=jQuery.parseJSON(Resultado);
							
							window.parent.FiltroConsulta(1);
							
							$("#btbCancelar").click();		
						}
					}						
				});
			}

			function detTipoCarga(ID_TIPO_CARGA) {

				var parametros = 'ID_CLASIF_TCARGA=<?php echo $ID_CLASIF_TCARGA;?>&ID_TIPO_CARGA='+ID_TIPO_CARGA;
					
				$.ajax({
					type: "POST",
					dataType:"html",
					url: "Sistema/Carga/ScriptComboDetTipoCarga.PHP",			
					data: parametros,
					beforeSend: function(){
						window.parent.parent.Cargando(1);
					},							
					success: function(Resultado){
						window.parent.parent.Cargando(0);
						if(window.parent.ValidarConexionError(Resultado)==1){							
							Arreglo=jQuery.parseJSON(Resultado);

							valore = Arreglo.OPTION.VALUE;
							texto = Arreglo.OPTION.TEXT;
							
							option = '<option value="" disabled selected>SELECCIONE...</option>'

							for (var i = 1; i < valore.length; i++) {
								option = '<option value="'+valore[i]+'">'+texto[i]+'</option>'
							}

							$("#ID_DET_TIPO_CARGA").html(option);		
						}
					}						
				});
			}
        </script>
	</body>
</html>