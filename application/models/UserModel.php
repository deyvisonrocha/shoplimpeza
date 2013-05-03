<?php

class UserModel extends CoreModel
{
	
	protected $_name = 'users';
	protected $_primary = 'id';
	
	
	public function getByLogin($login)
	{
		$select = new Zend_Db_Select($this->getAdapter());
		
		$select->from($this->getName(), array('*'));
		$select->where('user = ?', $login);
		
		$result = $this->getAdapter()->fetchRow($select);
		
		return $result;		
	}
	
	public function changePassword($user_id, $password)
	{
		$user_id = $this->getAdapter()->quote($user_id);
		
		$password = md5($password);
		try {
			$result = $this->update(array('password' => $password), 'id = ' . $user_id);
			
			return $result;
		} catch (Zend_Exception $e) {
			throw $e;
		}
	}
	
}