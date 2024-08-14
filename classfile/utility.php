<?php
class UTILITY
{
    public function get_country_data($conn)
    {
        try 
        {
            $query="select a.* from utm_add_country a order by a.country_name ";			
			$select_query=$conn->prepare($query);		    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            if ( $rowcount > 0) {
                $data = $select_query->fetchAll(PDO::FETCH_ASSOC);
                return $data;}
            else  return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
	public function check_country_code_name($conn,$val,$type)
    {
        try 
        {
            if($type=='code')  $select_query=$conn->prepare("select a.id from utm_add_country a  where a.country_code='".$val."' ");
            else $select_query=$conn->prepare("select a.id from utm_add_country a  where a.country_name='".$val."' ");	    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_country_data($conn,$code,$name,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip)
	{
	try 
        {
            $select_query=$conn->prepare("select a.id from utm_add_country a order by a.id desc limit 1 ");	    
            $select_query->execute();
            $row=$select_query->fetch();
            $maxid=$row['id']+1;
            $primary_id='UTM-C'.$maxid;

            $query = "INSERT INTO utm_add_country (pk_utm_country_id,country_code,country_name,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9)";
            $ins_query=$conn->prepare($query);
            $ins_query->bindParam(':var1',$primary_id);
            $ins_query->bindParam(':var2',$code);
            $ins_query->bindParam(':var3',$name);
            $ins_query->bindParam(':var4',$status);
            $ins_query->bindParam(':var5',$ins_by);
            $ins_query->bindParam(':var6',$ins_date);
            $ins_query->bindParam(':var7',$entry_type);
            $ins_query->bindParam(':var8',$ins_device);
            $ins_query->bindParam(':var9',$ip);
            $ins_query->execute();
		}
		catch (Exception $exception) {
        echo "Execution error: " . $exception->getMessage();
        }
	}
    public function get_country_editpopup($conn,$id)
    {
        try 
        {
            $query="select a.* from utm_add_country a where a.id=$id ";			
			$select_query=$conn->prepare($query);		    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            if ( $rowcount > 0) {
                $data = $select_query->fetch(PDO::FETCH_ASSOC);
                return $data;}
            else  return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function update_country_data($conn,$id,$code,$name,$ins_by,$ins_date,$ins_device,$ip)
	{
	try 
        {
            $update_query=$conn->prepare("update utm_add_country set country_code=:var1, country_name=:var2, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1',$code);
            $update_query->bindParam(':var2',$name);
            $update_query->bindParam(':var3',$ins_by);
            $update_query->bindParam(':var4',$ins_date);
            $update_query->bindParam(':var5',$ins_device);
            $update_query->bindParam(':var6',$ip);
            $update_query->bindParam(':updid',$id);
            $update_query->execute();
		}
		catch (Exception $exception) {
        echo "Execution error: " . $exception->getMessage();
        }
	}	
	//end country method
    public function get_country_select($conn)
    {
        try 
        {
            $query="select a.pk_utm_country_id,a.country_name from utm_add_country a where a.transaction_status=1 order by a.country_name ";			
			$select_query=$conn->prepare($query);		    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            if ( $rowcount > 0) {
                $data = $select_query->fetchAll(PDO::FETCH_ASSOC);
                return $data;}
            else  return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_state_data($conn)
    {
        try 
        {
            $query="select a.*,b.country_name from utm_add_state a left join utm_add_country as b on b.pk_utm_country_id=a.fk_utm_country_id order by b.country_name,a.pk_utm_state_id";			
			$select_query=$conn->prepare($query);		    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            if ( $rowcount > 0) {
                $data = $select_query->fetchAll(PDO::FETCH_ASSOC);
                return $data;}
            else  return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
	public function check_state_name($conn,$id,$name)
    {
        try 
        {
            $select_query=$conn->prepare("select a.id from utm_add_state a  where a.fk_utm_country_id='".$id."' and a.state_name='".$name."' ");	    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_state_data($conn,$code,$name,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip)
	{
	try 
        {
            $select_query=$conn->prepare("select a.id from utm_add_state a order by a.id desc limit 1 ");	    
            $select_query->execute();
            $row=$select_query->fetch();
            $maxid=$row['id']+1;
            $primary_id='UTM-S'.$maxid;

            $query = "INSERT INTO utm_add_state (pk_utm_state_id,fk_utm_country_id,state_name,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9)";
            $ins_query=$conn->prepare($query);
            $ins_query->bindParam(':var1',$primary_id);
            $ins_query->bindParam(':var2',$code);
            $ins_query->bindParam(':var3',$name);
            $ins_query->bindParam(':var4',$status);
            $ins_query->bindParam(':var5',$ins_by);
            $ins_query->bindParam(':var6',$ins_date);
            $ins_query->bindParam(':var7',$entry_type);
            $ins_query->bindParam(':var8',$ins_device);
            $ins_query->bindParam(':var9',$ip);
            $ins_query->execute();
		}
		catch (Exception $exception) {
        echo "Execution error: " . $exception->getMessage();
        }
	}
    public function get_state_editpopup($conn,$id)
    {
        try 
        {
            $query="select a.* from utm_add_state a where a.id=$id ";			
			$select_query=$conn->prepare($query);		    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            if ( $rowcount > 0) {
                $data = $select_query->fetch(PDO::FETCH_ASSOC);
                return $data;}
            else  return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function update_state_data($conn,$id,$code,$name,$ins_by,$ins_date,$ins_device,$ip)
	{
	try 
        {
            $update_query=$conn->prepare("update utm_add_state set fk_utm_country_id=:var1, state_name=:var2, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1',$code);
            $update_query->bindParam(':var2',$name);
            $update_query->bindParam(':var3',$ins_by);
            $update_query->bindParam(':var4',$ins_date);
            $update_query->bindParam(':var5',$ins_device);
            $update_query->bindParam(':var6',$ip);
            $update_query->bindParam(':updid',$id);
            $update_query->execute();
		}
		catch (Exception $exception) {
        echo "Execution error: " . $exception->getMessage();
        }
	}	
	//end state method
    public function get_state_select($conn,$id)
    {
        try 
        {
            $query="select a.pk_utm_state_id,a.state_name from utm_add_state a where a.transaction_status=1 and a.fk_utm_country_id='".$id."' order by a.state_name ";			
			$select_query=$conn->prepare($query);		    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            if ( $rowcount > 0) {
                $data = $select_query->fetchAll(PDO::FETCH_ASSOC);
                return $data;}
            else  return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_city_data($conn)
    {
        try 
        {
            $query="select a.*,b.country_name,c.state_name from utm_add_city a left join utm_add_country as b on b.pk_utm_country_id=a.fk_utm_country_id left join utm_add_state as c on c.pk_utm_state_id=a.fk_utm_state_id order by b.country_name,a.fk_utm_state_id,a.pk_utm_city_id ";			
			$select_query=$conn->prepare($query);		    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            if ( $rowcount > 0) {
                $data = $select_query->fetchAll(PDO::FETCH_ASSOC);
                return $data;}
            else  return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
	public function check_city_name($conn,$id,$name)
    {
        try 
        {
            $select_query=$conn->prepare("select a.id from utm_add_city a  where a.fk_utm_state_id='".$id."' and a.city_name='".$name."' ");	    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function insert_city_data($conn,$code,$state,$name,$status,$ins_by,$ins_date,$entry_type,$ins_device,$ip)
	{
	try 
        {
            $select_query=$conn->prepare("select a.id from utm_add_city a order by a.id desc limit 1 ");	    
            $select_query->execute();
            $row=$select_query->fetch();
            $maxid=$row['id']+1;
            $primary_id='UTM-CT'.$maxid;

            $query = "INSERT INTO utm_add_city (pk_utm_city_id,fk_utm_country_id,city_name,transaction_status,ins_by,ins_date,entry_type,ins_device,ins_ip,fk_utm_state_id) 
            VALUES(:var1,:var2,:var3,:var4,:var5,:var6,:var7,:var8,:var9,:var10)";
            $ins_query=$conn->prepare($query);
            $ins_query->bindParam(':var1',$primary_id);
            $ins_query->bindParam(':var2',$code);
            $ins_query->bindParam(':var3',$name);
            $ins_query->bindParam(':var4',$status);
            $ins_query->bindParam(':var5',$ins_by);
            $ins_query->bindParam(':var6',$ins_date);
            $ins_query->bindParam(':var7',$entry_type);
            $ins_query->bindParam(':var8',$ins_device);
            $ins_query->bindParam(':var9',$ip);
            $ins_query->bindParam(':var10',$state);
            $ins_query->execute();
		}
		catch (Exception $exception) {
        echo "Execution error: " . $exception->getMessage();
        }
	}
    public function get_city_editpopup($conn,$id)
    {
        try 
        {
            $query="select a.* from utm_add_city a where a.id=$id ";			
			$select_query=$conn->prepare($query);		    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            if ( $rowcount > 0) {
                $data = $select_query->fetch(PDO::FETCH_ASSOC);
                return $data;}
            else  return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function update_city_data($conn,$id,$code,$name,$ins_by,$ins_date,$ins_device,$ip)
	{
	try 
        {
            $update_query=$conn->prepare("update utm_add_city set fk_utm_state_id=:var1, city_name=:var2, update_by=:var3, update_date=:var4, update_device=:var5, update_ip=:var6 where id=:updid");
            $update_query->bindParam(':var1',$code);
            $update_query->bindParam(':var2',$name);
            $update_query->bindParam(':var3',$ins_by);
            $update_query->bindParam(':var4',$ins_date);
            $update_query->bindParam(':var5',$ins_device);
            $update_query->bindParam(':var6',$ip);
            $update_query->bindParam(':updid',$id);
            $update_query->execute();
		}
		catch (Exception $exception) {
        echo "Execution error: " . $exception->getMessage();
        }
	}	
	//end city method
}
$utility_query = new UTILITY();
date_default_timezone_set('Asia/Calcutta');
?>
