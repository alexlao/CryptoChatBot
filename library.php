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

?>

