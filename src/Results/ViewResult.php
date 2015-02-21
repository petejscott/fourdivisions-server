<?php 

class ViewResult extends ActionResult implements IPrintableResult
{
	private $viewPath = "/var/www/sites/fourdivisions-server/src/Views/";
	
	public function Render()
	{
		include $this->viewPath . $this->view . ".php";
	}
	
	public function __construct($view, $model, $responseCode = 200)
	{
		if ($view === null || empty($view)) throw new InvalidArgumentException('Null or empty $view');
		$this->view = $view;
		parent::__construct($model, $responseCode);
	}
}

?>