<?php
class USER
{
    public function get_module_data($conn)
    {
        try {
            $query = "select a.* from usm_add_modules a order by a.module_name ";
            $select_query = $conn->prepare($query);
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
    public function check_module_url_name($conn, $val, $type)
    {
        try {
            if ($type == 'url')
                $select_query = $conn->prepare("select a.id from usm_add_modules a  where a.module_url='" . $val . "' ");
            else if ($type == 'module_seq')
                $select_query = $conn->prepare("select a.id from usm_add_modules a  where a.module_seq='" . $val . "' ");
            else
                $select_query = $conn->prepare("select a.id from usm_add_modules a  where a.module_name='" . $val . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_module_data($conn, $url, $name, $module_seq,$sub_module_status,$status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_add_modules a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'USM-M' . $maxid;

            $query = "INSERT INTO usm_add_modules (pk_usm_module_id,module_name,module_url,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip,module_seq,	sub_module_status) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9,:var10,:var11)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $name);
            $ins_query->bindParam(':var3', $url);
            $ins_query->bindParam(':var4', $status);
            $ins_query->bindParam(':var5', $ins_by);
            $ins_query->bindParam(':var6', $ins_date);
            $ins_query->bindParam(':var7', $entry_type);
            $ins_query->bindParam(':var8', $ins_device);
            $ins_query->bindParam(':var9', $ip);
            $ins_query->bindParam(':var10', $module_seq);
            $ins_query->bindParam(':var11', $sub_module_status);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_module_editpopup($conn, $id)
    {
        try {
            $query = "select a.* from usm_add_modules a where a.id=$id ";
            $select_query = $conn->prepare($query);
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
    public function update_module_data($conn, $id, $url, $name,$seq,$sub_module_status,$ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update usm_add_modules set module_url=:var1, module_name=:var2, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 ,module_seq=:var7, sub_module_status=:var8  where id=:updid");
            $update_query->bindParam(':var1', $url);
            $update_query->bindParam(':var2', $name);
            $update_query->bindParam(':var3', $ins_by);
            $update_query->bindParam(':var4', $ins_date);
            $update_query->bindParam(':var5', $ins_device);
            $update_query->bindParam(':var6', $ip);
            $update_query->bindParam(':var7', $seq);
            $update_query->bindParam(':var8', $sub_module_status);
            $update_query->bindParam(':updid', $id);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    //end module method
    public function get_module_select($conn)
    {
        try {
            $query = "select a.pk_usm_module_id,a.module_name from usm_add_modules a where a.transaction_status=1 order by a.module_name ";
            $select_query = $conn->prepare($query);
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
    public function get_page_data($conn)
    {
        try {
            $query = "select a.*,b.module_name from usm_add_pages a left join usm_add_modules as b on b.pk_usm_module_id=a.fk_usm_module_id order by b.module_name,a.page_sequence ";
            $select_query = $conn->prepare($query);
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
    public function get_page_seqno($conn, $id)
    {
        try {
            $select_query = $conn->prepare("select a.page_sequence from usm_add_pages a where a.fk_usm_module_id='" . $id . "' order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $seqno = $row['page_sequence'] + 1;
            return $seqno;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function check_page_name_seqno($conn, $id, $val, $type)
    {
        try {
            if ($type == 'name')
                $select_query = $conn->prepare("select a.id from usm_add_pages a  where a.fk_usm_module_id='" . $id . "' and a.page_name='" . $val . "' ");
            else if ($type == 'url')
                $select_query = $conn->prepare("select a.id from usm_add_pages a  where a.fk_usm_module_id='" . $id . "' and a.page_actual='" . $val . "' ");
            else
                $select_query = $conn->prepare("select a.id from usm_add_pages a  where a.fk_usm_module_id='" . $id . "' and a.page_sequence='" . $val . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_page_data($conn, $module,$submodule, $name, $url, $seqno, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_add_pages a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'UTM-P' . $maxid;

            $query = "INSERT INTO usm_add_pages (pk_usm_page_id,fk_usm_module_id,fk_usm_sub_module_id,page_name,page_sequence,page_actual,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var12,:var3,:var10,:var11,:var4,:var5,:var6,:var7,:var8,:var9)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $module);
            $ins_query->bindParam(':var12', $submodule);
            $ins_query->bindParam(':var3', $name);
            $ins_query->bindParam(':var10', $seqno);
            $ins_query->bindParam(':var11', $url);
            $ins_query->bindParam(':var4', $status);
            $ins_query->bindParam(':var5', $ins_by);
            $ins_query->bindParam(':var6', $ins_date);
            $ins_query->bindParam(':var7', $entry_type);
            $ins_query->bindParam(':var8', $ins_device);
            $ins_query->bindParam(':var9', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_page_editpopup($conn, $id)
    {
        try {
            $query = "select a.* from usm_add_pages a where a.id=$id ";
            $select_query = $conn->prepare($query);
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
    public function  update_page_data($conn, $id, $module,$submodule,$name, $seqno, $url, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update usm_add_pages set fk_usm_module_id=:var1,fk_usm_sub_module_id=:var9,page_name=:var2, page_sequence=:var7,page_actual=:var8, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1', $module);
            $update_query->bindParam(':var9', $submodule);
            $update_query->bindParam(':var2', $name);
            $update_query->bindParam(':var7', $seqno);
            $update_query->bindParam(':var8', $url);
            $update_query->bindParam(':var3', $ins_by);
            $update_query->bindParam(':var4', $ins_date);
            $update_query->bindParam(':var5', $ins_device);
            $update_query->bindParam(':var6', $ip);
            $update_query->bindParam(':updid', $id);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    //end page method  
    public function select_designation_data($conn)
    {
        try {
            $query = "select a.pk_cnf_designation_id,a.name from cnf_add_designation a where a.transaction_status=1 order by a.name ";
            $select_query = $conn->prepare($query);
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
    public function get_user_data($conn)
    {
        try {
            $query = "select a.* from usm_add_users a order by a.user_name ";
            $select_query = $conn->prepare($query);
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
    public function check_user_name_contact_email($conn, $val, $type)
    {
        try {
            if ($type == 'name')
                $select_query = $conn->prepare("select a.id from usm_add_users a  where a.user_name='" . $val . "' ");
            else if ($type == 'phone')
                $select_query = $conn->prepare("select a.id from usm_add_users a  where a.primary_contact_no='" . $val . "' ");
            else
                $select_query = $conn->prepare("select a.id from usm_add_users a  where a.user_email='" . $val . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_user_data($conn, $user_level, $name, $phone, $altno, $email, $password, $design, $filename, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_add_users a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'USM-U' . $maxid;

            $query = "INSERT INTO usm_add_users (pk_usm_user_id,user_level,user_name,user_image,primary_contact_no,secondary_contact_no,user_email,designation,user_login_id,user_password,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var16,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9,:var10,:var11,:var12,:var13,:var14,:var15)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $name);
            $ins_query->bindParam(':var3', $filename);
            $ins_query->bindParam(':var4', $phone);
            $ins_query->bindParam(':var5', $altno);
            $ins_query->bindParam(':var6', $email);
            $ins_query->bindParam(':var7', $design);
            $ins_query->bindParam(':var8', $email);
            $ins_query->bindParam(':var9', $password);
            $ins_query->bindParam(':var10', $status);
            $ins_query->bindParam(':var11', $ins_by);
            $ins_query->bindParam(':var12', $ins_date);
            $ins_query->bindParam(':var13', $entry_type);
            $ins_query->bindParam(':var14', $ins_device);
            $ins_query->bindParam(':var15', $ip);
            $ins_query->bindParam(':var16', $user_level);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_user_editpopup($conn, $id)
    {
        try {
            $query = "select a.*,b.name as desig_name from usm_add_users a left join cnf_add_designation as b on b.pk_cnf_designation_id=a.designation where a.id=$id ";
            $select_query = $conn->prepare($query);
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
    public function update_user_data($conn, $id, $name,$type_of_user_id,$phone, $altno, $email, $pass, $design, $filename, $ins_by, $ins_date, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update usm_add_users set user_name=:var1, primary_contact_no=:var2,user_level=:var13, secondary_contact_no=:var7, user_email=:var8, designation=:var9, user_login_id=:var10, user_password=:var11, user_image=:var12, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1', $name);
            $update_query->bindParam(':var2', $phone);
            $update_query->bindParam(':var13', $type_of_user_id);
            $update_query->bindParam(':var7', $altno);
            $update_query->bindParam(':var8', $email);
            $update_query->bindParam(':var9', $design);
            $update_query->bindParam(':var10', $email);
            $update_query->bindParam(':var11', $pass);
            $update_query->bindParam(':var12', $filename);
            $update_query->bindParam(':var3', $ins_by);
            $update_query->bindParam(':var4', $ins_date);
            $update_query->bindParam(':var5', $ins_device);
            $update_query->bindParam(':var6', $ip);
            $update_query->bindParam(':updid', $id);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    //end user method
    public function get_user($conn)
    {
        try {
            $query = "select a.pk_usm_user_id,a.user_name from usm_add_users a where a.transaction_status=1 order by a.user_name ";
            $select_query = $conn->prepare($query);
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
    public function get_module($conn, $id)
    {
        try {
            $query = "select a.id,a.pk_usm_module_id,a.module_name, IFNULL((select b.transaction_status from usm_module_rights as b where b.fk_usm_module_id=a.pk_usm_module_id and b.fk_usm_user_id='" . $id . "' ),0) as transaction_status from usm_add_modules as a where a.transaction_status=1 order by a.module_name ";
            $select_query = $conn->prepare($query);
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
    public function check_module_right($conn, $user, $module)
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_module_rights a  where a.fk_usm_module_id='" . $module . "' and a.fk_usm_user_id='" . $user . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_module_right($conn, $module, $user, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_module_rights a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'USM-MR' . $maxid;

            $query = "INSERT INTO usm_module_rights (pk_usm_module_right_id,fk_usm_module_id,fk_usm_user_id,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $module);
            $ins_query->bindParam(':var3', $user);
            $ins_query->bindParam(':var4', $status);
            $ins_query->bindParam(':var5', $ins_by);
            $ins_query->bindParam(':var6', $ins_date);
            $ins_query->bindParam(':var7', $entry_type);
            $ins_query->bindParam(':var8', $ins_device);
            $ins_query->bindParam(':var9', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function update_module_right($conn, $module, $user, $status, $ins_by, $ins_date, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update usm_module_rights set transaction_status=:var1, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where fk_usm_module_id=:updid and fk_usm_user_id=:var2");
            $update_query->bindParam(':var1', $status);
            $update_query->bindParam(':var2', $user);
            $update_query->bindParam(':var3', $ins_by);
            $update_query->bindParam(':var4', $ins_date);
            $update_query->bindParam(':var5', $ins_device);
            $update_query->bindParam(':var6', $ip);
            $update_query->bindParam(':updid', $module);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    //end module right method
    public function get_select_module($conn, $id)
    {
        try {
            $query = "select a.id,a.pk_usm_module_id,a.module_name, b.transaction_status from usm_module_rights as b left join usm_add_modules as a on b.fk_usm_module_id=a.pk_usm_module_id where b.transaction_status=1 and b.fk_usm_user_id='" . $id . "' order by a.module_name ";
            $select_query = $conn->prepare($query);
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
    public function get_page($conn, $id, $mdid)
    {
        try {
            $query = "select a.id,a.pk_usm_page_id,a.page_name, IFNULL((select b.transaction_status from usm_page_rights as b where b.fk_usm_page_id=a.pk_usm_page_id and b.fk_usm_user_id='" . $id . "' and b.fk_usm_module_id='" . $mdid . "' ),0) as transaction_status from usm_add_pages as a where a.transaction_status=1 and a.fk_usm_module_id='" . $mdid . "' order by a.page_sequence ";
            $select_query = $conn->prepare($query);
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
    public function check_page_right($conn, $user, $module, $page)
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_page_rights a  where a.fk_usm_module_id='" . $module . "' and a.fk_usm_user_id='" . $user . "' and a.fk_usm_page_id='" . $page . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_page_right($conn, $module, $user, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip, $page_id)
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_page_rights a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'USM-PR' . $maxid;

            $query = "INSERT INTO usm_page_rights (pk_usm_page_right_id,fk_usm_module_id,fk_usm_sub_module_id,fk_usm_page_id,fk_usm_user_id,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip,fk_usm_page_id) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9,:var10)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $module);
            $ins_query->bindParam(':var3', $user);
            $ins_query->bindParam(':var4', $status);
            $ins_query->bindParam(':var5', $ins_by);
            $ins_query->bindParam(':var6', $ins_date);
            $ins_query->bindParam(':var7', $entry_type);
            $ins_query->bindParam(':var8', $ins_device);
            $ins_query->bindParam(':var9', $ip);
            $ins_query->bindParam(':var10', $page_id);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function update_page_right($conn, $module, $user, $page, $status, $ins_by, $ins_date, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update usm_page_rights set transaction_status=:var1, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where fk_usm_module_id=:updid and fk_usm_user_id=:var2 and fk_usm_page_id=:pgid");
            $update_query->bindParam(':var1', $status);
            $update_query->bindParam(':var2', $user);
            $update_query->bindParam(':var3', $ins_by);
            $update_query->bindParam(':var4', $ins_date);
            $update_query->bindParam(':var5', $ins_device);
            $update_query->bindParam(':var6', $ip);
            $update_query->bindParam(':updid', $module);
            $update_query->bindParam(':pgid', $page);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    //end page right method



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

    // <!-- ========== get Sequence Number Start ========== -->
    public function get_row_count_of_table($conn, $table, $selected_column = "*",$condition="1")
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
    // <!-- ========== get Sequence Number End ========== -->


    public function insert_sub_module_data($conn, $module, $name, $url, $seqno, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_mst_submodule a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'USM-SM' . $maxid;

            $query = "INSERT INTO usm_mst_submodule (pk_usm_submodule_id,fk_usm_module_id,submodule_name,dashboard_url,sm_seq,submodule_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9,:var10,:var11)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $module);
            $ins_query->bindParam(':var3', $name);
            $ins_query->bindParam(':var5', $seqno);
            $ins_query->bindParam(':var4', $url);
            $ins_query->bindParam(':var6', $status);
            $ins_query->bindParam(':var7', $ins_by);
            $ins_query->bindParam(':var8', $ins_date);
            $ins_query->bindParam(':var9', $entry_type);
            $ins_query->bindParam(':var10', $ins_device);
            $ins_query->bindParam(':var11', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }


    public function update_sub_module_data($conn, $id, $code, $name, $seqno, $url, $ins_by, $ins_date, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update usm_mst_submodule set fk_usm_module_id=:var1, submodule_name=:var2, sm_seq=:var7, dashboard_url=:var8, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1', $code);
            $update_query->bindParam(':var2', $name);
            $update_query->bindParam(':var7', $seqno);
            $update_query->bindParam(':var8', $url);
            $update_query->bindParam(':var3', $ins_by);
            $update_query->bindParam(':var4', $ins_date);
            $update_query->bindParam(':var5', $ins_device);
            $update_query->bindParam(':var6', $ip);
            $update_query->bindParam(':updid', $id);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }




    public function insert_user_page_right($conn, $module,$user, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip, $page_id , $subModule = '')
    {
        try {
            $select_query = $conn->prepare("select a.id from usm_page_rights a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'USM-PR' . $maxid;

            $query = "INSERT INTO usm_page_rights (pk_usm_page_right_id,fk_usm_module_id,fk_usm_sub_module_id,fk_usm_page_id,fk_usm_user_id,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9,:var10,:var11)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $module);
            $ins_query->bindParam(':var3', $subModule);
            $ins_query->bindParam(':var4', $page_id);
            $ins_query->bindParam(':var5', $user);
            $ins_query->bindParam(':var6', $status);
            $ins_query->bindParam(':var7', $ins_by);
            $ins_query->bindParam(':var8', $ins_date);
            $ins_query->bindParam(':var9', $entry_type);
            $ins_query->bindParam(':var10', $ins_device);
            $ins_query->bindParam(':var11', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }

    public function update_user_page_right($conn, $module, $user, $page, $status, $ins_by, $ins_date, $ins_device, $ip ,$subModule = '')
    {
        try {
            if($subModule != ''){
                $update_query = $conn->prepare("update usm_page_rights set transaction_status=:var1, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where fk_usm_module_id=:updid and fk_usm_user_id=:var2 and fk_usm_page_id=:pgid and fk_usm_sub_module_id=:smid");

                $update_query->bindParam(':smid', $subModule);
            }else{
                $update_query = $conn->prepare("update usm_page_rights set transaction_status=:var1, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where fk_usm_module_id=:updid and fk_usm_user_id=:var2 and fk_usm_page_id=:pgid");
            }
            $update_query->bindParam(':var1', $status);
            $update_query->bindParam(':var2', $user);
            $update_query->bindParam(':var3', $ins_by);
            $update_query->bindParam(':var4', $ins_date);
            $update_query->bindParam(':var5', $ins_device);
            $update_query->bindParam(':var6', $ip);
            $update_query->bindParam(':updid', $module);
            $update_query->bindParam(':pgid', $page);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }

}
$user_query = new USER();
date_default_timezone_set('Asia/Calcutta');
?>