<?php
	$Nivel="../../../";
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();

	$id_localidad = $_SESSION[$SiglasSistema."id_localidad"]; 
	$CI_USUARIO = $_SESSION[$SiglasSistema."CI_USUARIO"];
	$ID_USUARIO=$_SESSION[$SiglasSistema.'ID_USUARIO'];
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	
	$id_empresa = $_GET["id_empresa"];
	$ANO_REGISTRO = $_GET["ANO_REGISTRO"];
	$Opc = $_GET["Opc"];
	
	switch($Opc)
	{
		case 1:	
				$sql="SELECT * FROM VIEW_DATOS_EMPRESA WHERE ID_EMPRESA=$id_empresa";
				
				if($rs=$conector->Ejecutar($sql))
				{
					$rif		=	odbc_result($rs,"RIF");	
					$razon		=	odbc_result($rs,"RAZON_SOCIAL");
					$direccion	=	odbc_result($rs,"DIRECC_FISCAL");	
					$objeto		=	odbc_result($rs,"OBJETO_EMPRESA");
					$telef1		=	odbc_result($rs,"TELEF1");	
					$telef2		=	odbc_result($rs,"TELEF2");	
					$email1		=	odbc_result($rs,"E_MAIL1");	
					$email2		=	odbc_result($rs,"E_MAIL2");	
					$Clasificaion=	odbc_result($rs,"NB_CLASIF_EMPR");	
					$F_VENC_RIF=	odbc_result($rs,"F_VENC_RIF");	
					
					$FG_BLOQUEADO=	odbc_result($rs,"FG_BLOQUEADO");
					$NB_MOTIVO_BLOQUEO=	odbc_result($rs,"NB_MOTIVO_BLOQUEO");	
					$MOTIVO_BLOQUEO=	odbc_result($rs,"MOTIVO_BLOQUEO");		
					$F_BLOQUEO=	odbc_result($rs,"F_BLOQUEO");	
					
					if($FG_BLOQUEADO)
					{
						$FG_BLOQUEADO_DS="SI";
						$F_BLOQUEO=fecha_normal($F_BLOQUEO);				
					}
					else
					{
						$FG_BLOQUEADO_DS="NO";
						$NB_MOTIVO_BLOQUEO="N/A";
						$MOTIVO_BLOQUEO="N/A";
						$F_BLOQUEO="N/A";
					}
					
					if($F_VENC_RIF)
						$F_VENC_RIF=fecha_normal($F_VENC_RIF);
						
					
					if($telef2<>'')
					{
						$tef=$telef1.' / '.$telef2;
					}
					else
					{
						$tef=$telef1;
					}
					
					if($email2<>'')
					{
						$email=$email1.' / '.$email2;
					}
					else
					{
						$email=$email1;
					}
				}
				else
				{
					echo $sql;
				}
				
				$sql="SELECT * FROM VIEW_SUCURSAL_EMPRE WHERE ID_EMPRESA=$id_empresa";
				
				if($rs=$conector->Ejecutar($sql))
				{
					$estado		=	odbc_result($rs,"NB_ESTADO");	
					$sucursal	=	($estado.' - '.$sucursal);
				}
				else
				{
					echo $sql;
				}
			?>
			
			<table class="table" bordercolor="#CCCCCC" border="1" align='center' cellpadding="0" cellspacing="0" style="margin:auto; border-collapse:collapse; border: 1px solid #CCCCCC; width:1050px">
			  <tr>
				<th width="155" align="left" >
				  RAZON SOCIAL:</th>
				<td width="1139" align="left">
				  <?php echo $razon;?>
				  
				</td>
			  </tr>
			  <tr>
				<th width="155" align="left">
				  RIF:
			    </th>
				<td width="1139" align="left">
				  <?php echo $rif;?>
			    </td>
			  </tr>
			  <tr>
				<th width="155" align="left">
				  FECHA VENCE RIF:
			    </th>
				<td width="1139" align="left">
				  <?php echo $F_VENC_RIF;?></td>
			  </tr>
			  <tr>
				<th width="155" align="left">DIRECCI&Oacute;N:</th>
				<td width="1139" align="left"><?php echo $direccion;?></td>
			  </tr>
			  <tr>
				<th width="155" align="left">SUCURSALES:</th>
				<td width="1139" align="left"><?php echo $sucursal;?></td>
			  </tr>
			  <tr>
				<th width="227" align="left">
				  CLASIFICACION
				</th>
				<td width="1071" align="left">
				  <?php echo $Clasificaion;?>
				</td>
			  </tr>
			  <tr>
				<th width="227" align="left">
				  OBJETO DE LA EMPRESA
				</th>
				<td width="1071" align="left">
				  <?php echo $objeto;?>
				</td>
			  </tr>
			  <tr>
				<th width="227" align="left">
				  TEL&Eacute;FONO (S)
				</th>
				<td width="1071" align="left">
				  <?php echo $tef;?></td>
			  </tr>
			  <tr>
				<th width="227" align="left">
				  EMAIL (S)
				</th>
				<td width="1071" align="left">
				  <?php echo $email;?></td>
			  </tr>
			  <tr>
				<th width="227" align="left">
				  BLOQUEADO
				</th>
				<td width="1071" align="left">
				  <?php echo $FG_BLOQUEADO_DS;?></td>
			  </tr>
			  <tr>
				<th width="227" align="left">
				  TIPO BLOQUEO
				</th>
				<td width="1071" align="left">
				  <?php echo $NB_MOTIVO_BLOQUEO;?></td>
			  </tr>
			  <tr>
				<th width="227" align="left">
				  MOTIVO BLOQUEO
				</th>
				<td width="1071" align="left">
				  <?php echo $MOTIVO_BLOQUEO;?></td>
			  </tr>
			  <tr>
				<th width="227" align="left">
				  FECHA BLOQUEO
				</th>
				<td width="1071" align="left">
				  <?php echo $F_BLOQUEO;?></td>
			  </tr>
			</table>
			<br />
			<br />
			<table width="885" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="width:1050px; margin:auto;">
			  <tr>
			   <th colspan="8" align='center'>REGISTRO MERCANTIL</th>
			   </tr>
			 <tr>
					<th width="130" align='center'>
						CIRCUSCRIPCI&Oacute;N
					</th>
				   <th width="130" align='center'>
						FECHA
					</th>
					<th width="130" align='center'>
						N&Uacute;MERO
					</th>
					<th width="130" align='center'>
						TOMO
					</th>
			</tr>
			
			<?php
			$sql="SELECT ID_REG_MERC,NB_ESTADO,F_REG_MERC,NRO_REG,TOMO_REG,ACTA_ASAMB,F_ASAMB,NRO_ASAMB,TOMO_ASAMB FROM VIEW_RP_LISTADO_REG_MERCANTIL WHERE ID_EMPRESA=$id_empresa AND ID_ESTADO IS NULL";
			
			if($rs=$conector->Ejecutar($sql))
			{
				$NRO_REG		=	odbc_result($rs,"NRO_REG");	
				$TOMO_REG		=	odbc_result($rs,"TOMO_REG");
				$nb_estado	=	odbc_result($rs,"NB_ESTADO");
				$F_REG_MERC	=	fecha_normal(odbc_result($rs,"F_REG_MERC")); 
			}
			else
			{
				echo $sql;
			}
			?>
			
			
			<tr>
                <td width="130" align='center'>
                	<?php echo $nb_estado;?>
                </td>
                <td width="130" align='center'>
                	<?php echo $F_REG_MERC;?>
                </td>
                <td width="130" align='center'>
                	<?php echo $NRO_REG;?>
                </td>
                <td width="130" align='center'>
                	<?php echo $TOMO_REG;?>
                </td>
			</tr>
			</table> 
			<br />
			<br />
			<table width="885" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" style="width:1050px; margin:auto;">
			  <tr>
			   <th colspan="8" align='center'>ACTAS DE ASAMBLEAS</th>
		      </tr>
			 <tr>
					<th width="130" align='center'>
						ACTA DE ASAMBLEA
					</th>
					 <th width="130" align='center'>
						FECHA ASAMBLEA
					</th>
					 <th width="130" align='center'>
						N&Uacute;MERO ASAMBLEA
					</th>
					<th width="130" align='center'>
						TOMO ASAMBLEA
					</th>
			</tr>
			
			<?php
			$sql="SELECT ID_REG_MERC,NB_ESTADO,F_REG_MERC,NRO_REG,TOMO_REG,ACTA_ASAMB,F_ASAMB,NRO_ASAMB,TOMO_ASAMB FROM VIEW_RP_LISTADO_REG_MERCANTIL WHERE ID_EMPRESA=$id_empresa AND (ID_ESTADO='0' OR ACTA_ASAMB IS NULL)";
			
			if($rs=$conector->Ejecutar($sql))
			{
				while(odbc_fetch_row($rs))
				{
					$ACTA_ASAMB	=	odbc_result($rs,"ACTA_ASAMB");	
					$NRO_ASAMB	=	odbc_result($rs,"NRO_ASAMB");	
					$TOMO_ASAMB		=	odbc_result($rs,"TOMO_ASAMB");	
					$F_ASAMB	=	fecha_normal(odbc_result($rs,"F_ASAMB"));
?>

                    <tr>
                        <td width="130" align='center'>
                            <?php echo $ACTA_ASAMB;?>
                        </td>
                        <td width="130" align='center'>
                            <?php echo $F_ASAMB;?>
                        </td>
                        <td width="130" align='center'>
                            <?php echo $NRO_ASAMB;?>
                        </td>
                        <td width="130" align='center'>
                            <?php echo $TOMO_ASAMB;?>
                        </td>
                    </tr>
<?php
				}
			}
			else
			{
				echo $sql;
			}
			?>			
			</table>  
<?php			
			$sql="SELECT COUNT(ID_EMPRESA) AS CONT_EMP FROM VIEW_SOCIO_EMPRE WHERE ID_EMPRESA=$id_empresa";
			if($rs=$conector->Ejecutar($sql))
			{
				while (odbc_fetch_row($rs))  
				{	
					$cont_socio	=	odbc_result($rs,"CONT_EMP");	
					if($cont_socio>0)
					{
					?> 
					<br />
			<br />
						<!--SOCIOS-->
					<table width="885" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC"  style="width:1050px; margin:auto;" >
							<tr>
							  <th colspan="3" align='center'>SOCIOS</th>
						  </tr>
							<tr> 
							 <th width="170" align="center">
								RIF
							 </th>
							 <th width="170" align="center">
								NOMBRE SOCIO
							 </th>
							 <th width="170" align="center">
								TIPO CLASIF.
							 </th>
							</tr>
							<?php
							$sql="SELECT * FROM VIEW_SOCIO_EMPRE WHERE ID_EMPRESA=$id_empresa";
							$pintar=0;
							if($rs2=$conector->Ejecutar($sql))
							{
							while (odbc_fetch_row($rs2))  
							{
								if($pintar)
								{
									$clase="class='color'";
									$pintar=0;
								}
								else
								{
									$clase="class='Normal'";
									$pintar=1;
								} 
								
								$rif			=	odbc_result($rs2,"RIF");	
								$nob_socio		=	odbc_result($rs2,"NOMBRE_SOCIO");	
								$clasif			=	odbc_result($rs2,"NB_CLASIF_EMPR");	
								
							?>
							<tr <?php echo $clase;?>>
							   <td width="170" align="center">
										
										<?php echo $rif;?>
							  </td>
								<td width="170" align="center">
										
										<?php echo $nob_socio;?>
								</td>
								<td width="170" align="center">
										
										<?php echo $clasif;?>
								</td>
							</tr>        
								
							<?php
								
							}
						}
						else
						{
							echo $sql;
						}
							?>
					</table>
						<!--SOCIOS-->
					<?php
					}
				}
			}
			else
			{
				echo $sql;
			}
		break;
		
		case 2:
				?>
			 	<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="border-collapse:collapse; width:1050px; margin:auto;">
    	<tr> 
           <th width="70" align='center' valign="middle">
                    NRO. PRE
        	</th>
           <th width="70" align='center' valign="middle">
                    TIPO PRELIQ
        	</th>
            <th width="100" align='center' valign="middle">
                    F. RESGISTRO
        	</th>
            <th width="100" align='center' valign="middle">
                    F. PRELIQUI
        	</th>
            <th width="80" align='center' valign="middle">
                    BASE IMPO.
        	</th>
            <th width="80" align='center' valign="middle">
                    MONTO EXEN.
        	</th>
            <th width="80" align='center' valign="middle">
                    IVA %
        	</th>
            <th width="80" align='center' valign="middle">
                    MTO. IVA
        	</th>
            <th width="80" align='center' valign="middle">
                    TOTAL
        	</th>
            <th width="170" align='center' valign="middle">
                    LOCALIDAD
        	</th>
            <th width="50" align='center' valign="middle">
                    NRO. FACT.
        	</th>
            <th width="50" align='center' valign="middle">
                    SALDO PRE.
        	</th>
            <th width="50" align='center' valign="middle">
                    FACTURADA
        	</th>
            <th width="50" align='center' valign="middle">
                    ESTATUS
        	</th>
          </tr>
 
 <?php
				
	$sql="SELECT *
FROM            VIEW_PRELIQUIDACIONES_EMPRESAS
WHERE        ID_EMPRESA = $id_empresa and ANO_REGISTRO=$ANO_REGISTRO
";
			
	if($rs2=$conector->Ejecutar($sql))
	{
		
		$det = '';
		$pintar=0;
		
		while (odbc_fetch_row($rs2))  
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$ID_PRELIQUIDACION			=	odbc_result($rs2,"ID_PRELIQUIDACION");
			$BASE_IMPONIBLE	  		 	=	number_format(odbc_result($rs2,"BASE_IMPONIBLE"),2,",",".");	
			$MONTO_EXENTO				=	number_format(odbc_result($rs2,"MONTO_EXENTO"),2,",",".");	
			$VALOR_IVA				  	=	number_format(odbc_result($rs2,"VALOR_IVA") * 100,2,",",".");	
			$MONTO_IVA		  			=	number_format(odbc_result($rs2,"MONTO_IVA"),2,",",".");	
			$MONTO_PRELIQ_BS			=	number_format(odbc_result($rs2,"MONTO_PRELIQ_BS"),2,",",".");	
			$NB_LOCALIDAD				=	odbc_result($rs2,"NB_LOCALIDAD");
			$NRO_FACTURA				=	odbc_result($rs2,"NRO_FACTURA");
			$SALDO						=	odbc_result($rs2,"SALDO");	
			$ESTATUS				    =	odbc_result($rs2,"ESTATUS");	
			$FG_FACTURADO				=	odbc_result($rs2,"FG_FACTURADO");	
			$ID_TP_PRELIQ				=	odbc_result($rs2,"ID_TP_PRELIQ");	
			$DESC_TIPO_PRELIQUIDA		=	odbc_result($rs2,"DESC_TIPO_PRELIQUIDA");	
			
			$F_REGISTRO					=	(odbc_result($rs2,"F_REGISTRO"));
			
			$FECHA_PRELIQUIDACION				    =	(odbc_result($rs2,"FECHA_PRELIQUIDACION"));	
			
			if($F_REGISTRO)
					$F_REGISTRO	=	fecha_normal($F_REGISTRO);
			
			if($FECHA_PRELIQUIDACION)
					$FECHA_PRELIQUIDACION	=	fecha_normal($FECHA_PRELIQUIDACION);
					
			$FACTURADA="NO";
			
			if($FG_FACTURADO)
			{
				$FACTURADA="SI";
			}
			
			$CAD_ESTATUS="ANULADA";
			
			if($ESTATUS)
			{
				$CAD_ESTATUS="ACTIVA";
			}
			
			if($ID_TP_PRELIQ==2)
			{
				$NB_TIPO="EMPLEADOS";
				
				$sql="SELECT DISTINCT dbo.EMPRE_ACTA.NRO_ACTA, dbo.EMPRE_EMPLEADO.ID_PRELIQUIDACION
	FROM            dbo.EMPRE_ACTA INNER JOIN
							 dbo.EMPRE_EMPLEADO ON dbo.EMPRE_ACTA.ID_EMPR_ACTA = dbo.EMPRE_EMPLEADO.ID_EMPR_ACTA
	WHERE        (dbo.EMPRE_EMPLEADO.ID_PRELIQUIDACION = $ID_PRELIQUIDACION)";
				$rs222=$conector->Ejecutar($sql);
				
				$NRO_ACTA		=	odbc_result($rs222,"NRO_ACTA");	
			}
			else
			{
				if($ID_TP_PRELIQ==3 or $ID_TP_PRELIQ==4)
				{
					$NB_TIPO="VEHÍCULOS";
						
					$sql="SELECT        dbo.EMPRE_ACTA.NRO_ACTA, dbo.EMPRE_VEHICULO.ID_PRELIQUIDACION 
							FROM            dbo.EMPRE_ACTA INNER JOIN
							 dbo.EMPRE_VEHICULO ON dbo.EMPRE_ACTA.ID_EMPR_ACTA = dbo.EMPRE_VEHICULO.ID_EMPR_ACTA
							WHERE        (dbo.EMPRE_VEHICULO.ID_PRELIQUIDACION = $ID_PRELIQUIDACION)";
							
					$rs222=$conector->Ejecutar($sql);
					
					$NRO_ACTA		=	odbc_result($rs222,"NRO_ACTA");	
				}
			}
		
			//$Enlace="<a href='".$Nivel."Sistema/Reportes/PRELIQUIDACION.php?id_pre=$ID_PRELIQUIDACION' target='_blank'>$ID_PRELIQUIDACION</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"Preliquidacion\", \"Preliquidacion\", \"Sistema/Reportes/PRELIQUIDACION.php\", \"id_pre=$ID_PRELIQUIDACION\", 600, 1000, 0, 1, 1, 1, 1);'>$ID_PRELIQUIDACION</a>";		
		
 ?>	
            <tr <?php echo $clase;?>>
                <td align='center'><?php echo $Enlace?>	</td>
                <td align='center'><?php echo utf8_encode($DESC_TIPO_PRELIQUIDA);?></td>
                <td align='center'><?php echo $F_REGISTRO;?></td>
                <td align='center'><?php echo $FECHA_PRELIQUIDACION;?></td>
                <td align="right"><?php echo $BASE_IMPONIBLE;?></td>
                <td align="right"><?php echo $MONTO_EXENTO;?></td>
                <td align="right"><?php echo $VALOR_IVA;?></td>
                <td align="right"><?php echo $MONTO_IVA;?></td>
                <td align="right"><?php echo $MONTO_PRELIQ_BS;?></td>
                <td align='center'><?php echo $NB_LOCALIDAD;?></td>
                <td align='center'><?php echo $NRO_FACTURA;?></td>
                <td align="right"><?php echo $SALDO;?></td>
                <td align='center'><?php echo $FACTURADA;?></td>
                <td align='center'><?php echo $CAD_ESTATUS;?></td>
             </tr>
<?php
		}
	}
	else
	{
		echo $sql;
	}
 ?>	
                
    </table>
