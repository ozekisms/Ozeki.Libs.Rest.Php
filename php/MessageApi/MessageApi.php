<?php

namespace Ozeki_PHP_Rest
{
require 'Configuration.php';
require 'Message.php';
require 'MessageApi_MessageSendResult.php';
require 'MessageApi_MessageSendResults.php';
	
	class MessageApi	
	{
		public Configuration $configuration;
		
		//**********************************************
		// Construction
		//**********************************************
		function __construct($configuration)
		{
			$this -> configuration = $configuration;
		}	
		
		//**********************************************
        // Message properties
        //**********************************************		
		
        //Id
		const PROP_NAME_MESSAGE_ID = "message_id";        
        //From
		const PROP_NAME_FROM_CONNECTION = "from_connection";
		const PROP_NAME_FROM_ADDRESS = "from_address";
		const PROP_NAME_FROM_STATION = "from_station";
        //To
		const PROP_NAME_TO_CONNECTION = "to_connection";
		const PROP_NAME_TO_ADDRESS = "to_address";
		const PROP_NAME_TO_STATION = "to_station";
        //Text
		const PROP_NAME_TEXT = "text";
        //Dates
		const PROP_NAME_CREATE_DATE = "create_date";
		const PROP_NAME_VALID_UNTIL = "valid_until";
		const PROP_NAME_TIME_TO_SEND = "time_to_send";
        //Reports
		const PROP_NAME_SUBMIT_REPORT_REQUESTED = "submit_report_requested";
		const PROP_NAME_DELIVERY_REPORT_REQUESTED = "delivery_report_requested";
		const PROP_NAME_VIEW_REPORT_REQUESTED = "view_report_requested";		
        //Tags
		const PROP_NAME_TAGS = "tags";

        //**********************************************
        // Folder
        //**********************************************
		
		const FOLDER_INBOX = "inbox";
		const FOLDER_OUTBOX = "outbox";
		const FOLDER_SENT = "sent";
		const FOLDER_NOT_SENT = "notsent";
		const FOLDER_DELETED = "deleted";
		
		function getUrl_SendMessage()
		{
			$apiUrl = rtrim($this -> configuration -> ApiUrl,'?');
			return $apiUrl . "?action=sendmsg";
		}
		
		function GetTagsAsArray($tags){
			$tagArray = [];
			foreach($tags as $key => $value){
				array_push($tagArray, array(
					'name' => strval($key),
					'value' => strval($value),
				));
			}
			return $tagArray;
		}
		
		function GetMessageAsArray($message){	
			return array(
				'id' => $message -> ID,
				'from_connection' => $message -> FromConnection,
				'from_address' => $message -> FromAddress,
				'from_station' => $message -> FromStation,
				'to_connection' => $message -> ToConnection,
				'to_address' => $message -> ToAddress,
				'to_station' => $message -> ToStation,
				'text' => $message -> Text,
				'create_date' => $message -> CreateDate,
				'valid_until' => $message -> ValidUntil,
				'time_to_send' => $message -> TimeToSend,
				'submit_report_requested' => $message -> IsSubmitReportRequested,
				'delivery_report_requested' => $message -> IsDeliveryReportRequested,
				'view_report_requested' => $message -> IsViewReportRequested,
				'tags' => $this -> GetTagsAsArray($message -> GetTags()),
			);
		}
		
		function CreateRequestBody_SendMessage($messages)			
		{
			$messageArray = [];
			foreach($messages as $key => $value){
				array_push($messageArray, $this -> GetMessageAsArray($value));
			}
			
			$ret = json_encode(['messages' => $messageArray]);
			return $ret;
		}		
		
		
		function DoRequestPost($url, $contentType, $requestBody, $username , $password)
		{													
			$ch = curl_init();
			curl_setopt($ch,CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type'. ':' .$contentType));
			curl_setopt($ch, CURLOPT_USERPWD, $username. ":" .$password);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch,CURLOPT_POSTFIELDS, $requestBody);
			$result = curl_exec($ch);
			curl_close($ch);			
			return ($result);
		}	
		
		function getVal($message, $property){
			if(property_exists($message, $property))
			    return $message -> $property;
		     return null;
		}
		
		function ParseMessage($responseMsg){
			$msg = new Message();
			$msg-> ID = $this -> getVal($responseMsg, 'message_id');
			$msg-> FromConnection = $this -> getVal($responseMsg, 'from_connection');
			$msg-> FromAddress = $this -> getVal($responseMsg, 'from_address');
			$msg-> FromStation = $this -> getVal($responseMsg, 'from_station');
			$msg-> ToConnection = $this -> getVal($responseMsg, 'to_connection');
			$msg-> ToAddress = $this -> getVal($responseMsg, 'to_address');
			$msg-> ToStation = $this -> getVal($responseMsg, 'to_station');
			$msg-> Text = $this -> getVal($responseMsg, 'text');
			$msg-> CreateDate = $this -> getVal($responseMsg, 'create_date');
			$msg-> ValidUntil = $this -> getVal($responseMsg, 'valid_until');
			$msg-> TimeToSend = $this -> getVal($responseMsg, 'time_to_send'); 
			$msg-> IsSubmitReportRequested = $this -> getVal($responseMsg, 'submit_report_requested');
			$msg-> IsDeliveryReportRequested = $this -> getVal($responseMsg, 'delivery_report_requested'); 
			$msg-> IsViewReportRequested = $this -> getVal($responseMsg, 'view_report_requested');
			foreach($responseMsg->tags as $tagIndex => $tagData){
				$msg->AddTag($tagData->name, $tagData->value);
			}
			return $msg;
		}
		
		function ParseSendMessageResult($responseMsg){
			$msgResult = new MessageSendResult();
			$msgResult->Message = $this -> ParseMessage($responseMsg);
			$msgResult->Status = $responseMsg->status;
			return $msgResult;
		}
		
		function ParseSendMessageResults ($jsonResponse)
		{
			$response = json_decode($jsonResponse);
			if($response->response_code != 'SUCCESS')
				return null;
			
			$messageResults = [];
			$messages = $response->data->messages;
			foreach($messages as $key => $value)
			{
				$msgResult = $this -> ParseSendMessageResult($value);
				array_push($messageResults, $msgResult);
			}
			
			$results = new MessageSendResults();			
			$results->TotalCount = $response->data->total_count;
			$results->SuccessCount = $response->data->success_count;
			$results->FailedCount = $response->data->failed_count;
			$results->Results = $messageResults;
			
			return($results);
		}		
				
		function Send($messages)		
        {	
			$Username =  $this -> configuration -> Username;
			$Password =  $this -> configuration -> Password;
			
            $requestBody = $this -> CreateRequestBody_SendMessage($messages);
            $jsonResponse = $this -> DoRequestPost($this->getUrl_SendMessage(), "application/json", $requestBody, $Username, $Password);
			$results = $this -> ParseSendMessageResults($jsonResponse);
			return $results;			
        }
		
		function SendSingle($message)
		{
			$results = $this -> Send(array($message));			
			return $results;
		}
			
	}	
}

?>