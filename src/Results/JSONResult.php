<?php 

class JSONResult extends ActionResult implements IPrintableResult
{
	public function Render()
	{
		return json_encode($this->GetModel());
	}
}

?>