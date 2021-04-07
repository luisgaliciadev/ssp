<?php
	session_start();	
	
	$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar();
	
	$SiglasSistema=$_SESSION['SiglasSistema'];
	
	date_default_timezone_set('America/Caracas');
	
	$UsuarioAD=$_POST['LOGIN'];
	
	$Arreglo["NB_USUARIO"]=$UsuarioAD;

	$vSQL="EXEC SP_SESION_VERIFICAR_USUARIO '$UsuarioAD';";	

	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');

	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$result=$ResultadoEjecutar["RESULTADO"];

	if($CONEXION=="SI" and $ERROR=="NO")
	{
		$RESULTADO=odbc_result($result,"RESULTADO");

		if($RESULTADO==-2)
		{
			$TELEFU=odbc_result($result,"TELEFU");
			$CODIGO=odbc_result($result,"CODIGO");
			
			$Arreglo["RESULTADO"]=-2;
			$Arreglo["TELEFU"]=$TELEFU;
			//$Arreglo["CODIGO"]=$CODIGO;
			
			$_SESSION[$SiglasSistema.'CODIGO']=$CODIGO;
			
			$objClienteSOAP = new SoapClient("http://200.74.217.211/sms_bolipuertos/SMS_corporativo.asmx?wsdl");
		
			$msg = "__base__ BOLIPUERTOS: El codigo para continuar su operacion es " . $CODIGO;
			
			if($TELEFU)
			{
				$Codigo=substr($TELEFU, 0, 3);
				$Numero=substr($TELEFU, 3, strlen($TELEFU));
				
				$NumerosMSJ.=$Codigo."-".$Numero.";";
			}

			$objRespuesta = $objClienteSOAP->EjecuarTransaccion(array("p_stGrupo" => "","p_stNumeros" => $NumerosMSJ, "p_stMensaje" => $msg));
		}
		else
		{
			if($RESULTADO==-3)
			{
				$Arreglo["RESULTADO"]=-3;
			}
			else
			{
				if($RESULTADO==0)
				{
					$Arreglo["RESULTADO"]=0;
				}
				else
				{
					if($RESULTADO==1)
					{
						$TELEFU=odbc_result($result,"TELEFU");
						$CODIGO=odbc_result($result,"CODIGO");
	
						$Arreglo["RESULTADO"]=1;
						$Arreglo["TELEFU"]=$TELEFU;
						//$Arreglo["CODIGO"]=$CODIGO;
						
						$_SESSION[$SiglasSistema.'CODIGO']=$CODIGO;	
						
						$objClienteSOAP = new SoapClient("http://200.74.217.211/sms_bolipuertos/SMS_corporativo.asmx?wsdl");
					
						$msg = "__base__ BOLIPUERTOS: El codigo para continuar su operacion es " . $CODIGO;
						
						if($TELEFU)
						{
							$Codigo=substr($TELEFU, 0, 3);
							$Numero=substr($TELEFU, 3, strlen($TELEFU));
							
							$NumerosMSJ.=$Codigo."-".$Numero.";";
						}
		
						$objRespuesta = $objClienteSOAP->EjecuarTransaccion(array("p_stGrupo" => "","p_stNumeros" => $NumerosMSJ, "p_stMensaje" => $msg));
					}
				}
			}
		}
	}
	else
	{			
		$Arreglo["CONEXION"]="NO";
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$ResultadoEjecutar["MSJ_ERROR"];
	}
	
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();
?>