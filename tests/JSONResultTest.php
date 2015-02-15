<?php
class JSONResultTest extends PHPUnit_Framework_TestCase
{
	
	public function testJSONResultEncodesContent()
	{
		$result = new JSONResult(array("foo", "bar"));
		$this->assertEquals('["foo","bar"]', $result->GetContent());
	}
	
	public function testJSONResultReturnsProvidedResponseCode()
	{
		$result = new JSONResult("hello", 404);
		$this->assertEquals(404, $result->GetResponseCode());
	}
	
	public function testJSONResultGetErrorsReturnsExpectedJSONForSingleError()
	{
		$result = new JSONResult("hello", 404);
		$result->AddError("This is an error message");
		$this->assertEquals('["This is an error message"]', $result->GetErrors());
	}
	
	public function testJSONResultGetErrors()
	{
		$result = new JSONResult("hello", 404);
		$result->AddError("This is an error message");
		$result->AddError(array("This is too!","And so is this"));
		$this->assertEquals('["This is an error message","This is too!","And so is this"]', $result->GetErrors());
	}

}

?>