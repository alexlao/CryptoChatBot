<?php
	include 'library.php';
	if($_SERVER['REQUEST_METHOD']==='POST'){
		$post = json_decode(file_get_contents('php://input'),true);
		if($post['name']==='Crypto Price'){
			return;
		}
		$message = $post['text'];
		/*echo 'Message is: ' . $message;
		sendMessage($message);*/
		$demand = explode(' ', $message);
		echo $demand[0];
		if($demand[0][0]==='!'){
			if($demand[0]==='!prices'){
				getAllPrices();
			}
			else if($demand[0] === '!giveme'){
				getSpecific($demand[1]);
			}
			else if($demand[0] === '!add'){
				addCurrency($demand[1]);
			}
			else if($demand[0] === '!clear'){
				clearList();
			}
			//sendMessage('Command is: ' . $demand[0]);
			//it is some type of demand
			//sendMessage($message);
		}
		else{
			//ignore, it is not a type of demand
			return;
		}
	}
	//sendMessage("hi");
	echo 'hi';
?>
