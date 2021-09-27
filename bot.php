<?php
error_reporting(0);
set_time_limit(0);
ob_start();
$admin = "ADMIN_USER_ID";
define('API_KEY', "BOT_ACCESS_TOKEN");
function iNeoTeamBot($method, $parameters = []){
	$api = "https://api.ineo-team.ir/_telegram.php";
	$cURL = curl_init();
	curl_setopt($cURL, CURLOPT_URL, $api."?token=".API_KEY."&method=".$method);
	curl_setopt($cURL, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($cURL, CURLOPT_POSTFIELDS, $parameters);
	curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
	return json_decode(curl_exec($cURL));
}

$recevie	= file_get_contents("php://input");
$update		= json_decode($recevie);
$message_id	= $update->message->message_id;
$text		= $update->message->text;
$chat_id	= $update->message->chat->id;
$first_name	= $update->message->chat->first_name;
$username	= iNeoTeamBot('getMe')->result->username;

if(!is_dir("data")){ mkdir("data"); }
if(!is_dir("data/$chat_id")){ mkdir("data/$chat_id"); }

if($text == "/start"){
	$GET = iNeoTeamBot('sendMessage', [
		'chat_id' => $chat_id,
		'text' => "Hello world !\n\n@".$username,
		'reply_to_message_id' => $message_id
	]);
}else{
	$GET = iNeoTeamBot('sendMessage', [
		'chat_id' => $chat_id,
		'text' => "<code>".$recevie."</code>",
		'parse_mode' => "HTML"
	]);
}
?>