<?php
		break;
		
		case 3:
		?>
			<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="70" align='center' valign="middle">
                    NRO. PRE
       	  </th>
            <th width="250" align='center' valign="middle">
                    BANCO
       	  </th>
            <th width="120" align='center' valign="middle">
                    Nº. CTA. BANC.
       	  </th>
            <th width="80" align='center' valign="middle">
                    TIPO.MOV.
       	  </th>
            <th width="120" align='center' valign="middle">
                    REFERENCIA
       	  </th>
            <th width="80" align='center' valign="middle">
                    FECHA
       	  </th>
            <th width="120" align='center' valign="middle">
                    MONTO
       	  </th>
            <th width="120" align='center' valign="middle">
                    SALDO
       	  </th>            
          </tr>
     <?php 
     $sql = "SELECT id_preliquidacion,NB_BANCO,nro_cta_banc,siglas_msl,referencia,f_aplic_pago,mto_usado,MTO_SALDO FROM VIEW_RP_DEP_PRE WHERE id_empresa=$id_empresa";
	 
		if($rs=$conector->Ejecutar($sql))
		{
			$pintar=0;
			while (odbc_fetch_row($rs))
			{
				if($pintar)
				{
					$clase="class='color'";
					$pintar=0;
				}
				else
				{
					$clase="class='Normal'";
					$pintar=1;
				}
			
				$id_preliquidacion	=odbc_result($rs,"id_preliquidacion");
				$NB_BANCO			=odbc_result($rs,"NB_BANCO");
				$nro_cta_banc		=odbc_result($rs,"nro_cta_banc");
				$siglas_msl			=odbc_result($rs,"siglas_msl");
				$referencia			=odbc_result($rs,"referencia");
				$f_aplic_pago		=(odbc_result($rs,"f_aplic_pago"));
				$mto_usado			=number_format(odbc_result($rs,"mto_usado"),2,",",".");
				$mto_saldo			=number_format(odbc_result($rs,"MTO_SALDO"),2,",",".");
				
				if($f_aplic_pago)
					$f_aplic_pago=fecha_normal($f_aplic_pago);
 ?> 
 				<tr <?php echo $clase;?>>
					<td align='center'><?php echo $id_preliquidacion;?></td>
					<td align='center'><?php echo $NB_BANCO;?></td>
					<td align='center'><?php echo $nro_cta_banc;?></td>
					<td align='center'><?php echo $siglas_msl;?></td>
					<td align='center'><?php echo $referencia;?></td>
					<td align='center'><?php echo $f_aplic_pago;?></td>
					<td align="right"><?php echo $mto_usado;?></td>
					<td align="right"><?php echo $mto_saldo;?></td>
				</tr>
<?php
			}
		}
		else
		{
			echo $sql;
		} 
    ?> 
    
    </table> 
    <?php
		break;
		
		case 4:
    ?> 
    		<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="70" align='center' valign="middle">
           		
                    NRO. REF
              
       	  </th>
            <th width="250" align='center' valign="middle">
              
                    DESCRIPCION
              
       	  </th>
            <th width="120" align='center' valign="middle">
              
                    FECHA
              
       	  </th>
            <th width="80" align='center' valign="middle">
              
                    MONTO
              
       	  </th>
            <th width="120" align='center' valign="middle">
              
                    USADO
              
       	  </th>
            <th width="80" align='center' valign="middle">
              
                    MONTO USADO
              
       	  </th>
            <th width="120" align='center' valign="middle">
              
                    SALDO
              
       	  </th>           
          </tr>
     <?php 
     	$sql="SELECT * FROM VIEW_DATOS_EMPRESA WHERE ID_EMPRESA=$id_empresa";
				
				if($rs=$conector->Ejecutar($sql))
				{
					$rif		=	odbc_result($rs,"RIF");	
				}
		$sql = "SELECT distinct 
				REFERENCIA_MOV
				,DESC_MOV
				,FECHA_MOV
				,MTO_MOV
				,FG_USADO
				,SALDO
				,MTO_USADO
			FROM DETALLE_MOVIMIENTO_BANCARIOS
			WHERE rif_cliente like '$rif'";
		
		if($rs=$conector->Ejecutar($sql))
		{
			$res = "";
			$pintar=0;
			while (odbc_fetch_row($rs))
			{
				if($pintar)
				{
					$clase="class='color'";
					$pintar=0;
				}
				else
				{
					$clase="class='Normal'";
					$pintar=1;
				}
			
				$REFERENCIA_MOV	=odbc_result($rs,"REFERENCIA_MOV");
				$DESC_MOV		=odbc_result($rs,"DESC_MOV");
				$FECHA_MOV		=(odbc_result($rs,"FECHA_MOV"));
				$MTO_MOV		=number_format(odbc_result($rs,"MTO_MOV"),2,",",".");
				$FG_USADO		=odbc_result($rs,"FG_USADO");
				$MTO_USADO		=number_format(odbc_result($rs,"MTO_USADO"),2,",",".");
				$SALDO			=number_format(odbc_result($rs,"SALDO"),2,",",".");
				
				if($FECHA_MOV)
					$FECHA_MOV=fecha_normal($FECHA_MOV);
				
				if($FG_USADO)
				{
					$USADO="SI";
				}
				else
				{
					$USADO="NO";
				}
?> 
						<tr <?php echo $clase;?>>
							<td align='center'  ><?php echo $REFERENCIA_MOV;?></td>
							<td align='center'><?php echo $DESC_MOV;?></td>
							<td align='center'><?php echo $FECHA_MOV;?></td>
							<td align='center'><?php echo $MTO_MOV;?></td>
							<td align='center'><?php echo $USADO;?></td>
							<td align='center'><?php echo $SALDO;?></td>
							<td align="right"><?php echo $MTO_USADO;?></td>
						</tr>
<?php
			}
		}
		else
		{
			echo $sql;
		}
    ?> 
    
    </table> 
    
    
    </table> 
    <?php
		break;
		
		case 13:
    ?> 
<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align='center'>
           		
                    NRO.
              
        	</th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
        	</th>
            <th width="114" align='center'>
              
                    F. REGISTRO.
              
        	</th>
            <th width="115" align='center'>
              
                    F. ANULACION.
              
        	</th>
            <th width="110" align='center'>
              
                    F. RECEP.
              
        	</th>
            <th width="110" align='center'>
              
                    ABG. RECEP.
              
        	</th>   
            <th width="74" align='center'>
              
                    F. ASIG.
              
        	</th>
            <th width="108" align='center'>
              
                    ABG. ASIG.
              
        	</th>
            <th width="115" align='center'>
              
                    F. CONFORME
              
        	</th>     
            <th width="141" align='center'>
              
                    ABG. COMFORME.
              
        	</th>    
            <th width="94" align='center'>
              
                    ESTATUS
              
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 1 AND FG_AMBITO_GEOGRAFICO=0 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$F_ANULACION		=odbc_result($rs,"F_ANULACION");
			$F_RECEP			=(odbc_result($rs,"F_RECEP"));
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$F_ASIG				=(odbc_result($rs,"F_ASIG"));
			
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			
			$F_APROB			=(odbc_result($rs,"F_APROB"));
			
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			if($F_RECEP)
				$F_RECEP=fecha_normal($F_RECEP);
			
			if($F_ASIG)
				$F_ASIG=fecha_normal($F_ASIG);
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='ACTA_DOCUMENTO.php?id_empr_acta=".odbc_result($rs,"id_empr_acta")."&id_empresa=$id_empresa'/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"ActaDeDocumentos\", \"Acta de Documentos\", \"Sistema/Reportes/ACTA_DOCUMENTO.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";	

?> 
			<tr <?php echo $clase;?>>
				<td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $F_ASIG;?></td>
				<td align='center'><?php echo $NB_ABG_ASIG;?></td>
				<td align='center'><?php echo $F_APROB;?></td>
				<td align='center'><?php echo $NB_ABG_APROB;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
			  </tr>
<?php
		}
		}
		else
		{
			echo $sql;
		}
?> 
    
    </table>
<?php
		break;
		
		case 21:
    ?> 
<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align='center'>
           		
                    NRO.
              
        	</th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
        	</th>
            <th width="114" align='center'>
              
                    F. REGISTRO.
              
        	</th>
            <th width="115" align='center'>
              
                    F. ANULACION.
              
        	</th>
            <th width="110" align='center'>
              
                    F. RECEP.
              
        	</th>
            <th width="110" align='center'>
              
                    ABG. RECEP.
              
        	</th>   
            <th width="74" align='center'>
              
                    F. ASIG.
              
        	</th>
            <th width="108" align='center'>
              
                    ABG. ASIG.
              
        	</th>
            <th width="115" align='center'>
              
                    F. CONFORME
              
        	</th>     
            <th width="141" align='center'>
              
                    ABG. COMFORME.
              
        	</th>    
            <th width="94" align='center'>
              
                    ESTATUS
              
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 1 AND FG_AMBITO_GEOGRAFICO=1 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$F_ANULACION		=odbc_result($rs,"F_ANULACION");
			$F_RECEP			=(odbc_result($rs,"F_RECEP"));
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$F_ASIG				=(odbc_result($rs,"F_ASIG"));
			
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			
			$F_APROB			=(odbc_result($rs,"F_APROB"));
			
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			if($F_RECEP)
				$F_RECEP=fecha_normal($F_RECEP);
			
			if($F_ASIG)
				$F_ASIG=fecha_normal($F_ASIG);
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='ACTA_DOCUMENTO.php?id_empr_acta=".odbc_result($rs,"id_empr_acta")."&id_empresa=$id_empresa'/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"ActaDeDocumentos\", \"Acta de Documentos\", \"Sistema/Reportes/ACTA_DOCUMENTO.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";	

?> 
			<tr <?php echo $clase;?>>
				<td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $F_ASIG;?></td>
				<td align='center'><?php echo $NB_ABG_ASIG;?></td>
				<td align='center'><?php echo $F_APROB;?></td>
				<td align='center'><?php echo $NB_ABG_APROB;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
			  </tr>
<?php
		}
		}
		else
		{
			echo $sql;
		}
?> 
    
    </table>
<?php
		break;
		
		case 5:
    ?> 
    		<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align='center'>
           		
                    NRO.
              
        	</th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
        	</th>
            <th width="114" align='center'>
              
                    F. REGISTRO.
              
        	</th>
            <th width="115" align='center'>
              
                    F. ANULACION.
              
        	</th>
            <th width="110" align='center'>
              
                    F. RECEP.
              
        	</th>
            <th width="110" align='center'>
              
                    ABG. RECEP.
              
        	</th>   
            <th width="74" align='center'>
              
                    F. ASIG.
              
        	</th>
            <th width="108" align='center'>
              
                    ABG. ASIG.
              
        	</th>
            <th width="115" align='center'>
              
                    F. CONFORME
              
        	</th>     
            <th width="141" align='center'>
              
                    ABG. COMFORME.
              
        	</th>    
            <th width="94" align='center'>
              
                    ESTATUS
              
        	</th>   
            <th width="94" align='center'>
              
                    AMBITO GEOGRAFICO
              
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS,
				FG_AMBITO_GEOGRAFICO
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 2 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$F_ANULACION		=odbc_result($rs,"F_ANULACION");
			$F_RECEP			=(odbc_result($rs,"F_RECEP"));
			$FG_AMBITO_GEOGRAFICO			=(odbc_result($rs,"FG_AMBITO_GEOGRAFICO"));
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$F_ASIG				=(odbc_result($rs,"F_ASIG"));
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$F_APROB			=(odbc_result($rs,"F_APROB"));
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			
			if($FG_AMBITO_GEOGRAFICO)
				$FG_AMBITO_GEOGRAFICO="SI";
			else
				$FG_AMBITO_GEOGRAFICO="NO";
				
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if($F_RECEP)
				$F_RECEP=fecha_normal($F_RECEP);
			
			if($F_ASIG)
				$F_ASIG=fecha_normal($F_ASIG);
				
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			$ESTATUS="";
				
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='DETALLE_GARANTIA.php?id_empr_acta=".odbc_result($rs,"ID_EMPR_ACTA")."&id_empresa=$id_empresa '/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"ActaDeGarantias\", \"Acta de Garantias\", \"Sistema/Reportes/ACTA_GARANTIA.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
?> 
			<tr <?php echo $clase;?>>
				<td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $F_ASIG;?></td>
				<td align='center'><?php echo $NB_ABG_ASIG;?></td>
				<td align='center'><?php echo $F_APROB;?></td>
				<td align='center'><?php echo $NB_ABG_APROB;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
				<td align='center'><?php echo $FG_AMBITO_GEOGRAFICO;?></td>
			  </tr>
<?php
		}
		}
		else
		{
			echo $sql;
		} 
    ?> 
    
    </table> 
    
    
    
    <br>
    <br>
    <table width="1028" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
        <thead>
            <tr>
                <th width="44" align="center">NRO. ACTA</th>
                <th width="125" align="center">TIPO</th>
                <th width="87" align="center">GENERAL</th>
                <th width="182" align="center">CATEGORIA</th>
                <th width="69" align="center">LOCALIDAD</th>
                <th width="170" align="center">NRO. DOCUMENTO</th>
                <th width="74" align="center">NRO. ANEXO</th>
                <th width="113" align="center">F. DESDE</th>
                <th width="85" align="center">F. HASTA</th>
                <th width="85" align="center">CANT. EMPLEADO</th>
                <th width="85" align="center">ACTIVO</th>
                <th width="85" align="center">ESTATUS</th>
            </tr>
        </thead>
