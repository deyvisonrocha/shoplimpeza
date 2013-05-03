<?php
class CoreModel extends Zend_Db_Table
{
	
	protected $_name;
	protected $_primary;
	
	public function getName()
	{
		return $this->_name;
	}
	
}