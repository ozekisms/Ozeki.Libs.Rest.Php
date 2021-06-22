<?php

namespace Ozeki_PHP_Rest
{	
	class MessageMarkResult
    {
		public $Folder;
        public $MessageIdsMarkSucceeded = array();
        public $MessageIdsMarkFailed = array();

        function SuccessCount()
		{			
			return (count($this -> $MessageIdsMarkSucceeded));
		}
		
		function FailedCount()
		{			
			return (count($this -> $MessageIdsMarkFailed));
		}
		
		function TotalCount()
		{			
			return ($this -> SuccessCount() + $this -> FailedCount());
		}
		
		public function __toString()
		{
            return "Total: " . $this -> TotalCount . ". Success: " . $this -> SuccessCount . ". Failed: " . $this -> FailedCount . ".";
        }
	}
}
?>