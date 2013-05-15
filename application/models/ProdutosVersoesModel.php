<?php

class ProdutosVersoesModel extends CoreModel
{
	
	protected $_name = 'products_version';
	protected $_primary = 'id';
	
	public function getAllByProduct($product_id)
	{
		$select = new Zend_Db_Select($this->getAdapter());
			
		$select->from(array('pv' => $this->getName()), array('pv_id' => 'pv.id', 'pv_name' => 'pv.name', 'pv_fragrance' => 'pv.fragrance',
				'pv_color' => 'pv.color', 'pv_dilution' => 'pv.dilution', 'pv_packing' => 'pv.packing'));
		$select->where('pv.product_id = ?', $product_id);
	
		$result = $this->getAdapter()->fetchAll($select);
	
		return $result;
	}
	
	public function deleteAllByProduct($product_id)
	{
		$id = $this->getAdapter()->quote($product_id);
	
		$rows = parent::delete('product_id = ' . $id);
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