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
		$apikey = $ac->POST_Login(
			[
			"password"=>"fakepassword"
			]);
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
		$apikey = $ac->POST_Login(
			[
			"email"=>"fake@example.com"
			]);
	}
	
	public function testCreateAPIKeyWithInvalidCredentialsReturnsModelWIthError()
	{
		$ac = new AuthController(
			new APIService(new MemcacheStorage(new SecureUniqueIdFactory()))
		);
		$apikey = $ac->POST_Login(
			[
			"email"=>"fake@example.com",
			"password"=>"fakepassword"
			]);
		
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
		$result = $ac->GET_Login([]);
		
		$this->assertTrue($result instanceof ViewResult);
		$this->assertTrue($result->GetModel() instanceof UserModel);
	}
	
	public function testCreateAPIKey()
	{
		$as = new APIService(new MemCacheStorage(new SecureUniqueIdFactory()));
		
		$ac = new AuthController($as);
		$result = $ac->POST_Login(
			[
			"email"=>"user1@example.com",
			"password"=>"user1password"
			]);
		$apikey = $result->GetModel()->APIKey;
		$this->assertTrue(strlen($apikey) > 32);
		$this->assertTrue(strncasecmp($apikey, '4d.apikey.', 10) == 0);
		
		// cleanup
		$as->RevokeAPIKey($apikey);
	}
	
	public function testModelDataSetIgnoresUnspecifiedParameters()
	{
		$expectedModelId = 0;
		
		$as = new APIService(new MemCacheStorage(new SecureUniqueIdFactory()));
		$ac = new AuthController($as);
		$result = $ac->GET_Login(
			[
			"Id"=>9999
			]);
			
		$model = $result->GetModel();
		
		$this->assertEquals($expectedModelId, $model->Id);
	}
	
	public function testModelDataSetUsesAllowedParameters()
	{
		$expectedModelId = 9999;
		
		$as = new APIService(new MemCacheStorage(new SecureUniqueIdFactory()));
		$ac = new AuthController($as);
		$model = $ac->SetModelData(
			["Id"=>$expectedModelId],
			new UserModel(),
			["Id"]);
		
		$this->assertEquals($expectedModelId, $model->Id);
	}

}

?>