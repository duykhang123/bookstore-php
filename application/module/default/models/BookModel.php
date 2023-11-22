<?php
class BookModel extends Model{
	
	private $_columns = array('id', 'name', 'description', 'price', 'sale_off', 'picture','created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id');
	private $_userInfo;
	
	public function __construct(){
		parent::__construct();
			
		$this->setTable(TBL_BOOK);
		$userObj 			= Session::get('user');
		$this->_userInfo 	= $userObj['info'] ?? '';
	}
	
	public function listItem($arrParam, $option = null){
		if($option['task'] == 'books-in-cat'){
			$catID		= $arrParam['category_id'];
			$query[]	= "SELECT `id`, `name`, `picture`, `description`,`category_id`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `status`  = 1 AND `category_id` = '$catID'";
			$query[]	= "ORDER BY `ordering` ASC";
	
			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);
			return $result;
		}
		
		if($option['task'] == 'books-relate'){
			$bookID		= $arrParam['book_id'];
			$catID		= $arrParam['category_id'];
			
			$query[]	= "SELECT `b`.`id`, `b`.`name`, `b`.`picture`, `b`.`category_id`, `c`.`name` AS `category_name`";
			$query[]	= "FROM `".TBL_BOOK."` AS `b`, `".TBL_CATEGORY."` AS `c`";
			$query[]	= "WHERE `b`.`status`  = 1  AND `c`.`id` = `b`.`category_id` AND `b`.`id` <> '$bookID' AND `c`.`id`  = '$catID'";
			$query[]	= "ORDER BY `b`.`ordering` ASC";
		
			$query		= implode(" ", $query);
			$result		= $this->listRecord($query);
			return $result;
		}
	}
	
	public function infoItem($arrParam, $option = null){
		if($option['task'] == 'get-cat-name'){
			$query	= "SELECT `name` FROM `".TBL_CATEGORY."` WHERE `id` = '" . $arrParam['category_id'] . "'";
			$result	= $this->singleRecord($query);
			return $result['name'];
		}
		
		if($option['task'] == 'book-info'){
			$query	= "SELECT `b`.`id`, `b`.`name`, `c`.`name` AS `category_name`, `b`.`price`, `b`.`sale_off`, `b`.`picture`, `b`.`description`, `b`.`category_id` FROM `".TBL_BOOK."` AS `b`, `".TBL_CATEGORY."` AS `c` WHERE `b`.`id` = '" . $arrParam['book_id'] . "' AND `c`.`id` = `b`.`category_id`";
			$result	= $this->singleRecord($query);
			return $result;
		}
	}
}