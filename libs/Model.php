<?php
class Model
{
    protected $connect;
    protected $database;
    protected $table;
    protected $result;

    public function __construct($params = null)
    {
        if ($params == null) {
            $params['server']    = DB_HOST;
            $params['username']    = DB_USER;
            $params['password']    = DB_PASS;
            $params['database']    = DB_NAME;
            $params['table']    = DB_TABLE;
        }
        $conn = new mysqli($params['server'], $params['username'], $params['password']);
        if (!$conn) {
            die("Connection failed: " . mysqli_error($conn));
        } else {
            $this->connect = $conn;
            $this->database = $params['database'];
            $this->table = $params['table'];
            $this->setDatabase();
        }
    }

    public function setConnect($connect)
    {
        $this->connect = $connect;
    }

    public function setDatabase($database  = null)
    {
        if ($database != null) {
            $this->database = $database;
        }
        return mysqli_select_db($this->connect, $this->database);
    }


    public function setTable($table)
    {
        $this->table = $table;
    }

    //INSERT
    public function insert($params, $type = 'single')
    {
        if ($type == 'single') {
            $result = $this->createInsertSQL($params);
            $query = "INSERT INTO `" . $this->table . "`(" . $result['colt'] . ") VALUES (" . $result['vals'] . ") ";
            $this->query($query);
        } else {
            foreach ($params as $v) {
                $result = $this->createInsertSQL($v);
                $query = "INSERT INTO `" . $this->table . "`(" . $result['colt'] . ") VALUES (" . $result['vals'] . ") ";
                $this->query($query);
            }
        }
        return $this->lastID();
    }

    public function prinr_preti($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
        die();
    }

    //UPDATE

    public function update($params, $where)
    {
        $newparams = $this->createUpdateSQL($params);
        $newwhere = $this->createWhereSQL($where);
        $query = "UPDATE `" . $this->table . "` SET " . $newparams['colt'] . "  WHERE $newwhere ";
        $this->query($query);
    }

    // CREATE WHERE DELTE SQL
    public function createWhereDeleteSQL($data)
    {
        $newWhere = '';
        if (!empty($data)) {
            foreach ($data as $id) {
                $newWhere .= "'" . $id . "', ";
            }
            $newWhere .= "'0'";
        }
        return $newWhere;
    }
    //DELETE

    public function delete($params)
    {
        $newQuery = $this->createDeleteSQL($params);
        $query = "DELETE FROM  `" . $this->table . "`  WHERE `id` IN ($newQuery) ";
        $this->query($query);
        return $this->affectedRows();
    }

    // AFFECTED ROWS
    public function affectedRows()
    {
        return mysqli_affected_rows($this->connect);
    }


    //CREATE UPDATE
    public function createUpdateSQL($data)
    {
        $newQuery = [];
        $colt = "";
        foreach ($data as $k => $v) {
            $colt .= ", `$k` = '$v'";
        }
        $newQuery['colt'] = substr($colt, 2);
        return $newQuery;
    }

    public function createDeleteSQL($data)
    {
        $deleteID  = "";
        if (!empty($data)) {
            foreach ($data as $v) {
                $deleteID  .= "'" . $v . "', ";
            }
            $deleteID .= "'0'";
        }

        return $deleteID;
    }

    //CREATE WHERE
    public function createWhereSQL($data)
    {

        $newQuery = [];
        $colt = "";
        foreach ($data as $k) {
            $newQuery[] = "`$k[0]` = '$k[1]'";
            $newQuery[] = $k[2];
        }
        $newQuery = implode(" ", $newQuery);
        return $newQuery;
    }

    // LAST ID
    public function lastID()
    {
        return mysqli_insert_id($this->connect);
    }

    //query
    public function query($query)
    {
        $this->result = mysqli_query($this->connect, $query);
        return $this->result;
    }

    public function singleRecord($query)
    {
        $result = [];
        if (!empty($query)) {
            $resultQuery =  $this->query($query);
            if (mysqli_num_rows($resultQuery) > 0) {
                $result = mysqli_fetch_assoc($resultQuery);
            }
            mysqli_free_result($resultQuery);
        }
        return $result;
    }

    public function listRecord($query)
    {
        $result = [];
        if (!empty($query)) {
            $resultQuery = $this->query($query);
            if (mysqli_num_rows($resultQuery) > 0) {
                while ($row = mysqli_fetch_assoc($resultQuery)) {
                    $result[] = $row;
                }
                mysqli_free_result($resultQuery);
            }
        }
        return $result;
    }

    public function fetchPairs($query)
    {
        $result = [];
        if (!empty($query)) {
            $resultQuery = $this->query($query);
            if (mysqli_num_rows($resultQuery) > 0) {
                while ($row = mysqli_fetch_assoc($resultQuery)) {
                    $result[$row['id']] = $row['name'];
                }
                mysqli_free_result($resultQuery);
            }
        }
        return $result;
    }

    public function totalItem($query)
    {
        if (!empty($query)) {
            $resultQuery = $this->query($query);
            if (mysqli_num_rows($resultQuery) > 0) {
                while ($row = mysqli_fetch_assoc($resultQuery)) {
                    $result = $row;
                }
                mysqli_free_result($resultQuery);
            }
        }
        return $result['totalItems'];
    }

    public function createInsertSQL($array)
    {
        $data = [];
        $colt = "";
        $vals = "";
        foreach ($array as $k => $v) {
            $colt .= ", `$k`";
            $vals .= ", '$v'";
        }
        $data['colt'] = substr($colt, 2);
        $data['vals'] = substr($vals, 2);

        return $data;
    }

    public function isExist($query)
    {
        if ($query != null) {
            $this->result = $this->query($query);
        }
        if (mysqli_num_rows($this->result) > 0) return true;
        return false;
    }


    public function __destruct()
    {
        return mysqli_close($this->connect);
    }
}
