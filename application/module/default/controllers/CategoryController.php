<?php
class CategoryController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}
	
	// ACTION: LIST CATGORIES
	public function indexAction(){
		//$this->_view->_title 		= 'Category List';
		require_once LIBRARY_EXT_PATH . 'XML.php';
		$this->_view->_title 		= 'Category';
		$this->_view->Items 		= XML::getContentXML('categories.xml');;
		$this->_view->render('category/index');
	}
	
}