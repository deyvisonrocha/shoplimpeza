<?php
class Zend_View_Helper_CategoryMenu extends Zend_View_Helper_Abstract
{
	
	private $html;
	
	private $link;
	
	public function categoryMenu($category_id)
	{
		$category_id = (int) $category_id;
		$this->link = new Zend_View_Helper_Url();
		
		$categoriasModel = new CategoriasModel();
		$categorias = $categoriasModel->fetchAll('parent_id = ' . $category_id);
		
		if ($category_id != 0) {
			$this->html .= '<ul class="sub_menu_2">';
		}
		else {
			$this->html .= '<ul class="sub_menu">';
		}
		
		foreach ($categorias as $categoria) {
			$categoria_id = $categoria->id;
			$categoria_name = $categoria->name;
			$categoria_pai = $categoria->parent_id;
			$category = Common::removeSpecialChars($categoria_name);
			
			$this->html .= '<li>';
			$this->html .= '<a href="' . $this->link->url(array('controller' => 'produtos', 'action' => 'index', 'category' => $category), 'ProdutosRouter', true) . '">' . $categoria_name . '</a>';
			
			if ($categoria_pai == '0') {
				$this->categoryMenu($categoria_id);
			}
			
			$this->html .= '</li>';
		}
		
		$this->html .= '</ul>';
		
		return $this->html;
	}
	
}