<?php

    $sql="SELECT        dbo.TB_PERIODO.FG_ACTIVO AS Expr1, dbo.TB_TIPO_GARANTIA.NB_TGARANTIA, dbo.TB_TIPO_GARANTIA.FG_GENERAL, 
                         CASE dbo.EMPRE_GARANTIA.ID_CATEGORIA WHEN 0 THEN 'N/A' ELSE NB_CATEGORIA END AS NB_CATEGORIA, dbo.EMPRE_ACTA.NRO_ACTA, dbo.TB_LOCALIDAD.NB_LOCALIDAD, 
                         dbo.EMPRE_GARANTIA.NRO_DOCUM, dbo.EMPRE_GARANTIA.NRO_ANEXO, dbo.EMPRE_GARANTIA.FG_ANEXO, dbo.EMPRE_GARANTIA.FG_ACTIVO, dbo.EMPRE_GARANTIA.F_VIG_DESDE, 
                         dbo.EMPRE_GARANTIA.F_VIG_HASTA, dbo.EMPRE_ACTA.ESTATUS, dbo.EMPRE_GARANTIA.ID_EMPRESA, dbo.EMPRE_EXPEDIENTE.ESTATUS AS Expr2, dbo.EMPRE_GARANTIA.CI_CONFOME, 
                         dbo.EMPRE_GARANTIA.ID_CATEGORIA, dbo.EMPRE_GARANTIA.ID_TGARANTIA, dbo.EMPRE_GARANTIA.CANT_EMPL
FROM            dbo.TB_TIPO_GARANTIA INNER JOIN
                         dbo.TB_PERIODO INNER JOIN
                         dbo.EMPRE_GARANTIA INNER JOIN
                         dbo.EMPRE_ACTA INNER JOIN
                         dbo.EMPRE_EXPEDIENTE ON dbo.EMPRE_ACTA.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP ON dbo.EMPRE_GARANTIA.ID_EMPR_ACTA = dbo.EMPRE_ACTA.ID_EMPR_ACTA ON 
                         dbo.TB_PERIODO.ANO_REGISTRO = dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO ON dbo.TB_TIPO_GARANTIA.ID_TGARANTIA = dbo.EMPRE_GARANTIA.ID_TGARANTIA INNER JOIN
                         dbo.TB_LOCALIDAD ON dbo.EMPRE_GARANTIA.ID_LOCALIDAD = dbo.TB_LOCALIDAD.ID_LOCALIDAD LEFT OUTER JOIN
                         dbo.TB_CATEGORIA ON dbo.EMPRE_GARANTIA.ID_CATEGORIA = dbo.TB_CATEGORIA.ID_CATEGORIA
WHERE        (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO) AND (dbo.EMPRE_GARANTIA.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1) AND (dbo.TB_PERIODO.FG_ACTIVO = 1)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

//echo $sql;
$cn2=$conector->Ejecutar($sql);

$id_preliquidacion = 0;

$pintar=0;

while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$NRO_ACTA			=odbc_result($cn2,"NRO_ACTA");
	$ID_TGARANTIA=utf8_encode (odbc_result($cn2,'ID_TGARANTIA'));
	$NB_TGARANTIA=utf8_encode (odbc_result($cn2,'NB_TGARANTIA'));
	$FG_GENERAL=utf8_encode (odbc_result($cn2,'FG_GENERAL'));
	$NB_CATEGORIA=utf8_encode (odbc_result($cn2,'NB_CATEGORIA'));
	$NB_LOCALIDAD=utf8_encode (odbc_result($cn2,'NB_LOCALIDAD'));
	$NRO_DOCUM = odbc_result($cn2,'NRO_DOCUM');
	$NRO_ANEXO = odbc_result($cn2,'NRO_ANEXO');	
	$FG_ANEXO = odbc_result($cn2,'FG_ANEXO');	
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVO');
	$CI_CONFOME = odbc_result($cn2,'CI_CONFOME');
	$CANT_EMPL = odbc_result($cn2,'CANT_EMPL');	
	
	if($ID_TGARANTIA!=3)
		$CANT_EMPL="N/A";
	
	$F_VIG_DESDE			=fecha_normal(odbc_result($cn2,"F_VIG_DESDE"));
	$F_VIG_HASTA			=fecha_normal(odbc_result($cn2,"F_VIG_HASTA"));
	
	if(!$FG_ANEXO)
	{
		$NRO_ANEXO="N/A";
	}
	
	if($FG_GENERAL)
		$FG_GENERAL="SI";
	else
		$FG_GENERAL="NO";
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($CI_CONFOME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
				<td align="center" ><?php echo $NRO_ACTA;?></td>
				<td align="center" ><?php echo $NB_TGARANTIA;?></td>
				<td align="center" ><?php echo $FG_GENERAL;?></td>
				<td align="center" ><?php echo $NB_CATEGORIA;?></td>
				<td align="center" ><?php echo $NB_LOCALIDAD;?></td>
				<td align="center" ><?php echo $NRO_DOCUM;?></td>
  		  		<td align="center" ><?php echo $NRO_ANEXO;?></td>
  		  		<td align="center" ><?php echo $F_VIG_DESDE;?></td>
  		  		<td align="center" ><?php echo $F_VIG_HASTA;?></td>
  		  		<td align="center" ><?php echo $CANT_EMPL;?></td>
				<td align="center" ><?php echo $ACTIVO;?></td>
				<td align="center" ><?php echo $CONFORME;?></td>
  		  </tr>
<?php	
}
?>
		</table>
    
    
    
    <br>
    <br>
    <table width="1028" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
        <thead>
            <tr>
              <th colspan="10" align="center">GARANTIAS ACTIVAS SIN ACTA</th>
            </tr>
            <tr>
                <th width="125" align="center">TIPO</th>
                <th width="87" align="center">GENERAL</th>
                <th width="182" align="center">CATEGORIA</th>
                <th width="69" align="center">LOCALIDAD</th>
                <th width="170" align="center">NRO. DOCUMENTO</th>
                <th width="74" align="center">NRO. ANEXO</th>
                <th width="113" align="center">F. DESDE</th>
                <th width="85" align="center">F. HASTA</th>
                <th width="85" align="center">CANT. EMPLEADO</th>
            </tr>
        </thead>
<?php

    $sql="SELECT        dbo.TB_TIPO_GARANTIA.NB_TGARANTIA, dbo.TB_TIPO_GARANTIA.FG_GENERAL, 
                         CASE dbo.EMPRE_GARANTIA.ID_CATEGORIA WHEN 0 THEN 'N/A' ELSE NB_CATEGORIA END AS NB_CATEGORIA, dbo.TB_LOCALIDAD.NB_LOCALIDAD, dbo.EMPRE_GARANTIA.NRO_DOCUM, 
                         dbo.EMPRE_GARANTIA.NRO_ANEXO, dbo.EMPRE_GARANTIA.FG_ANEXO, dbo.EMPRE_GARANTIA.FG_ACTIVO, dbo.EMPRE_GARANTIA.F_VIG_DESDE, dbo.EMPRE_GARANTIA.F_VIG_HASTA, 
                         dbo.EMPRE_GARANTIA.CI_CONFOME, dbo.EMPRE_GARANTIA.ID_CATEGORIA, dbo.EMPRE_GARANTIA.ID_EMPRESA, dbo.EMPRE_GARANTIA.ANO_REGISTRO, dbo.EMPRE_GARANTIA.ID_EMPR_ACTA, 
                         dbo.EMPRE_EXPEDIENTE.ESTATUS AS Expr2, dbo.TB_PERIODO.FG_ACTIVO AS Expr1, dbo.EMPRE_GARANTIA.ID_TGARANTIA, dbo.EMPRE_GARANTIA.CANT_EMPL
FROM            dbo.TB_LOCALIDAD INNER JOIN
                         dbo.EMPRE_GARANTIA INNER JOIN
                         dbo.TB_TIPO_GARANTIA ON dbo.EMPRE_GARANTIA.ID_TGARANTIA = dbo.TB_TIPO_GARANTIA.ID_TGARANTIA ON dbo.TB_LOCALIDAD.ID_LOCALIDAD = dbo.EMPRE_GARANTIA.ID_LOCALIDAD INNER JOIN
                         dbo.TB_PERIODO INNER JOIN
                         dbo.EMPRE_EXPEDIENTE ON dbo.TB_PERIODO.ANO_REGISTRO = dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO ON dbo.EMPRE_GARANTIA.ANO_REGISTRO = dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO AND 
                         dbo.EMPRE_GARANTIA.ID_EMPRESA = dbo.EMPRE_EXPEDIENTE.ID_EMPRESA LEFT OUTER JOIN
                         dbo.TB_CATEGORIA ON dbo.EMPRE_GARANTIA.ID_CATEGORIA = dbo.TB_CATEGORIA.ID_CATEGORIA
WHERE        (dbo.EMPRE_GARANTIA.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1) AND (dbo.TB_PERIODO.FG_ACTIVO = 1) AND (dbo.EMPRE_GARANTIA.ANO_REGISTRO = $ANO_REGISTRO) AND 
                         (dbo.EMPRE_GARANTIA.ID_EMPR_ACTA IS NULL)";

//echo $sql;
$cn2=$conector->Ejecutar($sql);

$id_preliquidacion = 0;

$pintar=0;

while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$NRO_ACTA			=odbc_result($cn2,"NRO_ACTA");
	$ID_TGARANTIA=utf8_encode (odbc_result($cn2,'ID_TGARANTIA'));
	$NB_TGARANTIA=utf8_encode (odbc_result($cn2,'NB_TGARANTIA'));
	$FG_GENERAL=utf8_encode (odbc_result($cn2,'FG_GENERAL'));
	$NB_CATEGORIA=utf8_encode (odbc_result($cn2,'NB_CATEGORIA'));
	$NB_LOCALIDAD=utf8_encode (odbc_result($cn2,'NB_LOCALIDAD'));
	$NRO_DOCUM = odbc_result($cn2,'NRO_DOCUM');
	$NRO_ANEXO = odbc_result($cn2,'NRO_ANEXO');	
	$FG_ANEXO = odbc_result($cn2,'FG_ANEXO');	
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVO');
	$CI_CONFOME = odbc_result($cn2,'CI_CONFOME');
	$CANT_EMPL = odbc_result($cn2,'CANT_EMPL');	
	
	if($ID_TGARANTIA!=3)
		$CANT_EMPL="N/A";	
	
	$F_VIG_DESDE			=fecha_normal(odbc_result($cn2,"F_VIG_DESDE"));
	$F_VIG_HASTA			=fecha_normal(odbc_result($cn2,"F_VIG_HASTA"));
	
	if(!$FG_ANEXO)
	{
		$NRO_ANEXO="N/A";
	}
	
	if($FG_GENERAL)
		$FG_GENERAL="SI";
	else
		$FG_GENERAL="NO";
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($CI_CONFOME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
				<td align="center" ><?php echo $NB_TGARANTIA;?></td>
				<td align="center" ><?php echo $FG_GENERAL;?></td>
				<td align="center" ><?php echo $NB_CATEGORIA;?></td>
				<td align="center" ><?php echo $NB_LOCALIDAD;?></td>
				<td align="center" ><?php echo $NRO_DOCUM;?></td>
  		  		<td align="center" ><?php echo $NRO_ANEXO;?></td>
  		  		<td align="center" ><?php echo $F_VIG_DESDE;?></td>
  		  		<td align="center" ><?php echo $F_VIG_HASTA;?></td>
  		  		<td align="center" ><?php echo $CANT_EMPL;?></td>
		  </tr>
<?php	
}
?>
		</table>
    <?php
		break;
		
		case 6:
    ?> 
    		<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align='center'>
           		
                    NRO.
              
        	</th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
        	</th>
            <th width="114" align='center'>
              
                    F. REGISTRO.
              
        	</th>
            <th width="115" align='center'>
              
                    F. ANULACION.
              
        	</th>
            <th width="110" align='center'>
              
                    F. RECEP.
              
        	</th>
            <th width="110" align='center'>
              
                    ABG. RECEP.
              
        	</th>   
            <th width="74" align='center'>
              
                    F. ASIG.
              
        	</th>
            <th width="108" align='center'>
              
                    ABG. ASIG.
              
        	</th>
            <th width="115" align='center'>
              
                    F. CONFORME
              
        	</th>     
            <th width="141" align='center'>
              
                    ABG. COMFORME.
              
        	</th>    
            <th width="94" align='center'>
              
                    ESTATUS
              
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 3 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
		
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if(odbc_result($rs,"F_ANULACION"))
			{
				$F_ANULACION			=fecha_normal(odbc_result($rs,"F_ANULACION"));
			}
			else
			{
				$F_ANULACION="";
			}
			
			if(odbc_result($rs,"F_RECEP"))
			{
				$F_RECEP			=fecha_normal(odbc_result($rs,"F_RECEP"));
			}
			else
			{
				$F_RECEP="";
			}
			
			if(odbc_result($rs,"F_ASIG"))
			{
				$F_ASIG			=fecha_normal(odbc_result($rs,"F_ASIG"));
			}
			else
			{
				$F_ASIG="";
			}
			
			if(odbc_result($rs,"F_APROB"))
			{
				$F_APROB			=fecha_normal(odbc_result($rs,"F_APROB"));
			}
			else
			{
				$F_APROB="";
			}
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='DETALLE_EMPLEADO.php?id_empr_acta=".odbc_result($rs,"id_empr_acta")."&id_empresa=$id_empresa'/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"SolicituddeEmpleados\", \"Solicitud de Empleados\", \"Sistema/Reportes/ACTA_EMPLEADO.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
?> 
			<tr <?php echo $clase;?>>
				<td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $F_ASIG;?></td>
				<td align='center'><?php echo $NB_ABG_ASIG;?></td>
				<td align='center'><?php echo $F_APROB;?></td>
				<td align='center'><?php echo $NB_ABG_APROB;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
			  </tr>
<?php
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    </table> 
    <br />
    <br />
    <table width="900" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
        <thead>
            <tr>
                <th width="44" align="center">NRO. ACTA</th>
                <th width="75" align="center">CEDULA</th>
                <th width="280" align="center">NOMBRE</th>
                <th width="140" align="center">NRO. GARANTIA</th>
                <th width="140" align="center">NRO. ANEXO</th>
                <th width="140" align="center">CARGO</th>
                <th width="140" align="center">PRELIQUIDACION</th>
                <th width="61" align="center">ACTIVO</th>
                <th width="70" align="center">ESTATUS</th>
                <th width="72" align="center">IMPRESO</th>
            </tr>
        </thead>
<?php	

$sql="SELECT        dbo.EMPRE_EXPEDIENTE.ID_EMPEXP, dbo.EMPRE_EMPLE_GRAL.CI_EMPLEADO, dbo.EMPRE_EMPLE_GRAL.NB_EMPLEADO, dbo.EMPRE_EMPLEADO.ID_LOCALIDAD, 
                         dbo.EMPRE_EMPLEADO.ID_EMPRESA, dbo.TB_CARGO_EMPLEADO.NB_CARGO, dbo.EMPRE_ACTA.NRO_ACTA, dbo.EMPRE_ACTA.F_ANULACION, dbo.EMPRE_ACTA.ID_EMPR_ACTA, 
                         dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_EMPLEADO.ID_PRELIQUIDACION, dbo.EMPRE_EMPLEADO.FG_CONFORME, dbo.EMPRE_EMPLEADO.FG_ACTIVO AS FG_ACTIVOE, dbo.TB_PERIODO.FG_ACTIVO, 
                         dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, dbo.EMPRE_EMPLEADO.FG_IMPRESO, dbo.EMPRE_GARANTIA.NRO_DOCUM, dbo.EMPRE_GARANTIA.NRO_ANEXO
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_CARGO_EMPLEADO INNER JOIN
                         dbo.EMPRE_EMPLEADO INNER JOIN
                         dbo.EMPRE_EMPLE_GRAL ON dbo.EMPRE_EMPLEADO.CI_EMPLEADO = dbo.EMPRE_EMPLE_GRAL.CI_EMPLEADO INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_EMPLEADO.ID_EMPR_ACTA = dbo.EMPRE_ACTA.ID_EMPR_ACTA ON dbo.TB_CARGO_EMPLEADO.ID_CARGO_EMPLE = dbo.EMPRE_EMPLEADO.CARGO ON 
                         dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_ACTA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO LEFT OUTER JOIN
                         dbo.EMPRE_GARANTIA ON dbo.EMPRE_EMPLEADO.ID_EMPR_GARAN = dbo.EMPRE_GARANTIA.ID_EMPR_GARAN
