<?php
class CategoryController extends Controller{
	
	public function __construct($arrParams){
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	
	public function indexAction(){
		$this->_view->_title = ('User Manager: Category');
		$totalItems					= $this->_model->countItem($this->_arrParam, null);
		$configPagination = array('totalItemsPerPage'	=> 5, 'pageRange' => 3);
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);
		$this->_view->Item = $this->_model->listItem($this->_arrParam, null);
		$this->_view->render('category/index');
	}

	public function formAction(){
		$this->_view->_title = 'User Categorys : Add';
		if(!empty($_FILES)) $this->_arrParam['form']['picture']  = $_FILES['picture'];
		if(isset($this->_arrParam['id'])){
			$this->_view->_title = 'User Categorys : Edit';
			$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
			if(empty($this->_arrParam['form'])) URL::redirect('admin', 'category', 'index');
		}
		
		if(isset($this->_arrParam['form']['token']) && $this->_arrParam['form']['token'] > 0){
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('name', 'string', array('min' => 3, 'max' => 255))
			->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
			->addRule('status', 'status', array('deny' => array('default')))
			->addRule('picture', 'file', array('min' => 100, 'max' => 1000000, 'extension' => array('jpg', 'png')), false);
			$validate->run();
			$this->_arrParam['form'] = $validate->getResult();
			if($validate->isValid() == false){
				$this->_view->errors = $validate->showErrors();
			}else{
				$task	= (isset($this->_arrParam['form']['id'])) ? 'edit' : 'add';
				$id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
				if($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'category', 'index');
				if($this->_arrParam['type'] == 'save-new') 		URL::redirect('admin', 'category', 'form');
				if($this->_arrParam['type'] == 'save') 			URL::redirect('admin', 'category', 'form', array('id' => $id));
			}
		}
		
		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render('category/form');
	}

	public function changeStatusAction(){
		$result = $this->_model->ajaxStatus($this->_arrParam, ['task' => 'change-ajax-status']);
		echo json_encode($result);
	}

	public function changeACPAction(){
		$result = $this->_model->ajaxStatus($this->_arrParam, ['task' => 'change-ajax-category-acp']);
		echo json_encode($result);
	}

	public function statusAction(){
		$this->_model->ajaxStatus($this->_arrParam,['task' => 'change-status']);
		URL::redirect('admin', 'category', 'index');
	}

	public function trashAction(){
		$this->_model->delete($this->_arrParam);
		URL::redirect('admin', 'category', 'index');
	}


	public function orderingAction(){
		$this->_model->changeOrdering($this->_arrParam);
		URL::redirect('admin', 'category', 'index');
	}
}