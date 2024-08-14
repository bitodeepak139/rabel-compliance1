<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
require_once "../../classfile/initialize.php";
require_once "../../classfile/compliance_certificate_management.php";

if (isset($_POST['isset_gridStatusReport'])) {
  $zone = trim($_POST['zone']);
  $status = trim($_POST['status']);
  $establishmentType = trim($_POST['establishmentType']);
  $establishment = trim($_POST['establishment']);
  $certificate_type = trim($_POST['certificate_type']);
  $verfication_status = trim($_POST['verfication_status']);
  $entity_arr = explode("-", $establishment);
  $entity_id = $entity_arr[0];

  $ccm_query->debug($_POST);

?>
  <div class="box-body ">
    <div class="table-responsive">
      <table id="regservice" class="table table-bordered table-hover display nowrap " style="width:100%">
        <thead>
          <tr style>
            <th scope='col'>S.No</th>
            <th scope='col'>Certificate<i class="invisible">_</i>Date</th>
            <th scope='col'>Certificate<i class="invisible">_</i>Type</th>
            <th scope='col'>Certificate<i class="invisible">_</i>No</th>
            <th scope='col'>Establishment<i class="invisible">_</i>Code</th>
            <th scope='col'>Establishment<i class="invisible">_</i>Name</th>
            <th scope='col'>Verification<i class="invisible">_</i>Status</th>
            <th scope='col'>Licence<i class="invisible">_</i>Nominee</th>
            <th scope='col'>Certificate<i class="invisible">_</i>File</th>
            <th scope='col'>Renewal<i class="invisible">_</i>Due<i class="invisible">_</i>Date</th>
            <th scope='col'>Expiry<i class="invisible">_</i>Date</th>
            <th scope='col'>Expiry<i class="invisible">_</i>Date<i class="invisible">_</i>Status</th>
            <th scope='col'>Uploaded<i class="invisible">_</i>By</th>
            <th scope='col'>Verification<i class="invisible">_</i>Status</th>
            <th scope='col'>Verified<i class="invisible">_</i>By</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $dataToPrint = array();
          $currentDate = date('d-m-Y');


          $condition = '';
          if ($_SESSION['user_id'] == 'USM-U1') {
            $condition .= " a.fk_sfa_ent_entity_id IN (SELECT pk_sfa_ent_entity_id FROM sfa_ent_mst_entity WHERE pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE l4_user='USM-U28' AND transaction_status='1')) AND a.fk_cpl_compliancetype_id IN ( SELECT pk_cpl_compliancetype_id FROM cpl_compliance_type WHERE transaction_status='1' AND compliance_type='Compliance') AND a.transaction_status='1'";
          } else {
            // get the level of user
            $userLevel = $abc->fetch_data($conn, "usm_add_users", "user_level", "pk_usm_user_id='$_SESSION[user_id]'");

            $condition .= "  a.transaction_status='1' and a.fk_sfa_ent_entity_id IN (SELECT pk_sfa_ent_entity_id FROM sfa_ent_mst_entity WHERE pk_sfa_ent_entity_id IN (SELECT kitchen_id FROM cpl_define_kitchen_rights WHERE ";

            if ($userLevel[0]['user_level'] == 'L1') {
              $condition .= "l1_user='$_SESSION[user_id]' AND transaction_status='1')";
            }
            if ($userLevel[0]['user_level'] == 'L2') {
              $condition .= "l2_user='$_SESSION[user_id]' AND transaction_status='1')";
            }
            if ($userLevel[0]['user_level'] == 'L3') {
              $condition .= "l3_user='$_SESSION[user_id]' AND transaction_status='1')";
            }
            if ($userLevel[0]['user_level'] == 'L4') {
              $condition .= "l4_user='$_SESSION[user_id]' AND transaction_status='1')";
            }

            $condition .= " ) AND a.fk_cpl_compliancetype_id IN ( SELECT pk_cpl_compliancetype_id FROM cpl_compliance_type WHERE transaction_status='1' AND compliance_type='Compliance') AND a.transaction_status='1'";
          }
          if ($zone != '') {
            $condition .= " AND b.zone_id='$zone'";
          }
          if ($establishmentType != '') {
            $condition .= " AND b.fk_sfa_cnf_entitytype_id='$establishmentType'";
          }
          if ($entity_id != '') {
            $condition .= " AND a.fk_sfa_ent_entity_id='$entity_id'";
          }
          if ($certificate_type != '') {
            $condition .= " AND a.fk_cpl_compliancetype_id='$certificate_type'";
          }

          if ($status == 'all') {
            // $totalCondition = $condition . " AND a.compliance_applicable='Yes'";
            // $total = $abc->fetch_data($conn, "cpl_establishment_compliance as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", " a.*,b.entity_name ", $totalCondition);
            // $dataToPrint = $total;
            // // $ccm_query->debug($dataToPrint);
            // $sno = 1;
            // foreach ($dataToPrint as $d) {
            //   $ccm_query->debug($d);
            //   $Kstatus = '';
            //   // if ($d['verification_status'] == '0') {
            //   //   $Kstatus = '<span class="badge bg-warning">Pending</span>';
            //   // } else if ($d['verification_status'] == '-1') {
            //   //   $Kstatus = 'Rejected';
            //   // } else if ($d['verification_status'] == '1') {
            //   //   $Kstatus = 'Verified';
            //   // }

            //   $fetchComplianceData = $ccm_query->fetch_data($conn,"cpl_compliance_master","*","fk_sfa_ent_entity_id='$d[fk_sfa_ent_entity_id]' AND fk_cpl_compliancetype_id='$d[fk_cpl_compliancetype_id]' AND transaction_status='1'");
            //   if($fetchComplianceData != 0){
            //     if($fetchComplianceData[0]['verification_status'] == '0'){
            //       $Kstatus = '<span class="badge bg-warning">Pending</span>';
            //     }else if($fetchComplianceData[0]['verification_status'] == '-1'){
            //       $Kstatus = '<span class="badge bg-danger">Rejected</span>';
            //     }else if($fetchComplianceData[0]['verification_status'] == '1'){
            //       $Kstatus = '<span class="badge bg-success">Verified</span>';
            //     }
            //   }else{
            //     $Kstatus = '<span class="badge bg-black">Not Update</span>';
            //   }

            $fetchComplianceData = $ccm_query->fetch_data($conn,"cpl_compliance_master","*"," transaction_status='1' AND verification_status='0'");
            $sno = 1;
            foreach($fetchComplianceData as $d){
              echo "<tr>
            <td>$sno</td>
            <td>$d[certification_date]</td>
            <td>$d[fk_cpl_compliancetype_id]</td>
            <td>$d[certificate_no]</td>
            <td>$d[fk_sfa_ent_entity_id]</td>
            <td>$d[fk_sfa_ent_entity_id]</td>
            <td>$d[verification_status]</td>
            <td>$d[licence_nominee]</td>
            <td>CertificateFile</td>
            <td>RenewalDueDate</td>
            <td>$d[expiry_date]</td>
            <td>ExpiryDateStatus</td>
            <td>UploadedBy</td>
            <td>VerificationStatus</td>
            <td>VerifiedBy</td>
          </tr>";
              $sno++;
            }
          } else if ($status == 'not_updated') {
            $notCondition = $condition . " AND a.compliance_applicable='Yes' AND NOT EXISTS (SELECT * FROM cpl_compliance_master WHERE cpl_compliance_master.fk_sfa_ent_entity_id = cpl_establishment_compliance.fk_sfa_ent_entity_id AND cpl_compliance_master.fk_cpl_compliancetype_id = cpl_establishment_compliance.fk_cpl_compliancetype_id) AND transaction_status='1'";
            $notUP = $abc->fetch_data($conn, "cpl_establishment_compliance as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", " * ", $notCondition);
            $dataToPrint = $notUP;
          } else if ($status == 'complied') {
            $compliedCondition = $condition . " AND a.verification_status='1' AND str_to_date(a.expiry_date,'%d-%m-%Y') > str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.renew_due_date_l1,'%d-%m-%Y') > str_to_date('$currentDate','%d-%m-%Y') AND a.transaction_status='1'";
            $complied = $abc->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "*", $compliedCondition);
            $dataToPrint = $complied;
          } else if ($status == 'expiring_soon') {
            $expiringSoonCondition = $condition . " AND a.verification_status='1'  AND str_to_date(a.expiry_date,'%d-%m-%Y') >= str_to_date('$currentDate','%d-%m-%Y') AND str_to_date(a.renew_due_date_l1,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y')";
            $expiring = $abc->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "*", $expiringSoonCondition);
            $dataToPrint = $expiring;
          } else if ($status == 'expired') {
            $expiredCondition = $condition . " AND a.verification_status='1' AND str_to_date(a.expiry_date,'%d-%m-%Y') < str_to_date('$currentDate','%d-%m-%Y')";
            $expired = $abc->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "*", $expiredCondition);
            $dataToPrint = $expired;
          } else if ($status == 'todays_renewal') {
            $todaysRenewalCondition = $condition . " AND a.verification_status='1' AND a.expiry_date = '$currentDate'";
            $todaysRenewal = $abc->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "*", $todaysRenewalCondition);
            $dataToPrint = $todaysRenewal;
          }

          if ($verfication_status  == '0') {
            $pendingCondition = $condition . " AND a.verification_status='0' ";
            $pendingVerificaton = $abc->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "*", $pendingCondition);
            $dataToPrint = $pendingVerificaton;
          } else if ($verfication_status  == '-1') {
            $rejectedCondition = $condition . " AND a.verification_status='-1' ";
            $rejected = $abc->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "*", $rejectedCondition);
            $dataToPrint = $rejected;
          } else if ($verfication_status  == '1') {
            $verificatioCondition = $condition . " AND a.verification_status='1'";
            $verified = $abc->fetch_data($conn, "cpl_compliance_master as a left join sfa_ent_mst_entity  as b on a.fk_sfa_ent_entity_id=b.pk_sfa_ent_entity_id", "*", $verificatioCondition);
            $dataToPrint = $verified;
          }























          // $expiredCondition = $verificatioCondition . " AND expiry_date < '$currentDate'";
          // $expired = $abc->fetch_data($conn, "cpl_compliance_master", "*", $expiredCondition);

          // $todaysRenewalCondition = $verificatioCondition . " AND expiry_date = '$currentDate'";
          // $todaysRenewal = $abc->fetch_data($conn, "cpl_compliance_master", "*", $todaysRenewalCondition);




          ?>
        </tbody>
      </table>
    </div>
  </div>
<?php
}
