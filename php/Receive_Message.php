<?php
namespace Ozeki_PHP_Rest
{
require 'MessageApi/MessageApi.php';

		$configuration = new Configuration();
		
		$configuration -> Username = "http_user";
		$configuration -> Password = "qwe123";
		$configuration -> ApiUrl = "http://192.168.0.113:9509/api";
					
		$api = new MessageApi($configuration);
		
		$result = $api -> DownloadIncoming();	
			
		echo "Folder: " . $result -> Folder;
		echo "<br>";
		
		echo "Limit: " . $result -> Limit;
		echo "<br>";
		
		echo strval($result);
		echo "<br>";
		
		echo "Messages:";
		echo "<br>";
		
		foreach($result->Messages as $msg)
			{
				echo "From: ". $msg->FromAddress . " Text: " . $msg->Text;
				echo "<br>";				
			}
}		
?>