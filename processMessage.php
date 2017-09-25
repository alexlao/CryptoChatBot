<?php

	if($_SERVER['REQUEST_METHOD']==='POST'){
		$message = $_POST['text'];
		$demand = explode(' ', $message);
		if($demand[0][0]==='!'){
			//it is some type of demand
			
		}
		else{
			//ignore, it is not a type of demand
			return;
		}
	}

?>
