<?php

namespace Ozeki_PHP_Rest;
{
	class Message
    {
        //**********************************************
        // Id
        //**********************************************
        		
		public ?string $ID = null;
		
        //**********************************************
        // From
        //**********************************************

        public ?string $FromConnection = null;
				
        public ?string $FromAddress = null;
					
		public ?string $FromStation = null;
		
        //**********************************************
        // To
        //**********************************************

		public ?string $ToConnection = null;
		
		public ?string $ToAddress = null;
		
		public ?string $ToStation = null;
		
        //**********************************************
        // Text
        //**********************************************

		public ?string $Text = null;
		
        //**********************************************
        // Dates
        //**********************************************

		public ?string $CreateDate = null;
		
		public ?string $ValidUntil = null;
		
		public ?string $TimeToSend = null;
		
        //**********************************************
        //* Reports
        //**********************************************

		public ?bool $IsSubmitReportRequested = null;
		
		public ?bool $IsDeliveryReportRequested = null;
		
		public ?bool $IsViewReportRequested = null;
				
		public ?array $tags = array();
		
        public function AddTag($key, $value)
        {            
           $this -> tags[strval($key)] = strval($value);           
        }		
		
		public function GetTags() {
			return $this->tags;
		}
		

        //**********************************************
        // Construction
        //**********************************************
		
		function genguid($data = null) 
		{
			// Generate 16 bytes (128 bits) of random data or use the data passed into the function.
			$data = $data ?? random_bytes(16);
			assert(strlen($data) == 16);

			// Set version to 0100
			$data[6] = chr(ord($data[6]) & 0x0f | 0x40);
			// Set bits 6-7 to 10
			$data[8] = chr(ord($data[8]) & 0x3f | 0x80);

			// Output the 36 character UUID.
			return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
		}

        function __construct()
        {	
            $this -> ID = $this -> genguid();
			
            $this -> CreateDate = date("Y-m-d H:i:s");
            $this -> TimeToSend = date("Y-m-d H:i:s");
			
			$date = strtotime("+7 day");
            $this -> ValidUntil = date("Y-m-d H:i:s", $date);
			
            $this -> IsSubmitReportRequested = true;
            $this -> IsDeliveryReportRequested = true;
            $this -> IsViewReportRequested = true;			
        }
	}	
}
?>