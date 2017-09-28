<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.coinmarketcap.com/v1/ticker/?limit=10");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	$data = curl_exec($ch);
	$values = json_decode($data, true);
	print_r($values);

	$servername = "localhost";
	$username = "alexaqj1_admin";
	$pw = "Al3xL4oz!!";
	$dbname = "alexaqj1_cryptos";
	
	$connectToDB=new mysqli($servername, $username, $pw, $dbname);

	if($connectToDB->connect_error){
		die("Connection to DB failed: " . $connectToDB->connect_error);
	}
	/*	
	$table = "DROP TABLE IF EXISTS 'currencies';";
	$table .= "CREATE TABLE currencies(currencyName VARCHAR(32) PRIMARY KEY, symbol VARCHAR(16));";
	if($connectToDB->multi_query($table)===TRUE){
		echo 'created successfully';
	}	
	else{
		echo 'error ' . $connectToDB->error;
	}*/
	if(!$connectToDB->query("DROP TABLE IF EXISTS currencies")||!$connectToDB->query("CREATE TABLE currencies(currencyName VARCHAR(30),symbol VARCHAR(12))")){
		echo 'Table creation failed: (' . $connectToDB->errno . ') '. $connectToDB->error . "\n";
	}
	foreach($values as $item){
		$insertStatement = "INSERT INTO currencies(currencyName, symbol) VALUES ('" . $item['name'] . "','" . $item['symbol'] . "')"; 
		if($connectToDB->query($insertStatement)===FALSE){
			echo 'Query Error: ' . $connectToDB->error . "\n";
		}
	
		echo 'in loop ' . $insertStatement . "\n";
	}
	$connectToDB->close();

?>
