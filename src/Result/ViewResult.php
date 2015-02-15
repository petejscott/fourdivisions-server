<?php 

class ViewResult extends ActionResult
{
	private $viewPath = "/var/www/sites/fourdivisions-server/src/Views/";
	
	public function Render()
	{
		include $this->viewPath . $this->view . ".php";
	}
	
	public function __construct($view, $content, $responseCode = 200)
	{
		if ($view === null || empty($view)) throw new InvalidArgumentException('Null or empty $view');
		$this->view = $view;
		parent::__construct($content, $responseCode);
	}
}

?>