WHERE        (dbo.EMPRE_EMPLEADO.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_ACTA.ID_TACTA = 3) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$NRO_ACTA=odbc_result($cn2,'NRO_ACTA');
	$ci_empleado=odbc_result($cn2,'ci_empleado');
	$nb_empleado=odbc_result($cn2,'nb_empleado');
	$nb_cargo=odbc_result($cn2,'nb_cargo');
	$id_preliquidacion = odbc_result($cn2,'id_preliquidacion');
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVOE');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORME');
	$FG_IMPRESO = odbc_result($cn2,'FG_IMPRESO');
	$NRO_DOCUM = odbc_result($cn2,'NRO_DOCUM');
	$NRO_ANEXO = odbc_result($cn2,'NRO_ANEXO');
	
	if($FG_IMPRESO)
		$FG_IMPRESO="SI";
	else
		$FG_IMPRESO="NO";
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
            <td align="center" ><?php echo $NRO_ACTA;?></td>
            <td align="center" ><?php echo $ci_empleado;?></td>
            <td align="center" ><?php echo $nb_empleado;?></td>
            <td align="center" ><?php echo $NRO_DOCUM;?></td>
            <td align="center" ><?php echo $NRO_ANEXO;?></td>
            <td align="center" ><?php echo $nb_cargo;?></td>
            <td align="center" ><?php echo $id_preliquidacion;?></td>
            <td align="center" ><?php echo $ACTIVO;?></td>
            <td align="center" ><?php echo $CONFORME;?></td>
            <td align='center' ><?php echo $FG_IMPRESO;?></td>
        </tr>
<?php	
}
?>
	</table>
    <br>
    <br>
    
    <table width="900" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
        <thead>
            <tr>
              <th colspan="10" align="center">EMPLEADOS ACTIVOS SIN ACTA</th>
            </tr>
            <tr>
                <th width="75" align="center">CEDULA</th>
                <th width="280" align="center">NOMBRE</th>
                <th width="140" align="center">CARGO</th>
                <th width="140" align="center">NRO. GARANTIA</th>
                <th width="140" align="center">NRO. ANEXO</th>
            </tr>
        </thead>
<?php	

$sql="SELECT        dbo.EMPRE_EXPEDIENTE.ID_EMPEXP, dbo.EMPRE_EMPLE_GRAL.CI_EMPLEADO, dbo.EMPRE_EMPLE_GRAL.NB_EMPLEADO, dbo.EMPRE_EMPLEADO.ID_LOCALIDAD, dbo.EMPRE_EMPLEADO.ID_EMPRESA, 
                         dbo.TB_CARGO_EMPLEADO.NB_CARGO, dbo.EMPRE_EMPLEADO.ID_PRELIQUIDACION, dbo.EMPRE_EMPLEADO.FG_CONFORME, dbo.EMPRE_EMPLEADO.FG_ACTIVO AS FG_ACTIVOE, 
                         dbo.TB_PERIODO.FG_ACTIVO AS Expr1, dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, dbo.EMPRE_EMPLEADO.FG_IMPRESO, dbo.EMPRE_EMPLEADO.ID_EMPR_ACTA, dbo.EMPRE_GARANTIA.NRO_DOCUM, 
                         dbo.EMPRE_GARANTIA.NRO_ANEXO
FROM            dbo.TB_PERIODO INNER JOIN
                         dbo.EMPRE_EXPEDIENTE ON dbo.TB_PERIODO.ANO_REGISTRO = dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO INNER JOIN
                         dbo.EMPRE_EMPLEADO INNER JOIN
                         dbo.EMPRE_EMPLE_GRAL ON dbo.EMPRE_EMPLEADO.CI_EMPLEADO = dbo.EMPRE_EMPLE_GRAL.CI_EMPLEADO INNER JOIN
                         dbo.TB_CARGO_EMPLEADO ON dbo.EMPRE_EMPLEADO.CARGO = dbo.TB_CARGO_EMPLEADO.ID_CARGO_EMPLE ON 
                         dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_EMPLEADO.ID_EMPEXP LEFT OUTER JOIN
                         dbo.EMPRE_GARANTIA ON dbo.EMPRE_EMPLEADO.ID_EMPR_GARAN = dbo.EMPRE_GARANTIA.ID_EMPR_GARAN
WHERE        (dbo.EMPRE_EMPLEADO.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO) AND (dbo.EMPRE_EMPLEADO.ID_EMPR_ACTA IS NULL) AND (dbo.EMPRE_EMPLEADO.FG_ACTIVO = 1) ";

$cn2=$conector->Ejecutar($sql);
$pintar=0;
while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$NRO_ACTA=odbc_result($cn2,'NRO_ACTA');
	$ci_empleado=odbc_result($cn2,'ci_empleado');
	$nb_empleado=odbc_result($cn2,'nb_empleado');
	$nb_cargo=odbc_result($cn2,'nb_cargo');
	$id_preliquidacion = odbc_result($cn2,'id_preliquidacion');
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVOE');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORME');
	$FG_IMPRESO = odbc_result($cn2,'FG_IMPRESO');
	$NRO_DOCUM = odbc_result($cn2,'NRO_DOCUM');
	$NRO_ANEXO = odbc_result($cn2,'NRO_ANEXO');
	
	if($FG_IMPRESO)
		$FG_IMPRESO="SI";
	else
		$FG_IMPRESO="NO";
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
            <td align="center" ><?php echo $ci_empleado;?></td>
            <td align="center" ><?php echo $nb_empleado;?></td>
            <td align="center" ><?php echo $nb_cargo;?></td>
            <td align="center" ><?php echo $NRO_DOCUM;?></td>
            <td align="center" ><?php echo $NRO_ANEXO;?></td>
        </tr>
<?php	
}
?>
	</table>
    <br>
    <br>
    <!--<a href="DETALLE_EMPLEADO_SA.php?id_empresa=<?php echo $id_empresa;?>" target="_blank">LISTADO DE EMPLEADOS SIN SOLICITUDES</a>-->
    <?php
		break;
		
		case 7:
    ?> 
    		<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align='center'>
           		
                    NRO.
       	  </th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
       	  </th>
            <th width="114" align='center'>
              
                    F. REGISTRO.
              
       	  </th>
            <th width="115" align='center'>
              
                    F. ANULACION.
              
       	  </th>
            <th width="110" align='center'>
              
                    F. RECEP.
              
       	  </th>
            <th width="110" align='center'>
              
                    ABG. RECEP.
              
       	  </th>   
            <th width="74" align='center'>
              
                    F. ASIG.
              
       	  </th>
            <th width="108" align='center'>
              
                    ABG. ASIG.
              
       	  </th>
            <th width="115" align='center'>
              
                    F. CONFORME
              
       	  </th>     
            <th width="141" align='center'>
              
                    ABG. COMFORME.
              
       	  </th>    
            <th width="94" align='center'>
              
                    ESTATUS
              
       	  </th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 4 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if(odbc_result($rs,"F_ANULACION"))
			{
				$F_ANULACION			=fecha_normal(odbc_result($rs,"F_ANULACION"));
			}
			else
			{
				$F_ANULACION="";
			}
			
			if(odbc_result($rs,"F_RECEP"))
			{
				$F_RECEP			=fecha_normal(odbc_result($rs,"F_RECEP"));
			}
			else
			{
				$F_RECEP="";
			}
			
			if(odbc_result($rs,"F_ASIG"))
			{
				$F_ASIG			=fecha_normal(odbc_result($rs,"F_ASIG"));
			}
			else
			{
				$F_ASIG="";
			}
			
			if(odbc_result($rs,"F_APROB"))
			{
				$F_APROB			=fecha_normal(odbc_result($rs,"F_APROB"));
			}
			else
			{
				$F_APROB="";
			}
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
			
			//$Enlace="<a  target='_blank' href='DETALLE_VEHICULO.php?id_empr_acta=".odbc_result($rs,"id_empr_acta")."&id_empresa=$id_empresa'/>$NRO_ACTA</a>";	
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"SolicituddeVehiculos\", \"Solicitud de Vehiculos\", \"Sistema/Reportes/ACTA_VEHICULO.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
?> 
			<tr <?php echo $clase;?>>
				<td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $F_ASIG;?></td>
				<td align='center'><?php echo $NB_ABG_ASIG;?></td>
				<td align='center'><?php echo $F_APROB;?></td>
				<td align='center'><?php echo $NB_ABG_APROB;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
			  </tr>
<?php
		}
		}
		else
		{
			echo $sql;
		}
    ?> 
    
    </table>   
    <br>
    <br>
    <table width="1028" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
        <thead>
            <tr>
                <th width="44" align="center">NRO. ACTA</th>
                <th width="125" align="center">PLACA</th>
                <th width="87" align="center">MODELO</th>
                <th width="182" align="center">TIPO DE VEHICULO</th>
                <th width="69" align="center">COLOR</th>
                <th width="170" align="center">PRELIQUIDACION</th>
                <th width="74" align="center">ACTIVO</th>
                <th width="85" align="center">ESTATUS</th>
                <th width="85" align="center">NRO POLIZA</th>
                <th width="113" align="center">F. V. POLIZA</th>
                <th width="85" align="center">NRO CERTIFICADO</th>
                <th width="113" align="center">F. V. CERTIFICADO</th>
                <th width="79" align="center">IMPRESO</th>
            </tr>
        </thead>
<?php

    $sql="SELECT       dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, dbo.EMPRE_VEHICULO_N.ID_EMPRESA, dbo.EMPRE_EXPEDIENTE.ESTATUS, dbo.TB_MODELO_VEH.NB_MODELO_VEH, 
                         dbo.TB_TIPO_VEHICULO.NB_TVEHICULO, dbo.EMPRE_ACTA.NRO_ACTA, dbo.EMPRE_ACTA.ID_LOCALIDAD, dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_ACTA.ID_EMPEXP, dbo.EMPRE_POLIZA.F_VIG_POLIZA, 
                         dbo.EMPRE_VEHICULO_N.ID_EMPR_ACTA, dbo.EMPRE_VEHICULO_N.ID_PRELIQUIDACION, dbo.VEHICULO_GRAL.PLACA, dbo.VEHICULO_GRAL.COLOR, dbo.EMPRE_VEHICULO_N.FG_ACTIVO, 
                         dbo.EMPRE_VEHICULO_N.FG_IMPRESO, dbo.EMPRE_POLIZA.NRO_POLIZA, dbo.EMPRE_POLIZA_CERT.F_HASTA_CERT, dbo.EMPRE_POLIZA_CERT.NRO_CERTIFICADO,dbo.EMPRE_VEHICULO_N.FG_CONFORME
FROM            dbo.EMPRE_VEHICULO_N INNER JOIN
                         dbo.EMPRE_POLIZA ON dbo.EMPRE_VEHICULO_N.ID_EMPRE_POLIZA = dbo.EMPRE_POLIZA.ID_EMPRE_POLIZA INNER JOIN
                         dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO ON dbo.EMPRE_VEHICULO_N.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP INNER JOIN
                         dbo.TB_TIPO_VEHICULO INNER JOIN
                         dbo.VEHICULO_GRAL ON dbo.TB_TIPO_VEHICULO.ID_TVEHICULO = dbo.VEHICULO_GRAL.ID_TVEHICULO INNER JOIN
                         dbo.TB_MODELO_VEH ON dbo.VEHICULO_GRAL.ID_MODELO_VEH = dbo.TB_MODELO_VEH.ID_MODELO_VEH ON dbo.EMPRE_VEHICULO_N.ID_VEH_GRAL = dbo.VEHICULO_GRAL.ID_VEH_GRAL INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_VEHICULO_N.ID_EMPR_ACTA = dbo.EMPRE_ACTA.ID_EMPR_ACTA LEFT OUTER JOIN
                         dbo.EMPRE_POLIZA_CERT ON dbo.EMPRE_VEHICULO_N.ID_POL_CERT = dbo.EMPRE_POLIZA_CERT.ID_POL_CERT
WHERE        (dbo.EMPRE_VEHICULO_N.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO) AND (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

//echo $sql;
$cn2=$conector->Ejecutar($sql);

$id_preliquidacion = 0;

$pintar=0;

while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$NRO_ACTA			=odbc_result($cn2,"NRO_ACTA");
	$placa=utf8_encode (odbc_result($cn2,'placa'));
	$nb_modelo_veh=utf8_encode (odbc_result($cn2,'nb_modelo_veh'));
	$nb_tvehiculo=utf8_encode (odbc_result($cn2,'nb_tvehiculo'));
	$color=utf8_encode (odbc_result($cn2,'color'));
	$id_preliquidacion = odbc_result($cn2,'id_preliquidacion');
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVO');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORME');
	$FG_IMPRESO = odbc_result($cn2,'FG_IMPRESO');	
	$NRO_CERTIFICADO = odbc_result($cn2,'NRO_CERTIFICADO');	
	$NRO_POLIZA = odbc_result($cn2,'NRO_POLIZA');		
	
	$F_HASTA_CERT			=fecha_normal(odbc_result($cn2,"F_HASTA_CERT"));
	$F_VIG_POLIZA			=fecha_normal(odbc_result($cn2,"F_VIG_POLIZA"));
	
	if(!$NRO_CERTIFICADO)
	{
		$NRO_CERTIFICADO="N/A";
		$F_HASTA_CERT="N/A";
	}
	if($FG_IMPRESO)
		$FG_IMPRESO="SI";
	else
		$FG_IMPRESO="NO";
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
				<td align="center" ><?php echo $NRO_ACTA;?></td>
				<td align="center" ><?php echo $placa;?></td>
				<td align="center" ><?php echo $nb_modelo_veh;?></td>
				<td align="center" ><?php echo $nb_tvehiculo;?></td>
				<td align="center" ><?php echo $color;?></td>
				<td align="center" ><?php echo $id_preliquidacion;?></td>
				<td align="center" ><?php echo $ACTIVO;?></td>
				<td align="center" ><?php echo $CONFORME;?></td>
  		  		<td align="center" ><?php echo $NRO_POLIZA;?></td>
  		  		<td align="center" ><?php echo $F_VIG_POLIZA;?></td>
  		  		<td align="center" ><?php echo $NRO_CERTIFICADO;?></td>
  		  		<td align="center" ><?php echo $F_HASTA_CERT;?></td>
				<td align='center' ><?php echo $FG_IMPRESO;?></td>
		  </tr>
<?php	
}
?>
		</table>
        
        
          
    <br>
    <br>
    <table width="1028" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
        <thead>
            <tr>
              <th colspan="8" align="center">VEHICULOS ACTIVOS SIN ACTA</th>
            </tr>
            <tr>
                <th width="125" align="center">PLACA</th>
                <th width="87" align="center">MODELO</th>
                <th width="182" align="center">TIPO DE VEHICULO</th>
                <th width="69" align="center">COLOR</th>
                <th width="85" align="center">NRO POLIZA</th>
                <th width="113" align="center">F. V. POLIZA</th>
                <th width="85" align="center">NRO CERTIFICADO</th>
                <th width="113" align="center">F. V. CERTIFICADO</th>
            </tr>
        </thead>
<?php

    $sql="SELECT      dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, dbo.EMPRE_VEHICULO_N.ID_EMPRESA, dbo.EMPRE_EXPEDIENTE.ESTATUS, dbo.TB_MODELO_VEH.NB_MODELO_VEH, 
                         dbo.TB_TIPO_VEHICULO.NB_TVEHICULO, dbo.EMPRE_POLIZA.F_VIG_POLIZA, dbo.EMPRE_VEHICULO_N.ID_EMPR_ACTA, dbo.EMPRE_VEHICULO_N.ID_PRELIQUIDACION, dbo.VEHICULO_GRAL.PLACA, 
                         dbo.VEHICULO_GRAL.COLOR, dbo.EMPRE_VEHICULO_N.FG_ACTIVO, dbo.EMPRE_VEHICULO_N.FG_IMPRESO, dbo.EMPRE_POLIZA.NRO_POLIZA, dbo.EMPRE_POLIZA_CERT.F_HASTA_CERT, 
                         dbo.EMPRE_POLIZA_CERT.NRO_CERTIFICADO, dbo.EMPRE_VEHICULO_N.FG_CONFORME
