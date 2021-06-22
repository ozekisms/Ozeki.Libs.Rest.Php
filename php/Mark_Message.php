<?php
namespace Ozeki_PHP_Rest
{
require 'MessageApi/MessageApi.php';

	$configuration = new Configuration();
		
	$configuration -> Username = "http_user";
	$configuration -> Password = "qwe123";
	$configuration -> ApiUrl = "http://192.168.0.113:9509/api";
				
	$api = new MessageApi($configuration);

	$msg = new Message();
	
	$msg -> ID = "48dcf5b2-9640-40e7-98fb-4fe6e0b4242d";
	
	$result = $api -> MarkSingle($msg);			
	
	echo strval($result);	
}		
?>