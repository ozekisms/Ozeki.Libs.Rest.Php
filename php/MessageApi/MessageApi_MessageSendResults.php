<?php

namespace Ozeki_PHP_Rest
{
	class MessageSendResults
    {
        public int $TotalCount;
		
        public int $SuccessCount;
		
        public int $FailedCount;
		
        public $Results = array();
        
    }
 }
?>