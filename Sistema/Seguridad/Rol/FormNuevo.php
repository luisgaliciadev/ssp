<?php 
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);
	
	$Nivel="";
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body>
    	<form id="vForm">
            <div class="form-group">
                <label for="NB_ROL">Nombre:</label>
                <input id="NB_ROL" type="text" class="form-control" required>
            </div>
           
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
        </form>
        
        <script>
			$(document).ready(function(e) 
			{				
                $('#vForm').on('submit', function(e) 
				{
					e.preventDefault();
					
					Guardar();
				});
            });
			
			function Guardar()
			{	                					
				var	NB_ROL=$("#NB_ROL").val();
				
				
				Parametros="NB_ROL="+NB_ROL;
				
				//alert(Parametros);
				
				$.ajax(
				{
					type: "POST",
					dataType:"html",
					url: "Sistema/Seguridad/Rol/ScriptGuardar.PHP",			
					data: Parametros,	
					beforeSend: function() 
					{
						window.parent.Cargando(1);
					},												
					cache: false,			
					success: function(Resultado)
					{
						//alert(Resultado);
						
						if(window.parent.ValidarConexionError(Resultado)==1)
						{
							var Arreglo=jQuery.parseJSON(Resultado);
							
							var EXISTE=Arreglo['EXISTE'];
							
							if(EXISTE=="SI")
							{
								window.parent.Cargando(0);
								
								window.parent.MostrarMensaje("Amarillo", "Disculpe, Ya se encuentra registrado!");
								
								$("#NB_ROL").focus();
							}
							else
							{		
								window.parent.FiltroConsulta(1);
								
								window.parent.$("#vModal").modal('toggle');			
								
								window.parent.MostrarMensaje("Verde", "Operacion realizada exitosamente!");
							}
						}		
					}						
				});
			}
        </script>
    </body>
</html>