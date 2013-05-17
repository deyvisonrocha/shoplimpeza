<?php

class ProdutosCaracteristicasModel extends CoreModel
{

	protected $_name = 'products_character';

	protected $_primary = 'id';

	public function getAllByProduct ($product_id)
	{
		$select = new Zend_Db_Select($this->getAdapter());
		
		$select->from(array('pc' => $this->getName()), array('pc.*'));
		$select->where('pc.product_id = ?', $product_id);
		
		$result = $this->getAdapter()->fetchAll($select);
		
		return $result;
	}

	public function deleteAllByProduct($product_id)
	{
		$id = $this->getAdapter()->quote($product_id);
		
		$rows = parent::delete('product_id = ' . $id);
		
		return $rows;
	}

	public function get($id)
	{
		$select = new Zend_Db_Select($this->getAdapter());
		
		$select->from(array('pc' => $this->getName()), array('pc.*'));
		$select->where('pc.id = ?', $id);
		
		$result = $this->getAdapter()->fetchRow($select);
		
		return $result;
	}

	public function add ($params)
	{
		$id = parent::insert($params);
		
		return $id;
	}

	public function edit ($params, $id)
	{
		$id = $this->getAdapter()->quote($id);
		
		$rows = parent::update($params, 'id = ' . $id);
		
		return $rows;
	}

	public function delete ($id)
	{
		$id = $this->getAdapter()->quote($id);
		
		$rows = parent::delete('id = ' . $id);
		
		return $rows;
	}
}