<?php
class LOGIN
{
    public function get_login_data($conn,$username,$pass)
    {
        try 
        {           		
			$query="select a.* from usm_add_users a where a.user_login_id=:var1 and user_password=:var2 ";			
			$select_query=$conn->prepare($query);	
            $select_query->bindParam(':var1',$username);
            $select_query->bindParam(':var2',$pass);
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
	public function check_login_username_password($conn,$username,$pass)
    {
        try 
        {
            $query="select a.pk_usm_user_id from usm_add_users a where a.user_login_id=:var1 and user_password=:var2 ";			
			$select_query=$conn->prepare($query);	
            $select_query->bindParam(':var1',$username);
            $select_query->bindParam(':var2',$pass);	    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }	
    // public function get_current_session($conn)
    // {
    //     try 
    //     {
    //         $query="select a.id,a.pk_cnf_session_id,a.session_name from cnf_add_session a where a.transaction_status=1 order by a.id desc limit 1 ";			
	// 		$select_query=$conn->prepare($query);		    
    //         $select_query->execute();
    //         $rowcount=$select_query->rowCount();
    //         if ( $rowcount > 0) {
    //             $data = $select_query->fetch(PDO::FETCH_ASSOC);
    //             return $data;}
    //         else  return $rowcount;            
    //     } catch (Exception $exception) {
    //         echo "Execution error: " . $exception->getMessage();
    //     }
    // }	
    public function check_teacher_login_username_password($conn,$username,$pass)
    {
        try 
        {
            $query="select a.pk_teacher_id from tch_teacher_master a where a.mobile_no=:var1 and password=:var2 ";	
            $select_query=$conn->prepare($query);	
            $select_query->bindParam(':var1',$username);
            $select_query->bindParam(':var2',$pass);	    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_teacher_login_data($conn,$username,$pass)
    {
        try 
        {
            $query="select a.* from tch_teacher_master a where a.mobile_no=:var1 and password=:var2 ";	
            $select_query=$conn->prepare($query);	
            $select_query->bindParam(':var1',$username);
            $select_query->bindParam(':var2',$pass);					    
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
    public function check_studentr_login_username_password($conn,$username,$pass)
    {
        try 
        {
            $query="select a.id from std_student_master a  where a.pk_user_id=:var1 and password=:var2 ";	
            $select_query=$conn->prepare($query);	
            $select_query->bindParam(':var1',$username);
            $select_query->bindParam(':var2',$pass);	    
            $select_query->execute();
            $rowcount=$select_query->rowCount();
            return $rowcount;            
        } catch (Exception $exception) {
            echo "Execution error: " . $exception->getMessage();
        }
    }
    public function get_student_login_data($conn,$username,$pass)
    {
        try 
        {
            $query="select a.* from std_student_master a  where a.pk_user_id=:var1 and password=:var2 ";
            $select_query=$conn->prepare($query);	
            $select_query->bindParam(':var1',$username);
            $select_query->bindParam(':var2',$pass);					    
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
	//end login method
}
$login_query = new LOGIN();
?>
