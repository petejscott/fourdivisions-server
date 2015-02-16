<?php 

class JSONResult extends ActionResult
{
	public function Render()
	{
		return json_encode($this->GetModel());
	}
}

?>