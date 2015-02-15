<?php 

abstract class ActionResult
{
	protected $responseCode = 200;
	protected $content = null;
	protected $errors = [];
	
	public function GetResponseCode()
	{
		return $this->responseCode;
	}
	public function GetContent()
	{
		return $this->content;
	}
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
	
	public function __construct($content, $responseCode = 200)
	{
		$this->content = $content;
		$this->responseCode = $responseCode;
	}
}

?>