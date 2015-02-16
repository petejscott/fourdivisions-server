<?php

class APIService
{
	private $storage;
	
	public function __construct(IStorage $storage)
	{
		if ($storage === null) throw new InvalidArgumentException('Null $storage');
		$this->storage = $storage;
	}
	
	/**
	* Stores an API Key and an associated User ID in the storage implementation.
	*/
	public function CreateAPIKey($userId)
	{
		$key = $this->storage->GetUniqueId('4d.apikey.');
		$this->storage->SetData($key, $userId);
		return $key;
	}
	
	/**
	* Returns the User ID associated with the API Key, or null if there is no 
	* User ID associated with the key (thus, null represents an invalid key)
	*/
	public function ValidateAPIKey($key)
	{
		return $this->storage->GetData($key);
	}
	
	/**
	* Removes the data specified by $key from the storage implementation
	*/
	public function RevokeAPIKey($key)
	{
		return $this->storage->DeleteData($key);
	}
}

?>