<?php
	//Variables to detect major changes
	include 'library.php';
/*	$rally = "MAJOR RALLIES\n";
	$rallyIndicator = false;
	$fall = "MAJOR FALLS\n";
	$fallIndicator = false;
	$message = null;
	$currencyFile = fopen("currencies.txt","r") or die("Unable to open file");
	$fileText = fread($currencyFile,filesize("currencies.txt"));
	$currencies = explode(",",$fileText);

	$currenciesCount = count($currencies);
	$curl_arr = array();
	$ch = curl_multi_init();
	$mainURL = "https://api.coinmarketcap.com/v1/ticker/";
	//setting up curl request

	for($i=0; $i<$currenciesCount;$i++){
		$url = $mainURL . $currencies[$i] . '/';
		$curl_arr[$i] = curl_init($url);
		curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
		curl_multi_add_handle($ch, $curl_arr[$i]);		
	}

	do{
		curl_multi_exec($ch,$running);
	} while($running>0);

	for($i=0; $i<$currenciesCount;$i++){
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
	sendMessage($message);*/
	getAllPrices();

/*
option 1: write request for each specified currency
option 2: request for n currencies, iterate and find match

Add currencies: use file storing names and then use delimeter
*/
?>
