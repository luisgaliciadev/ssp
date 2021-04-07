<?php
	$Nivel="../../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	$ID_MODULO_PM=$_GET['ID_MODULO_PM'];
	$ID_MODULO=$_GET['ID_MODULO_H'];
	
	$vSQL="select * from TB_ADMIN_USU_MODULO where ID_MODULO=$ID_MODULO";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];
	
	if($CONEXION=="SI")
	{		
		$ERROR=$ResultadoEjecutar["ERROR"];
	
		if($ERROR=="NO")
		{			
			$rsPrincipal=$ResultadoEjecutar["RESULTADO"];
				
			$ID_MODULO=odbc_result($rsPrincipal,"ID_MODULO");	
			$ID_MODULO_PV=odbc_result($rsPrincipal,"ID_MODULO_P");		
			$FG_SUB_MODULOV=odbc_result($rsPrincipal,'FG_SUB_MODULO');
			$ORDENV=odbc_result($rsPrincipal,'ORDEN');
			$NB_MODULO=odbc_result($rsPrincipal,'NB_MODULO');
			$RUTA=odbc_result($rsPrincipal,'RUTA');
			$TIPO_MENU=odbc_result($rsPrincipal,'TIPO_MENU');
			$ENLACE=odbc_result($rsPrincipal,'ENLACE');
			$ICONO=odbc_result($rsPrincipal,'ICONO');
		}
		else
		{
			echo $ResultadoEjecutar["MSJ_ERROR"];
			exit;	
		}
	}
	else
	{
		echo $ResultadoEjecutar["MSJ_ERROR"];	
		exit;	
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo includes($Nivel)?>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script>
		$(document).ready(function(e) 
		{				
			$('#vForm').on('submit', function(e) 
			{
				e.preventDefault();
				
				ModificarMenu();
			});
			
			fTIPO_MENU(<?php echo $TIPO_MENU?>);
        });
		
		function ModificarMenu()
		{
			ID_MODULO="&ID_MODULO="+$("#ID_MODULO").val();
			ID_MODULO_P="&ID_MODULO_P="+$("#ID_MODULO_P").val();
			ID_MODULO_PV="&ID_MODULO_PV="+$("#ID_MODULO_PV").val();
			NB_MODULO="&NB_MODULO="+$("#NB_MODULO").val();
			FG_SUB_MODULOV="&FG_SUB_MODULOV="+$("#FG_SUB_MODULOV").val();
			ORDENV="&ORDENV="+$("#ORDENV").val();
			TIPO_MENU="&TIPO_MENU="+$("#TIPO_MENU").val();
			RUTA="&RUTA="+$("#RUTA").val();
			ENLACE="&ENLACE="+$("#ENLACE").val();
			ICONO="&ICONO="+$("#ICONO").val();
			
			if(!$("#ID_MODULO_P").val())
			{
				window.parent.MostrarMensaje("Amarillo", "Disculpe, debe seleccionar el Modulo Padre.");
				$("#ID_MODULO_P").focus()
				return;
			}
			
			if($("#TIPO_MENU").val()==1)
			{			
				PARAMETROS=ID_MODULO+ID_MODULO_P+ID_MODULO_PV+NB_MODULO+FG_SUB_MODULOV+ORDENV+TIPO_MENU+ICONO;
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
					
					PARAMETROS=ID_MODULO+ID_MODULO_P+ID_MODULO_PV+NB_MODULO+FG_SUB_MODULOV+ORDENV+TIPO_MENU+ENLACE+ICONO;
				}
				else
				{		
					if(!$("#RUTA").val())
					{
						window.parent.MostrarMensaje("Amarillo", "Disculpe, debe ingresar la Ruta.");
						$("#RUTA").focus()
						return;
					}
					
					PARAMETROS=ID_MODULO+ID_MODULO_P+ID_MODULO_PV+NB_MODULO+FG_SUB_MODULOV+ORDENV+TIPO_MENU+RUTA+ICONO;
				}
			}
			
			$.ajax(
			{
				url: 'Sistema/Seguridad/Modulo/ModificarMenu.php',
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
					
						window.parent.MostrarMensaje("Verde", "Operacion realizada exitosamente!.");		
										
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
        <input type="hidden" id="ID_MODULO_PV" value="<?php echo $ID_MODULO_PV?>"/>
        <input type="hidden" id="ID_MODULO" value="<?php echo $ID_MODULO?>"/>
        <input type="hidden" id="FG_SUB_MODULOV" value="<?php echo $FG_SUB_MODULOV?>"/>
        <input type="hidden" id="ORDENV" value="<?php echo $ORDENV?>"/>    
         
        <div class="form-group">   
            <label for="ID_MODULO_P">Modulo Padre:</label>
        	<select id="ID_MODULO_P" class="form-control">
        	<?php				
				$vSQL="SELECT * FROM TB_ADMIN_USU_MODULO WHERE FG_ACTIVO=1 AND TIPO_MENU=1 ORDER BY ID_MODULO_P, ORDEN";
			
				$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
				$CONEXION=$ResultadoEjecutar["CONEXION"];
				$ERROR=$ResultadoEjecutar["ERROR"];
				$rsPrincipal=$ResultadoEjecutar["RESULTADO"];
				$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
				
				if($CONEXION=="SI" and $ERROR=="NO")
				{	
					while($row = odbc_fetch_array($rsPrincipal))
					{
						$Ite++;
						
						$ID_MODULO_AUX=$row['ID_MODULO'];
						$NB_MODULO_AUX=utf8_encode($row['NB_MODULO']);
						$FG_SUB_MODULO_AUX=$row['FG_SUB_MODULO'];	
						$ID_MODULO_P_AUX=$row['ID_MODULO_P'];
						
						if($FG_SUB_MODULO_AUX==0)
						{
							$Nivel="&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;
									Nivel 1: $NB_MODULO_AUX";
						}
						else
						{
							if($FG_SUB_MODULO_AUX==1)
							{
								$Nivel="&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										Nivel 2: $NB_MODULO_AUX";
							}
							else
							{
								$Nivel="&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										&nbsp;&nbsp;&nbsp;&nbsp;
										Nivel 3: $NB_MODULO_AUX";
							}
						}
						
						if($Ite==1)
						{
							if($ID_MODULO_AUX==$ID_MODULO and $ID_MODULO_P_AUX=='-1')
							{
								echo "<option value='-1' selected>Nivel 0: Menu Principal</option>";
							}
							else
							{
								echo "<option value='-1'>Nivel 0: Menu Principal</option>";	
								echo "<option value='$ID_MODULO_AUX'>$Nivel</option>";								
							}
						}
						else
						{
							if($ID_MODULO_PV==$ID_MODULO_AUX)
							{
								echo "<option value='$ID_MODULO_AUX' selected>$Nivel</option>";
							}
							else
							{
								echo "<option value='$ID_MODULO_AUX'>$Nivel</option>";
							}
						}
					}
				}
				else
				{
					echo $ResultadoEjecutar["MSJ_ERROR"];	
					exit;	
				}
			?>
        	</select>
        </div>
        <div class="form-group">
        	<label for="TIPO_MENU">Tipo Menú:</label>
            <select id="TIPO_MENU" onchange="fTIPO_MENU(this.value);" class="form-control">
<?php
              	if($TIPO_MENU==1)
				{
?>
                  <option value="1" selected="selected">Menú padre</option>
                  <option value="2">Menú con enlace a una pagina externa.</option>
                  <option value="3">Menú pagina</option>
<?php
				}
              	else
				{
					if($TIPO_MENU==2)
					{
?>
                      <option value="1">Menú padre</option>
                      <option value="2" selected="selected">Menú con enlace a una pagina externa.</option>
                      <option value="3">Menú pagina</option>					
<?php
					}
					else
					{
?>
                      <option value="1">Menú padre</option>
                      <option value="2">Menú con enlace a una pagina externa.</option>
                      <option value="3" selected="selected">Menú pagina</option>
<?php
					}
				}
?>
            </select>
		</div>
        <div class="form-group">
			<label for="NB_MODULO">Titulo:</label>
            <input type="text" id="NB_MODULO" style="text-transform:none" class="form-control" required value="<?php echo $NB_MODULO?>" />
		</div>
        <div class="form-group">
			<label for="ICONO">Icono:</label>
            <input type="text" id="ICONO" style="text-transform:none" class="form-control" required value="<?php echo $ICONO?>" />
		</div>
        <div class="form-group" id='divTIPO_MENU' style="display:none;">
            <label for="RUTA">Ruta:</label>
            <input type="text" id="RUTA" style="text-transform:none" class="form-control" value="<?php echo $RUTA?>" />
		</div>
        <div class="form-group" id='divEnlace' style="display:none;">
            <label for="ENLACE">Enlace:</label>
            <input type="text" id="ENLACE" style="text-transform:none" class="form-control" value="<?php echo $ENLACE?>" />
		</div>
           
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </div>
	</form>
</body>
</html>
<?php
	$Conector=Conectar();
?>