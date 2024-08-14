<?php
require_once 'sfa_configuration_management.php';

class Sfa_entity_management extends Sfa_configuration_management
{
    public function deleteData($conn, $table_name, $col_id, $fkName = '', $fkKeyValue = '')
    {
        try {

            if ($col_id != '') {
                $query = "DELETE FROM $table_name WHERE `id`=:var1";
            }
            if ($fkName != '') {
                $query = "DELETE FROM $table_name WHERE `$fkName`=:var2";
            }
            $deleteData = $conn->prepare($query);
            if ($col_id != '') {
                $deleteData->bindParam(':var1', $col_id);
            }
            if ($fkKeyValue != '') {
                $deleteData->bindParam(':var2', $fkKeyValue);
            }
            $result = $deleteData->execute();
            if ($result) {
                return true;
            } else {
                return false;
            }

        } catch (\Throwable $th) {
            return $th;
        }
    }

    public function uploadImage($image_name, $newName, $target_dir, $allowedExt = array('jpeg', 'jpg', 'png', 'gif', 'JPEG', 'JPG', 'PNG', 'GIF', 'PDF', 'pdf'))
    {
        try {
            $fileName = $_FILES[$image_name]['name'];
            $tmpFileName = $_FILES[$image_name]['tmp_name'];
            $size = $_FILES[$image_name]['size'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            // $newName = "Doc-" . $doc_name . rand(1000, 1000000) . "." . $ext;
            if (in_array($ext, $allowedExt)) {
                if ($size < 20000000) {
                    move_uploaded_file($tmpFileName, $target_dir . $newName);
                    return array('status' => "1", "msg" => "File Uploaded Successfully");
                } else {
                    return array('status' => "0", "msg" => "File Must be less than 20MB");
                }
            } else {
                $msg = "";
                $allowedExt = array_unique($allowedExt);
                $revisedExt = array();
                foreach ($allowedExt as $extension) {
                    $extension = strtoupper($extension);
                    array_push($revisedExt, $extension);
                }
                $newAllowedExt = array_unique($revisedExt);
                foreach ($newAllowedExt as $value) {
                    $msg .= $value . " ";
                }
                return array('status' => "0", "msg" => "Please upload File with " . $msg . "Extension Only");
            }
        } catch (\Throwable $th) {
            return $th;
        }
    }


    public function RenameImage($image_name)
    {
        try {
            $fileName = $_FILES[$image_name]['name'];
            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newName = $image_name . "-" . time() . mt_rand(100000, 10000000) . "." . $ext;
            return $newName;
        } catch (\Throwable $th) {
            return $th;
        }

    }

    public function passwordGenetor($pass_len)
    {
        try {
            $data = '1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcefghijklmnopqrstuvwxyz';
            return substr(str_shuffle($data), 0, $pass_len);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}

$sfa_ent = new Sfa_entity_management();

?>