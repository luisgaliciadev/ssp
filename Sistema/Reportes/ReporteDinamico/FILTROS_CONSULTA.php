<?php
	$Nivel="../../../";	
	include($Nivel."includes/funciones.php");
	
	$conector=Conectar();
	
	session_start();
	
	$ID_ROL = $_SESSION[$SiglasSistema."ID_ROL"];
	$ID_USUARIO=$_SESSION[$SiglasSistema.'ID_USUARIO'];
	
	$IdVentana=$_GET['IdVentana'];
	$IdVentanaP=$_GET['IdVentanaP'];	
	$ID_REP_DIN_CAMPOS=$_GET['ID_REP_DIN_CAMPOS'];
	
	$vSQL="SELECT 
				*
			FROM            
				TB_REP_DIN_CAMPOS
			WHERE        
				(ID_REP_DIN_CAMPOS = $ID_REP_DIN_CAMPOS)";
	
	if($result=$conector->Ejecutar($vSQL))
	{	
		while($fila = odbc_fetch_row($result))
		{
			$Arreglo["ID_REP_DIN_CAMPOS"]=odbc_result($result,"ID_REP_DIN_CAMPOS");
			$Arreglo["NB_CAMPO"]=odbc_result($result,"NB_CAMPO");
			$Arreglo["NB_CAMPO_SQL"]=odbc_result($result,"NB_CAMPO_SQL");
			$Arreglo["TIPO_CAMPO_HTML"]=odbc_result($result,"TIPO_CAMPO_HTML");
			$Arreglo["ID_CAMPO_SELECT"]=odbc_result($result,"ID_CAMPO_SELECT");
			$Arreglo["SELECT_FLAG"]=odbc_result($result,"SELECT_FLAG");
		}
		
		echo json_encode($Arreglo);
		$conector->Cerrar();
		exit;
	}
	else
	{
		$Arreglo["Error"]=1;
		echo $vSQL;
	}
?>