<?php 

class GameModel extends Model
{
	public $Id;
	public $Plys = [];
	
	public function __construct($id, $plys)
	{
		$this->Id = $id;
		$this->Plys = $plys;
	}
}

?>