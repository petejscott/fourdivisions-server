<?php 

class JSONResult extends ActionResult implements JsonSerializable
{

	public function Render()
	{
		return json_encode($this);
	}
	
	public function jsonSerialize()
	{
		return [
            'content' => $this->GetContent(),
            'errors' => $this->GetErrors()
        ];
	}
}

?>