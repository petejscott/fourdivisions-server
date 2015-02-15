<?php

interface IStorage 
{
	public function GetUniqueId($prefix);
	public function GetData($identifier);
	public function SetData($identifier, $data);
	public function DeleteData($identifier);
}

?>