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
	
	$msg -> ID = "c2ca9c94-6c43-4907-a66a-a7d8caa75bdf";
	
	$result = $api -> DeleteSingle($msg);			
		
	echo strval($result);
	
}		
?>