<?php
class AuthControllerTest extends PHPUnit_Framework_TestCase
{
	
	/**
	* @expectedException LogicException
	*
	*/
	public function testCreateAPIKeyWithoutEmailThrowsException()
	{
		$ac = new AuthController(
			new APIService(new MemcacheStorage())
		);
		$apikey = $ac->PUT_APIKey(
			array(
				"password"=>"fakepassword"), 
			"PUT");
	}
	
	/**
	* @expectedException LogicException
	*
	*/
	public function testCreateAPIKeyWithoutPasswordThrowsException()
	{
		$ac = new AuthController(
			new APIService(new MemcacheStorage())
		);
		$apikey = $ac->PUT_APIKey(
			array(
				"email"=>"fakeemail"), 
			"PUT");
	}
	
	/**
	* @expectedException OutOfBoundsException
	*
	*/
	public function testCreateAPIKeyWithInvalidCredentialsThrowsException()
	{
		$ac = new AuthController(
			new APIService(new MemcacheStorage())
		);
		$apikey = $ac->PUT_APIKey(
			array(
				"email"=>"fakeemail",
				"password"=>"fakepassword"), 
			"PUT");
	}
	
	public function testCreateAPIKey()
	{
		$ac = new AuthController(
			new APIService(new MemcacheStorage())
		);
		$result = $ac->PUT_APIKey(
			array(
				"email"=>"user1@example.com",
				"password"=>"user1password"), 
			"PUT");
		$apikey = $result->GetContent();
		$this->assertTrue(strlen($apikey) > 32);
		$this->assertTrue(strncasecmp($apikey, '4d.apikey.', 10) == 0);
		
		// cleanup
		$as = new APIService(new MemCacheStorage());	
		$as->RevokeAPIKey($apikey);
	}

}

?>