<?php

require_once('IStorage.php');

class FileStorage implements IStorage
{
	private $path = '/var/www/sites/4d/src/Data/';
	
	public function GetUniqueId($prefix)
	{
		return uniqid ($prefix, true);
	}
	public function GetData($identifier) 
	{
		$filename = $this->getFilename($identifier);
		if (!file_exists($filename)) 
		{
			return null;
		}
		return file_get_contents($filename);
	}
	public function SetData($identifier, $data)
	{
		$filename = $this->getFilename($identifier);	
		return file_put_contents($filename, $data, LOCK_EX);
	}
	public function DeleteData($identifier)
	{
		$filename = $this->getFilename($identifier);	
		return unlink($filename);
	}
	
	private function getFilename($identifier)
	{
		$id = $this->stripInvalid($identifier);
		return $this->path.$id;
	}
	private function stripInvalid($identifier)
	{
		return preg_replace("/[^a-zA-Z0-9\.]/", "", $identifier);
	}
}

?>