<?php
	$currencies = array('bitcoin', 'ethereum', 'omisego');
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
		$results = json_decode(curl_multi_getcontent($curl_arr[$i]),false);
	}
	print_r($results);

	//get response of request
	/*
	$data = curl_exec($ch);

	$errors = curl_error($ch);
	$response = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	//close curl request
	curl_close($ch);
	//var_dump($errors);
	var_dump($response);
	$values = json_decode($data, true);
	print_r($values);

	foreach($values as $coin){
		//check if name is equal to item requested in a list
		echo $coin['name'] . " price: " . $coin['price_usd'] . " |||| Change in 24hr: " . $coin['percent_change_24h'] . "%\n";
	}*//*
	echo "Bitcoin price: " . $values[0]['price_usd'] . "\n";
	echo "Change in 24hr: " . $values[0]['percent_change_24h'] . "\n";
*/

	/* Messaging GroupMe Part
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.groupme.com/v3/bots/post");
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query(array('bot_id'=>'52f7968f3fa35936ef8c8be25d','text'=>'Bitcoin price: ' . $values[0]['price_usd'])));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$server_reply = curl_exec($ch);

	curl_close($ch);

	if($server_reply=="OK"){
		echo 'Good response';
	}
	else{
		echo 'Error';
	}*/


/*
option 1: write request for each specified currency
option 2: request for n currencies, iterate and find match
*/
?>
