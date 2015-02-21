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
			new APIService(new MemcacheStorage(new SecureUniqueIdFactory()))
		);
		$apikey = $ac->Execute(
			"POST_Login",
			["Password"=>"fakepassword"]);
	}
	
	/**
	* @expectedException LogicException
	*
	*/
	public function testCreateAPIKeyWithoutPasswordThrowsException()
	{
		$ac = new AuthController(
			new APIService(new MemcacheStorage(new SecureUniqueIdFactory()))
		);
		$apikey = $ac->Execute(
			"POST_Login",
			["Email"=>"fake@example.com"]);
	}
	
	public function testCreateAPIKeyWithInvalidCredentialsReturnsModelWIthError()
	{
		$ac = new AuthController(
			new APIService(new MemcacheStorage(new SecureUniqueIdFactory()))
		);
		$apikey = $ac->POST_Login(
			[
			"Email"=>"fake@example.com",
			"Password"=>"fakepassword"
			],
			new UserModel());
		
		$usermodel = $apikey->GetModel();
		$this->assertTrue($usermodel instanceof UserModel);
		$this->assertTrue(count($usermodel->GetErrors()) > 0);
		$this->assertEquals("Invalid Credentials", $usermodel->GetErrors()[0]);
	}
	
	public function testLoginAction()
	{
		$ac = new AuthController(
			new APIService(
				new MemcacheStorage(
					new SecureUniqueIdFactory())));
		$result = $ac->GET_Login([], new UserModel());
		
		$this->assertTrue($result instanceof ViewResult);
		$this->assertTrue($result->GetModel() instanceof UserModel);
	}
	
	public function testCreateAPIKey()
	{
		$as = new APIService(new MemCacheStorage(new SecureUniqueIdFactory()));
		
		$ac = new AuthController($as);
		$result = $ac->Execute(
			"POST_Login",
			[
			"Email"=>"user1@example.com",
			"Password"=>"user1password"
			]);
		$apikey = $result->GetModel()->APIKey;
		$this->assertTrue(strlen($apikey) > 32);
		$this->assertTrue(strncasecmp($apikey, '4d.apikey.', 10) == 0);
		
		// cleanup
		$as->RevokeAPIKey($apikey);
	}
	
	public function testModelDataSetIgnoresUnspecifiedParameters()
	{
		$expectedModelEmail = "test@example.com";
		
		$as = new APIService(new MemCacheStorage(new SecureUniqueIdFactory()));
		$ac = new AuthController($as);
		$result = $ac->Execute(
			"GET_Login",
			["Email"=>$expectedModelEmail]);
			
		$model = $result->GetModel();
		
		$this->assertEquals($expectedModelEmail, $model->Email);
	}
	
	public function testModelDataSetUsesOnlyAllowedParameters()
	{
		$expectedModelEmail = "test@example.com";
		
		$as = new APIService(new MemCacheStorage(new SecureUniqueIdFactory()));
		$ac = new AuthController($as);
		$result = $ac->Execute(
			"GET_Login",
			["Email"=>$expectedModelEmail]);
			
		$model = $result->GetModel();
		
		$this->assertEquals($expectedModelEmail, $model->Email);
	}

}

?>