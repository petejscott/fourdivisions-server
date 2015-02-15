<?php 

class JSONResult extends ActionResult
{
	public function GetContent()
	{
		return json_encode($this->content);
	}
	public function GetErrors()
	{
		return json_encode($this->errors);
	}
}

?>