<?php
$Nivel="../../";
	include($Nivel."includes/PHP/funciones.php");
	
	$Conector=Conectar3();
	//$Conector2 = Conectar3();
	
	//$Conector_hosting=Conectar();

	
	session_start();	

     $RIF=$_SESSION[$_SESSION['SiglasSistema'].'RIF'];
//	 $ID_LOCALIDAD=$_SESSION[$SiglasSistema."ID_LOCALIDAD"];

	$consulta = $_POST["consulta"];
/////////////Para primera consulta////////////////////////
	$cedula1 = $_POST["cedula"];
	$id_solic_muelle1 = $_POST["id_solic_muelle"];	
/////////////Para segunda consulta////////////////////////	
	$id_localidad1 = $_POST["id_localidad"];
	$operador1 = $_POST["operador"];	

    if ($consulta==1)
 {	
 	$operador = $_POST["operador"];		
	$categoria = $_POST["categoria"];		
	 $ID_LOCALIDAD=$_SESSION[$_SESSION['SiglasSistema']."ID_LOCALIDAD"];
	 //$vSQL="SELECT CI_EMPLEADO, NB_EMPLEADO, CARGO FROM dbo.EMPLEADO_SM WHERE (CI_EMPLEADO = '$cedula1') AND (ID_SOL_SM = $id_solic_muelle1)";
	$vsql1 = "SELECT 1 AS EXISTE FROM EMPLEADO_SM WHERE ID_SOL_SM =$id_solic_muelle1 AND CI_EMPLEADO = '$cedula1' and fg_act_emp = 1"; 
	$ResultadoEjecutar=$Conector->Ejecutar($vsql1, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];
	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin2=$ResultadoEjecutar["RESULTADO"];
	
	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		if (1)
        {		
			$existe = odbc_result($resultPrin2,"EXISTE");
			if ($existe == ''){
				
				 $vSQL="EXEC [web].[SP_EMPLEADOS_OPERATIVOS] $ID_LOCALIDAD, '$operador','$cedula1',$categoria";
				$ResultadoEjecutar=$Conector2->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
				
				$CONEXION=$ResultadoEjecutar["CONEXION"];
			
				$ERROR=$ResultadoEjecutar["ERROR"];
				$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
				$resultPrin=$ResultadoEjecutar["RESULTADO"];
				//$Arreglo["CONSULTA"] = $vSQL;
				//$Arreglo["COMBO"] = '<option value="">Seleccione...</option>';
			   
				if($CONEXION=="SI" and $ERROR=="NO")
				{		
					if (odbc_fetch_array($resultPrin))
					{		
						//$Arreglo["CI_EMPLEADO"]	=odbc_result($resultPrin,"NOMBRE");
						$Arreglo["NB_EMPLEADO"]	=odbc_result($resultPrin,"NOMBRE");
						$Arreglo["CARGO"]	=odbc_result($resultPrin,"NB_CARGO");
						$Arreglo["CONEXION"]=$CONEXION;
						$Arreglo["ERROR"]=$ERROR;
						$Arreglo["EXISTE"]="NO";
				
						
					} 
					
					else 
					
					  {		
						$Arreglo["CONEXION"]=$CONEXION;
						$Arreglo["ERROR"]=$ERROR;
						$Arreglo["EXISTE"]="SI";
			
						
					} 
					
					
				}
				else
				{
					$Arreglo["CONEXION"]=$CONEXION;
					$Arreglo["ERROR"]=$ERROR;
					$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
					$Arreglo["HOLA"]=$vSQL;
				}
			
			
			
			
			//////////////////////////
			
			}else{
				
				$Arreglo["CONEXION"]=$CONEXION;
				$Arreglo["ERROR"]=$ERROR;
				$Arreglo["EXISTE"]="SI";
			
			}
			
			
		} 
		
		else 
		
		  {		
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["EXISTE"]="NO";

			
		} 
		
		
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;
		$Arreglo["HOLA"]=$vSQL;
	}
	
	
	
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();

}





if ($consulta==2)
 {	
    $vSQL="exec web.[SP_LISTADO_OPERADORES_SM] $id_localidad1, '$operador1', '$cedula1'";
	
	$ResultadoEjecutar=$Conector_hosting->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	//$Arreglo["CONSULTA"] = $vSQL;
	//$Arreglo["COMBO"] = '<option value="">Seleccione...</option>';

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
		if (odbc_fetch_array($resultPrin))
        {		
			$Arreglo["NOMBRE"]	=odbc_result($resultPrin,"NOMBRE");
			$Arreglo["CARGO"]	=odbc_result($resultPrin,"NB_CARGO");
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["EXISTE"]="SI";

			
		} 
		
		else 
		
		  {		
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["EXISTE"]="NO";

			
		} 
		
		
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;

	}
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();

}

if ($consulta==3)
 {	
 	$rif_operador = $_POST["operador"];
    $vSQL="exec [web].[SP_LISTADO_CATEG_OPERADORES_SM] '$rif_operador', $id_solic_muelle1";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	//$Arreglo["CONSULTA"] = $vSQL;
	//$Arreglo["COMBO"] = '<option value="">Seleccione...</option>';

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
				
			$resultado = '<option value="">Seleccione...</option>';
			while (odbc_fetch_array($resultPrin)) {
			
				 $ID_CATEGORIA = odbc_result($resultPrin,"ID_CATEGORIA");
				 $NB_CATEGORIA = odbc_result($resultPrin,"NB_CATEGORIA");
				 $resultado .= "<option value=".$ID_CATEGORIA.">$NB_CATEGORIA </option>";
			}
			$Arreglo["RESULTADOS"]	=$resultado;
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["EXISTE"]="SI";
	
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;

	}
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();

}
	

if ($consulta==4)
 {	
 	$ID_RELACION_EVENTO = $_POST["ID"];
    $vSQL="update RELACION_EVENTOS_SASPWEB set FG_ACTIVO = 0 where ID_RELACION_EVENTO = $ID_RELACION_EVENTO";
	
	$ResultadoEjecutar=$Conector->Ejecutar($vSQL, $INSERT_MAYUSCULA="SI", $SP_BITACORA='NO', $SP_ACCION='', $SP_NB_TABLA='', $SP_VALOR_CAMPO_ID='');
	
	$CONEXION=$ResultadoEjecutar["CONEXION"];

	$ERROR=$ResultadoEjecutar["ERROR"];
	$MSJ_ERROR=$ResultadoEjecutar["MSJ_ERROR"];
	$resultPrin=$ResultadoEjecutar["RESULTADO"];
	//$Arreglo["CONSULTA"] = $vSQL;
	//$Arreglo["COMBO"] = '<option value="">Seleccione...</option>';

	if($CONEXION=="SI" and $ERROR=="NO")
	{		
				
			$Arreglo["RESULTADOS"]	='ELIMINADO';
			$Arreglo["CONEXION"]=$CONEXION;
			$Arreglo["ERROR"]=$ERROR;
			$Arreglo["EXISTE"]="SI";
	
	}
	else
	{
		$Arreglo["CONEXION"]=$CONEXION;
		$Arreglo["ERROR"]=$ERROR;
		$Arreglo["MSJ_ERROR"]=$MSJ_ERROR;

	}
		
	echo json_encode($Arreglo);
	
	$Conector->Cerrar();

}

?>