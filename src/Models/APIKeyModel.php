<?php 

class APIKeyModel extends Model
{
	public $APIKey;
	public $Created;
	
	public function __construct($apiKey)
	{
		$this->APIKey = $apiKey;
		$this->Created = time();
	}
}

?>