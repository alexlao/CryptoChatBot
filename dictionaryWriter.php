<?php
	//Script that is programmed to run weekly with cron. Will update dictionary that is used to validate currencies requested by users with the top coins.

	//Creates and executes curl request to get info on the top 120 coins. 
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.coinmarketcap.com/v1/ticker/?limit=120");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	$data = curl_exec($ch);
	$values = json_decode($data, true);
	print_r($values);

	//Initialize a connection to the MySQL server.
	$servername = "localhost";
	$username = "alexaqj1_admin";
	$pw = "";
	$dbname = "alexaqj1_cryptos";
	
	$connectToDB=new mysqli($servername, $username, $pw, $dbname);

	if($connectToDB->connect_error){
		die("Connection to DB failed: " . $connectToDB->connect_error);
	}
	
	//Everytime this script is run, drop the current table and simply create a new one.
	//This is necessary because some of the past top 120 currencies may no longer be in such a position.
	if(!$connectToDB->query("DROP TABLE IF EXISTS currencies")||!$connectToDB->query("CREATE TABLE currencies(currencyName VARCHAR(30),symbol VARCHAR(12))")){
		echo 'Table creation failed: (' . $connectToDB->errno . ') '. $connectToDB->error . "\n";
	}

	//Add every item to the database. Prepared statements are unnecessary because symbol and currency name will not have such symbols.
	foreach($values as $item){
		$insertStatement = "INSERT INTO currencies(currencyName, symbol) VALUES ('" . $item['name'] . "','" . $item['symbol'] . "')"; 
		if($connectToDB->query($insertStatement)===FALSE){
			echo 'Query Error: ' . $connectToDB->error . "\n";
		}
	
		echo 'in loop ' . $insertStatement . "\n";
	}
	//Terminate initalized connections.
	$connectToDB->close();
	curl_close($ch);
?>
