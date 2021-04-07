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
		$SENTENCIA_SQL=odbc_result($result,'SENTENCIA_SQL');
?> 
				<option value="">SELECCIONE...</option>
<?php 
		
		if($result=$conector->Ejecutar($SENTENCIA_SQL))
		{
			while($fila = odbc_fetch_row($result))
			{
				$ID=odbc_result($result,1);
				$VALOR=odbc_result($result,2);
?> 
				<option value="<?php echo $ID;?>"><?php echo $VALOR;?></option>
<?php 
			}
		}
		else
		{
			echo $vSQL;
		}
	}
	else
	{
		echo $vSQL;
	}
?>