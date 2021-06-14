<?php
namespace Ozeki_PHP_Rest
{
require 'MessageApi/MessageApi.php';

		$configuration = new Configuration();
		
		$configuration -> Username = "http_user";
		$configuration -> Password = "qwe123";
		$configuration -> ApiUrl = "http://192.168.0.113:9509/api";
		
		$msg = new Message();
		
		$msg -> ToAddress = "+36201111111";
		$msg -> Text = "Hello, World!";
			
		$api = new MessageApi($configuration);
		
		$result = $api -> SendSingle($msg);	
		
		var_dump($result);
}		
?>