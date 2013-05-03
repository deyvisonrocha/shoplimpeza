<?php
class CategoriasModel extends CoreModel
{
	
	protected $_name = 'categories';
	protected $_primary = 'id';
	
	/**
	 * 
	 * @param array $filters
	 */
	public function listAll($filters)
	{	
		$select = new Zend_Db_Select($this->getAdapter());
			
		$select->from(array('c' => $this->getName()), array('c.id', 'c.name'));
		$select->joinLeft(array('ct' => $this->getName()), 'ct.id = c.parent_id', array('parent_name' => 'ct.name'));
		
		$this->setFilter($select, $filters);
		
		$result = $this->getAdapter()->fetchAll($select);
		
		return $result;
	}
	
	
	private function setFilter(&$select, $filters)
	{
		$order_by = (!empty($filters['order_by']) ? $filters['order_by'] : 'ASC');
		$order_name = (!empty($filters['order_name']) ? $filters['order_name'] : 'name');
		$name = (!empty($filters['name']) ? $filters['name'] : null);
		$parent_name = (!empty($filters['parent_name']) ? $filters['parent_name'] : null);
		
		if (!empty($name)) {
			$select->where('name LIKE "%?%"', $name);
		}
		
		if (!empty($parent_name)) {
			$select->where('parent_name LIKE "%?%"', $$parent_name);
		}
		
		$select->order($order_name . ' ' . $order_by);
	}
	
	public function getAll()
	{
		$select = new Zend_Db_Select($this->getAdapter());
			
		$select->from(array('c' => $this->getName()), array('c.*'));
		
		$result = $this->getAdapter()->fetchAll($select);
		
		return $result;
	}
	
	public function get($id)
	{
		$select = new Zend_Db_Select($this->getAdapter());
			
		$select->from(array('c' => $this->getName()), array('c.*'));
		$select->where('c.id = ?', $id);
	
		$result = $this->getAdapter()->fetchRow($select);
	
		return $result;
	}
	
	public function add($params)
	{
		$id = parent::insert($params);
		
		return $id;
	}
	
	public function edit($params, $id)
	{
		$rows = parent::update($params, 'id = ' . $id);
		
		return $rows;
	}
	
	public function delete($id)
	{
		$id = $this->getAdapter()->quote($id);
		
		$rows = parent::delete('id = ' . $id);
	}
}