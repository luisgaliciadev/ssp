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
?> 
		<option value="">TODOS...</option>
<?php 
		
		$NB_CAMPO=odbc_result($result,'NB_CAMPO');
		$SELECT_FLAG=odbc_result($result,'SELECT_FLAG');
		
		if($SELECT_FLAG)
		{
?> 
			<!--<option value="1"><?php echo $NB_CAMPO;?></option>
			<option value="0">NO <?php echo $NB_CAMPO;?></option>-->
            <option value="1">SI</option>
			<option value="0">NO</option>
<?php 
		}
		else
		{
			$SENTENCIA_SQL_SELECT=odbc_result($result,'SENTENCIA_SQL_SELECT');
			if($result=$conector->Ejecutar($SENTENCIA_SQL_SELECT))
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
	}
	else
	{
		echo $vSQL;
	}
?>