FROM            dbo.EMPRE_VEHICULO_N INNER JOIN
                         dbo.EMPRE_POLIZA ON dbo.EMPRE_VEHICULO_N.ID_EMPRE_POLIZA = dbo.EMPRE_POLIZA.ID_EMPRE_POLIZA INNER JOIN
                         dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO ON dbo.EMPRE_VEHICULO_N.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP INNER JOIN
                         dbo.TB_TIPO_VEHICULO INNER JOIN
                         dbo.VEHICULO_GRAL ON dbo.TB_TIPO_VEHICULO.ID_TVEHICULO = dbo.VEHICULO_GRAL.ID_TVEHICULO INNER JOIN
                         dbo.TB_MODELO_VEH ON dbo.VEHICULO_GRAL.ID_MODELO_VEH = dbo.TB_MODELO_VEH.ID_MODELO_VEH ON 
                         dbo.EMPRE_VEHICULO_N.ID_VEH_GRAL = dbo.VEHICULO_GRAL.ID_VEH_GRAL LEFT OUTER JOIN
                         dbo.EMPRE_POLIZA_CERT ON dbo.EMPRE_VEHICULO_N.ID_POL_CERT = dbo.EMPRE_POLIZA_CERT.ID_POL_CERT
WHERE        EMPRE_VEHICULO_N.FG_activo=1 AND     (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO) AND (dbo.EMPRE_VEHICULO_N.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1) AND (dbo.EMPRE_VEHICULO_N.ID_EMPR_ACTA IS NULL)";

//echo $sql;
$cn2=$conector->Ejecutar($sql);

$id_preliquidacion = 0;

$pintar=0;

while(odbc_fetch_row($cn2))
{
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="class='Normal'";
		$pintar=1;
	}
	
	$NRO_ACTA			=odbc_result($cn2,"NRO_ACTA");
	$placa=utf8_encode (odbc_result($cn2,'placa'));
	$nb_modelo_veh=utf8_encode (odbc_result($cn2,'nb_modelo_veh'));
	$nb_tvehiculo=utf8_encode (odbc_result($cn2,'nb_tvehiculo'));
	$color=utf8_encode (odbc_result($cn2,'color'));
	$id_preliquidacion = odbc_result($cn2,'id_preliquidacion');
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVO');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORME');
	$FG_IMPRESO = odbc_result($cn2,'FG_IMPRESO');	
	$NRO_CERTIFICADO = odbc_result($cn2,'NRO_CERTIFICADO');	
	$NRO_POLIZA = odbc_result($cn2,'NRO_POLIZA');		
	
	$F_HASTA_CERT			=fecha_normal(odbc_result($cn2,"F_HASTA_CERT"));
	$F_VIG_POLIZA			=fecha_normal(odbc_result($cn2,"F_VIG_POLIZA"));
	
	if(!$NRO_CERTIFICADO)
	{
		$NRO_CERTIFICADO="N/A";
		$F_HASTA_CERT="N/A";
	}
	if($FG_IMPRESO)
		$FG_IMPRESO="SI";
	else
		$FG_IMPRESO="NO";
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
				<td align="center" ><?php echo $placa;?></td>
				<td align="center" ><?php echo $nb_modelo_veh;?></td>
				<td align="center" ><?php echo $nb_tvehiculo;?></td>
				<td align="center" ><?php echo $color;?></td>
				<td align="center" ><?php echo $NRO_POLIZA;?></td>
  		  		<td align="center" ><?php echo $F_VIG_POLIZA;?></td>
  		  		<td align="center" ><?php echo $NRO_CERTIFICADO;?></td>
  		  		<td align="center" ><?php echo $F_HASTA_CERT;?></td>
		  </tr>
<?php	
}
?>
		</table>
    <!--<a href="DETALLE_VEHICULO_SA.php?id_empresa=<?php echo $id_empresa;?>" target="_blank">LISTADO DE VEHICULOS SIN SOLICITUDES</a>-->
    <?php
		break;
		
		case 8:
    ?> 
    		<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align='center'>
           		
                    NRO.
              
       	  </th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
       	  </th>
            <th width="114" align='center'>
              
                    F. REGISTRO.
              
       	  </th>
            <th width="115" align='center'>
              
                    F. ANULACION.
              
       	  </th>
            <th width="110" align='center'>
              
                    F. RECEP.
              
       	  </th>
            <th width="110" align='center'>
              
                    ABG. RECEP.
              
       	  </th>   
            <th width="74" align='center'>
              
                    F. ASIG.
              
       	  </th>
            <th width="108" align='center'>
              
                    ABG. ASIG.
              
       	  </th>
            <th width="115" align="center">
              
                    F. CONFORME
              
        	</th>     
            <th width="141" align="center">
              
                    ABG. COMFORME.
              
        	</th>    
            <th width="94" align="center">
              
                    ESTATUS
              
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 5 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if(odbc_result($rs,"F_ANULACION"))
			{
				$F_ANULACION			=fecha_normal(odbc_result($rs,"F_ANULACION"));
			}
			else
			{
				$F_ANULACION="";
			}
			
			if(odbc_result($rs,"F_RECEP"))
			{
				$F_RECEP			=fecha_normal(odbc_result($rs,"F_RECEP"));
			}
			else
			{
				$F_RECEP="";
			}
			
			if(odbc_result($rs,"F_ASIG"))
			{
				$F_ASIG			=fecha_normal(odbc_result($rs,"F_ASIG"));
			}
			else
			{
				$F_ASIG="";
			}
			
			if(odbc_result($rs,"F_APROB"))
			{
				$F_APROB			=fecha_normal(odbc_result($rs,"F_APROB"));
			}
			else
			{
				$F_APROB="";
			}
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
				
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"SolicituddeMaquinariasEquipos\", \"Solicitud de Maquinarias y Equipos\", \"Sistema/Reportes/ACTA_MAQ_EQUIP.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
?> 
			<tr <?php echo $clase;?>>
				<td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $F_ASIG;?></td>
				<td align='center'><?php echo $NB_ABG_ASIG;?></td>
				<td align='center'><?php echo $F_APROB;?></td>
				<td align='center'><?php echo $NB_ABG_APROB;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
			  </tr>
<?php
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
    <br>
    <br>
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
				<thead>
					<tr>
					<th align="center" valign="middle">NRO. ACTA</th>
					<th align="center" valign="middle">SERIAL</th>
					<th align="center" valign="middle">PROPIETARIO</th>
					<th align="center" valign="middle">TIPO MAQUINA</th>
					<th align="center" valign="middle">MARCA</th>
					<th align="center" valign="middle">ACTIVO</th>
					<th align="center" valign="middle">ESTATUS</th>
					</tr>
				</thead>
    <?php

    $sql="SELECT dbo.EMPRE_ACTA.NRO_ACTA, dbo.TB_TIPO_MAQEQUIP.NB_TIPO_MAQEQUIP, dbo.TB_MARCA_MAQEQUIP.NB_MARCA_MAQEQUIP, dbo.EMPRE_ACTA.ID_LOCALIDAD, 
                         dbo.EMPRE_ACTA.ID_TACTA, dbo.EMPRE_ACTA.F_ANULACION, dbo.TB_PERIODO.FG_ACTIVO AS Expr1, dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, dbo.EMPRE_MAQEQUIP_N.ID_EMPRESA, 
                         dbo.EMPRE_MAQEQUIP_N.ID_EMPR_ACTA, dbo.MAQ_EQUIP_GRAL.SERIAL, dbo.MAQ_EQUIP_GRAL.CAPACIDAD, dbo.MAQ_EQUIP_GRAL.OBSERVACION, dbo.EMPRE_MAQEQUIP_N.FG_ACTIVO, 
                         dbo.MAQ_EQUIP_AUTORIZA.NB_PROPIETARIO, dbo.MAQ_EQUIP_AUTORIZA.RIF_PROPIETARIO, dbo.EMPRE_MAQEQUIP_N.FG_CONFORME
FROM            dbo.TB_MARCA_MAQEQUIP INNER JOIN
                         dbo.TB_TIPO_MAQEQUIP INNER JOIN
                         dbo.MAQ_EQUIP_GRAL ON dbo.TB_TIPO_MAQEQUIP.ID_TIPO_MAQEQUIP = dbo.MAQ_EQUIP_GRAL.ID_TIPO_MAQEQUIP ON 
                         dbo.TB_MARCA_MAQEQUIP.ID_MARCA_MAQEQUIP = dbo.MAQ_EQUIP_GRAL.ID_MARCA_MAQEQUIP INNER JOIN
                         dbo.EMPRE_MAQEQUIP_N ON dbo.MAQ_EQUIP_GRAL.ID_MAQ_EQUIP_GRAL = dbo.EMPRE_MAQEQUIP_N.ID_MAQ_EQUIP_GRAL INNER JOIN
                         dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.EMPRE_ACTA ON dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_ACTA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO ON dbo.EMPRE_MAQEQUIP_N.ID_EMPR_ACTA = dbo.EMPRE_ACTA.ID_EMPR_ACTA LEFT OUTER JOIN
                         dbo.MAQ_EQUIP_AUTORIZA ON dbo.MAQ_EQUIP_GRAL.ID_MAQ_EQUIP_GRAL = dbo.MAQ_EQUIP_AUTORIZA.ID_MAQ_EQUIP_GRAL
WHERE        (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO) AND (dbo.EMPRE_MAQEQUIP_N.ID_EMPRESA = $id_empresa)
ORDER BY dbo.EMPRE_ACTA.NRO_ACTA";

//echo $sql;
$cn2=$conector->Ejecutar($sql);
$pintar=0;

while(odbc_fetch_row($cn2))
{	
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="";
		$pintar=1;
	}
	
	$SERIAL=utf8_encode (odbc_result($cn2,'SERIAL'));
	$NB_PROPIETARIO=utf8_encode (odbc_result($cn2,'NB_PROPIETARIO'));
	$NB_TIPO_MAQEQUIP=utf8_encode (odbc_result($cn2,'NB_TIPO_MAQEQUIP'));
	$NB_MARCA_MAQEQUIP=utf8_encode (odbc_result($cn2,'NB_MARCA_MAQEQUIP'));
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVO');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORME');
	$NRO_ACTA			=odbc_result($cn2,"NRO_ACTA");
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
				<td align="center" ><?php echo $NRO_ACTA;?></td>
				<td align="center" ><?php echo $SERIAL;?></td>
				<td align="center" ><?php echo $NB_PROPIETARIO;?></td>
				<td align="center" ><?php echo $NB_TIPO_MAQEQUIP;?></td>
				<td align="center" ><?php echo $NB_MARCA_MAQEQUIP;?></td>
				<td align="center" ><?php echo $ACTIVO;?></td>
				<td align="center" ><?php echo $CONFORME;?></td>
		  </tr>
<?php

}
?>
</table>


    <br>
    <br>
<table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
				<thead>
					<tr>
					  <th colspan="4" align="center" valign="middle">MAQUINAS ACTIVAS SIN ACTA</th>
				  </tr>
					<tr>
					<th align="center" valign="middle">SERIAL</th>
					<th align="center" valign="middle">PROPIETARIO</th>
					<th align="center" valign="middle">TIPO MAQUINA</th>
					<th align="center" valign="middle">MARCA</th>
					</tr>
				</thead>
    <?php

    $sql="SELECT       dbo.TB_TIPO_MAQEQUIP.NB_TIPO_MAQEQUIP, dbo.TB_MARCA_MAQEQUIP.NB_MARCA_MAQEQUIP, dbo.TB_PERIODO.FG_ACTIVO AS Expr1, dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, 
                         dbo.EMPRE_MAQEQUIP_N.ID_EMPRESA, dbo.EMPRE_MAQEQUIP_N.ID_EMPR_ACTA, dbo.MAQ_EQUIP_GRAL.SERIAL, dbo.MAQ_EQUIP_GRAL.CAPACIDAD, dbo.MAQ_EQUIP_GRAL.OBSERVACION, 
                         dbo.EMPRE_MAQEQUIP_N.FG_ACTIVO, dbo.MAQ_EQUIP_AUTORIZA.NB_PROPIETARIO, dbo.MAQ_EQUIP_AUTORIZA.RIF_PROPIETARIO, dbo.EMPRE_MAQEQUIP_N.FG_CONFORME
FROM            dbo.TB_MARCA_MAQEQUIP INNER JOIN
                         dbo.TB_TIPO_MAQEQUIP INNER JOIN
                         dbo.MAQ_EQUIP_GRAL ON dbo.TB_TIPO_MAQEQUIP.ID_TIPO_MAQEQUIP = dbo.MAQ_EQUIP_GRAL.ID_TIPO_MAQEQUIP ON 
                         dbo.TB_MARCA_MAQEQUIP.ID_MARCA_MAQEQUIP = dbo.MAQ_EQUIP_GRAL.ID_MARCA_MAQEQUIP INNER JOIN
                         dbo.EMPRE_MAQEQUIP_N ON dbo.MAQ_EQUIP_GRAL.ID_MAQ_EQUIP_GRAL = dbo.EMPRE_MAQEQUIP_N.ID_MAQ_EQUIP_GRAL INNER JOIN
                         dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO ON dbo.EMPRE_MAQEQUIP_N.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP LEFT OUTER JOIN
                         dbo.MAQ_EQUIP_AUTORIZA ON dbo.MAQ_EQUIP_GRAL.ID_MAQ_EQUIP_GRAL = dbo.MAQ_EQUIP_AUTORIZA.ID_MAQ_EQUIP_GRAL
WHERE        EMPRE_MAQEQUIP_N.FG_activo=1 AND     (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO) AND (dbo.EMPRE_MAQEQUIP_N.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_MAQEQUIP_N.ID_EMPR_ACTA IS NULL)";

//echo $sql;
$cn2=$conector->Ejecutar($sql);
$pintar=0;

