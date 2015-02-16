<?php 

abstract class Model implements JsonSerializable
{
	protected $errors = [];
	public function GetErrors()
	{
		return $this->errors;
	}	
	public function AddError($err)
	{
		if (is_array($err))
		{
			$this->errors = array_merge($this->errors, $err);
		}
		else
		{
			$this->errors[] = $err; 
		}
	}
	
	public function jsonSerialize()
	{
		$out = array();
		foreach($this as $key => $value) 
		{
			$out[$key] = $value;
		}
		return $out;
	}
}

?>