<?php

interface IStorage 
{
	public function GetUniqueIdFactory();
	public function GetData($identifier);
	public function SetData($identifier, $data);
	public function DeleteData($identifier);
}

?>