while(odbc_fetch_row($cn2))
{	
	if($pintar)
	{
		$clase="class='color'";
		$pintar=0;
	}
	else
	{
		$clase="";
		$pintar=1;
	}
	
	$SERIAL=utf8_encode (odbc_result($cn2,'SERIAL'));
	$NB_PROPIETARIO=utf8_encode (odbc_result($cn2,'NB_PROPIETARIO'));
	$NB_TIPO_MAQEQUIP=utf8_encode (odbc_result($cn2,'NB_TIPO_MAQEQUIP'));
	$NB_MARCA_MAQEQUIP=utf8_encode (odbc_result($cn2,'NB_MARCA_MAQEQUIP'));
	$FG_ACTIVO = odbc_result($cn2,'FG_ACTIVO');
	$FG_CONFORME = odbc_result($cn2,'FG_CONFORM');
	$NRO_ACTA			=odbc_result($cn2,"NRO_ACTA");
	
	if($FG_ACTIVO)
		$ACTIVO="ACTIVO";
	else
		$ACTIVO="INACTIVO";
	
	if($FG_CONFORME)
		$CONFORME="CONFORME";
	else
		$CONFORME="SIN VERIFICAR";

	if(!$NRO_ACTA)
		$NRO_ACTA="S/N";
?>
        <tr <?php echo $clase;?>>
				<td align="center" ><?php echo $SERIAL;?></td>
				<td align="center" ><?php echo $NB_PROPIETARIO;?></td>
				<td align="center" ><?php echo $NB_TIPO_MAQEQUIP;?></td>
				<td align="center" ><?php echo $NB_MARCA_MAQEQUIP;?></td>
		  </tr>
<?php

}
?>
</table>
    <!--<a href="DETALLE_MAQ_EQUIP_SA.php?id_empresa=<?php echo $id_empresa;?>" target="_blank">LISTADO DE MAQUNARIAS Y EQUIPOS SIN SOLICITUDES</a>-->
    <?php
		break;
		
		case 9:	
			$sql="SELECT        
						dbo.TB_LOCALIDAD.NB_LOCALIDAD, 
						dbo.EMPRESA.RIF, dbo.EMPRESA.RAZON_SOCIAL
					FROM            
						dbo.EMPRE_EXPEDIENTE INNER JOIN
						dbo.TB_LOCALIDAD ON dbo.EMPRE_EXPEDIENTE.ID_LOCALIDAD = dbo.TB_LOCALIDAD.ID_LOCALIDAD INNER JOIN
						dbo.EMPRESA ON dbo.EMPRE_EXPEDIENTE.ID_EMPRESA = dbo.EMPRESA.ID_EMPRESA
					WHERE        
						(dbo.EMPRE_EXPEDIENTE.ID_EMPRESA = $id_empresa) AND 
						(dbo.EMPRE_EXPEDIENTE.ESTATUS = 1) AND 
						(dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO);";
				
			if($rs=$conector->Ejecutar($sql))
			{
				$PuertoConsignacion		=	odbc_result($rs,"NB_LOCALIDAD");	
				$rif		=	odbc_result($rs,"RIF");	
				$razon		=	odbc_result($rs,"RAZON_SOCIAL");
			}
			else
			{
				echo $sql;
			}
    ?> 
    		<table bordercolor="#CCCCCC" width="800" border="1" align='center' cellpadding="0" cellspacing="0" style="width:1050px; margin:auto;" >
    	<tr>
    	  <th colspan="15" align='center'>PUERTO DE CONSIGNACION: <?php echo $PuertoConsignacion;?></th>
    	  </tr>
    	<tr> 
           <th width="300" align="center">
           		
                    CATEGORIA
              
       	  </th>
            <th width="70" align='center'>
              
                    PTO. CABELLO
              
       	  </th>
            <th width="70" align="center">
              
                    LA GUAIRA
              
        	</th>
            <th width="70" align="center">
              
                    GUANTA
              
        	</th>
            <th width="70" align="center">
              
                    GUAMACHE
              
        	</th> 
            <th width="70" align="center">
              
                    MARACAIBO
              
        	</th>
            
            <th width="70" align="center">
              
                    LA CEIBA
              
        	</th>
            
            <th width="70" align="center">
              
                    PRELIQUIDACION
              
        	</th> 
            
            <th width="70" align="center">
              
                    F. REGISTRO
              
        	</th>  
            
            <th width="70" align="center">
              
                    F. DESESTIMACION
              
        	</th>   
            
            <th width="70" align="center">
              
                    ESTATUS
              
        	</th>         
          </tr>
     <?php 
     //$sql = "SELECT * FROM VIEW_CATEG_X_PTO WHERE id_empresa=$id_empresa";
     
	 $sql = "SELECT   * FROM VIEW_CATEGORIAS_POR_PUERTOS WHERE id_empresa=$id_empresa AND ANO_REGISTRO=$ANO_REGISTRO AND ESTATUS=1";
		if($rs=$conector->Ejecutar($sql))
		
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$CATEGORIA			=odbc_result($rs,"CATEGORIA");
			$PTO_CABELLO		=odbc_result($rs,"PTO_CABELLO");
			$LAGUAIRA			=odbc_result($rs,"LAGUAIRA");
			$GUANTA				=odbc_result($rs,"GUANTA");
			$GUAMACHE			=odbc_result($rs,"GUAMACHE");
			$MARACAIBO			=odbc_result($rs,"MARACAIBO");
			$CEIBA				=odbc_result($rs,"CEIBA");
			$FG_ACTIVO				=odbc_result($rs,"FG_ACTIVO");
			$ID_PRELIQUIDACION				=odbc_result($rs,"ID_PRELIQUIDACION");
			$ID_EMPCATEG				=odbc_result($rs,"ID_EMPCATEG");
			$F_REGISTRO				=odbc_result($rs,"F_REGISTRO");
			$F_DESESTIM				=odbc_result($rs,"F_DESESTIM");
	
			if($FG_ACTIVO)
			{
				$ACTIVO="ACTIVO";
			}
			else
			{
				$ACTIVO="INACTIVO";
			}
			
			if($F_REGISTRO)
				$F_REGISTRO	=	fecha_normal($F_REGISTRO);
			
			if($F_DESESTIM)
				$F_DESESTIM	=	fecha_normal($F_DESESTIM);
    ?> 
    
    		<tr <?php echo $clase;?>>
				<td align='center'  ><?php echo $CATEGORIA;?></td>
				<td align='center'><?php echo $PTO_CABELLO;?></td>
				<td align='center'><?php echo $LAGUAIRA;?></td>
				<td align='center'><?php echo $GUANTA;?></td>
				<td align='center'><?php echo $GUAMACHE;?></td>
				<td align='center'><?php echo $MARACAIBO;?></td>
				<td align='center'><?php echo $CEIBA;?></td>
				<td align='center'><?php echo $ID_PRELIQUIDACION;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_DESESTIM;?></td>
				<td align='center'><?php echo $ACTIVO;?></td>
			  </tr>
 
 <?php
		}
		}
		else
		{
			echo $sql;
		} 
    ?> 
    
    </table> 
    
    <p>&nbsp;</p>
    <table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="border-collapse:collapse; width:1050px; margin:auto;">
    	<tr>
    	  <th colspan="5" align='center' valign="middle">HISTORICO DE PUERTOS</th>
   	  </tr>
    	<tr> 
           <th width="234" align='center' valign="middle">
                    PUERTO
       	  </th>
           <th width="347" align='center' valign="middle">
                    CATEGORIA
       	  </th>
            <th width="92" align='center' valign="middle">
                    F. RESGISTRO
       	  </th>
            <th width="134" align='center' valign="middle">
                    F. DESESTIMACION
       	  </th>
            <th width="81" align='center' valign="middle">
                    ESTATUS
       	  </th>
      </tr>
 
 <?php
				
	$sql="
	SELECT        
		dbo.TB_LOCALIDAD.NB_LOCALIDAD, 
		dbo.TB_CATEGORIA.NB_CATEGORIA, 
		dbo.EMPRE_CATEG_LOCAL.F_REGISTRO,
		dbo.EMPRE_CATEG_LOCAL.F_DESESTIM, 
		dbo.EMPRE_CATEG_LOCAL.FG_ACTIVO, 
		dbo.EMPRE_EXPEDIENTE.ESTATUS
	FROM
		dbo.EMPRE_CATEG_LOCAL INNER JOIN
        dbo.TB_LOCALIDAD ON dbo.EMPRE_CATEG_LOCAL.ID_LOCALIDAD = dbo.TB_LOCALIDAD.ID_LOCALIDAD INNER JOIN
        dbo.EMPRE_CATEGORIA ON dbo.EMPRE_CATEG_LOCAL.ID_EMPCATEG = dbo.EMPRE_CATEGORIA.ID_EMPCATEG INNER JOIN
        dbo.TB_CATEGORIA ON dbo.EMPRE_CATEGORIA.ID_CATEGORIA = dbo.TB_CATEGORIA.ID_CATEGORIA INNER JOIN
        dbo.EMPRE_EXPEDIENTE ON dbo.EMPRE_CATEGORIA.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP
	WHERE        
		dbo.EMPRE_CATEGORIA.ID_EMPRESA = $id_empresa and 
		dbo.EMPRE_CATEG_LOCAL.ANO_REGISTRO=$ANO_REGISTRO AND 
		(dbo.EMPRE_EXPEDIENTE.ESTATUS = 1)
";
			
	if($rs2=$conector->Ejecutar($sql))
	{
		
	$det = '';
	$pintar=0;
	
	while (odbc_fetch_row($rs2))  
	{
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="class='Normal'";
			$pintar=1;
		}
	
		$NB_LOCALIDAD			=	odbc_result($rs2,"NB_LOCALIDAD");	
		$NB_CATEGORIA				=	odbc_result($rs2,"NB_CATEGORIA");
		$F_REGISTRO				=	odbc_result($rs2,"F_REGISTRO");
		$F_DESESTIM						=	odbc_result($rs2,"F_DESESTIM");	
		$FG_ACTIVO				    =	odbc_result($rs2,"FG_ACTIVO");	
		
		
		if($F_REGISTRO)
				$F_REGISTRO	=	fecha_normal($F_REGISTRO);
				
		if($F_DESESTIM)
				$F_DESESTIM	=	fecha_normal($F_DESESTIM);
		
		if($FG_ACTIVO)
		{
			$CAD_ESTATUS="ACTIVO";

			$F_DESESTIM	= "";
		}
		else
		{
			$CAD_ESTATUS="ANULADO";
		}
?>	
				<tr <?php echo $clase;?>>
					<td align="center"><?php echo $NB_LOCALIDAD;?></td>
					<td align="center"><?php echo $NB_CATEGORIA;?></td>
					<td align="center"><?php echo $F_REGISTRO;?></td>
					<td align="center"><?php echo $F_DESESTIM;?></td>
					<td align="center"><?php echo $CAD_ESTATUS;?></td>
	  </tr>
<?php
	}
	}
	else
	{
		echo $sql;
	}
 ?>	
 	
