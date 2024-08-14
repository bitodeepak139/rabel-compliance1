<?php
function get_item_validation() {
if($_POST['process'] == '') {
$validate=0; $errormsg='Item Process Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['itmname'] == '') {
$validate=0; $errormsg='Item Name Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['munit'] == '') {
$validate=0; $errormsg='Measure Unit Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
/*else if($_POST['hsn'] == '') {
$validate=0; $errormsg='HSN/SAC Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['sqty'] == '') {
$validate=0; $errormsg='Special Qunatity Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}*/
else if($_POST['qty'] == '') {
$validate=0; $errormsg='Qunatity Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['price'] == '') {
$validate=0; $errormsg='Unit Price Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['hastax'] == '') {
$validate=0; $errormsg='Has Direct Tax Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else if($_POST['gstrate'] == '') {
$validate=0; $errormsg='GST Rate Required..!!';
return array('v' => $validate, 'e' => $errormsg); 
}
else   {
$validate=1; $errormsg=''; 
return array('v' => $validate, 'e' => $errormsg);
}
}
?>