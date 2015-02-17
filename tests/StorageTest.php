<?php
class StorageTest extends PHPUnit_Framework_TestCase
{

	public function testTheTestFramework()
	{
		$x = 1;
		$this->assertEquals(1, $x);
	}
	
	public function testInvalidIdentifierReturnsNull()
	{
		$sut = new FileStorage();
		$data = $sut->GetData('test.4d.some_made_up_identifier');
		$this->assertEquals(null, $data);
	}
	
	public function testValidIdentifierReturnsFileContents()
	{
		$id = '4d.game.empty';
		$sut = new FileStorage();
		$data = $sut->GetData($id);
		$this->assertEquals('{}', $data);
	}
	
	public function testWritingDataToFile()
	{
		$sut = new FileStorage();
		$id = $sut->GetUniqueId('test.4d.');
		$result = $sut->SetData($id, '{"data":"foo"}');
		$data = $sut->GetData($id);
		
		$this->assertTrue($result !== false);
		$this->assertEquals('{"data":"foo"}', $data);
		
		// cleanup
		$sut->DeleteData($id);
	}
	
	public function testInvalidMemcacheKeyReturnsNull()
	{
		$sut = new MemcacheStorage();
		$data = $sut->GetData('test.4d.some_made_up_identifier');
		$this->assertEquals(null, $data);
	}
	
	public function testSetAndGetOnMemcache()
	{
		$sut = new MemcacheStorage();
		$id = 'testmemcacheid';
		$result = $sut->SetData($id, '{"data":"foo"}');
		$data = $sut->GetData($id);
		
		$this->assertTrue($result !== false);
		$this->assertEquals('{"data":"foo"}', $data);
	}

}

?>