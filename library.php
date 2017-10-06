<?php
	function sendMessage($message){
		$chat = curl_init();
		curl_setopt($chat, CURLOPT_URL, "https://api.groupme.com/v3/bots/post");
		curl_setopt($chat, CURLOPT_POST,1);
		curl_setopt($chat, CURLOPT_POSTFIELDS,http_build_query(array('bot_id'=>'68049da0849ea1551753f26e25','text'=>$message)));
		curl_setopt($chat, CURLOPT_RETURNTRANSFER, true);

		if(curl_exec($chat)===false){
			echo 'Curl error: ' . curl_error($ch);
		}
		else{
			echo 'Good response';
			echo $message;
		}
		curl_close($chat);
	}

	function getAllPrices(){
        	$rally = "MAJOR RALLIES\n";
        	$rallyIndicator = false;
        	$fall = "MAJOR FALLS\n";
        	$fallIndicator = false;
        	$message = null;
       		$currencyFile = fopen("currencies.txt","r");
        	if($currencyFile === FALSE){
			sendMessage("No added currencies. Use !add to add currencies.");
			return;
		}
		$fileText = fread($currencyFile,filesize("currencies.txt"));
        	$currencies = explode(",",$fileText);
		var_dump($currencies);
	        $currenciesCount = count($currencies);
        	$curl_arr = array();
        	$ch = curl_multi_init();
        	$mainURL = "https://api.coinmarketcap.com/v1/ticker/";
        //setting up curl request

        	for($i=0; $i<$currenciesCount -1;$i++){
                	$url = $mainURL . $currencies[$i] . '/';
                	$curl_arr[$i] = curl_init($url);
                	curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
                	curl_multi_add_handle($ch, $curl_arr[$i]);
        	}

        	do{
                	curl_multi_exec($ch,$running);
        	} while($running>0);

        	for($i=0; $i<$currenciesCount-1;$i++){
                	$results[] = json_decode(curl_multi_getcontent($curl_arr[$i]),true);
        	}		
        	print_r($results);

        //Prints current prices for all specified currencies. Also checks for major changes in past hour.
        	foreach($results as $coin){
                	$message = $message . $coin[0]['name'] . "'s current price is " . $coin[0]['price_usd'] . '. Its %change in 24hr is ' . $coin[0]['percent_change_24h'] . "\n\n";
                	if(doubleval($coin[0]['percent_change_1h'])>7.5){
                        	$rally = $rally . $coin[0]['name'] . " is shooting up. It has gained " . $coin[0]['percent_change_1h'] . " in the past hour.\n";
                        	$rallyIndicator = true;
                	}
                	else if(doubleval($coin[0]['percent_change_1h'])<-7.5){
                        	$fall = $fall . $coin[0]['name'] . " is collapsing. It has dropped " . $coin[0]['percent_change_1h'] . " in the past hour.\n";
                        	$fallIndicator = true;
                	}
       	 	}
        	if($rallyIndicator){
                	$message = $message . $rally;
                	echo $rally . "\n";
        	}
        	if($fallIndicator){
                	$message = $message . "\n" . $fall;
                	echo $fall . "\n";
        	}
        	curl_multi_close($ch);
        	fclose($currencyFile);
        	sendMessage($message);
	}

	function getSpecific($requested){
 		$ch =  curl_init();
		$sym = verifyCurrency($requested);
		if($sym == NULL){
			sendMessage($requested." is not a currency. \n");
			return;
		}
		//setting up curl request
 		curl_setopt($ch, CURLOPT_URL, "https://api.coinmarketcap.com/v1/ticker/" . $sym . "/");
 		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 		curl_setopt($ch, CURLOPT_FOLLOWLOCATION,true);
		//get response of request
		$data = curl_exec($ch);
		$result = json_decode($data, true);

		$text = $result[0]['name'] . "'s current price is " . $result[0]['price_usd'] . '. Its %change in 24hr is ' . $result[0]['percent_change_24h'];
		sendMessage($text);
	}

	function addCurrency($requested){
		$sym = verifyCurrency($requested);
		if($sym===NULL){
			sendMessage($requested . " is not a currency. \n");
			return -1; 
		}
		if(file_put_contents("currencies.txt", $sym .',', FILE_APPEND)===FALSE){
			sendMessage("Error opening file");
			return -1;
		}
		return 1;
		/*
		else{
			getAllPrices();
		}*/
	/*	$file = fopen("currencies.txt", "a") or die("Unable to open file");
		fwrite($file, ','.$requested);
		fclose($file);*/
	}
	function clearList(){
		if(unlink("currencies.txt")===TRUE){
			return 1;
		}
		else{
			return -1;
		}
	}

	function verifyCurrency($requested){
		$servername = "localhost";
		$username = "alexaqj1_admin";
		$pw = "Al3xL4oz!!";
		$dbname = "alexaqj1_cryptos";

		$message = "SELECT currencyName FROM currencies WHERE currencyName ='" . $requested . "' OR symbol='" . $requested . "'";

		$connectToDB = new mysqli($servername, $username, $pw, $dbname);
		if($connectToDB->connect_error){
			die("Connection to db failed: " . $connectToDB->connect_error);
		}
		
		if(($queryResult=$connectToDB->query($message))===FALSE){
			echo 'Query Error: ' . $connectToDB->error . "\n";
			sendMessage($conectToDB->error);
		}
		$selectedCurrency = $queryResult->fetch_array(MYSQLI_NUM);
		if($selectedCurrency != NULL){
			$selectedCurrency = $selectedCurrency[0];
		}
		$queryResult->free();
		$connectToDB->close();
		return $selectedCurrency;
	}

	function removeCurrency($requested){
		$list = file_get_contents("./currencies.txt");
		$name = verifyCurrency($requested);
		if($name ===NULL){
			sendMessage($requested . " is not a currency. \n");
			return;
		}
		$currencies = explode(",",$list);
		$newList = NULL;
		clearList();
		foreach($currencies as $coinName){
			if($coinName==NULL){
				return;
			}
			if($coinName == $name){

			}
			else{
				addCurrency($coinName);
			}
		}

	}
?>

