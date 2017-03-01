<?php
include_once 'ip2locationlite.class.php';

class Ip2location {
    private /*ip2locationlite obj*/ $ip2locationlite;
    private /*string*/$apiKey;    
        
    public function __construct($apiKey){
    	$this->ip2locationlite = new ip2location_lite;
    	$this->ip2locationlite->setKey($apiKey[0]);
    }
	public function getCity(){
		$return["locations"] = $this->ip2locationlite->getCity($_SERVER['REMOTE_ADDR']);
		$return["errors"] = $this->ip2locationlite->getError();
		
		return $return;
	}
  	 
}	
?>