<?php 

class RedirectResult extends ActionResult
{	
	private $url = null;
	
	public function Render()
	{
		//TODO: if $model !== null, should we pass the model's public properties as GET params 
		// to the URL? Not sure what a sensible approach is here, so for now we'll just ignore it. =]
		header("Location: ". $this->url);
		exit;
	}
	
	public function __construct($url, $model, $responseCode = 302)
	{
		if ($url === null || empty($url)) throw new InvalidArgumentException('Null or empty $url');
		$this->url = $url;
		parent::__construct($model, $responseCode);
	}
}

?>