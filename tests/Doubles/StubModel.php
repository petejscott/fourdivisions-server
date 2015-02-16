<?php 

class StubModel extends Model
{
	public $StringData;
	public function __construct($stringData)
	{
		$this->StringData = $stringData;
	}
}

?>