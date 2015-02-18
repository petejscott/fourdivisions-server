<?php

class MemcacheStorage implements IStorage
{
	private $cache;
	private $uniqueIdFactory = null;
	
	public function GetUniqueIdFactory()
	{		
		return $this->uniqueIdFactory;
	}	
	
	public function __construct(IUniqueIdFactory $uniqueIdFactory)
	{
		if ($uniqueIdFactory === null) throw new InvalidArgumentException('Null $uniqueId');
		$this->uniqueIdFactory = $uniqueIdFactory;
		
		$this->cache = new Memcached('4d');
		$memServers = $this->cache->getServerList();
		if (empty($memServers)) 
		{
			$this->cache->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
			$this->cache->addServer('localhost', 11211);
		}
	}
	public function GetData($identifier) 
	{
		$data = $this->cache->get($identifier);
		if ($data === false)
		{
			return null;
		}
		return $data;
	}
	public function SetData($identifier, $data)
	{
		$this->cache->set($identifier, $data);
	}
	public function DeleteData($identifier)
	{
		$this->cache->delete($identifier);
	}
}

?>