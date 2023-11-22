<?php
class CategoryModel extends Model
{

    private $_columns = array('id', 'name', 'picture', 'created', 'created_by', 'modified', 'modified_by', 'status', 'ordering');
    private $_userInfo;
    public function __construct()
    {
        parent::__construct();
        $this->setTable(TBL_CATEGORY);

        $userObj    = Session::get('user');
        $this->_userInfo    = $userObj['info'];
    }

    public function countItem($arrParam, $option = null)
    {

        $query[]    = "SELECT COUNT(`id`) AS `total`";
        $query[]    = "FROM `$this->table`";

        // FILTER : KEYWORD
        $flagWhere     = false;
        if (!empty($arrParam['filter_search'])) {
            $keyword    = '"%' . $arrParam['filter_search'] . '%"';
            $query[]    = "WHERE `name` LIKE $keyword";
            $flagWhere     = true;
        }

        // FILTER : STATUS
        if (isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
            if ($flagWhere == true) {
                $query[]    = "AND `status` = '" . $arrParam['filter_state'] . "'";
            } else {
                $query[]    = "WHERE `status` = '" . $arrParam['filter_state'] . "'";
                $flagWhere    = true;
            }
        }



        $query        = implode(" ", $query);
        $result        = $this->singleRecord($query);
        return $result['total'];
    }

    public function listItem($arrParam, $option = null)
    {
        if ($option == null) {
            $query[] = "SELECT `id`,`name`,`picture`,`status`,`ordering`,`created`,`created_by`,`modified`,`modified_by`";
            $query[] = "FROM `$this->table`";

            //print_r_prettify($arrParam);

            $flagWhere     = false;
            if (!empty($arrParam['filter_search'])) {
                $keyword = '"%' . $arrParam['filter_search'] . '%"';
                $query[] = "WHERE `name` like $keyword";
                $flagWhere     = true;
            }

            if (isset($arrParam['filter_state']) && $arrParam['filter_state'] != 'default') {
                if ($flagWhere == true) {
                    $query[]    = "AND `status` = '" . $arrParam['filter_state'] . "'";
                } else {
                    $query[]    = "WHERE `status` = '" . $arrParam['filter_state'] . "'";
                    $flagWhere    = true;
                }
            }

            if (!empty($arrParam['filter_column']) && !empty($arrParam['filter_column_dir'])) {
                $column = $arrParam['filter_column'];
                $columnDir = $arrParam['filter_column_dir'];
                $query[] = "ORDER BY `$column` $columnDir";
            } else {
                $query[] = "ORDER BY `name` ASC";
            }

            // PAGINATION
            $pagination            = $arrParam['pagination'];
            $totalItemsPerPage    = $pagination['totalItemsPerPage'];
            if ($totalItemsPerPage > 0) {
                $position    = ($pagination['currentPage'] - 1) * $totalItemsPerPage;
                $query[]    = "LIMIT $position, $totalItemsPerPage";
            }

            $query = implode(" ", $query);
            $result = $this->listRecord($query);
            return $result;
        }
        if ($option['task'] == 'xml-category') {
            $query    = "SELECT `id`, `name`, `picture` FROM `$this->table` WHERE `status` = 1";
            $result   = $this->listRecord($query);
            return $result;
        }
    }

    public function infoItem($arrParam, $option = null)
    {
        if ($option == null) {
            $query[]    = "SELECT `id`, `name`, `picture`, `status`, `ordering`";
            $query[]    = "FROM `$this->table`";
            $query[]    = "WHERE `id` = '" . $arrParam['id'] . "'";
            $query        = implode(" ", $query);
            $result        = $this->singleRecord($query);
            return $result;
        }
    }

