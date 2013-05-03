<?php
class ProdutosModel extends CoreModel
{
	
	protected $_name = 'products';
	protected $_primary = 'id';

	/**
	 *
	 * @param array $filters
	 */
	public function listAll($filters)
	{
		$select = new Zend_Db_Select($this->getAdapter());
			
		$select->from(array('p' => $this->getName()), array('c.*'));
	
		$this->setFilter($select, $filters);
	
		$result = $this->getAdapter()->fetchAll($select);
	
		return $result;
	}
	
	
	private function setFilter(&$select, $filters)
	{
		$order_by = (!empty($filters['order_by']) ? $filters['order_by'] : 'ASC');
		$order_name = (!empty($filters['order_name']) ? $filters['order_name'] : 'name');
		$name = (!empty($filters['name']) ? $filters['name'] : null);
	
		if (!empty($name)) {
			$select->where('p.name LIKE "%?%"', $name);
		}
	
		$select->order($order_name . ' ' . $order_by);
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