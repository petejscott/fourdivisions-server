<?php

require_once 'Doubles/StubModel.php';

class JSONResultTest extends PHPUnit_Framework_TestCase
{
	
	public function testJSONResultEncodesContent()
	{
		$result = new JSONResult(new StubModel("foo"));
		$this->assertEquals('{"StringData":"foo","errors":[]}', $result->Render());
	}
	
	public function testJSONResultEncodesErrors()
	{
		$model = new StubModel("foo");
		$model->AddError("Error 1");
		$result = new JSONResult($model);
		$this->assertEquals('{"StringData":"foo","errors":["Error 1"]}', $result->Render());
	}
	
	public function testJSONResultReturnsProvidedResponseCode()
	{
		$result = new JSONResult(new GameModel("foo", []), 404);
		$this->assertEquals(404, $result->GetResponseCode());
	}
	
	public function testJSONResultGetErrorsReturnsExpectedOutputForSingleError()
	{
		$model = new GameModel("foo", []);
		$model->AddError("This is an error message");
		
		$result = new JSONResult($model, 404);
		$this->assertEquals(1, count($result->GetModel()->GetErrors()));
		$this->assertEquals("This is an error message", $result->GetModel()->GetErrors()[0]);
	}
	
	public function testJSONResultGetErrors()
	{
		$model = new GameModel("foo", []);
		$model->AddError("This is an error message");
		$model->AddError(array("This is too!","And so is this"));
		
		$result = new JSONResult($model, 404);
		$this->assertEquals(3, count($result->GetModel()->GetErrors()));
	}

}

?>