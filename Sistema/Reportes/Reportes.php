<?php
	$Nivel="../../";	
	include($Nivel."includes/PHP/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	$ID_USUARIO=$_SESSION[$SiglasSistema.'ID_USUARIO'];
	
	$IdVentana=$_GET['IdVentana'];	
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
$( document ).ready(function() {
			window.parent.parent.Cargando(0);
});
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
			url: "ReportesConsulta.php",
			data: id_reporte,
			cache: false,
			beforeSend: function() 
			{			
				window.parent.$("#Loading").css("display","");
			},
			success: function(html)
			{							
				window.parent.$("#Loading").css("display","none");
				
				$("#tablaReportes").html(html);
				
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
				
				$('#f_hasta').datepicker('setDate', 'today');				
				$('#f_desde').datepicker('setDate', 'today');	
			}
		});
	}
	
	function impr_reporte()
	{
		if($('#reportes').val()!='0')
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
			
			if ($('#status').is(':visible'))
			{
				if ($('#status').val() == ''){
					window.parent.toastr.error("Disculpe, debe ingresar el nro de la preliquidacion")
					return
				}else
					if (aux == 0)
					{
						Parametros+="status="+$('#status').val()
						aux = 1
					}else
						Parametros+="&status="+$('#status').val()		
			}
			
			ID_REPORTE=$("#reportes").val();
			NB_HOJA=$("#NB_HOJA").val();
			NB_REPORTE=$("#NB_REPORTE").val();
			
			window.parent.$("#Loading").css("display","");			
			
			//parent.AbrirVentana(replaceAll(' ', '', NB_REPORTE), "REPORTE "+NB_REPORTE, "Sistema/Reportes/"+NB_HOJA, Parametros, 600, 1200, 0, 1, 1, 1, 1, 0);
			parent.AbrirVentana(ID_REPORTE, "REPORTE "+NB_REPORTE, "Sistema/Reportes/"+NB_HOJA, Parametros, 600, 1200, 0, 1, 1, 1, 1, 0);
		}
	}
	
	function replaceAll(vfind, vreplace, str) 
    {
      while( str.indexOf(vfind) > -1)
      {
        str = str.replace(vfind, vreplace);
      }
      return str;
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
					window.parent.$("#Loading").css("display","");
				},
				success: function(html)
				{
					window.parent.$("#Loading").css("display","none");
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
		$("#BtnBuscar").hide();
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
	
	function ValidarTecla(e)
	{
		var key=e.keyCode || e.which;
		
		if (key==13)
		{
			BuscarEmpresa();
		}
		e.preventDefault();	
	}
	
	function limpiar2()
	{
		$("#limpiar").hide("fadeout");
		$("#BtnBuscar").show("fadeout");
		$("#rif").attr("disabled",false);
		$("#rif").val("");
		$("#rif").focus();		
	}
	
	function Aceptar()
	{
		if(RecorrerForm('frm_per'))
		{
			impr_reporte()
		}
		else
		{
			window.parent.toastr.error('Disculpe, debe ingresar los datos!');
		}
	}
</script>
</head>
<body>
        <p>&nbsp;</p>
<p>&nbsp;</p>
        <form action="javascript: " method="post" id="frm_per">
        <table width="367" border="0" align="center" style="margin:auto;">
          <tr>
            <td width="157" align="right">Tipo:</td>
            <td width="194">
              <select name="reportes" id="reportes" onChange="Reportes(this.values)">
                <option value="0">SELECCIONE...</option>
                <?php 
                        $vSQL="select * from tb_reporte where nb_hoja is not null and fg_activo=1 and fg_seg_por=0  and fg_comer=0 order by nb_reporte asc";
						
						if($result=$conector->Ejecutar($vSQL))
						{
							while(odbc_fetch_row($result))
							{ 
								$resp .="<option value='".odbc_result($result,'ID_reporte')."'>".odbc_result($result,'nb_reporte')."</option>"; 
							}
							
							echo $resp;
						}
						else
						{
							echo $vSQL;
						}
						
						$conector->Cerrar();
                    ?>
            </select></td>
          </tr>
          <tbody id="tablaReportes">
          </tbody>
        </table>
        <p>&nbsp;</p>
        <div style="margin:auto; border:#000 solid 0px; text-align:center">
            <input name="agregar" type="button" id="agregar" value="Agregar" class="button small btnSistema" onClick="Aceptar();"/>
            <input name="cancelar" type="button" id="cancelar" value="Cancelar" onClick="javascript:parent.CerrarVentana('<?php echo $IdVentana;?>');" class="button small btnSistema"/>
        </div>
        </form>
</body>
</html>