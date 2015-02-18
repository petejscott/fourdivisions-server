<?php
class APIServiceTest extends PHPUnit_Framework_TestCase
{

	public function testValidateValidAPIKey()
	{
		$storage = new MemcacheStorage(new SecureUniqueIdFactory());
		$sut = new APIService($storage);
		$key = $sut->CreateAPIKey(1000);
		
		$data = $sut->ValidateAPIKey($key);
		
		$this->assertEquals(1000, $data);
		
		//cleanup
		$sut->RevokeAPIKey($key);
	}
	
	public function testAPIKeyIsGoodEnoughLength()
	{
		$storage = new MemcacheStorage(new SecureUniqueIdFactory());
		$sut = new APIService($storage);
		$key = $sut->CreateAPIKey(1000);
		
		$this->assertTrue(strlen($key) >= 32);
		
		//cleanup
		$sut->RevokeAPIKey($key);
	}
	
	public function testValidateInvalidAPIKey()
	{
		$storage = new MemcacheStorage(new SecureUniqueIdFactory());
		$sut = new APIService($storage);
		
		$data = $sut->ValidateAPIKey('invalidapikey');
		
		$this->assertEquals(null, $data);
	}
	
	public function testRevokeAPIKey()
	{
		$storage = new MemcacheStorage(new SecureUniqueIdFactory());
		$sut = new APIService($storage);
		$key = $sut->CreateAPIKey(1000);
		$sut->RevokeAPIKey($key);
		
		$data = $sut->ValidateAPIKey($key);
		
		$this->assertEquals(null, $data);
	}

}

?>