<?php 

class SimpleUniqueIdFactory implements IUniqueIdFactory
{
	public function GetUniqueId($prefix)
	{
		return uniqid($prefix, true);
	}
}

?>