<?php 

class JSONResult extends ActionResult implements JsonSerializable
{

	public function Render()
	{
		return json_encode($this->GetModel());
	}
	
	public function jsonSerialize()
	{
		return [
            'model' => $this->GetModel()
        ];
	}
}

?>