    public function saveItem($arrParam, $option = null)
    {
        require_once LIBRARY_EXT_PATH . 'XML.php';
        require_once LIBRARY_EXT_PATH . 'Upload.php';
        $uploadObj = new Upload();

        if ($option['task'] == 'add') {
            $arrParam['form']['picture']    = $uploadObj->uploadFile($arrParam['form']['picture'], 'category');
            $arrParam['form']['created']    = date('Y-m-d', time());
            $arrParam['form']['modified']    = date('Y-m-d', time());
            $arrParam['form']['created_by']    = $this->_userInfo['username'];
            $data    = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->insert($data);
            Session::set('message', array('class' => 'success', 'content' => 'Dữ liệu được lưu thành công!'));
            $arrCategories = $this->listItem($arrParam, ['task' => 'xml-category']);

            XML::createXML($arrCategories, 'categories.xml');
            return $this->lastID();
        }
        if ($option['task'] == 'edit') {
            $arrParam['form']['modified']    = date('Y-m-d', time());
            $arrParam['form']['modified_by'] = $this->_userInfo['username'];
            if ($arrParam['form']['picture']['name'] == null) {
                unset($arrParam['form']['picture']);
            } else {
                $uploadObj->removeFile('category', $arrParam['form']['picture_hidden']);
                $uploadObj->removeFile('category', '60x90-' .  $arrParam['form']['picture_hidden']);

                $arrParam['form']['picture']    = $uploadObj->uploadFile($arrParam['form']['picture'], 'category');
            }
            $data    = array_intersect_key($arrParam['form'], array_flip($this->_columns));
            $this->update($data, array(array('id', $arrParam['form']['id'])));
            Session::set('message', array('class' => 'success', 'content' => 'Dữ liệu được lưu thành công!'));
            $arrCategories = $this->listItem($arrParam, ['task' => 'xml-category']);

            XML::createXML($arrCategories, 'categories.xml');

            return $arrParam['form']['id'];
        }
    }

    public function ajaxStatus($arrParam, $option = null)
    {
        require_once LIBRARY_EXT_PATH . 'XML.php';
        if ($option['task'] == 'change-ajax-status') {
            $status = ($arrParam['status'] == 0) ? 1 : 0;
            $id = $arrParam['id'];
            $query = "UPDATE `$this->table` SET `status` = $status WHERE `id` = $id";
            $this->query($query);
            $arrCategories    = $this->listItem($arrParam, array('task' => 'xml-category'));
            XML::createXML($arrCategories, 'categories.xml');


            return [$id, $status, URL::createLink('admin', 'category', 'changeStatus', ['id' => $id, 'status' => $status])];
        }


        if ($option['task'] == 'change-status') {
            $status = $arrParam['type'];
            if (!empty($arrParam['cid'])) {
                $cid = $this->createWhereDeleteSQL($arrParam['cid']);
                $query = "UPDATE `$this->table` SET `status` = $status WHERE `id` IN ($cid)";
                $this->query($query);
                $arrCategories    = $this->listItem($arrParam, array('task' => 'xml-category'));
                XML::createXML($arrCategories, 'categories.xml');

                Session::set('message', ['class' => 'success', 'content' => 'Có ' . $this->affectedRows() . ' phần tử thay đổi trạng thái']);
            } else {
                Session::set('message', ['class' => 'error', 'content' => 'Vui lòng chọn vào phần tử muỗn xóa!']);
            }
        }
    }

    public function delete($arrParam, $option = null)
    {
        require_once LIBRARY_EXT_PATH . 'XML.php';
        if ($option == null) {
            if (!empty($arrParam['cid'])) {
                $cid = $this->createWhereDeleteSQL($arrParam['cid']);

                // Remove image
                $query = "SELECT `id`, `picture` as `name` FROM `$this->table` WHERE `id` IN ($cid)";
                $arrImage = $this->listRecord($query);

                require_once LIBRARY_EXT_PATH . 'Upload.php';
                $uploadObj    = new Upload();
                foreach ($arrImage as $value) {
                    $uploadObj->removeFile('category', $value['name']);
                    $uploadObj->removeFile('category', '60x90-' . $value['name']);
                }

                $query        = "DELETE FROM `$this->table` WHERE `id` IN ($cid)";
                $this->query($query);
                $arrCategories    = $this->listItem($arrParam, array('task' => 'xml-category'));
                XML::createXML($arrCategories, 'categories.xml');

                Session::set('message', array('class' => 'success', 'content' => 'Có ' . $this->affectedRows() . ' phần tử được xóa!'));
            } else {
                Session::set('message', array('class' => 'error', 'content' => 'Vui lòng chọn vào phần tử muỗn xóa!'));
            }
        }
    }

    public function changeOrdering($arrParam, $option = null)
    {
        if ($option == null) {
            if (!empty($arrParam['order'])) {
                $i = 0;
                foreach ($arrParam['order'] as $id => $ordering) {
                    $i++;
                    $query = "UPDATE `$this->table` SET `ordering` = $ordering WHERE `id` IN ($id)";
                    $this->query($query);
                }
                Session::set('message', array('class' => 'success', 'content' => 'Có ' . $i . ' phần tử được thay đỏi  ordering!'));
            }
        }
    }
}
