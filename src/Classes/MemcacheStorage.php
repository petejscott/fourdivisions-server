<?php

require_once('IStorage.php');

class MemcacheStorage implements IStorage
{
	private $cache;
	
	public function __construct()
	{
		$this->cache = new Memcached('4d');
		$memServers = $this->cache->getServerList();
		if (empty($memServers)) 
		{
			$this->cache->setOption(Memcached::OPT_BINARY_PROTOCOL, true);
			$this->cache->addServer('localhost', 11211);
		}
	}
	public function GetUniqueId($prefix)
	{
		return $prefix.bin2hex(openssl_random_pseudo_bytes(16));
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