<?php
class UserServiceTest extends PHPUnit_Framework_TestCase
{

	public function testInsertThenGetUser()
	{
		$storage = new FileStorage(new SimpleUniqueIdFactory());
		$user = new UserModel();
		$sut = new UserService($storage);
		$userId = $sut->InsertUser($user);
		$data = $sut->GetUser($userId);
		
		$this->assertTrue($data instanceof StdClass);
		$this->assertEquals($userId, $data->Id);
		
		//cleanup
		$sut->DeleteUser($userId);
	}
	
	public function testInsertThenUpdateThenGetUser()
	{
		$storage = new FileStorage(new SimpleUniqueIdFactory());
		$user = new UserModel();
		$sut = new UserService($storage);
		
		// insert a new user and get its ID
		$userId = $sut->InsertUser($user);
		// retrieve the user we just saved
		$data = $sut->GetUser($userId);
		// give it a new ply
		$data->Email = "bob@example.com";
		// update it
		$sut->UpdateUser($userId, $data);
		// reset $data
		$data = null;
		// retrieve the user
		$data = $sut->GetUser($userId);
		
		$this->assertTrue($data instanceof StdClass);
		$this->assertEquals($userId, $data->Id);
		$this->assertEquals("bob@example.com", $data->Email);
		
		//cleanup
		$sut->DeleteUser($userId);
	}

}

?>