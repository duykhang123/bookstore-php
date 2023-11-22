<?php
class BookModel extends Model{

    private $_columns = array('id','special', 'name', 'description', 'price', 'sale_off', 'picture','created', 'created_by', 'modified', 'modified_by', 'status', 'ordering', 'category_id');
	private $_userInfo;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_BOOK);

        $userObj	= Session::get('user');
		$this->_userInfo	= $userObj['info'] ?? '';
    }

    public function countItem($arrParam, $option = null){
	
		$query[]	= "SELECT COUNT(`id`) AS `total`";
		$query[]	= "FROM `$this->table`";
	
		// FILTER : KEYWORD
		$flagWhere 	= false;
		if(!empty($arrParam['filter_search'])){
			$keyword	= '"%' . $arrParam['filter_search'] . '%"';
			$query[] = "AND (`name` like $keyword)";
		}
	
		// FILTER : STATUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
            $query[]	= "AND `status` = '" . $arrParam['filter_state'] . "'";
        }

        if(isset($arrParam['filter_category_id']) && $arrParam['filter_category_id'] != 'default'){
            $query[]	= "AND `category_id` = '" . $arrParam['filter_category_id']. "'";
        }
		

	
		$query		= implode(" ", $query);
		$result		= $this->singleRecord($query);
		return $result['total'];
	}

    public function listItem($arrParam, $option = null){
        $query[] = "SELECT `b`.`id`,`b`.`name`,`b`.`special`,`b`.`price`,`b`.`sale_off`,`b`.`picture`,`b`.`status`,`b`.`ordering`,`b`.`created`,`b`.`created_by`,`b`.`modified`,`b`.`modified_by`, `c`.`name` as `name_category`";
        $query[] = "FROM `$this->table` AS `b` LEFT JOIN `". TBL_CATEGORY . "` as `c` ON `b`.`category_id` = `c`.`id`";
        $query[]= "WHERE `b`.`id` > 0";


        //print_r_prettify($arrParam);

        if(!empty($arrParam['filter_search'])){
            $keyword = '"%'. $arrParam['filter_search'] . '%"';
            $query[] = "AND (`b`.`name` like $keyword)";
        }

        if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
            $query[]	= "AND `b`.`status` = '" . $arrParam['filter_state'] . "'";
        }

        if(isset($arrParam['filter_category_id']) && $arrParam['filter_category_id'] != 'default'){
            $query[]	= "AND `b`.`category_id` = '" . $arrParam['filter_category_id']. "'";
        }

        if(isset($arrParam['filter_special']) && $arrParam['filter_special'] != 'default'){
            $query[]	= "AND `b`.`special` = '" . $arrParam['filter_special']. "'";
        }

        if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])){
            $column = $arrParam['filter_column'];
            $columnDir = $arrParam['filter_column_dir'];
            $query[] = "ORDER BY `$column` $columnDir";
        }else{
            $query[] = "ORDER BY `b`.`name` ASC";
        }

        // PAGINATION
		$pagination			= $arrParam['pagination'];
		$totalItemsPerPage	= $pagination['totalItemsPerPage'];
		if($totalItemsPerPage > 0){
			$position	= ($pagination['currentPage']-1)*$totalItemsPerPage;
			$query[]	= "LIMIT $position, $totalItemsPerPage";
		}

        $query = implode(" ", $query);
        $result = $this->listRecord($query);
        return $result;
    }

    public function infoItem($arrParam, $option = null){
		if($option == null){
			$query[]	= "SELECT `id`, `description`, `picture`,`name`, `price`, `special`,`sale_off`,`category_id`, `status`, `ordering`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return $result;
		}
	}

    public function itemInSelectbox($arrParam, $option = null){
        if($option == null){
            $query	= "SELECT `id`, `name` FROM `".TBL_CATEGORY."`";
            $result = $this->fetchPairs($query);
            $result['default'] = "- Select Category -";
            ksort($result);
        }
        return $result;
    }
	
	public function saveItem($arrParam, $option = null){
        require_once LIBRARY_EXT_PATH . 'Upload.php';
		$uploadObj	= new Upload();


		if($option['task'] == 'add'){
            $arrParam['form']['picture']	= $uploadObj->uploadFile($arrParam['form']['picture'], 'book', 98, 150);
            $arrParam['form']['created']	= date('Y-m-d', time());
            $arrParam['form']['modified']	= date('Y-m-d', time());
			$arrParam['form']['created_by']	= $this->_userInfo['username'];
            $arrParam['form']['description']= $arrParam['form']['description'];
			$arrParam['form']['name']		= $arrParam['form']['name'];
			
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class' => 'success', 'content' => 'Dữ liệu được lưu thành công!'));
			return $this->lastID();
		}
		if($option['task'] == 'edit'){
            if($arrParam['form']['picture']['name']==null){
				unset($arrParam['form']['picture']);
			}else{
				$uploadObj->removeFile('book', $arrParam['form']['picture_hidden']);
				$uploadObj->removeFile('book', '98x150-' .  $arrParam['form']['picture_hidden']);
			
				$arrParam['form']['picture']	= $uploadObj->uploadFile($arrParam['form']['picture'], 'book', 98, 150);
			}
			$arrParam['form']['modified']	= date('Y-m-d', time());
			$arrParam['form']['modified_by']= $this->_userInfo['username'];
            $arrParam['form']['description']= $arrParam['form']['description'];
			$arrParam['form']['name']		= $arrParam['form']['name'];
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->update($data, array(array('id', $arrParam['form']['id'])));
			Session::set('message', array('class' => 'success', 'content' => 'Dữ liệu được lưu thành công!'));
			return $arrParam['form']['id'];
		}
	}

    public function ajaxStatus($arrParam, $option = null){
        if($option['task'] == 'change-ajax-status'){
            $status = ($arrParam['status'] == 0) ? 1 : 0;
            $id = $arrParam['id'];
            $query = "UPDATE `$this->table` SET `status` = $status WHERE `id` = $id";
            $this->query($query);

            return [$id, $status, URL::createLink('admin','book','changeStatus',['id' => $id,'status'=>$status])];
        }

        if($option['task'] == 'change-ajax-special'){
            $id = $arrParam['id'];
            $special = ($arrParam['special'] == 0) ? 1 : 0;
            $query = "UPDATE `$this->table` SET `special` = $special WHERE `id` = $id";
            $this->query($query);


            return [$id, $special, URL::createLink('admin','book','changeSpecial',['id' => $id,'special'=>$special])];
        }

        if($option['task'] == 'change-status'){
            $status = $arrParam['type'];
            if(!empty($arrParam['cid'])){
                $cid = $this->createWhereDeleteSQL($arrParam['cid']);
                $query = "UPDATE `$this->table` SET `status` = $status WHERE `id` IN ($cid)";
                $this->query($query);
                Session::set('message',['class' => 'success', 'content' =>'Có ' .$this->affectedRows(). ' phần tử thay đổi trạng thái']); 
            }else{
                Session::set('message',['class' => 'error', 'content' =>'Vui lòng chọn vào phần tử muỗn xóa!']); 
            }
        }
    }

    public function delete($arrParam, $option = null){
        if($option == null){
            if(!empty($arrParam['cid'])){
                $cid = $this->createWhereDeleteSQL($arrParam['cid']);

                $query		= "SELECT `id`, `picture` AS `name` FROM `$this->table` WHERE `id` IN ($cid)";
				$arrImage	= $this->fetchPairs($query);
				require_once LIBRARY_EXT_PATH . 'Upload.php';
				$uploadObj	= new Upload();
				foreach ($arrImage as $value){
					$uploadObj->removeFile('book', $value);
					$uploadObj->removeFile('book', '98x150-' . $value);
				}

                $query		= "DELETE FROM `$this->table` WHERE `id` IN ($cid)";
                $this->query($query);
                Session::set('message', array('class' => 'success', 'content' => 'Có ' . $this->affectedRows(). ' phần tử được xóa!'));
			}else{
				Session::set('message', array('class' => 'error', 'content' => 'Vui lòng chọn vào phần tử muỗn xóa!'));
            }
        }
    }

    public function changeOrdering($arrParam, $option = null){
        if($option == null){
            if(!empty($arrParam['order'])){
                $i = 0;
                foreach($arrParam['order'] as $id => $ordering){
                    $i++;
                    $query = "UPDATE `$this->table` SET `ordering` = $ordering WHERE `id` IN ($id)";
                    $this->query($query);
                }
                Session::set('message', array('class' => 'success', 'content' => 'Có ' .$i. ' phần tử được thay đỏi  ordering!'));
            }
        }
    }
}