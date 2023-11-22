<?php
class UserModel extends Model{

    private $_columns = array(
		'id', 
		'username', 
		'email', 
		'fullname', 
		'password',
		'created', 
		'created_by', 
		'modified', 
		'modified_by', 
		'register_date',
		'register_ip',
		'status', 
		'ordering', 
		'group_id'
	);

    private $_userInfo;
    
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_USER);

        $userObj	= Session::get('user');
		$this->_userInfo	= $userObj['info'];
    }

    public function countItem($arrParam, $option = null){
	
		$query[]	= "SELECT COUNT(`id`) AS `total`";
		$query[]	= "FROM `$this->table`";
        $query[]    = "WHERE `id` > 0";
	
		// FILTER : KEYWORD
		if(!empty($arrParam['filter_search'])){
			$keyword	= '"%' . $arrParam['filter_search'] . '%"';
			$query[]	= "AND (`username` like $keyword OR `email` like $keyword)";
		}
	
		// FILTER : STATUS
		if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
			$query[]	= "AND `status` = '" . $arrParam['filter_state']. "'";
		}

		if(isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default'){
            $query[]	= "AND `group_id` = '" . $arrParam['filter_group_id'] . "'";
        }
	
		$query		= implode(" ", $query);
		$result		= $this->singleRecord($query);
		return $result['total'];
	}

    public function itemInSelectbox($arrParam, $option = null){
        if($option == null){
            $query	= "SELECT `id`, `name` FROM `".TBL_GROUP."`";
            $result = $this->fetchPairs($query);
            $result['default'] = "- Select Group -";
            ksort($result);
        }
        return $result;
    }

    public function listItem($arrParam, $option = null){
        $query[]	= "SELECT `u`.`id`, `u`.`username`, `u`.`email`, `u`.`status`, `u`.`fullname`, `u`.`ordering`, `u`.`created`, `u`.`created_by`, `u`.`modified`, `u`.`modified_by`, `g`.`name` AS `group_name`";
		$query[]	= "FROM `$this->table` AS `u` LEFT JOIN `". TBL_GROUP . "` AS `g` ON  `u`.`group_id` = `g`.`id`";
		$query[]	= "WHERE `u`.`id` > 0";
        

        if(!empty($arrParam['filter_search'])){
            $keyword = '"%'. $arrParam['filter_search'] . '%"';
            $query[] = "AND (`username` like $keyword OR `email` like $keyword)";
        }

        if(isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default'){
            $query[]	= "AND `u`.`status` = '" . $arrParam['filter_state'] . "'";
        }

        if(isset($arrParam['filter_group_id']) && $arrParam['filter_group_id'] != 'default'){
            $query[]	= "AND `u`.`group_id` = '" . $arrParam['filter_group_id'] . "'";
        }



        if(!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])){
            $column = $arrParam['filter_column'];
            $columnDir = $arrParam['filter_column_dir'];
            $query[] = "ORDER BY `$column` $columnDir";
        }else{
            $query[] = "ORDER BY `username` ASC";
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
			$query[]	= "SELECT `id`, `username`, `email`, `fullname`,`group_id`, `status`, `ordering`";
			$query[]	= "FROM `$this->table`";
			$query[]	= "WHERE `id` = '" . $arrParam['id'] . "'";
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);
			return $result;
		}
	}
	
	public function saveItem($arrParam, $option = null){

		if($option['task'] == 'add'){
            $arrParam['form']['created']	= date('Y-m-d', time());
            $arrParam['form']['modified']	= date('Y-m-d', time());
            $arrParam['form']['register_date']	= date("Y-m-d H:m:s", time());
			$arrParam['form']['register_ip']	= $_SERVER['REMOTE_ADDR'];
			$arrParam['form']['created_by']	= $this->_userInfo['username'];
            $arrParam['form']['password'] = md5($arrParam['form']['password']);
			$data	= array_intersect_key($arrParam['form'], array_flip($this->_columns));
			$this->insert($data);
			Session::set('message', array('class' => 'success', 'content' => 'Dữ liệu được lưu thành công!'));
			return $this->lastID();
		}
		if($option['task'] == 'edit'){
			$arrParam['form']['modified']	= date('Y-m-d', time());
			$arrParam['form']['modified_by']= $this->_userInfo['username'];
            if($arrParam['form']['password'] != null){
                $arrParam['form']['password'] = md5($arrParam['form']['password']);
            }else{
                unset($arrParam['form']['password']);
            }
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

            return [$id, $status, URL::createLink('admin','user','changeStatus',['id' => $id,'status'=>$status])];
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