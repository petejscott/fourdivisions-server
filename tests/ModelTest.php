<?php

require_once 'Doubles/StubModel.php';

class ModelTest extends PHPUnit_Framework_TestCase
{
	public function testModelErrors()
	{
		$model = new StubModel("foo");
		$model->AddError("Error 1");
		$model->AddError(array("Error 2", "Error 3"));
		$this->assertEquals(3, count($model->GetErrors()));		
	}
}

?>