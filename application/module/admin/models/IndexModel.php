<?php
class IndexModel extends Model{

    
    public function __construct()
    {
        parent::__construct();
    }

    public function infoItem($arrParam, $option = null){
        if($option == null){
            $username = $arrParam['form']['username'];
            $password = md5($arrParam['form']['password']);
            $query[]	= "SELECT `u`.`id`, `u`.`fullname`, `u`.`email`, `u`.`username`, `u`.`group_id`, `g`.`group_acp`, `g`.`privilege_id`";
			$query[]	= "FROM `user` AS `u` LEFT JOIN `group` AS g ON `u`.`group_id` = `g`.`id`";
			$query[]	= "WHERE `username` = '$username' AND `password` = '$password'";
			
			$query		= implode(" ", $query);
			$result		= $this->singleRecord($query);


            $strPrivilegeID = '';
            if($result['group_acp'] == 1){
                $arrPrivilege	= explode(',', $result['privilege_id']);
                foreach($arrPrivilege as $privilegeId){
                    $strPrivilegeID .= "'$privilegeId', ";
                }
                $queryP[]	= "SELECT `id`, CONCAT(`module`, '-', `controller`, '-',`action`) AS `name`";
				$queryP[]	= "FROM `".TBL_PRIVELEGE."` AS p";
				$queryP[]	= "WHERE id IN ($strPrivilegeID'0')";
				
				$queryP		= implode(" ", $queryP);
				$result['privilege']	= $this->listRecord($queryP);
            }


            return $result;
        }
    }
}