</table>
<?php
		break;
		
		case 10:
    ?> 
    		<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
            <th width="65" align="center">
           		
                    NRO.
              
        	</th>
           <th width="300" align="center">
       		  
                    TIPO DOC.
              
       	  </th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
       	  </th>
            <th width="114" align="center">
              
                    F. REGISTRO.
              
        	</th>
            <th width="115" align="center">
              
                    F. ANULACION.
              
        	</th>
            <th width="110" align="center">
              
                    F. RECEP.
              
        	</th>
            <th width="110" align="center">
              
                    ABG. RECEP.
              
        	</th>   
            <th width="74" align="center">
              
                    F. ASIG.
              
        	</th>
            <th width="108" align="center">
              
                    ABG. ASIG.
              
        	</th>
            <th width="115" align="center">
              
                    F. CONFORME
              
        	</th>     
            <th width="141" align="center">
              
                    ABG. COMFORME.
              
        	</th>    
            <th width="94" align="center">
              
                    ESTATUS
              
        	</th>                  
          </tr>
     <?php 
	 
     $sql = "
	 		SELECT 
	 			*
 			FROM 
				VIEW_RP_STAT_EMPRE 
			WHERE 
				id_empresa=$id_empresa AND
				ID_TACTA<>6 AND
				ANO_REGISTRO=$ANO_REGISTRO 
			order by 
				id_tacta 
			asc";
 	
		//echo $sql;
		
		if($result=$conector->Ejecutar($sql))
		{
			$res="";
			$pintar=0;
			while (odbc_fetch_row($result))
			{
				if($pintar)
				{
					$clase="class='color'";
					$pintar=0;
				}
				else
				{
					$clase="class='Normal'";
					$pintar=1;
				}
				
				$NRO_ACTA			=odbc_result($result,"NRO_ACTA");
				$NB_TACTA			=odbc_result($result,"NB_TACTA");
				$NB_LOCALIDAD		=odbc_result($result,"NB_LOCALIDAD");
				$F_REGISTRO		    =odbc_result($result,"F_REGISTRO");
				$NB_ABG_RECEP			=odbc_result($result,"NB_USUARIO")." ".odbc_result($result,"AP_ABG_RECEP");
				$F_ASIG				=odbc_result($result,"F_ASIG");
				$F_RASIG				=odbc_result($result,"F_RASIG");
				$ABG_RASIG				=odbc_result($result,"ABG_RASIG");
				$NB_ABG_APROB			=odbc_result($result,"ABG_APROB")." ".odbc_result($result,"AP_ABG_APROB");
			
				if($F_REGISTRO)
					$F_REGISTRO=fecha_normal($F_REGISTRO);
				
				if($ABG_RASIG)
					$NB_ABG_RASIG			=odbc_result($result,"ABG_RASIG")." ".odbc_result($result,"AP_ABG_RASIG");
				else
					$NB_ABG_RASIG			=odbc_result($result,"ABG_ASIG")." ".odbc_result($result,"AP_ABG_ASIG");
			
				if(odbc_result($result,"F_ANULACION"))
				{
					$F_ANULACION			=fecha_normal(odbc_result($result,"F_ANULACION"));
				}
				else
				{
					$F_ANULACION="";
				}
				
				if(odbc_result($result,"F_RECEP"))
				{
					$F_RECEP			=fecha_normal(odbc_result($result,"F_RECEP"));
				}
				else
				{
					$F_RECEP="";
				}
				
				if(odbc_result($result,"F_ASIG"))
				{
					$F_ASIG			=fecha_normal(odbc_result($result,"F_ASIG"));
				}
				else
				{
					$F_ASIG="";
				}
				
				if(odbc_result($result,"F_APROB"))
				{
					$F_APROB			=fecha_normal(odbc_result($result,"F_APROB"));
				}
				else
				{
					$F_APROB="";
				}
				
				$ESTATUS="SIN RECEPCIONAR";
				
				if($F_ANULACION)
				{
					$ESTATUS="ANULADA";
				}
				else
				{
					$F_ANULACION="N/A";
					
					if($F_APROB)
					{
						$ESTATUS="APROBADO";
					}
					else
					{
						if($F_ASIG or $F_RASIG)
						{
							$ESTATUS="ASIGNADO";
						}
						else
						{
							if($F_RECEP)
							{
								$ESTATUS="RECEPCIONADO";
							}
						}
					}
				}
?>			
				<tr <?php echo $clase;?>>
					<td align='center'><?php echo $NRO_ACTA;?></td>
					<td align='center'><?php echo $NB_TACTA;?></td>
					<td align='center'><?php echo $NB_LOCALIDAD;?></td>
					<td align='center'><?php echo $F_REGISTRO;?></td>
					<td align='center'><?php echo $F_ANULACION;?></td>
					<td align='center'><?php echo $F_RECEP;?></td>
					<td align='center'><?php echo $NB_ABG_RECEP;?></td>
					<td align='center'><?php echo $F_ASIG;?></td>
					<td align='center'><?php echo $NB_ABG_RASIG;?></td>
					<td align='center'><?php echo $F_APROB;?></td>
					<td align='center'><?php echo $NB_ABG_APROB;?></td>
					<td align='center'><?php echo $ESTATUS;?></td>
				  </tr>
<?php
			}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
</table>
    <?php
		break;
		
		case 11:
    ?> 
    		<table border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP"  style="width:1050px; margin:auto;">
    <thead>
      <tr>
        <th width="250" align="center">NRO. CONTRATO</th>
        <th width="250" align="center">NRO. ANEXO</th>
        <th width="250" align="center">TIPO DOCUMENTO</th>
        <th width="446" align='center'>LOCALIDAD</th>
        <th width="446" align='center'>CATEGORIA</th>
        <th width="250" align="center">ABOGADO</th>
        <th width="101" align="center">FECHA REGISTRO</th>
        <th width="100" align="center">FECHA FIRMA</th>
        <th width="99" align="center">ESTATUS</th>
        </tr>
    </thead>
    <?php
    /*$sql="SELECT        dbo.EMPRE_DOCLEGAL.ID_EDOC_LEGAL, dbo.EMPRE_DOCLEGAL.ID_EMPCATEG, dbo.EMPRE_DOCLEGAL.ID_LOCALIDAD, 
                         dbo.EMPRE_DOCLEGAL.ID_TDOC_LEGAL, dbo.EMPRE_DOCLEGAL.ID_EDOC_LEGAL_ORIG, dbo.EMPRE_DOCLEGAL.ID_EMPEXP, 
                         dbo.EMPRE_DOCLEGAL.NRO_DOC_LEGAL, dbo.EMPRE_DOCLEGAL.F_EMISION, dbo.EMPRE_DOCLEGAL.F_FIRMA, dbo.EMPRE_DOCLEGAL.F_VIG_DESDE, 
                         dbo.EMPRE_DOCLEGAL.F_VIG_HASTA, dbo.EMPRE_DOCLEGAL.F_ENVIO, dbo.EMPRE_DOCLEGAL.ESTATUS, dbo.EMPRE_DOCLEGAL.FG_RENOVACION, 
                         dbo.EMPRE_DOCLEGAL.FG_RENOVADO, dbo.EMPRE_DOCLEGAL.MTO_CONTRATO, dbo.EMPRE_DOCLEGAL.CI_ABOGADO, dbo.EMPRE_DOCLEGAL.ID_CONTRATO, 
                         dbo.EMPRE_DOCLEGAL.NB_DOC_GENERADO, dbo.EMPRE_DOCLEGAL.CI_ABOG_CARGA_DOC, dbo.EMPRE_DOCLEGAL.NB_DIR_CONTRATO, 
                         dbo.EMPRE_DOCLEGAL.F_REGISTRO, dbo.EMPRE_DOCLEGAL.DESC_CONTRATO, dbo.EMPRE_DOCLEGAL.ULTIMA_FECHA_UPBO, 
                         dbo.EMPRE_DOCLEGAL.FG_DEFINITIVO, dbo.EMPRE_DOCLEGAL.FECHA_EMISION_DEF, dbo.EMPRE_DOCLEGAL.CORRELATIVO_SEGURIDAD, 
                         dbo.EMPRE_DOCLEGAL.FG_GUARDADO, dbo.EMPRE_DOCLEGAL.ID_BITACORA, dbo.TB_CATEGORIA.NB_CATEGORIA, dbo.TB_CATEGORIA.ID_CATEGORIA, 
                         dbo.EMPRE_CATEGORIA.ID_EMPRESA, dbo.USUARIO.NB_USUARIO, dbo.USUARIO.AP_USUARIO, dbo.TB_PERIODO.FG_ACTIVO, 
                         dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO
FROM            dbo.EMPRE_DOCLEGAL INNER JOIN
                         dbo.EMPRE_CATEGORIA ON dbo.EMPRE_DOCLEGAL.ID_EMPCATEG = dbo.EMPRE_CATEGORIA.ID_EMPCATEG INNER JOIN
                         dbo.TB_CATEGORIA ON dbo.EMPRE_CATEGORIA.ID_CATEGORIA = dbo.TB_CATEGORIA.ID_CATEGORIA INNER JOIN
                         dbo.USUARIO ON dbo.EMPRE_DOCLEGAL.CI_ABOGADO = dbo.USUARIO.CI_USUARIO INNER JOIN
                         dbo.EMPRE_EXPEDIENTE ON dbo.EMPRE_DOCLEGAL.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO
WHERE        (dbo.EMPRE_CATEGORIA.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO)";*/

//echo $sql;

    $sql="select * from VIEW_RP_LISTADO_CONTRATOS where id_empresa =$id_empresa and ANO_REGISTRO = $ANO_REGISTRO";

	$cn2=$conector->Ejecutar($sql);
	
	$pintar=0;
	
	while(odbc_fetch_row($cn2))
	{
		if(odbc_result($cn2,'FG_DEFINITIVO'))
		{
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="class='Normal'";
			$pintar=1;
		}
	
		$NB_USUARIO=odbc_result($cn2,'NB_USUARIO');
		$AP_USUARIO=odbc_result($cn2,'AP_USUARIO');
		$NB_AP=$NB_USUARIO." ".$AP_USUARIO;
		$CODIGO_CONT=odbc_result($cn2,'CODIGO_CONT');
		$NB_TDOC_LEGAL=odbc_result($cn2,'NB_TDOC_LEGAL');
		$NB_LOCALIDAD=odbc_result($cn2,'NB_LOCALIDAD');
		$FG_FIRMA_EMPRESA=odbc_result($cn2,'FG_FIRMA_EMPRESA');
		$ID_EMPCATEG=odbc_result($cn2,'ID_EMPCATEG');
		$NRO_ANEXO=odbc_result($cn2,'NRO_ANEXO');
		$ID_CATEGORIA=utf8_encode (odbc_result($cn2,'ID_CATEGORIA'));
		$NB_CATEGORIA=utf8_encode (odbc_result($cn2,'NB_CATEGORIA'));
		$ID_LOCALIDAD=utf8_encode (odbc_result($cn2,'ID_LOCALIDAD'));
		$ID_EDOC_LEGAL=utf8_encode (odbc_result($cn2,'ID_EDOC_LEGAL'));
		$F_REGISTRO=utf8_encode (odbc_result($cn2,'F_REGISTRO'));
		$F_FIRMA_EMPRESA=utf8_encode (odbc_result($cn2,'F_FIRMA_EMPRESA'));
		$FG_DEFINITIVO=utf8_encode (odbc_result($cn2,'FG_DEFINITIVO'));
		$NB_ABOGADO=utf8_encode (odbc_result($cn2,'NB_USUARIO')." ".odbc_result($cn2,'AP_USUARIO'));	
		
		if($FG_DEFINITIVO)
		{			
			$ESTATUS="DEFINITIVO";
			
			if($F_FIRMA_EMPRESA)
			{
				$ESTATUS="FIRMADO";
			}
		}
		else
		{
			$CODIGO_CONT="S/N";
			
			$ESTATUS="BORRADOR";
		}
	
		if($F_REGISTRO)
			$F_REGISTRO=fecha_normal($F_REGISTRO);
		
		if($F_FIRMA_EMPRESA)
			$F_FIRMA_EMPRESA=fecha_normal($F_FIRMA_EMPRESA);
?>
        <tr <?php echo $clase;?>>
			<td align="center" ><a href="javascript:" onclick="ver_contrato(<?php echo $ID_EDOC_LEGAL;?>, <?php echo $FG_DEFINITIVO;?>)"><?php echo $CODIGO_CONT;?></a></td>
			<td align="center" ><?php echo $NRO_ANEXO;?></td>
			<td align="center" ><?php echo $NB_TDOC_LEGAL;?></td>
			<td align="center" ><?php echo $NB_LOCALIDAD;?></td>
			<td align="center" ><?php echo $NB_CATEGORIA;?></td>
			<td align="center" ><?php echo $NB_AP;?></td>
			<td align="center" ><?php echo ($F_REGISTRO);?></td>
			<td align="center" ><?php echo ($F_FIRMA_EMPRESA);?></td>
			<td align="center" ><?php echo $ESTATUS;?></td>
		</tr>
        <?php
	}
}
?>
  </table>
    <?php
		break;
		
		case 12:
    ?> 
    		<table border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align="center">
           		
                    NRO.
              
       	  </th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
       	  </th>
            <th width="114" align="center">
              
                    F. REGISTRO.
              
        	</th>
            <th width="110" align="center">
              
                    F. RECEP.
              
        	</th>
            <th width="110" align="center">
              
                    F. ALULACION.
              
        	</th>
            <th width="110" align="center">
              
                    ABG. RECEP.
              
        	</th>
            <th width="94" align="center">
              
                    ESTATUS
              
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 6 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_ANULACION		=odbc_result($rs,"F_ANULACION");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			$F_APROB			=(odbc_result($rs,"F_APROB"));
			$F_ASIG				=(odbc_result($rs,"F_ASIG"));
			$F_RECEP			=(odbc_result($rs,"F_RECEP"));
			$F_REGISTRO		    =(odbc_result($rs,"F_REGISTRO"));
			
			if($F_RECEP)
				$F_RECEP=fecha_normal($F_RECEP);
				
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			if($F_ASIG)
				$F_ASIG=fecha_normal($F_ASIG);
			
			if($F_APROB)
				$F_APROB=fecha_normal($F_APROB);
			
			if($F_ANULACION)
				$F_ANULACION=fecha_normal($F_ANULACION);
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_RECEP)
			{
				$ESTATUS="RECEPCIONADA";
			}
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADO POR EL USUARIO";
			}
				
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"Inconformidades\", \"Inconformidades\", \"Sistema/Reportes/INCONFORMIDAD.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
  ?> 
			<tr <?php echo $clase;?>>
			  <td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
			  </tr>
    <?php
		}
		}
		else
		{
			echo $sql;
		} 
    ?> 
    </table> 
    <br />
    <br />
    <?php
		break;	
		
		case 14:
    ?> 
			<table width="1034" border="1" align="center" cellpadding="0" cellspacing="0"  bordercolor="#CCCCCC" style="width:1050px; margin:auto;" >
				  <tr>
						<th width="170" align="center">CEDULA</th>
					   <th width="170" align="center">
						NOMBRE </th>
						<th width="170" align="center">
							CARGO
						</th>
						 <th width="170" align="center">
							EMAIL
						</th>
						  <th width="170" align="center">
							TEL&Eacute;FONO
						</th>
						 <th width="170" align="center">CONTRATO</th>
						 <th width="170" align="center">ESTATUS</th>
					   
				</tr>
				<?php
				$sql="SELECT * FROM VIEW_RP_TABLA_REPRES_LEGAL WHERE ID_EMPRESA=$id_empresa";
				
				if($rs=$conector->Ejecutar($sql))
				{
					$pintar=0;
					while (odbc_fetch_row($rs))  
					{
						if($pintar)
						{
							$clase="class='color'";
							$pintar=0;
						}
						else
						{
							$clase="class='Normal'";
							$pintar=1;
						} 
						
						$fg_activo		=	odbc_result($rs,"fg_activo");
						$ci_repre		=	odbc_result($rs,"CI_REP_LEGAL");	
						$nob_repre		=	odbc_result($rs,"NB_REPR_LEGAL");	
						$cargo_repre	=	odbc_result($rs,"NB_CARGO_REPRES");	
						$telf_repre		=	odbc_result($rs,"TELEF1");	
						$email_repre	=	odbc_result($rs,"EMAIL_REPRE");	
						$direccion_rep	=	odbc_result($rs,"DIRECCION");	
						$FG_REP_CONTRATO	=	odbc_result($rs,"FG_REP_CONTRATO");	
						
						if ($FG_REP_CONTRATO==1)
						{
							$FG_REP_CONTRATO="SI";
						}
						else
						{
							$FG_REP_CONTRATO="NO";
						}
						
						if ($fg_activo==1)
						{
							$estatus="ACTIVO";
						}
						else
						{
							$estatus="INACTIVO";
						}
						?>
						<tr <?php echo $clase;?>>
							<td width="170" align="center">
								<?php echo $ci_repre;?>
							</td>
						   <td width="170" align="center">
								<?php echo $nob_repre;?>
							</td>
							<td width="170" align="center">
								<?php echo $cargo_repre;?>
							</td>
							
							 <td width="170" align="center">
								<?php echo $email_repre;?>
							</td>
							 <td width="170" align="center">
								<?php echo $telf_repre;?>
							</td>
						  <td width="170" align="center">
								<?php echo $FG_REP_CONTRATO;?>
						  </td>
						  <td width="170" align="center">
								<?php echo $estatus;?>
						  </td>
					</tr>
					<?php
					}
				}
				else
				{
					echo $sql;
				}
			?>
			</table>
            <?php
		break;
		
		case 15:
			?>
            <table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="border-collapse:collapse; width:1050px; margin:auto;">
    	<tr> 
           <th width="234" align='center' valign="middle">
                    NRO
       	  </th>
           <th width="347" align='center' valign="middle">
                    ASEGURADORA
       	  </th>
            <th width="92" align='center' valign="middle">
                    MONTO</th>
            <th width="134" align='center' valign="middle">
                    F. VENCIMIENTO
       	  </th>
            <th width="81" align='center' valign="middle">
                    TIPO
       	  </th>
            <th width="81" align='center' valign="middle">
                    VEHICULOS AMPARADOS
       	  </th>
            <th width="81" align='center' valign="middle">
                    ESTATUS
       	  </th>
      </tr>
 
 <?php
				
	$sql="SELECT *
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.EMPRE_POLIZA ON dbo.EMPRE_EXPEDIENTE.ID_EMPEXP = dbo.EMPRE_POLIZA.ID_EMPEXP INNER JOIN
                         dbo.TB_PERIODO ON dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = dbo.TB_PERIODO.ANO_REGISTRO RIGHT OUTER JOIN
                         dbo.EMPRESA_ASEGURADORA ON dbo.EMPRE_POLIZA.ID_EMP_ASEGUR = dbo.EMPRESA_ASEGURADORA.ID_EMP_ASEGUR
WHERE   (dbo.TB_PERIODO.FG_ACTIVO = 1) AND (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO) AND (dbo.EMPRE_POLIZA.ID_EMPRESA = $id_empresa)";
			
	if($rs2=$conector->Ejecutar($sql))
	{
		
	$det = '';
	$pintar=0;
	
	while (odbc_fetch_row($rs2))  
	{
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="class='Normal'";
			$pintar=1;
		}
		
		$id=odbc_result($rs2,"ID_EMPRE_POLIZA");
		$fg_activo=odbc_result($rs2,"fg_activo");
		$f_vigencia=odbc_result($rs2,"F_VIG_POLIZA");
		$tipo_poliza=odbc_result($rs2,"TIPO_POLIZA");
		$ESTATUS=odbc_result($rs2,"ESTATUS");
		$FG_CONFORME=odbc_result($rs2,"FG_CONFORME");
		$FG_RECEP=odbc_result($rs2,"FG_RECEP");
		$FG_RENOV_RCV=odbc_result($rs2,"FG_RENOV_RCV");
		$CANT_AMPARADO=odbc_result($rs2,"CANT_AMPARADO");
		$NRO_POLIZA=odbc_result($rs2,"NRO_POLIZA");
		$NB_EMP_ASEGUR=odbc_result($rs2,"NB_EMP_ASEGUR");
		$FG_ACTIVO=odbc_result($rs2,"FG_ACTIVO");
		$MTO_COBERTURA=number_format(odbc_result($rs2,"MTO_COBERTURA"),2);
		
		if($f_vigencia)
				$f_vigencia	=	fecha_normal($f_vigencia);
				
		if($tipo_poliza==1)
			$tipo_poliza="INDIVIDUAL";
		else
			$tipo_poliza="FLOTA";
				
		if($FG_ACTIVO)
			$FG_ACTIVO="ACTIVA";
		else
			$FG_ACTIVO="INACTIVA";
				
?>	
				<tr <?php echo $clase;?>>
					<td align="center"><?php echo $NRO_POLIZA;?></td>
					<td align="center"><?php echo $NB_EMP_ASEGUR;?></td>
					<td align="center"><?php echo $MTO_COBERTURA;?></td>
					<td align="center"><?php echo $f_vigencia;?></td>
					<td align="center"><?php echo $tipo_poliza;?></td>
					<td align="center"><?php echo $CANT_AMPARADO;?></td>
					<td align="center"><?php echo $FG_ACTIVO;?></td>
	  </tr>
<?php
	}
	}
	else
	{
		echo $sql;
	}
 ?>	
 	
</table>
            <?php
		break;
		
		case 16:
			?>
            <table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="border-collapse:collapse; width:1050px; margin:auto;">
    	<tr> 
           <th width="148" align='center' valign="middle">
                    NRO PRELIQUIDACION
       	  </th>
           <th width="150" align='center' valign="middle">
                    NRO FACTURA / NC
       	  </th>
            <th width="184" align='center' valign="middle">
                    TIPO DOCUMENTO
            </th>
            <th width="196" align='center' valign="middle">
                    LOCALIDAD
            </th>
            <th width="183" align='center' valign="middle">
                    USUARIO
            </th>
            <th width="175" align='center' valign="middle">
                    F. FACTURA
       	  </th>
      </tr>
 
 <?php
				
	$sql="SELECT        dbo.EMPRE_HIST_PRELIQ.ID_PRELIQUIDACION, dbo.EMPRE_HIST_PRELIQ.NRO_DOCUMENTO, dbo.EMPRE_HIST_PRELIQ.FECHA_REGISTRO, dbo.TB_TP_DOC_PRELIQ.DS_TIPO_DOC_PRE, 
                         dbo.EMPRE_PRELIQUIDACION.ID_EMPRESA, dbo.EMPRE_EXPEDIENTE.ESTATUS, dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, dbo.EMPRE_HIST_PRELIQ.USER_FACTURA, 
                         dbo.TB_LOCALIDAD.NB_LOCALIDAD
FROM            dbo.EMPRE_HIST_PRELIQ INNER JOIN
                         dbo.EMPRE_PRELIQUIDACION ON dbo.EMPRE_HIST_PRELIQ.ID_PRELIQUIDACION = dbo.EMPRE_PRELIQUIDACION.ID_PRELIQUIDACION INNER JOIN
                         dbo.TB_TP_DOC_PRELIQ ON dbo.EMPRE_HIST_PRELIQ.ID_TIPO_DOC_PRE = dbo.TB_TP_DOC_PRELIQ.ID_TIPO_DOC_PRE INNER JOIN
                         dbo.EMPRE_EXPEDIENTE ON dbo.EMPRE_PRELIQUIDACION.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP INNER JOIN
                         dbo.TB_LOCALIDAD ON dbo.EMPRE_PRELIQUIDACION.ID_LOCALIDAD = dbo.TB_LOCALIDAD.ID_LOCALIDAD
WHERE        (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1) AND (dbo.EMPRE_PRELIQUIDACION.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO)";
			
	if($rs2=$conector->Ejecutar($sql))
	{
		
	$det = '';
	$pintar=0;
	
	while (odbc_fetch_row($rs2))  
	{
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="class='Normal'";
			$pintar=1;
		}
		
		$ID_PRELIQUIDACION=odbc_result($rs2,"ID_PRELIQUIDACION");
		$NRO_DOCUMENTO=odbc_result($rs2,"NRO_DOCUMENTO");
		$DS_TIPO_DOC_PRE=odbc_result($rs2,"DS_TIPO_DOC_PRE");
		$NB_LOCALIDAD=odbc_result($rs2,"NB_LOCALIDAD");
		$USER_FACTURA=utf8_encode(odbc_result($rs2,"USER_FACTURA"));
		$FECHA_REGISTRO=odbc_result($rs2,"FECHA_REGISTRO");
		$MTO_COBERTURA=number_format(odbc_result($rs2,"MTO_COBERTURA"),2);
		
		if($FECHA_REGISTRO)
				$FECHA_REGISTRO	=	fecha_normal($FECHA_REGISTRO);
				
?>	
				<tr <?php echo $clase;?>>
					<td align="center"><?php echo $ID_PRELIQUIDACION;?></td>
					<td align="center"><?php echo $NRO_DOCUMENTO;?></td>
					<td align="center"><?php echo $DS_TIPO_DOC_PRE;?></td>
					<td align="center"><?php echo $NB_LOCALIDAD;?></td>
					<td align="center"><?php echo $USER_FACTURA;?></td>
					<td align="center"><?php echo $FECHA_REGISTRO;?></td>
	  </tr>
<?php
	}
	}
	else
	{
		echo $sql;
	}
 ?>	
 	
