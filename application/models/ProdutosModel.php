<?php
class ProdutosModel extends CoreModel
{
	
	protected $_name = 'products';
	protected $_primary = 'id';

	/**
	 *
	 * @param array $filters
	 */
	public function listAll($filters = array())
	{
		$categoriasModel = new CategoriasModel();
		
		$select = new Zend_Db_Select($this->getAdapter());
		
		$select->from(array('p' => $this->getName()), array('p.*'));
		$select->joinLeft(array('c' => $categoriasModel->getName()), 'p.category_id = c.id', array('category_name' => 'c.name'));
	
		$this->setFilter($select, $filters);
	
		$result = $this->getAdapter()->fetchAll($select);
	
		return $result;
	}
	
	
	private function setFilter(&$select, $filters)
	{
		$order_by = (!empty($filters['order_by']) ? $filters['order_by'] : 'ASC');
		$order_name = (!empty($filters['order_name']) ? $filters['order_name'] : 'name');
		$name = (!empty($filters['name']) ? $filters['name'] : null);
		$main = (!empty($filters['main']) ? $filters['main'] : null);
		$parent_id = (!empty($filters['parent_id']) ? $filters['parent_id'] : null);
	
		if (!empty($name)) {
			$select->where('p.name LIKE "%?%"', $name);
		}
		
		if (!empty($main)) {
			$select->where('p.main = ?', $main);
		}
		
		if (!empty($parent_id)) {
			$select->where('p.parent_id = ?', $parent_id);
		}
	
		$select->order($order_name . ' ' . $order_by);
	}
	
	public function get($id)
	{
		$select = new Zend_Db_Select($this->getAdapter());
			
		$select->from(array('p' => $this->getName()), array('p.*'));
		$select->where('p.id = ?', $id);
	
		$result = $this->getAdapter()->fetchRow($select);
	
		return $result;
	}
	
	public function getMain()
	{
		$select = new Zend_Db_Select($this->getAdapter());
			
		$select->from(array('p' => $this->getName()), array('p.*'));
		$select->where('p.main = 1');
	
		$result = $this->getAdapter()->fetchRow($select);
	
		return $result;
	}
	
	public function add($params)
	{
		$params['created_at'] = date('now');
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