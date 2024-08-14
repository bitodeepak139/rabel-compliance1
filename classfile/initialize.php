<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set("asia/kolkata");
class Initialize
{

    
    private $host = "localhost";

    // private $db_name = "bitoapps_rebelcompliance";
    // private $username = "bitoapps_rebeladmin";
    // private $password = "add_temp_itemrebel";
    private $db_name = "rebel_compliancedb";
    private $username = "root";
    private $password = "";
    public $conn;
    public $leads;

    public function getConnection()
    {
        $this->conn = '';

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            if (!$this->conn) {
                echo "Failed to connect to Database";
                exit();
            } else {
                return $this->conn;
                //return "Conected";
            }

        } catch (Exception $exception) {
            echo "Connection error in PDO: " . $exception->getMessage();
        }
    }

    public function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if (isset($_SERVER['HTTP_FORWARDED'])) {
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if (isset($_SERVER['REMOTE_ADDR'])) {
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else {
            $ipaddress = 'UNKNOWN';
        }

        return $ipaddress;
    }
    public function unv_active_block_data($id, $clid, $table, $column, $status)
    {
        try {
            $query = "update $table set $column=:status where $clid=:id";
            $update_query = $this->conn->prepare($query);
            $update_query->bindParam(':status', $status);
            $update_query->bindParam(':id', $id);
            $resut = $update_query->execute();
            if ($resut)
                return 1;
            else
                return 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    public function user_get_all_right_module($id)
    {
        try {
            $query = "select a.id,a.pk_usm_module_id,a.module_name, a.module_url from usm_module_rights as b 
            left join usm_add_modules as a on b.fk_usm_module_id=a.pk_usm_module_id where b.transaction_status=1 and a.transaction_status=1 and b.fk_usm_user_id=:var1 order by a.id";
            $select_query = $this->conn->prepare($query);
            $select_query->bindParam(':var1', $id);
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            if ($rowcount > 0) {
                $data = $select_query->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } else
                return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function user_get_first_right_page($id, $mdid)
    {
        try {
            $query = "select a.id,a.pk_usm_page_id,a.page_name,a.page_actual from usm_page_rights as b 
            left join usm_add_pages as a on b.fk_usm_page_id=a.pk_usm_page_id where b.transaction_status=1 and a.transaction_status=1 and b.fk_usm_user_id='" . $id . "' and b.fk_usm_module_id='" . $mdid . "' order by a.page_sequence limit 1";
            $select_query = $this->conn->prepare($query);
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            if ($rowcount > 0) {
                $data = $select_query->fetch(PDO::FETCH_ASSOC);
                return $data;
            } else
                return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function user_get_all_right_page($id, $mdid)
    {
        try {
            $query = "select a.id,a.pk_usm_page_id,a.page_name,a.page_actual from usm_page_rights as b 
            left join usm_add_pages as a on b.fk_usm_page_id=a.pk_usm_page_id where b.transaction_status=1 and a.transaction_status=1 and b.fk_usm_user_id='" . $id . "' and b.fk_usm_module_id='" . $mdid . "' order by a.page_sequence";
            $select_query = $this->conn->prepare($query);
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            if ($rowcount > 0) {
                $data = $select_query->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } else
                return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function user_get_page_id($id)
    {
        try {
            $query = "select a.id,a.pk_usm_page_id,a.page_name,a.page_actual from usm_add_pages as a where a.page_actual='" . $id . "' order by a.page_sequence limit 1";
            $select_query = $this->conn->prepare($query);
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            if ($rowcount > 0) {
                $data = $select_query->fetch(PDO::FETCH_ASSOC);
                return $data;
            } else
                return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function user_get_page_right_status($id, $pageid)
    {
        try {
            $query = "select b.transaction_status from usm_page_rights as b left join usm_add_pages as a on b.fk_usm_page_id=a.pk_usm_page_id where b.fk_usm_user_id='" . $id . "' and b.fk_usm_page_id='" . $pageid . "' order by a.page_sequence limit 1";
            $select_query = $this->conn->prepare($query);
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            if ($rowcount > 0) {
                $data = $select_query->fetch(PDO::FETCH_ASSOC);
                return $data['transaction_status'];
            } else
                return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function user_get_module_right_status($id, $mdlid)
    {
        try {
            $query = "select b.transaction_status from usm_module_rights as b where b.fk_usm_user_id='" . $id . "' and b.fk_usm_module_id='" . $mdlid . "' order by b.id limit 1";
            $select_query = $this->conn->prepare($query);
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            if ($rowcount > 0) {
                $data = $select_query->fetch(PDO::FETCH_ASSOC);
                return $data['transaction_status'];
            } else
                return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    // public function get_session_data()
    // {
    //     try {
    //         $query = "select a.id,a.pk_cnf_session_id,a.session_name from cnf_add_session a order by a.id desc ";
    //         $select_query = $this->conn->prepare($query);
    //         $select_query->execute();
    //         $rowcount = $select_query->rowCount();
    //         if ($rowcount > 0) {
    //             $data = $select_query->fetchAll(PDO::FETCH_ASSOC);
    //             return $data;
    //         } else
    //             return $rowcount;
    //     } catch (Exception $exception) {
    //         echo "Execution error: " . $exception->getMessage();
    //     }
    // }



    public function fetch_data($conn, $table_name, $selected_column = "*", $condition = "1")
    {
        try {
            $query = $conn->prepare("select $selected_column from $table_name where $condition");
            // return $query;
            $query->execute();
            $rowCount = $query->rowCount();
            if ($rowCount > 0) {
                $data = $query->fetchAll(PDO::FETCH_ASSOC);
                return $data;
            } else {
                return $rowCount;
            }

        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    // <!-- ========== Fetch Function Code  End ========== -->



    // <!-- ========== Debug function Code Start Section ========== -->
    public function debug($arr)
    {
        try {
            echo "<pre>";
            print_r($arr);
            echo "</pre>";
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    // <!-- ========== Debug function Code End Section ========== -->

    // <!-- ========== get Sequence Number Start ========== -->
    public function get_row_count_of_table($conn, $table, $selected_column = "*", $condition = "1")
    {
        try {
            $select_query = $conn->prepare("select $selected_column from $table where $condition ");
            $select_query->execute();
            $rowCount = $select_query->rowCount();
            return $rowCount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }

    //**************************************************************************************************************************     
}
$abc = new Initialize();
$conn = $abc->getConnection();
$ip = $abc->get_client_ip();
//***********************************************************************************************************************************
?>