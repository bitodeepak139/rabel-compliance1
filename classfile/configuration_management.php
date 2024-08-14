<?php
class organization
{
    public function get_organization_data($conn)
    {
        try {
            $query = "select a.* from cnf_add_organization a order by a.organization_name ";
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
    public function get_country_select($conn)
    {
        try {
            $query = "select a.pk_utm_country_id,a.country_name from utm_add_country a where a.transaction_status=1 order by a.country_name ";
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
    public function get_state_select($conn, $id)
    {
        try {
            $query = "select a.pk_utm_state_id,a.state_name from utm_add_state a where a.transaction_status=1 and a.fk_utm_country_id='" . $id . "' order by a.state_name ";
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
    public function get_city_select($conn, $id)
    {
        try {
            $query = "select a.pk_utm_city_id,a.city_name from utm_add_city a where a.transaction_status=1 and a.fk_utm_state_id='" . $id . "' order by a.city_name ";
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
    public function check_org_name($conn, $name)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_organization a  where a.organization_name='" . $name . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function check_org_contact($conn, $phone)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_organization a  where a.primary_contact_no='" . $phone . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_org_data($conn, $country, $state, $name, $city, $address, $phone, $altno, $email, $website, $filename, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_organization a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'CNF-OR' . $maxid;

            $query = "INSERT INTO cnf_add_organization (pk_cnf_organization_id,organization_name,fk_utm_country_id,fk_utm_state_id,fk_utm_city_id,organization_address,primary_contact_no,secondary_contact_no,email,website_url,organization_logo,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9,:var10,:var11,:var12,:var13,:var14,:var15,:var16,:var17)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $name);
            $ins_query->bindParam(':var3', $country);
            $ins_query->bindParam(':var4', $state);
            $ins_query->bindParam(':var5', $city);
            $ins_query->bindParam(':var6', $address);
            $ins_query->bindParam(':var7', $phone);
            $ins_query->bindParam(':var8', $altno);
            $ins_query->bindParam(':var9', $email);
            $ins_query->bindParam(':var10', $website);
            $ins_query->bindParam(':var11', $filename);
            $ins_query->bindParam(':var12', $status);
            $ins_query->bindParam(':var13', $ins_by);
            $ins_query->bindParam(':var14', $ins_date);
            $ins_query->bindParam(':var15', $entry_type);
            $ins_query->bindParam(':var16', $ins_device);
            $ins_query->bindParam(':var17', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_org_viewpopup($conn, $id)
    {
        try {
            $query = "select a.*,b.country_name,c.state_name,d.city_name from cnf_add_organization as a left join utm_add_country as b on b.pk_utm_country_id=a.fk_utm_country_id left join utm_add_state as c on c.pk_utm_state_id=a.fk_utm_state_id left join utm_add_city as d on d.pk_utm_city_id=a.fk_utm_city_id where a.id=$id ";
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
    public function get_org_editpopup($conn, $id)
    {
        try {
            $query = "select a.* from cnf_add_organization a where a.id=$id ";
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
    public function update_org_data($conn, $editid, $company_name, $cin_no, $pan_no, $gst_no, $tan_no, $fax_no, $registered_address, $country, $state, $city, $contact1, $contact2, $email, $website, $filename, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {

            $update_query = $conn->prepare("update cnf_mst_company set company_name=:var1, registered_address=:var2, country_id=:var3, state_id=:var4, city_id=:var5,contact_no1=:var6,
            contact_no2=:var7,email_id=:var8,company_website=:var9,company_logo=:var10,cin_no=:var11,fax_no=:var12,tan_no=:var13,pan_no=:var14,gstn_no=:var15,update_by=:var16, update_date=:var17, update_system=:var18, update_ip=:var19 where id=:updid");
            $update_query->bindParam(':var1', $company_name);
            $update_query->bindParam(':var2', $registered_address);
            $update_query->bindParam(':var3', $country);
            $update_query->bindParam(':var4', $state);
            $update_query->bindParam(':var5', $city);
            $update_query->bindParam(':var6', $contact1);
            $update_query->bindParam(':var7', $contact2);
            $update_query->bindParam(':var8', $email);
            $update_query->bindParam(':var9', $website);
            $update_query->bindParam(':var10', $filename);
            $update_query->bindParam(':var11', $cin_no);
            $update_query->bindParam(':var12', $fax_no);
            $update_query->bindParam(':var13', $tan_no);
            $update_query->bindParam(':var14', $pan_no);
            $update_query->bindParam(':var15', $gst_no);
            $update_query->bindParam(':var16', $ins_by);
            $update_query->bindParam(':var17', $ins_date);
            $update_query->bindParam(':var18', $ins_device);
            $update_query->bindParam(':var19', $ip);
            $update_query->bindParam(':updid', $editid);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    //end org method
    public function get_department_data($conn)
    {
        try {
            $query = "select a.* from cnf_add_department a order by a.department_name ";
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
    public function check_department_name($conn, $name)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_department a where a.department_name='" . $name . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_department_data($conn, $name, $details, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_department a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'CNF-DPT' . $maxid;

            $query = "INSERT INTO cnf_add_department (pk_cnf_department_id,department_name,department_details,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var12,:var13,:var14,:var15,:var16,:var17)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $name);
            $ins_query->bindParam(':var3', $details);
            $ins_query->bindParam(':var12', $status);
            $ins_query->bindParam(':var13', $ins_by);
            $ins_query->bindParam(':var14', $ins_date);
            $ins_query->bindParam(':var15', $entry_type);
            $ins_query->bindParam(':var16', $ins_device);
            $ins_query->bindParam(':var17', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_department_editpopup($conn, $id)
    {
        try {
            $query = "select a.* from cnf_add_department a where a.id=$id ";
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
    public function update_department_data($conn, $id, $name, $details, $ins_by, $ins_date, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update cnf_add_department set department_name=:var1, department_details=:var2, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1', $name);
            $update_query->bindParam(':var2', $details);
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
    //end department method

    public function get_designation_data($conn)
    {
        try {
            $query = "select a.* from cnf_add_designation a order by a.name ";
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
    public function check_designation_name($conn, $name)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_designation a where a.name='" . $name . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }

    public function get_designation_editpopup($conn, $id)
    {
        try {
            $query = "select a.* from cnf_add_designation a where a.id=$id ";
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
    public function update_designation_data($conn, $id, $name, $details, $ins_by, $ins_date, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update cnf_add_designation set name=:var1, details=:var2, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1', $name);
            $update_query->bindParam(':var2', $details);
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
    //end designation method
    public function get_class_data($conn)
    {
        try {
            $query = "select a.* from cnf_add_class a order by a.id ";
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
    public function check_class_name($conn, $name)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_class a where a.class_name='" . $name . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_class_data($conn, $name, $details, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_class a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'CNF-CLS' . $maxid;

            $query = "INSERT INTO cnf_add_class (pk_cnf_class_id,class_name,class_details,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var12,:var13,:var14,:var15,:var16,:var17)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $name);
            $ins_query->bindParam(':var3', $details);
            $ins_query->bindParam(':var12', $status);
            $ins_query->bindParam(':var13', $ins_by);
            $ins_query->bindParam(':var14', $ins_date);
            $ins_query->bindParam(':var15', $entry_type);
            $ins_query->bindParam(':var16', $ins_device);
            $ins_query->bindParam(':var17', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_class_editpopup($conn, $id)
    {
        try {
            $query = "select a.* from cnf_add_class a where a.id=$id ";
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
    public function update_class_data($conn, $id, $name, $details, $ins_by, $ins_date, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update cnf_add_class set class_name=:var1, class_details=:var2, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1', $name);
            $update_query->bindParam(':var2', $details);
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
    //end class method
    public function get_class_select($conn)
    {
        try {
            $query = "select a.pk_cnf_class_id,a.class_name from cnf_add_class a where a.transaction_status=1 order by a.id ";
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
    public function get_class_section_data($conn)
    {
        try {
            $query = "select a.*,b.class_name from cnf_add_class_section as a left join cnf_add_class as b on b.pk_cnf_class_id=a.fk_cnf_class_id order by a.id ";
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
    public function check_class_section_name($conn, $class, $name)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_class_section a where a.fk_cnf_class_id='" . $class . "' and a.section_name='" . $name . "' ");
            $select_query->execute();
            $rowcount = $select_query->rowCount();
            return $rowcount;
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_class_section_data($conn, $class, $name, $details, $status, $ins_by, $ins_date, $entry_type, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_add_class_section a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'CNF-SEC' . $maxid;

            $query = "INSERT INTO cnf_add_class_section (pk_cnf_section_id,fk_cnf_class_id,section_name,section_details,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var4,:var12,:var13,:var14,:var15,:var16,:var17)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $class);
            $ins_query->bindParam(':var3', $name);
            $ins_query->bindParam(':var4', $details);
            $ins_query->bindParam(':var12', $status);
            $ins_query->bindParam(':var13', $ins_by);
            $ins_query->bindParam(':var14', $ins_date);
            $ins_query->bindParam(':var15', $entry_type);
            $ins_query->bindParam(':var16', $ins_device);
            $ins_query->bindParam(':var17', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_class_section_editpopup($conn, $id)
    {
        try {
            $query = "select a.* from cnf_add_class_section a where a.id=$id ";
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
    public function update_class_section_data($conn, $id, $class, $name, $details, $ins_by, $ins_date, $ins_device, $ip)
    {
        try {
            $update_query = $conn->prepare("update cnf_add_class_section set fk_cnf_class_id=:var7, section_name=:var1, section_details=:var2, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var7', $class);
            $update_query->bindParam(':var1', $name);
            $update_query->bindParam(':var2', $details);
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
    //end class section method







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

    // <!-- ========== get Sequence Number End ========== -->

    public function insert_zone_data($conn, $country, $zone_name, $zone_details, $status, $ins_by, $ins_date, $ins_time, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_mst_zone a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'Z' . $maxid;

            $query = "INSERT INTO cnf_mst_zone (pk_cnf_zone_id,country_id,zone_name,zone_details,transaction_status,ins_by,ins_date,ins_system,ins_ip,ins_time) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9,:var10)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $country);
            $ins_query->bindParam(':var3', $zone_name);
            $ins_query->bindParam(':var4', $zone_details);
            $ins_query->bindParam(':var5', $status);
            $ins_query->bindParam(':var6', $ins_by);
            $ins_query->bindParam(':var7', $ins_date);
            $ins_query->bindParam(':var8', $ins_device);
            $ins_query->bindParam(':var9', $ip);
            $ins_query->bindParam(':var10', $ins_time);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }

    public function update_zone_data($conn, $id, $country_id, $zone_name, $zone_details)
    {
        try {
            $update_query = $conn->prepare("update cnf_mst_zone set country_id=:var1, zone_name=:var2, zone_details=:var3 where Id=:updid");
            $update_query->bindParam(':var1', $country_id);
            $update_query->bindParam(':var2', $zone_name);
            $update_query->bindParam(':var3', $zone_details);
            $update_query->bindParam(':updid', $id);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }

    public function update_region_data($conn, $id, $country, $zone_id, $region_name, $region_details)
    {
        try {
            $update_query = $conn->prepare("update cnf_mst_region set country_id=:var1, fk_cnf_zone_id=:var2, region_name=:var3 , region_details=:var4 where Id=:updid");
            $update_query->bindParam(':var1',$country);
            $update_query->bindParam(':var2', $zone_id);
            $update_query->bindParam(':var3', $region_name);
            $update_query->bindParam(':var4', $region_details);
            $update_query->bindParam(':updid', $id);
            $update_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }


    public function insert_region_data($conn, $country, $zone_id, $region_name, $region_details, $status, $ins_by, $ins_date, $ins_time, $ins_device, $ip)
    {
        try {
            $select_query = $conn->prepare("select a.id from cnf_mst_region a order by a.id desc limit 1 ");
            $select_query->execute();
            $row = $select_query->fetch();
            $maxid = $row['id'] + 1;
            $primary_id = 'CNF-R' . $maxid;


            $query = "INSERT INTO cnf_mst_region (pk_cnf_region_id,country_id,fk_cnf_zone_id,region_name,region_details,transaction_status,ins_by,ins_date,ins_time,ins_system,ins_ip) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var12,:var13,:var14,:var15,:var16,:var17)";
            $ins_query = $conn->prepare($query);
            $ins_query->bindParam(':var1', $primary_id);
            $ins_query->bindParam(':var2', $country);
            $ins_query->bindParam(':var3', $zone_id);
            $ins_query->bindParam(':var4', $region_name);
            $ins_query->bindParam(':var5', $region_details);
            $ins_query->bindParam(':var12', $status);
            $ins_query->bindParam(':var13', $ins_by);
            $ins_query->bindParam(':var14', $ins_date);
            $ins_query->bindParam(':var15', $ins_time);
            $ins_query->bindParam(':var16', $ins_device);
            $ins_query->bindParam(':var17', $ip);
            $ins_query->execute();
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }

}
$org_query = new organization();
date_default_timezone_set('Asia/Calcutta');
?>