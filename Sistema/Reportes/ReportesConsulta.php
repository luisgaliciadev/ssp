<?php
	$Nivel="../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	$ID_USUARIO=$_SESSION[$SiglasSistema.'ID_USUARIO'];
	
	$id_reporte=$_POST['id_reporte'];
	
	$vSQL="SELECT        dbo.TB_ARGUMREP_GRAL.ARGUMENTO, dbo.TB_REPORTE.NB_HOJA, dbo.TB_REPORTE.NB_REPORTE
FROM            dbo.TB_ARGUMREP_GRAL INNER JOIN
                         dbo.TB_REPORTE_ARGUM ON dbo.TB_ARGUMREP_GRAL.ID_ARGUMREP_GRAL = dbo.TB_REPORTE_ARGUM.ID_ARGUMREP_GRAL INNER JOIN
                         dbo.TB_REPORTE ON dbo.TB_REPORTE_ARGUM.ID_REPORTE = dbo.TB_REPORTE.ID_REPORTE
WHERE        (dbo.TB_REPORTE_ARGUM.ID_REPORTE = $id_reporte)";
					
	if($resultP=$conector->Ejecutar($vSQL))
	{					
		while(odbc_fetch_row($resultP))
		{
			$ite++;
			
			$ARGUMENTO=odbc_result($resultP,'ARGUMENTO');
			$NB_HOJA=odbc_result($resultP,'NB_HOJA');
			$NB_REPORTE=odbc_result($resultP,'NB_REPORTE');
			
			if($ite==1)
			{
          		echo '<input type="hidden" name="NB_HOJA" id="NB_HOJA" value="'.$NB_HOJA.'">';
          		echo '<input type="hidden" name="NB_REPORTE" id="NB_REPORTE" value="'.$NB_REPORTE.'">';
			}
			
			switch($ARGUMENTO)
			{
			  case "ANO_REGISTRO":
		?>          
			  <tr id="trANO_REGISTRO">
				<td align="right">Período:</td>
				<td>
				<select name="ANO_REGISTRO" id="ANO_REGISTRO" title="No debe estar vacio">
					<option value=''>SELECCIONE...</option>
				<?php
					$CadCategorias="";
					
					$vSQL="SELECT 
									*
								FROM            
									TB_PERIODO ORDER BY ANO_REGISTRO DESC";
					
					$option="";
								
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
					}
				?>
				</select>
				</td>
			  </tr>
			  <?php
			  break;
			  
			  case "rif":
				?>
			  <tr id="trrif">
				<td align="right">RIF:</td>
				<td>
                <input type="text" id="rif" name="rif" onkeyup="ValidarTecla(event);" style="float:left; width:100px;"  title="No debe estar vacio"/>
                <input name="BtnBuscar" type="button" id="BtnBuscar" value="Buscar" class="button small btnSistema" onClick="BuscarEmpresa();" style="float:left; margin-top:-2px;"/>
                <a style="float:left; width:20px; height:20px; margin-left:5px; cursor:pointer; display:none;" id="limpiar" href="javascript: " onclick="limpiar2()">
                    <img style="width:20px; height:20px;" src="../../imagen/eliminar.png"/>
                </a>
                <div style="float:left;" id="Empresas"></div>
				</td>
			  </tr>
			  <?php
			  break;
			  
			  case "tipo_doc":
				?>
			  <tr id="trtipo_doc">
				<td align="right">Tipo Documento:</td>
				<td>
				  <select name="tipo_doc" id="tipo_doc" title="No debe estar vacio">
					<option value="">SELECCIONE...</option>
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
							}
						?>
				</select></td>
			  </tr>
			  <?php
			  break;
			  
			  case "puerto":
				?>
			  <tr id="trpuerto">
				<td align="right">Puerto:</td>
				<td>
				  <select name="puerto" id="puerto" title="No debe estar vacio">
					<option value="">SELECCIONE...</option>
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
							}
						?>
				</select></td>
			  </tr>
			  <?php
			  break;
			  
			  case "f_desde":
				?>
			  <tr id="trf_desde">
				<td align="right">Desde:</td>
				<td>
				  <input type="text" id="f_desde" readonly  title="No debe estar vacio"/>
				</td>
			  </tr>
			  <?php
			  break;
			  
			  case "f_hasta":
				?>
			  <tr id="trf_hasta">
				<td align="right">Hasta:</td>
				<td>
				<input type="text" id="f_hasta" readonly title="No debe estar vacio"/></td>
			  </tr>
			  <?php
			  break;
			  
			  case "categoria":
				?>
			  <tr id="trcategoria">
				<td align="right">Categoría:</td>
				<td>
				<select name="categoria" id="categoria" title="No debe estar vacio">
					<option value=''>SELECCIONE...</option>
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
						
						$option="";
										
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
						}
					?>
				</select>
				</td>
			  </tr>
			  <?php
			  break;
			  
			  case "NroPreliquidacion":
				?>
			  <tr id="trNroPreliquidacion">
				<td align="right">Preliquidación:</td>
				<td>
				  <input type="text" id="NroPreliquidacion"  title="No debe estar vacio"/>
				</td>
			  </tr>
			  <?php
			  break;
			  
			  case "Abogado":
				?>
			  <tr id="trAbogado">
				<td align="right">Abogado:</td>
				<td>
				  <select name="Abogado" id="Abogado" title="No debe estar vacio">
					<option value="">SELECCIONE...</option>
					<?php
						//buscar localidad del usuario 
						$resp='';
						$vSQL="SELECT ID_LOCALIDAD FROM USUARIO WHERE ID_USUARIO=$ID_USUARIO";
						
						if($result=$conector->Ejecutar($vSQL))
						{
							odbc_fetch_row($result);
							$id_localidad_user=	odbc_result($result,'ID_LOCALIDAD');
						}
						
						if($id_localidad_user==7)//sede central
						{
							
								//todos los puertos 
								$vSQL="SELECT ID_USUARIO, AP_USUARIO+','+NB_USUARIO AS NOMBRE FROM USUARIO WHERE ID_LOCALIDAD<>$id_localidad_user AND SIG_TITULO LIKE 'ABOG.'";
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
			  <?php
			  break;
			  
			  case "ano":
				?>
			  <tr id="trano">
				<td align="right">A&ntilde;o:</td>
				<td>
					 <select name="ano" id="ano" title="No debe estar vacio">
					<option value="">SELECCIONE...</option>
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
			  <?php
			  break;
			  
			  case "mes":
				?>
			  <tr id="trmes">
				<td align="right">Mes:</td>
				<td>
					 <select name="mes" id="mes" title="No debe estar vacio">
					<option value="">SELECCIONE...</option>
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
			  <?php
			  break;
			  
			  
			  case "status":
		?>          
			  <tr id="trstatus">
				<td align="right">Estatus:</td>
				<td>
				<select name="status" id="status" title="No debe estar vacio">
					<option value=''>SELECCIONE...</option>
					<option value='100'>Todos</option>
					<option value='1'>Recepcionada</option>
					<option value='2'>Asignado</option>
					<option value='4'>Verificada</option>
				</select>
				</td>
			  </tr>
			  <?php
			  break;
			}
		}
	}
	else
	{
		echo $vSQL;
	}
	
	$conector->Cerrar();
?>