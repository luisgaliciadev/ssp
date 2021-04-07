<?php 
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	session_start();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	ValidarSesion($Nivel);
	
	$ID_ROL=$_GET['ID_ROL'];
	
	$vSQL="SELECT * FROM TB_ADMIN_USU_ROL WHERE ID_ROL=$ID_ROL;";	
	
	$ArregloResultado=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ArregloResultado["CONEXION"];
	
	if($CONEXION=="SI")
	{
		$ERROR=$ArregloResultado["ERROR"];
		
		if($ERROR=="NO")
		{
			$result=$ArregloResultado["RESULTADO"];
			
			$NB_ROL=odbc_result($result,"NB_ROL");		
		
			if($FG_PRODUCTO==0)
			{
				$FG_PRODUCTO=2;
			}
		}
		else
		{
			$MSJ_ERROR=$ArregloResultado["MSJ_ERROR"];		
			
			echo $MSJ_ERROR;
		}
	}
	else
	{
		$MSJ_ERROR=$ArregloResultado["MSJ_ERROR"];		
		
		echo $MSJ_ERROR;
	}
	
	$Conector->Cerrar();
	
	$Nivel="";
?>
<!DOCTYPE html>
<html>
    <head>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
    	<form id="vForm">
        	<input id="ID_ROL" type="hidden" value="<?php echo $ID_ROL;?>">
            <div class="form-group">
                <label for="NB_ROL">Nombre:</label>
                <input id="NB_ROL" type="text" class="form-control" required value="<?php echo $NB_ROL;?>">
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
				var	ID_ROL=$("#ID_ROL").val();
				var	NB_ROL=$("#NB_ROL").val();			
				
				Parametros="NB_ROL="+NB_ROL+"&ID_ROL="+ID_ROL;
				
				//alert(Parametros);
				
				$.ajax(
				{
					type: "POST",
					dataType:"html",
					url: "Sistema/Seguridad/Rol/ScriptModificar.PHP",			
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