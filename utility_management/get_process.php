<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} 
include "../admin/conn.php";
$id=$_POST['id']; $user_id=$_SESSION['client_id'];
$type=strtolower($id);
if($type=='manufacturing'){
?>

<div class="form-group row">
  <label for="example-text-input" class="col-sm-12 col-form-label">Consumption Per Unit</label>
</div>
<hr />
<div class="form-group row">
  <label for="example-text-input" class="col-sm-2 col-form-label">Select Item Name<span class="text-danger">*</span></label>
  <div class="col-sm-3">
  <input type="text" name="spcname" id="spcname" class="form-control" placeholder="Type Item Name" onchange="getmeasureunt(this.value)" />	
  </div>
  <label for="example-text-input" class="col-sm-2 col-form-label">Measure Unit</label>
  <div class="col-sm-3"><span id="munit1">&nbsp;</span>
  </div>
  </div>
  <div class="form-group row">
  <label for="example-text-input" class="col-sm-2 col-form-label">Special Qunatity</label>
  <div class="col-sm-3">
    <input type="text" name="spcqty" id="spcqty" class="form-control">
  </div>
  <label for="example-text-input" class="col-sm-2 col-form-label">Qunatity<span class="text-danger">*</span></label>
  <div class="col-sm-3">
    <input type="text" name="quantity" id="quantity" class="form-control">
  </div>   
  <div class="col-sm-2"> <a href="javascript:void(0)" onclick="adddata()" class="btn btn-info btn-lg">Add List</a> </div>
</div>
<?php }  ?>
