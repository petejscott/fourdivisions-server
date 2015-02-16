<?php 

abstract class Model
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
}

?>