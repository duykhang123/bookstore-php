<?php
class BookController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('admin/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}


	public function indexAction()
	{
		$this->_view->_title = ('Manager: Book');
		$totalItems					= $this->_model->countItem($this->_arrParam, null);
		$this->_view->slbCategory = $this->_model->itemInSelectbox($this->_arrParam, null);

		$configPagination = array('totalItemsPerPage'	=> 5, 'pageRange' => 3);
		$this->setPagination($configPagination);
		$this->_view->pagination	= new Pagination($totalItems, $this->_pagination);
		$this->_view->Item = $this->_model->listItem($this->_arrParam, null);


		$this->_view->render('book/index');
	}

	public function formAction()
	{
		$this->_view->_title = 'Groups : Add';
		$this->_view->slbCategory = $this->_model->itemInSelectbox($this->_arrParam, null);

		if (!empty($_FILES)) $this->_arrParam['form']['picture']  = $_FILES['picture'];
		if (isset($this->_arrParam['id'])) {
			$this->_view->_title = 'Groups : Edit';
			$this->_arrParam['form'] = $this->_model->infoItem($this->_arrParam);
			if (empty($this->_arrParam['form'])) URL::redirect('admin', 'book', 'index');
		}

		if (isset($this->_arrParam['form']['token']) && $this->_arrParam['form']['token'] > 0) {
			$validate = new Validate($this->_arrParam['form']);
			$validate->addRule('name', 'string', array('min' => 3, 'max' => 255))
				->addRule('ordering', 'int', array('min' => 1, 'max' => 100))
				->addRule('status', 'status', array('deny' => array('default')))
				->addRule('special', 'status', array('deny' => array('default')))
				->addRule('category_id', 'status', array('deny' => array('default')))
				->addRule('picture', 'file', array('min' => 100, 'max' => 1000000, 'extension' => array('jpg', 'png')), false)
				->addRule('price', 'int', array('min' => 1000, 'max' => '1000000'))
				->addRule('sale_off', 'int', array('min' => 0, 'max' => '100'));
			$validate->run();
			$this->_arrParam['form'] = $validate->getResult();
			if ($validate->isValid() == false) {
				$this->_view->errors = $validate->showErrors();
			} else {
				$task	= (isset($this->_arrParam['form']['id'])) ? 'edit' : 'add';
				$id	= $this->_model->saveItem($this->_arrParam, array('task' => $task));
				if ($this->_arrParam['type'] == 'save-close') 	URL::redirect('admin', 'book', 'index');
				if ($this->_arrParam['type'] == 'save-new') 		URL::redirect('admin', 'book', 'form');
				if ($this->_arrParam['type'] == 'save') 			URL::redirect('admin', 'book', 'form', array('id' => $id));
			}
		}

		$this->_view->arrParam = $this->_arrParam;
		$this->_view->render('book/form');
	}

	public function changeStatusAction()
	{
		$result = $this->_model->ajaxStatus($this->_arrParam, ['task' => 'change-ajax-status']);
		echo json_encode($result);
	}

	public function changeSpecialAction()
	{
		$result = $this->_model->ajaxStatus($this->_arrParam, ['task' => 'change-ajax-special']);
		echo json_encode($result);
	}

	public function statusAction()
	{
		$this->_model->ajaxStatus($this->_arrParam, ['task' => 'change-status']);
		URL::redirect('admin', 'book', 'index');
	}

	public function trashAction()
	{
		$this->_model->delete($this->_arrParam);
		URL::redirect('admin', 'book', 'index');
	}


	public function orderingAction()
	{
		$this->_model->changeOrdering($this->_arrParam);
		URL::redirect('admin', 'book', 'index');
	}
}
