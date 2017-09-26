<?php
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.coinmarketcap.com/v1/ticker/?limit=10");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

	$data = curl_exec($ch);

	$values = json_decode($data, true);
	print_r($values);



?>
