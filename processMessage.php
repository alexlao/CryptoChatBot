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
				if(addCurrency($demand[1])==1){
					getAllPrices();
				}
			}
			else if($demand[0] === '!clear'){
				if(clearList()==1){
					sendMessage("List of currencies cleared.");
				}
				else{
					sendMessage("No list of currencies.");
				}
			}
			else if($demand[0] === '!remove'){
				removeCurrency($demand[1]);
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
