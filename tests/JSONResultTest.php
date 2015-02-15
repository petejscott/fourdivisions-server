<?php
class JSONResultTest extends PHPUnit_Framework_TestCase
{
	
	public function testJSONResultEncodesContent()
	{
		$result = new JSONResult(array("foo", "bar"));
		$this->assertEquals('{"content":["foo","bar"],"errors":[]}', $result->Render());
	}
	
	public function testJSONResultReturnsProvidedResponseCode()
	{
		$result = new JSONResult("hello", 404);
		$this->assertEquals(404, $result->GetResponseCode());
	}
	
	public function testJSONResultGetErrorsReturnsExpectedOutputForSingleError()
	{
		$result = new JSONResult("hello", 404);
		$result->AddError("This is an error message");
		$this->assertEquals(1, count($result->GetErrors()));
		$this->assertEquals("This is an error message", $result->GetErrors()[0]);
	}
	
	public function testJSONResultGetErrors()
	{
		$result = new JSONResult("hello", 404);
		$result->AddError("This is an error message");
		$result->AddError(array("This is too!","And so is this"));
		$this->assertEquals(3, count($result->GetErrors()));
	}

}

?>