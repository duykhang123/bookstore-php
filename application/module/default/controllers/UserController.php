<?php
class UserController extends Controller
{

	public function __construct($arrParams)
	{
		parent::__construct($arrParams);
		$this->_templateObj->setFolderTemplate('default/main/');
		$this->_templateObj->setFileTemplate('index.php');
		$this->_templateObj->setFileConfig('template.ini');
		$this->_templateObj->load();
	}

	public function indexAction()
	{
		$this->_view->_title 		= 'My account';
		$this->_view->render('user/index');
	}

	public function historyAction()
	{
		$this->_view->Items	 		= $this->_model->listItem($this->_arrParam, array('task' => 'books-in-history'));
		$this->_view->render('user/history');
	}


	public function buyAction()
	{
		$this->_model->saveItem($this->_arrParam, array('task' => 'submit-cart'));
		URL::redirect('default', 'index', 'index');
	}

	public function cartAction()
	{
		$this->_view->Items	 		= $this->_model->listItem($this->_arrParam, array('task' => 'books-in-cart'));
		$this->_view->render('user/cart');
	}

	public function orderAction()
	{
		$cart = Session::get('cart');
		$bookId = $this->_arrParam['book_id'];
		$price = $this->_arrParam['price'];


		if (empty($cart)) {
			$cart['quantity'][$bookId] = 1;
			$cart['price'][$bookId] = $price;
		} else {
			if (key_exists($bookId, $cart['quantity'])) {
				$cart['quantity'][$bookId] += 1;
				$cart['price'][$bookId] = $price * $cart['quantity'][$bookId];
			} else {
				$cart['quantity'][$bookId] = 1;
				$cart['price'][$bookId] = $price;
			}
		}
		Session::set('cart',$cart);
		URL::redirect('default','book','detail',['book_id' => $bookId]);
	}
}
