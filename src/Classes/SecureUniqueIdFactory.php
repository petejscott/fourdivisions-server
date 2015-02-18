<?php 

class SecureUniqueIdFactory implements IUniqueIdFactory
{
	public function GetUniqueId($prefix)
	{
		return $prefix.bin2hex(openssl_random_pseudo_bytes(16));
	}
}

?>