<?php

namespace Ozeki_PHP_Rest
{	
	class MessageDeleteResult
    {
		public $Folder;
        public $MessageIdsRemoveSucceeded = array();
        public $MessageIdsRemoveFailed = array();

		function SuccessCount()
		{			
			return (count($this -> $MessageIdsRemoveSucceeded));
		}
		
		function FailedCount()
		{			
			return (count($this -> $MessageIdsRemoveFailed));
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