<?php
	$Nivel="../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	$ID_USUARIO=$_SESSION[$SiglasSistema.'ID_USUARIO'];
	
	$IdVentana=$_GET['IdVentana'];
	
	
	
	
	
	
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php echo includes($Nivel);?>
<style>
	#Empresas 
	{
		display:none;
		position: absolute;
		width: 350px;
		z-index :10;
		border: #000 1px solid;  
		background-color:#FFF;
		margin-top: 20px;
		font-size:14px;
	}
		
	#Empresas a
	{
		text-decoration:none;
		display:block;
		color:#000;
	}
	
	#Empresas a:hover
	{
		background: #CCC;
	}
</style>
<script>
	function Reportes(Valor)
	{
		$('#trrif').hide();
		$('#rif').val("");
		limpiar();
		
		$('#trANO_REGISTRO').hide();
		$('#ANO_REGISTRO').val(0);
		
		$('#trano').hide();
		$('#ano').val(0);
		
		$('#trmes').hide();
		$('#mes').val(0);
		
		$('#trpuerto').hide();
		$('#puerto').val(0);
		
		$('#trf_desde').hide();
		$('#f_desde').datepicker('setDate', 'today');
		
		$('#trf_hasta').hide();
		$('#f_hasta').datepicker('setDate', 'today');
		
		$('#trcategoria').hide();
		$('#categoria').val(0);
		
		$('#trtipo_doc').hide();
		$('#tipo_doc').val(0);
		
		$('#trNroPreliquidacion').hide();
		$('#NroPreliquidacion').val('');
		
		$('#trAbogado').hide();
		$('#Abogado').val('');	
		
		$('#trAbogado').hide();
		$('#Abogado').val(0);	
		
		
		trNroPreliquidacion	
		
		/*if($( "#reportes" ).val()==17)
		{			
			$('#trNroPreliquidacion').show();
		}
		else
		{
			$('#trNroPreliquidacion').hide();
		}*/
		
		var id_reporte = 'id_reporte='+ $( "#reportes" ).val();
		
		$.ajax(
		{
			type: "POST",
			url: "argumento_reporte.php",
			data: id_reporte,
			cache: false,
			beforeSend: function() 
			{			
				window.parent.$("#Loading").css("display","");
			},
			success: function(html)
			{
				window.parent.$("#Loading").css("display","none");
				
				resultado = html.split('%%');
				
				$("#NombreReporte").val(resultado[0])
				
				vln_condicion = resultado[1]	
										
				for(i = 2; i < resultado.length; i++)
				{								
					desbloquear(resultado[i])
				}
			}
		});
	}
	
	$(document).ready(function(e) 
	{		
		$( "#f_desde" ).datepicker(
		{
			defaultDate: "+1w",
			changeYear: true,
			changeMonth: true,
			yearRange: '-100:+1',
			numberOfMonths: 1,
			dateFormat: 'dd/mm/yy',
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			monthStatus: 'Ver otro mes', 
			yearStatus: 'Ver otro año',
			dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			onClose: function( selectedDate ) 
			{
				$( "#f_hasta" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		
		$( "#f_hasta" ).datepicker(
		{
			defaultDate: "+1w",
			changeYear: true,
			changeMonth: true,
			yearRange: '-100:+1',
			numberOfMonths: 1,
			dateFormat: 'dd/mm/yy',
			monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
			monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
			monthStatus: 'Ver otro mes', 
			yearStatus: 'Ver otro año',
			dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
			dayNamesShort: ['Dom','Lun','Mar','Mie','Jue','Vie','Sáb'],
			dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sa'],
			onClose: function( selectedDate ) 
			{
				$( "#f_desde" ).datepicker( "option", "maxDate", selectedDate );
			}
		});
		
		$('#f_desde').datepicker('setDate', 'today');
		$('#f_hasta').datepicker('setDate', 'today');
    });
	
	function impr_reporte()
	{		
		aux=0;
		Parametros="";
	
		if($('#rif').is(':visible'))
		{
		   if ($('#rif').val() == '')
			{
				window.parent.toastr.error("Disculpe, debe ingresar un RIF valido")
				return
			}
			else
			{
				if (aux == 0)
				{
					Parametros+="rif="+$('#rif').val()
					aux = 1
				}else
					Parametros+="&rif="+$('#rif').val()
			}
		}
	
		if($('#Abogado').is(':visible'))
		{
		   if ($('#Abogado').val() == '')
			{
				window.parent.toastr.error("Disculpe, debe ingresar un abogado valido")
				return
			}
			else
			{
				if (aux == 0)
				{
					Parametros+="Abogado="+$('#Abogado').val()
					aux = 1
				}else
					Parametros+="&Abogado="+$('#Abogado').val()
			}
		}		
		
		if ($('#ANO_REGISTRO').is(':visible'))
		{
			if ($('#ANO_REGISTRO').val() < 0)
			{
				window.parent.toastr.error("Disculpe, debe seleccionar una período")
				return
			}else{
				if (aux == 0){
					Parametros+="ANO_REGISTRO="+$('#ANO_REGISTRO').val()
					aux = 1
				}else
					Parametros+="&ANO_REGISTRO="+$('#ANO_REGISTRO').val()
			}
		}		
		
		if ($('#ano').is(':visible'))
		{
			if ($('#ano').val() < 0)
			{
				window.parent.toastr.error("Disculpe, debe seleccionar una período")
				return
			}else{
				if (aux == 0){
					Parametros+="ano="+$('#ano').val()
					aux = 1
				}else
					Parametros+="&ano="+$('#ano').val()
			}
		}		
		
		if ($('#mes').is(':visible'))
		{
			if ($('#mes').val() < 0)
			{
				window.parent.toastr.error("Disculpe, debe seleccionar una período")
				return
			}else{
				if (aux == 0){
					Parametros+="mes="+$('#mes').val()
					aux = 1
				}else
					Parametros+="&mes="+$('#mes').val()
			}
		}
		
		if ($('#f_desde').is(':visible'))
		{
			if ($('#f_desde').val() == '')
			{
				window.parent.toastr.error("Disculpe, debe ingresar una Fecha valida")
				return
			}else
				if ($('#f_desde').val() >  $('#f_hasta').val()){
					window.parent.toastr.error("Disculpe, la fecha desde no puede ser mayor que la fecha hasta")					
				}else{
					if (aux == 0){
						Parametros+="f_desde="+$('#f_desde').val()
						aux = 1	
					}else
						Parametros+="&f_desde="+$('#f_desde').val()										
				}
		}
		
		if ($('#f_hasta').is(':visible'))
		{
			if ($('#f_hasta').val() == ''){
				window.parent.toastr.error("Disculpe, debe ingresar una Fecha valida")
				return
			}else
				if ($('#f_hasta').val() <  $('#f_desde').val()){
					window.parent.toastr.error("Disculpe, la fecha hasta no puede ser menor que la fecha desde")
				}else{
					if (aux == 0){
						Parametros+="f_hasta="+$('#f_hasta').val()
						aux = 1
					}else
						Parametros+="&f_hasta="+$('#f_hasta').val()
				}
		}
		
		if ($('#categoria').is(':visible'))
		{
			if ($('#categoria').val() < 0)
			{
				window.parent.toastr.error("Disculpe, debe seleccionar una Categoría")
				return
			}else{
				if (aux == 0){
					Parametros+="categoria="+$('#categoria').val()
					aux = 1
				}else
					Parametros+="&categoria="+$('#categoria').val()
			}
		}
		
		if ($('#puerto').is(':visible'))
		{
			if (aux == 0)
			{
				Parametros+="puerto="+$('#puerto').val()
				aux = 1
			}else
				Parametros+="&puerto="+$('#puerto').val()				
		}
		
		if ($('#tipo_doc').is(':visible'))
		{
			if (aux == 0){
				Parametros+="tipo_acta="+$('#tipo_doc').val()
				aux = 1
			}else
				Parametros+="&tipo_acta="+$('#tipo_doc').val()		
		}
		
		if ($('#NroPreliquidacion').is(':visible'))
		{
			if ($('#NroPreliquidacion').val() == ''){
				window.parent.toastr.error("Disculpe, debe ingresar el nro de la preliquidacion")
				return
			}else
				if (aux == 0)
				{
					Parametros+="NroPreliquidacion="+$('#NroPreliquidacion').val()
					aux = 1
				}else
					Parametros+="&NroPreliquidacion="+$('#NroPreliquidacion').val()		
		}
		
		NombreReporte=$("#NombreReporte").val();
		
		window.parent.$("#Loading").css("display","");
		
		parent.AbrirVentana('VIEW_REPORTES_GENERALES', 'Reporte', "Sistema/Reportes/"+NombreReporte, Parametros, 600, 1200, 0, 1, 1, 1, 1, 0);	
	}
	
	function BuscarEmpresa()
	{		
		buscar = $("#rif").val();
		
		if (buscar != '')
		{
			var parametros = 'searchword='+ buscar;
			$.ajax(
			{
				type: "POST",
				url: "BuscarEmpresa.php",
				data: parametros,
				cache: false,
				beforeSend: function() 
				{			
					//Loading2(1);
				},
				success: function(html)
				{
					//Loading2(0);
					$("#Empresas").html(html).show();
				}
			});
		}
		else
		{
			$( "#Empresas" ).hide("fadeout");
		} 
	}
	
	function Empresa(RIF)
	{
		$("#Empresas").hide("fadeout");
		$("#rif").val(RIF);			
		$("#rif").attr("disabled",true);
		$("#limpiar").show();	
	}

	function limpiar()
	{
		$("#limpiar").hide();
		$("#rif").attr("disabled",false);
		$("#rif").val("");
		$("#rif").focus();
	}
<?php
	$resp="
		function desbloquear(id)
		{";
	
			$vSQL = "select * from tb_argumrep_gral ";
			
			if($result=$conector->Ejecutar($vSQL))
			{
				$aux = 1;
				while(odbc_fetch_row($result))
				{
					$script = "$('#tr".odbc_result($result,'argumento')."').show(); ";
					$resp .="
					if (id ==".odbc_result($result,'id_argumrep_gral')." )
					{ 
						$script
					}";
				}
			}
			else
			{
				echo $vSQL;
				exit;
			}
	
		$resp .="
		}
		";
		
		echo $resp;
?>
</script>
</head>
<body>
        <p>&nbsp;</p>
<p>&nbsp;</p>
        <form action="javascript: impr_reporte()" method="post" id="frm_per" onSubmit="return RecorrerForm('frm_per')">
          <input type="hidden" name="NombreReporte" id="NombreReporte">
        <table width="367" border="0" align="center" style="margin:auto;">
          <tr>
            <td width="157" align="right">Tipo:</td>
            <td width="194">
              <select name="reportes" id="reportes" onChange="Reportes(this.values)">
                <option value="0">SELECCIONE...</option>
                <?php 
                        $vSQL="select * from tb_reporte where nb_hoja is not null and fg_activo=1 order by nb_reporte asc";
					if($result=$conector->Ejecutar($vSQL))
						{
							while(odbc_fetch_row($result))
							{ 
								if($ID_USUARIO!=87 and $ID_ROL!=30)
								{
									$resp .="<option value='".odbc_result($result,'ID_reporte')."'>".odbc_result($result,'nb_reporte')."</option>"; 
								}
								else
								{
									if($ID_ROL==30)
									{
										if(odbc_result($result,'ID_reporte')==1)
										{
											$resp .="<option value='".odbc_result($result,'ID_reporte')."'>".odbc_result($result,'nb_reporte')."</option>"; 
										}
									}
									else
									{
										if(odbc_result($result,'ID_reporte')==20)
										{
											$resp .="<option value='".odbc_result($result,'ID_reporte')."'>".odbc_result($result,'nb_reporte')."</option>"; 
										}
									}
								}
							}
							
							echo $resp;
						}
						else
						{
							echo $vSQL;
							exit;
						}
                    ?>
            </select></td>
          </tr>
          
          <tr id="trANO_REGISTRO" style="display:none">
            <td align="right">Período:</td>
            <td>
            <select name="ANO_REGISTRO" id="ANO_REGISTRO">
            	<option value='0'>SELECCIONE...</option>
            <?php
            	$CadCategorias="";
				
				$vSQL="SELECT 
								*
							FROM            
								TB_PERIODO ORDER BY ANO_REGISTRO DESC";
								
				if($result=$conector->Ejecutar($vSQL))
				{					
					while(odbc_fetch_row($result))
					{
						$ANO_REGISTRO=odbc_result($result,'ANO_REGISTRO');
						$option.="<option value='$ANO_REGISTRO'>$ANO_REGISTRO</option>";
					}
					
					echo $option;
				}
				else
				{
					echo $vSQL;
					exit;
				}
			?>
            </select>
            </td>
          </tr>
          <tr id="trrif" style="display:none">
            <td align="right">RIF:</td>
            <td>
            <input type="text" id="rif" name="rif" onKeyUp="BuscarEmpresa()" autocomplete="off" style="float:left;"/>
            <a style="float:left; width:20px; height:20px; margin-left:5px; cursor:pointer; display:none;" id="limpiar" href="javascript: " onClick="limpiar()">
            	<img style="width:20px; height:20px;" src="../../imagen/eliminar.png"/>
            </a>
			<div style="float:left;" id="Empresas"></div>
            </td>
          </tr>
         <!-- <tr id="trAbogado" style="display:none">
            <td align="right">Abogado:</td>
            <td>
            <input type="text" id="Abogado" name="Abogado" onKeyUp="BuscarAbogado()" autocomplete="off" style="float:left;"/>
            <a style="float:left; width:20px; height:20px; margin-left:5px; cursor:pointer; display:none;" id="limpiar2" href="javascript: " onClick="limpiar2()">
            	<img style="width:20px; height:20px;" src="../../imagen/eliminar.png"/>
            </a>
			<div style="float:left;" id="Abogado"></div>
            </td>
          </tr>-->
          <tr id="trtipo_doc" style="display:none">
            <td align="right">Tipo Documento:</td>
            <td>
              <select name="tipo_doc" id="tipo_doc">
                <option value="0">SELECCIONE...</option>
                <?php 
                        $resp ="";
                        $vSQL="select * from tb_tipo_acta WHERE FG_ACTIVO=1 order by id_tacta";
						
						if($result=$conector->Ejecutar($vSQL))
						{
							while(odbc_fetch_row($result))
							{ 
								$resp .="<option value='".odbc_result($result,'id_tacta')."'>".utf8_encode(odbc_result($result,'nb_tacta'))."</option>"; 
							}
							echo $resp;
						}
						else
						{
							echo $vSQL;
							exit;
						}
                    ?>
            </select></td>
          </tr>
          <tr id="trpuerto" style="display:none">
            <td align="right">Puerto:</td>
            <td>
              <select name="puerto" id="puerto">
                <option value="0">SELECCIONE...</option>
                <?php 
                        $resp ="";
                        $vSQL="select * from tb_localidad order by id_localidad";
						
						if($result=$conector->Ejecutar($vSQL))
						{
							while(odbc_fetch_row($result))
							{ 
								if($ID_USUARIO!=87)
								{
									$resp .="<option value='".odbc_result($result,'id_localidad')."'>".odbc_result($result,'nb_localidad')."</option>"; 
								}
								else
								{
									if(odbc_result($result,'id_localidad')==1)
									{
										$resp .="<option value='".odbc_result($result,'id_localidad')."'>".odbc_result($result,'nb_localidad')."</option>"; 															
									}
								}
							}
							echo $resp;
						}
						else
						{
							echo $vSQL;
							exit;
						}
                    ?>
            </select></td>
          </tr>
          <tr id="trf_desde" style="display:none">
            <td align="right">Desde:</td>
            <td>
              <input type="text" id="f_desde" readonly />
            </td>
          </tr>
          <tr id="trf_hasta" style="display:none">
            <td align="right">Hasta:</td>
            <td>
            <input type="text" id="f_hasta" readonly/></td>
          </tr>
          <tr id="trcategoria" style="display:none">
            <td align="right">Categoría:</td>
            <td>
            <select name="categoria" id="categoria">
            	<option value='0'>SELECCIONE...</option>
            <?php
            	$CadCategorias="";
	
				if($ID_USUARIO==87)
				{
					$CadCategorias=" AND ID_CATEGORIA=5 OR ID_CATEGORIA=6 OR ID_CATEGORIA=8";	
				}
				
				$vSQL="SELECT 
								*
							FROM            
								TB_CATEGORIA
							WHERE        
								(ID_CATEG_PPAL <> 0) $CadCategorias";
								
				if($result=$conector->Ejecutar($vSQL))
				{
					$option="<option value='2000'>TODAS</option>";
					
					while(odbc_fetch_row($result))
					{
						$ID_CATEGORIA=odbc_result($result,'ID_CATEGORIA');
						$NB_CATEGORIA=utf8_decode(odbc_result($result,'NB_CATEGORIA'));
						$option.="<option value='$ID_CATEGORIA'>$NB_CATEGORIA</option>";
					}
					
					echo $option;
				}
				else
				{
					echo $vSQL;
					exit;
				}
			?>
            </select>
            </td>
          </tr>
          <tr id="trNroPreliquidacion" style="display:none">
            <td align="right">Preliquidación:</td>
            <td>
              <input type="text" id="NroPreliquidacion" />
            </td>
          </tr>
          <tr id="trAbogado" style="display:none">
            <td align="right">Abogado:</td>
            <td>
              <select name="Abogado" id="Abogado">
                <option value="0">SELECCIONE...</option>
                <?php
					//buscar localidad del usuario 
					$resp='';
					$vSQL="SELECT ID_LOCALIDAD FROM USUARIO WHERE ID_USUARIO=$ID_USUARIO";
					
					if($result=$conector->Ejecutar($vSQL))
					{
						while(odbc_fetch_row($result))
						{ 
							$id_localidad_user=	odbc_result($result,'ID_LOCALIDAD');
						}
					}
					
					if($id_localidad_user==7)//sede central
					{
					   	
							//todos los puertos 
							$vSQL="SELECT ID_USUARIO, AP_USUARIO+','+NB_USUARIO AS NOMBRE FROM USUARIO WHERE ID_LOCALIDAD<>$id_localidad_user AND  SIG_TITULO LIKE 'ABOG.'";
							if($result=$conector->Ejecutar($vSQL))
							{
								while(odbc_fetch_row($result))
								{ 
								
								$resp .="<option value='".odbc_result($result,'ID_USUARIO')."'>".utf8_encode(odbc_result($result,'NOMBRE'))."</option>"; 
								
								}
							}
					   }
					   else//sede central
					   {
					   	
							//todos los puertos 
							$vSQL="SELECT ID_USUARIO, AP_USUARIO+','+NB_USUARIO AS NOMBRE FROM USUARIO WHERE ID_LOCALIDAD=$id_localidad_user AND SIG_TITULO LIKE 'ABOG.'";
							if($result=$conector->Ejecutar($vSQL))
							{
								while(odbc_fetch_row($result))
								{ 
								
								$resp .="<option value='".odbc_result($result,'ID_USUARIO')."'>".utf8_encode(odbc_result($result,'NOMBRE'))."</option>"; 
								
								}
							}
					   }
					   
					   echo $resp;
                ?>
              </select>
            </td>
          </tr>
          <tr id="trano" style="display:none">
            <td align="right">A&ntilde;o:</td>
            <td>
                 <select name="ano" id="ano">
                <option value="0">SELECCIONE...</option>
                <?php
                $vSQL="SELECT ano_registro FROM tb_periodo";
					$resp='';
					if($result=$conector->Ejecutar($vSQL))
					{
						while(odbc_fetch_row($result))
						{ 
							$resp .="<option value='".odbc_result($result,'ano_registro')."'>".odbc_result($result,'ano_registro')."</option>"; 
						}
					}
					echo $resp;
					
					$conector->Cerrar();
				?>
                </select>	
            </td>
          </tr>
          <tr id="trmes" style="display:none">
            <td align="right">Mes:</td>
            <td>
                 <select name="mes" id="mes">
                <option value="0">SELECCIONE...</option>
                <option value="1">ENERO</option>
                <option value="2">FEBRERO</option>
                <option value="3">MARZO</option>
                <option value="4">ABRIL</option>
                <option value="5">MAYO</option>
                <option value="6">JUNIO</option>
                <option value="7">JULIO</option>
                <option value="8">AGOSTO</option>
                <option value="9">SEPTIEMBRE</option>
                <option value="10">OCTUBRE</option>
                <option value="11">NOVIEMBRE</option>
                <option value="12">DICIEMBRE</option>
                
                </select>	
            </td>
          </tr>
        </table>
        <p>&nbsp;</p>
        <div style="margin:auto; border:#000 solid 0px; text-align:center">
            <input name="agregar" type="submit" id="agregar" value="Agregar" class="button small btnSistema"/>
            <input name="cancelar" type="button" id="cancelar" value="Cancelar" onClick="javascript:parent.CerrarVentana('<?php echo $IdVentana;?>');" class="button small btnSistema"/>
        </div>
        </form>
</body>
</html>