<?php	
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	ValidarSesion($Nivel);
	
	$Nivel="";
	
	$ID_MODULO=$_POST['vID_MODULO'];	
	$vNB_MODULO=$_POST["vNB_MODULO"];
?>
<!DOCTYPE html>
<html>
	<head>    
        <link rel="stylesheet" type="text/css" href="<?php echo $Nivel;?>Includes/Plugins/css_tree/_styles.css" media="screen">
         
		<script>     
			var CadMenusActivados="";
            
            $(document).ready(function(e) 
			{
                RecargarMenu();
            });
			       
            function RecargarMenu()
            {
                vCadMenusActivados="CadMenusActivados="+CadMenusActivados;
                ID_MODULO_PM="&ID_MODULO_PM=<?php echo $ID_MODULO;?>";
                
                PARAMETROS=vCadMenusActivados+ID_MODULO_PM;
				
                $.ajax(
				{
                    url: 'Sistema/Seguridad/Modulo/RecargarMenu.php',
                    data: PARAMETROS,
                    type: 'GET',
					beforeSend: function() 
					{			
						window.parent.parent.Cargando(1);
					},
                    success: function(Resultado)
                    {
						//alert(data);
						window.parent.parent.Cargando(0);
                   		
						if(window.parent.ValidarConexionError(Resultado)==1)
						{	
							var Arreglo=jQuery.parseJSON(Resultado);
							
							var Menu=Arreglo['Menu'];	
							
							$("#Menu").html(Menu);
                        }
                    }
                });
            }
			
			function EliminarMenu(ID_MODULO)
			{
				swal({
					title: "¿Estas seguro?",
					text: "Estas seguro de eliminar el Menu!",
					type: "warning",
					showCancelButton: true,
					confirmButtonColor: "#DD6B55",
					confirmButtonText: "Aceptar",
					cancelButtonText: "Cancelar",
					closeOnConfirm: true
				}, function () {
					ID_MODULO="ID_MODULO="+ID_MODULO;
					
					PARAMETROS=ID_MODULO;
					
					$.ajax(
					{
						url: 'Sistema/Seguridad/Modulo/EliminarMenu.php',
						data: PARAMETROS,
						type: 'POST',
						beforeSend: function() 
						{			
							window.parent.Cargando(1);
						},
						success: function(Resultado)
						{
							//alert(data);	
								
							if(window.parent.ValidarConexionError(Resultado)==1)
							{
								var Arreglo=jQuery.parseJSON(Resultado);						
							
								window.parent.MostrarMensaje("Verde", "Menu eliminado satisfactoriamente");
								
								RecargarMenu();
								
								//window.parent.ConstruirMenu();
								//window.parent.ActivarMenu('<?php echo $ID_MODULO;?>');
							}
						}
					});		
				});
			}
			
			function ReordenarMenu(ID_MODULO, ID_MODULO_P, ORDEN, Direccion)
			{
				ID_MODULO="ID_MODULO="+ID_MODULO;
				ID_MODULO_P="&ID_MODULO_P="+ID_MODULO_P;
				ORDEN="&ORDEN="+ORDEN;
				Direccion="&Direccion="+Direccion;
					
				PARAMETROS=ID_MODULO+ID_MODULO_P+ORDEN+Direccion;
				
				$.ajax(
				{
					url: 'Sistema/Seguridad/Modulo/ReordenarMenu.php',
					data: PARAMETROS,
					type: 'POST',
					async: false,
					beforeSend: function() 
					{			
						window.parent.$("#Loading").css("display","");
					},
					success: function(Resultado)
					{
						if(window.parent.ValidarConexionError(Resultado)==1)
						{							
							RecargarMenu();
							
							//window.parent.ConstruirMenu();
							
							//window.parent.ActivarMenu('<?php echo $ID_MODULO;?>');							
						}
					}
				});
			}
			
			function CKNivel(ID_MODULO)
			{					
				if($("#"+ID_MODULO).is(':checked'))
				{
					Pos = CadMenusActivados.indexOf(ID_MODULO);
					
					if(Pos<0)
						CadMenusActivados+=ID_MODULO+";";
				}
				else
				{
					Cant = ID_MODULO.length;
					CantCad = CadMenusActivados.length;
					
					Pos = CadMenusActivados.indexOf(ID_MODULO);
					
					A = CadMenusActivados.substring(0, Pos);
					
					B = CadMenusActivados.substring(Pos+Cant+1, CantCad);
					
					CadMenusActivados=A+B;
				}
			}
			
			function vModal(URl, Titulo)
			{
				$("#vModalTitulo").html(Titulo);
				$("#vModalContenido").load(URl);
				$("#vModal").modal();
			}
        </script>
        <style>
			.tree
			{
				margin-top:15px; 
				margin-left:15px;
			}
		</style>
    </head>
    <body>
    
	<div class="row wrapper border-bottom white-bg page-heading">
		<div class="col-lg-10">
			<h2><?php echo $vNB_MODULO;?></h2>
			<?php echo construirBreadcrumbs(substr($_POST["vID_MODULO"], 6, strlen($_POST["vID_MODULO"])));?>
		</div>
	</div>  
	
	<div class="wrapper wrapper-content animated fadeInRight col-md-4 col-md-offset-4">
		<div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins">
					<div class="ibox-content">
						<a href="javascript: " onClick="vModal('Sistema/Seguridad/Modulo/FormAgregarMenu.php?ID_MODULO_P=-1&FG_SUB_MODULO=0', 'Agregar Menu');">
							Agregar Menu
						</a>
						<ol id="Menu" class="tree Arbol" style="width:390px; margin-bottom:15px; border:0px solid #000;">
						</ol>
                    </div>
                </div>
            </div>
		</div>
	</div>
    
    <!-- Modal -->
    <div class="modal fade" id="vModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="vModalTitulo"></h4>
                </div>
                <div class="modal-body" id="vModalContenido">
                </div>
            </div>
        </div>
    </div>
    </body>
</html>