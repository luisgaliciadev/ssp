<?php session_start();

	/** Validate captcha */
	
	if(!empty($_POST['TxtCaptcha'])) 
	{
		if(empty($_SESSION['captcha']) || trim(strtolower($_POST['TxtCaptcha'])) != $_SESSION['captcha']) 
		{
			echo 0;
		} 
		else 
		{
			echo 1;		
		}
	}
?>