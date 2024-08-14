<?php
class Sfa_configuration_management
{
    // <!-- ========== Fetch Function Code  Start ========== -->
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

    // <!-- ========== get Row Count of Table  Start ========== -->
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

    // <!-- ========== get Row Count of Table  End ========== -->

    // <!-- ========== Insert Method Start Section ========== -->
    function InsertData($conn, $tableName, $values = array())
    {

        /*
            $values = [
                "column" => $value,               
            ];
            $result =  InsertData("table_name",$values);
        */
        try {

            foreach ($values as $field => $v)
                $vals[] = ':' . $field;

            $ins = implode(',', $vals);
            $fields = implode(',', array_keys($values));
            $sql = "INSERT INTO $tableName ($fields) VALUES ($ins)";
            
            $rows = $conn->prepare($sql); 
            foreach ($values as $k => $vl) {
                $rows->bindValue(":". $k, $vl);
            }
            $result = $rows->execute();
            return $result;
        } catch (\Throwable $th) {
            return $th;
        }
    }
    // <!-- ========== Insert Method End Section ========== -->

    // <!-- ========== update the Data of table Start Section ========== -->
    function UpdateData($conn, $tableName, $values = array(), $where = array())
    {

        /*
            $valueArr = [ column => "value",  ];
            $whereArr = [ column => "value",  ];
            $result = UpdateData("tableName",$valueArr, $whereArr);
        */
        try {

            //set value
            foreach ($values as $field => $v)
                $ins[] = $field . '= :' . $field;
            $ins = implode(',', $ins); //where value
            foreach ($where as $fieldw => $vw)
                $inswhere[] = $fieldw . '= :' . $fieldw;
            $inswhere = implode(' && ', $inswhere);


            $sql = "UPDATE  $tableName SET $ins WHERE $inswhere";
            $rows = $conn->prepare($sql); foreach ($values as $f => $v) {
                $rows->bindValue(':' . $f, $v);
            }
            foreach ($where as $k => $l) {
                $rows->bindValue(':' . $k, $l);
            }
            $result = $rows->execute();

            return $result;
        } catch (\Throwable $th) {
            return $th;
        }

    }
    // <!-- ========== update the Data of table End Section ========== -->




}
$sfa_query = new Sfa_configuration_management();
date_default_timezone_set('Asia/Calcutta');
?>