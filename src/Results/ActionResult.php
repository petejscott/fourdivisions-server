<?php 

abstract class ActionResult
{
	protected $responseCode = 200;
	protected $model = null;
	
	public function GetResponseCode()
	{
		return $this->responseCode;
	}
	public function GetModel()
	{
		return $this->model;
	}
	
	public function Render()
	{
		return $this->GetModel();
	}
	
	public function __construct(Model $model, $responseCode = 200)
	{
		$this->model = $model;
		$this->responseCode = $responseCode;
	}
}

?>