</table>
            <?php
		break;
		
		case 17:
			?>
            <table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="border-collapse:collapse; width:1050px; margin:auto;">
    	<tr> 
           <th width="150" align='center' valign="middle">
                    NRO PRELIQUIDACION
       	  </th>
           <th width="200" align='center' valign="middle">
                    TIPO
       	  </th>
           <th width="100" align='center' valign="middle">
                    BASE IMPONIBLE
       	  </th>
            <th width="100" align='center' valign="middle">
                    MONTO
            </th>
            <th width="87" align='center' valign="middle">
                    FECHA REGISTRO
            </th>
            <th width="74" align='center' valign="middle">
                    ESTATUS
       	  </th>
            <th width="221" align='center' valign="middle">
                    MOTIVO ANULACION
            </th>
            <th width="100" align='center' valign="middle">
                    FECHA ANULACION
            </th>
      </tr>
 
 <?php
				
	$sql="SELECT       *
FROM            dbo.EMPRE_DETRETEN INNER JOIN
                         dbo.EMPRE_PRELIQUIDACION ON dbo.EMPRE_DETRETEN.ID_PRELIQUIDACION = dbo.EMPRE_PRELIQUIDACION.ID_PRELIQUIDACION INNER JOIN
                         dbo.TB_TIPO_RETENCION ON dbo.EMPRE_DETRETEN.ID_TIPO_RETEN = dbo.TB_TIPO_RETENCION.ID_TIPO_RETEN INNER JOIN
                         dbo.EMPRE_EXPEDIENTE ON dbo.EMPRE_PRELIQUIDACION.ID_EMPEXP = dbo.EMPRE_EXPEDIENTE.ID_EMPEXP
WHERE        (dbo.EMPRE_PRELIQUIDACION.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO) AND (dbo.EMPRE_EXPEDIENTE.ESTATUS = 1)";
			
	if($rs2=$conector->Ejecutar($sql))
	{
		
	$det = '';
	$pintar=0;
	
	while (odbc_fetch_row($rs2))  
	{
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="class='Normal'";
			$pintar=1;
		}
		
		$ID_PRELIQUIDACION=odbc_result($rs2,"ID_PRELIQUIDACION");
		$NB_TIPO_RETENC=odbc_result($rs2,"NB_TIPO_RETENC");
		$BASE_IMPONIBLE=number_format(odbc_result($rs2,"BASE_IMPONIBLE"),2);
		$MONTO_RETEN=number_format(odbc_result($rs2,"MONTO_RETEN"),2);
		$FECHA_CREACION=odbc_result($rs2,"FECHA_CREACION");
		$FG_ACTIVO=odbc_result($rs2,"FG_ACTIVO");
		$MOTIVO=odbc_result($rs2,"MOTIVO");
		$FECHA_ANULACION=odbc_result($rs2,"FECHA_ANULACION");
		
		if($FG_ACTIVO)
		{
			$FG_ACTIVO="ACTIVA";
		}
		else
		{
			$FG_ACTIVO="ANULADA";
		}
		
		if($FECHA_CREACION)
				$FECHA_CREACION	=	fecha_normal($FECHA_CREACION);
		
		if($FECHA_TRANSFERENCIA)
				$FECHA_TRANSFERENCIA	=	fecha_normal($FECHA_TRANSFERENCIA);
		
		if($FECHA_ANULACION)
				$FECHA_ANULACION	=	fecha_normal($FECHA_ANULACION);
				
?>	
				<tr <?php echo $clase;?>>
					<td align="center"><?php echo $ID_PRELIQUIDACION;?></td>
					<td align="center"><?php echo $NB_TIPO_RETENC;?></td>
					<td align="center"><?php echo $BASE_IMPONIBLE;?></td>
					<td align="center"><?php echo $MONTO_RETEN;?></td>
					<td align="center"><?php echo $FECHA_CREACION;?></td>
					<td align="center"><?php echo $FG_ACTIVO;?></td>
					<td align="center"><?php echo $MOTIVO;?></td>
					<td align="center"><?php echo $FECHA_ANULACION;?></td>
	  </tr>
<?php
	}
	}
	else
	{
		echo $sql;
	}
 ?>	
 	
</table>
            <?php
		break;
		
		case 18:
			?>
            <table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="border-collapse:collapse; width:1050px; margin:auto;">
    	<tr> 
           <th width="148" align='center' valign="middle">
                    NRO EXPEDIENTE
       	  </th>
           <th width="150" align='center' valign="middle">
                    ANO_REGISTRO
       	  </th>
            <th width="196" align='center' valign="middle">
                    LOCALIDAD
            </th>
            <th width="175" align='center' valign="middle">
                    F. REGISTRO
       	  </th>
            <th width="175" align='center' valign="middle">
                    F. ANULACION
       	  </th>
            <th width="183" align='center' valign="middle">
                    ESTATUS
            </th>
            <th width="196" align='center' valign="middle">
                    RENOVADO
            </th>
      </tr>
 
 
 
 <?php
				
	$sql="SELECT        dbo.TB_LOCALIDAD.NB_LOCALIDAD, dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO, dbo.EMPRE_EXPEDIENTE.NRO_EXPED, dbo.EMPRE_EXPEDIENTE.F_CREACION, dbo.EMPRE_EXPEDIENTE.FG_RENOVACION, 
                         dbo.EMPRE_EXPEDIENTE.ESTATUS, dbo.EMPRE_EXPEDIENTE.F_REGISTRO, dbo.EMPRE_EXPEDIENTE.F_ANULACION, dbo.EMPRE_EXPEDIENTE.ID_EMPRESA
FROM            dbo.EMPRE_EXPEDIENTE INNER JOIN
                         dbo.TB_LOCALIDAD ON dbo.EMPRE_EXPEDIENTE.ID_LOCALIDAD = dbo.TB_LOCALIDAD.ID_LOCALIDAD
WHERE        (dbo.EMPRE_EXPEDIENTE.ID_EMPRESA = $id_empresa) AND (dbo.EMPRE_EXPEDIENTE.ANO_REGISTRO = $ANO_REGISTRO)";
			
	if($rs2=$conector->Ejecutar($sql))
	{
		
	$det = '';
	$pintar=0;
	
	while (odbc_fetch_row($rs2))  
	{
		if($pintar)
		{
			$clase="class='color'";
			$pintar=0;
		}
		else
		{
			$clase="class='Normal'";
			$pintar=1;
		}
		
		$NRO_EXPED=odbc_result($rs2,"NRO_EXPED");
		$ANO_REGISTRO=odbc_result($rs2,"ANO_REGISTRO");
		$NB_LOCALIDAD=odbc_result($rs2,"NB_LOCALIDAD");
		$F_REGISTRO=odbc_result($rs2,"F_REGISTRO");
		$F_ANULACION=odbc_result($rs2,"F_ANULACION");
		$ESTATUS=odbc_result($rs2,"ESTATUS");
		$FG_RENOVACION=odbc_result($rs2,"FG_RENOVACION");
		
		if($ESTATUS)
		{
			$ESTATUS="ACTIVO";
		}
		else
		{
			$ESTATUS="ANULADO";
		}
		
		if($FG_RENOVACION)
		{
			$FG_RENOVACION="RENOVADO";
		}
		else
		{
			$FG_RENOVACION="ANULADO";
		}
		
		if($F_REGISTRO)
				$F_REGISTRO	=	fecha_normal($F_REGISTRO);
		
		if($F_ANULACION)
				$F_ANULACION	=	fecha_normal($F_ANULACION);
				
?>	
				<tr <?php echo $clase;?>>
					<td align="center"><?php echo $NRO_EXPED;?></td>
					<td align="center"><?php echo $ANO_REGISTRO;?></td>
					<td align="center"><?php echo $NB_LOCALIDAD;?></td>
					<td align="center"><?php echo $F_REGISTRO;?></td>
					<td align="center"><?php echo $F_ANULACION;?></td>
					<td align="center"><?php echo $ESTATUS;?></td>
					<td align="center"><?php echo $FG_RENOVACION;?></td>
	  </tr>
<?php
	}
	}
	else
	{
		echo $sql;
	}
 ?>	
 	
</table>
            <?php
		break;
		
		case 19:
    ?> 
    		<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align='center'>
           		
                    NRO.
              
       	  </th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
       	  </th>
            <th width="114" align='center'>
              
                    F. REGISTRO.
              
       	  </th>
            <th width="115" align='center'>
              
                    F. ANULACION.
              
       	  </th>
            <th width="110" align='center'>
              
                    F. RECEP.
              
       	  </th>
            <th width="110" align='center'>
              
                    ABG. RECEP.
              
       	  </th>   
            <th width="74" align='center'>
              
                    F. ASIG.
              
       	  </th>
            <th width="108" align='center'>
              
                    ABG. ASIG.
              
       	  </th>
            <th width="115" align="center">
              
                    F. CONFORME
              
        	</th>     
            <th width="141" align="center">
              
                    ABG. COMFORME.
              
        	</th>    
            <th width="94" align="center">
              
                    ESTATUS
              
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 9 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if(odbc_result($rs,"F_ANULACION"))
			{
				$F_ANULACION			=fecha_normal(odbc_result($rs,"F_ANULACION"));
			}
			else
			{
				$F_ANULACION="";
			}
			
			if(odbc_result($rs,"F_RECEP"))
			{
				$F_RECEP			=fecha_normal(odbc_result($rs,"F_RECEP"));
			}
			else
			{
				$F_RECEP="";
			}
			
			if(odbc_result($rs,"F_ASIG"))
			{
				$F_ASIG			=fecha_normal(odbc_result($rs,"F_ASIG"));
			}
			else
			{
				$F_ASIG="";
			}
			
			if(odbc_result($rs,"F_APROB"))
			{
				$F_APROB			=fecha_normal(odbc_result($rs,"F_APROB"));
			}
			else
			{
				$F_APROB="";
			}
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
				
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"SolicituddeMaquinariasEquipos\", \"Solicitud de Maquinarias y Equipos\", \"Sistema/Reportes/ACTA_RENO_RCV.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
?> 
			<tr <?php echo $clase;?>>
				<td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $F_ASIG;?></td>
				<td align='center'><?php echo $NB_ABG_ASIG;?></td>
				<td align='center'><?php echo $F_APROB;?></td>
				<td align='center'><?php echo $NB_ABG_APROB;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
			  </tr>
<?php
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
<?php
		break;
		
		case 20:
    ?> 
    		<table width="800" border="1" align='center' cellpadding="0" cellspacing="0" bordercolor="#CCCCCC" class="fuenteP" style="width:1050px; margin:auto;" >
    	<tr> 
           <th width="65" align='center'>
           		
                    NRO.
              
       	  </th>
            <th width="226" align='center'>
              
                    LOCALIDAD
              
       	  </th>
            <th width="114" align='center'>
              
                    F. REGISTRO.
              
       	  </th>
            <th width="115" align='center'>
              
                    F. ANULACION.
              
       	  </th>
            <th width="110" align='center'>
              
                    F. RECEP.
              
       	  </th>
            <th width="110" align='center'>
              
                    USUARIO RECEP.
              
       	  </th>   
       
            <th width="115" align="center">
              
                    F. CONFORME
              
        	</th>     
            <th width="141" align="center">
              
                    USUARIO COMFORME.
              
        	</th>    
            <th width="94" align="center">
              
                    ESTATUS
              
        	</th>    
          </tr>
     <?php 
     $sql = "SELECT 
	 			ID_EMPR_ACTA,
				NRO_ACTA,
				NB_LOCALIDAD,
				F_REGISTRO, 
				F_ANULACION,
	 			F_RECEP,
				NB_ABG_RECEP,
				AP_ABG_RECEP,
				F_ASIG,
				NB_ABG_ASIG,
				AP_ABG_ASIG,
				f_APROB ,
				NB_ABG_APROB,
				AP_ABG_APROB,
				ESTATUS
	 		FROM VIEW_ESTATUS_ACTA_EMPRE WHERE id_empresa=$id_empresa AND ID_TACTA = 11 AND ANO_REGISTRO = $ANO_REGISTRO ORDER BY NRO_ACTA ASC";
			
		if($rs=$conector->Ejecutar($sql))
		{
		$res = "";
		$pintar=0;
		while (odbc_fetch_row($rs))
		{
			if($pintar)
			{
				$clase="class='color'";
				$pintar=0;
			}
			else
			{
				$clase="class='Normal'";
				$pintar=1;
			}
			
			$ID_EMPR_ACTA			=odbc_result($rs,"ID_EMPR_ACTA");
			$NRO_ACTA			=odbc_result($rs,"NRO_ACTA");
			$NB_LOCALIDAD		=odbc_result($rs,"NB_LOCALIDAD");
			$F_REGISTRO		    =odbc_result($rs,"F_REGISTRO");
			$NB_ABG_RECEP			=odbc_result($rs,"NB_ABG_RECEP")." ".odbc_result($rs,"AP_ABG_RECEP");
			$NB_ABG_ASIG			=odbc_result($rs,"NB_ABG_ASIG")." ".odbc_result($rs,"AP_ABG_ASIG");
			$NB_ABG_APROB			=odbc_result($rs,"NB_ABG_APROB")." ".odbc_result($rs,"AP_ABG_APROB");
			
			if($F_REGISTRO)
				$F_REGISTRO=fecha_normal($F_REGISTRO);
			
			if(odbc_result($rs,"F_ANULACION"))
			{
				$F_ANULACION			=fecha_normal(odbc_result($rs,"F_ANULACION"));
			}
			else
			{
				$F_ANULACION="";
			}
			
			if(odbc_result($rs,"F_RECEP"))
			{
				$F_RECEP			=fecha_normal(odbc_result($rs,"F_RECEP"));
			}
			else
			{
				$F_RECEP="";
			}
			
			if(odbc_result($rs,"F_ASIG"))
			{
				$F_ASIG			=fecha_normal(odbc_result($rs,"F_ASIG"));
			}
			else
			{
				$F_ASIG="";
			}
			
			if(odbc_result($rs,"F_APROB"))
			{
				$F_APROB			=fecha_normal(odbc_result($rs,"F_APROB"));
			}
			else
			{
				$F_APROB="";
			}
			
			$ESTATUS="SIN RECEPCIONAR";
			
			if($F_ANULACION)
			{
				$ESTATUS="ANULADA";
			}
			else
			{
				$F_ANULACION="N/A";
				
				if($F_APROB)
				{
					$ESTATUS="APROBADO";
				}
				else
				{
					if($F_ASIG)
					{
						$ESTATUS="ASIGNADO";
					}
					else
					{
						if($F_RECEP)
						{
							$ESTATUS="RECEPCIONADO";
						}
					}
				}
			}
				
			$Enlace="<a href='javascript:' onclick='parent.AbrirVentana(\"SolicituddeMaquinariasEquipos\", \"Acta de Conformidad SLA\", \"Sistema/Reportes/ACTA_SLA.php\", \"id_empr_acta=$ID_EMPR_ACTA&id_empresa=$id_empresa\", 600, 1000, 0, 1, 1, 1, 1);'>$NRO_ACTA</a>";
			
?> 
			<tr <?php echo $clase;?>>
				<td align='center'><?php echo $Enlace;?></td>
				<td align='center'><?php echo $NB_LOCALIDAD;?></td>
				<td align='center'><?php echo $F_REGISTRO;?></td>
				<td align='center'><?php echo $F_ANULACION;?></td>
				<td align='center'><?php echo $F_RECEP;?></td>
				<td align='center'><?php echo $NB_ABG_RECEP;?></td>
				<td align='center'><?php echo $F_APROB;?></td>
				<td align='center'><?php echo $NB_ABG_APROB;?></td>
				<td align='center'><?php echo $ESTATUS;?></td>
			  </tr>
<?php
		}
		}
		else
		{
			echo $sql;
		}
	
		echo $res;  
    ?> 
    
    </table> 
<?php
		break;
	
	}
	
	$conector->Cerrar();
?>
