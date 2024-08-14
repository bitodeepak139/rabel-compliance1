<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/configuration_management.php";
$retval=$org_query->get_organization_data($conn);
if($retval != 0) {
?>

<div class="box">            
            <!-- /.box-header -->
            <div class="box-body">			
              <table id="regservice" class="table table-bordered table-hover display nowrap margin-top-10 table-responsive">
				<thead>
					<tr>
						<th width='8%'>Sr. No</th>
						<th>Name</th>
						<th>Contact</th>
						<th>Email</th>
						<th  width='10%'>Status</th>
						<th width='9%'>Action</th>				
					</tr>
				</thead>
				<tbody>
				<?php
				$slno=1; $passname="cnf_add_organization-"."transaction_status";
				foreach($retval as $row){
				$id=$row['id']; $org_name=$row['organization_name']; $contact=$row['primary_contact_no']; $status=$row['transaction_status']; $stypeid="id-".$id;	
				$email=$row['email'];			
				?>
					<tr>
						<td><?php echo $slno ?></td>
						<td><?php echo $org_name ?></td>
						<td><?php echo $contact ?></td>
						<td><?php echo $email ?></td>
						<?php
						if($status=='1') echo '<td> <span class="label-success label label-default">Active</span></td>';
                        else echo '<td> <span class="label-default label label-danger">Block</span></td>';
						?>						
						<td><a href='javascript:void(0)' class='btn btn-danger btn-xs' id='blk<?php echo $stypeid; ?>'onClick="block('<?php echo $stypeid; ?>','<?php echo $passname; ?>','4')"  <?php if($status==0) { ?> style="display:none" <?php } ?> title="Block Record">B</a>
						<a href='javascript:void(0)' class='btn btn-info btn-xs' id='act<?php echo $stypeid; ?>'  onclick="actived('<?php echo $stypeid; ?>','<?php echo $passname; ?>','4')"  <?php if($status==1) { ?> style="display:none" <?php } ?> title="Active Record">A</a>
						<a href="javascript:void(0)" class="btn btn-warning btn-xs" onClick="editpopup('<?php echo $id ?>')" id="edt<?php echo $id ?>" title="Edit Details">E</a>
						<a href="javascript:void(0)" class="btn btn-success btn-xs" onClick="viewpopup('<?php echo $id ?>')" id="view<?php echo $id ?>" title="View Details">V</a>
						</td>					
					</tr>
					<?php $slno++; } ?>					
				</tbody>				
			</table>			
            
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box --> 
		  <?php } else echo '<p>No Organization Added Yet.!</p>'; ?>  