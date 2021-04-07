<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	$ID_MODULO_P=$_GET['ID_MODULO_P'];
	$FG_SUB_MODULO=$_GET['FG_SUB_MODULO'];
	echo $ID_MODULO_PM=$_GET['ID_MODULO_PM'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script>	
		$(document).ready(function(e) 
		{				
			$('#vForm').on('submit', function(e) 
			{
				e.preventDefault();
				
				AgregarMenu();
			});
		});	
		
		function AgregarMenu()
		{				
			ID_MODULO_P="ID_MODULO_P="+$("#ID_MODULO_P").val();
			FG_SUB_MODULO="&FG_SUB_MODULO="+$("#FG_SUB_MODULO").val();
			NB_MODULO="&NB_MODULO="+$("#NB_MODULO").val();
			RUTA="&RUTA="+$("#RUTA").val();
			TIPO_MENU="&TIPO_MENU="+$("#TIPO_MENU").val();
			ENLACE="&ENLACE="+$("#ENLACE").val();
			ICONO="&ICONO="+$("#ICONO").val();
			
			if($("#TIPO_MENU").val()==1)
			{			
				PARAMETROS=ID_MODULO_P+FG_SUB_MODULO+NB_MODULO+TIPO_MENU+ICONO;
			}
			else
			{
				if($("#TIPO_MENU").val()==2)
				{
					if(!$("#ENLACE").val())
					{
						window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar el Enlace.");
						$("#ENLACE").focus()
						return;
					}
					
					PARAMETROS=ID_MODULO_P+FG_SUB_MODULO+NB_MODULO+ENLACE+TIPO_MENU+ICONO;
				}
				else
				{		
					if(!$("#RUTA").val())
					{
						window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar la Ruta.");
						$("#RUTA").focus()
						return;
					}
					
					PARAMETROS=ID_MODULO_P+FG_SUB_MODULO+NB_MODULO+RUTA+TIPO_MENU+ICONO;
				}
			}
			
			$.ajax(
			{
				url: 'Sistema/Seguridad/Modulo/AgregarMenu.php',
				data: PARAMETROS,
				type: 'POST',
				beforeSend: function() 
				{			
					window.parent.Cargando(1);
				},
				success: function(Resultado)
				{
					if(window.parent.ValidarConexionError(Resultado)==1)
					{
						window.parent.MostrarMensaje("Verde", "Menu agregado satisfactoriamente");		
										
						window.parent.RecargarMenu();
						
						window.parent.$("#vModal").modal('toggle');
						
						window.parent.ConstruirMenu();
						
						window.parent.ActivarMenu('<?php echo $ID_MODULO_PM;?>');
					}
				}
			});
		}
		
		function fTIPO_MENU(valor)
		{
			if(valor==1)
			{
				$("#divTIPO_MENU").hide();
				$("#divEnlace").hide();
				$("#Visualizar").hide();
			}
			else
			{
				if(valor==2)
				{
					$("#divTIPO_MENU").hide();
					$("#divEnlace").show();
					$("#Visualizar").hide();
				}
				else
				{
					$("#divTIPO_MENU").show();
					$("#divEnlace").hide();
					$("#Visualizar").show();
				}
			}
		}
	</script>
</head>
<body>
    <form id="vForm">
        <input type="hidden" id="ID_MODULO_P" value="<?php echo $ID_MODULO_P?>"/>
        <input type="hidden" id="FG_SUB_MODULO" value="<?php echo $FG_SUB_MODULO?>"/>
        <div class="form-group">
        	<label for="NB_ROL">Tipo Menú:</label>
            <select id="TIPO_MENU"  class="form-control" required onchange="fTIPO_MENU(this.value);">
              <?php if($FG_SUB_MODULO!=2){?><option value="1">Menú padre</option><?php }?>
              <option value="2">Menú con enlace a una pagina externa.</option>
              <option value="3">Menú pagina</option>
            </select>
		</div>
        <div class="form-group">
			<label for="NB_MODULO">Titulo:</label>
            <input type="text" id="NB_MODULO" style="text-transform:none" class="form-control" required />
		</div>
        <div class="form-group">
			<label for="ICONO">Icono:</label>
            <input type="text" id="ICONO" style="text-transform:none" class="form-control" required value="dot-circle-o"/>
		</div>
        <div class="form-group" id='divTIPO_MENU' style="display:none;">
            <label for="RUTA">Ruta:</label>
            <input type="text" id="RUTA" style="text-transform:none" class="form-control"/>
		</div>
        <div class="form-group" id='divEnlace' style="display:none;">
            <label for="ENLACE">Enlace:</label>
            <input type="text" id="ENLACE" style="text-transform:none" class="form-control"/>
		</div>
           
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
	</form>
</body>
</html>