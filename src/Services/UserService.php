<?php

class UserService
{
	private $storage;
	
	public function __construct(IStorage $storage)
	{		
		if ($storage === null) throw new InvalidArgumentException('Null $storage');
		$this->storage = $storage;
	}
	
	/**
	* Stores a provided User object using a random name (id) in the storage implementation.
	*/
	public function InsertUser($user)
	{
		$userId = $this->storage->GetUniqueIdFactory()->GetUniqueId('4d.user.');
		$user->Id = $userId; // set the Id on the game before saving
		$this->storage->SetData($userId, json_encode($user));
		return $userId;
	}
	
	/**
	* Stores a provided User object using the provided name (id) in the storage implementation.
	*/
	public function UpdateUser($userId, $user)
	{
		$this->storage->SetData($userId, json_encode($user));
		return $userId;
	}
	
	/**
	* Returns the User (as stdClass) associated with the user id, or null if there is no 
	* User found
	*/
	public function GetUser($userId)
	{
		$user = $this->storage->GetData($userId);
		return json_decode($user);
	}
	
	/**
	* Removes the user identified by $userId from the storage implementation
	*/
	public function DeleteUser($userId)
	{
		return $this->storage->DeleteData($userId);
	}
}

?>