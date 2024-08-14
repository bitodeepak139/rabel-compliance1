function getdata(url, isset_var, target_div) {
  //alert();
  //   $("#loading").show();
  var formData = new FormData();
  formData.append(isset_var, "1");
  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (data) {
      //alert(data);
      $(target_div).html(data);
      //   $("#loading").hide();

      $("#regservice").DataTable({
        scrollX: true,
        bDestroy: true,
        dom: "Bfrtip",
        buttons: ["csv", "excel"],
      });
    },
  });
}

function addpopup(url) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: url,
    data: {},
    cache: false,
    success: function (data) {
      $("#mymodal").modal("show");
      $("#adddiv").html(data);
      $("#loading").hide();
    },
  });
}

function adddata(formId, url, isset_var) {
  // event.preventDefault();
  var str = 1;
  if (str == 1) {
    $("#loading").show();
    let form_id = document.getElementById(formId);
    var formData = new FormData(form_id);
    formData.append(isset_var, "1");
    $.ajax({
      type: "POST",
      url: url,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);
        if (isJsonString(data)) {
          let response = JSON.parse(data);
          let status = response[0];
          let msg = response[1];
          if (status == "false") {
            $.toast({
              heading: "Error",
              text: msg,
              position: "top-right",
              loaderBg: "#ff6849",
              icon: "error",
              hideAfter: 3500,
            });
          } else if (status == "true") {
            console.log(response);
            if (response[2] != "#") {
              let getUrl = response[2];
              let getIsset = response[3];
              let target_div = response[4];
              getdata(getUrl, getIsset, target_div);
            }
            $.toast({
              heading: "Success",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "success",
              hideAfter: 3500,
            });
            form_id.reset();
            if (response[3] == "hide") {
              $("#mymodal1").modal("hide");
              getDataForm(
                "ajaxpage/get_data_ajax.php",
                "isset_renew_Certificate",
                "renewCertificate",
                "#datadiv",
                event
              );
            }
            if (response[3] == "hide2") {
              $("#mymodal2").modal("hide");
              getDataForm(
                "ajaxpage/get_data_ajax.php",
                "isset_renew_Certificate",
                "renewCertificate",
                "#datadiv",
                event
              );
            }
            $("#mymodal").modal("hide");
          }
          $("#loading").hide();
        } else {
          $.toast({
            heading: "Error",
            text: "Task Incomplete",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          $("#loading").hide();
        }
      },
    });
  }
}

function editpopup(id, url) {
  $("#loading").show();
  $("#mymodal1").modal("hide");
  $.ajax({
    type: "POST",
    url: url,
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#editdiv").html(data);
      $("#mymodal1").modal("show");
      $("#loading").hide();
    },
  });
}

function step2popup(id, master_id, url) {
  $("#loading").show();
  $("#mymodal2").modal("hide");
  $.ajax({
    type: "POST",
    url: url,
    data: { id: id, master_id: master_id },
    cache: false,
    success: function (data) {
      $("#editdiv2").html(data);
      $("#mymodal2").modal("show");
      $("#loading").hide();
    },
  });
}

function isJsonString(str) {
  try {
    JSON.parse(str);
  } catch {
    return false;
  }
  return true;
}

function edit(id, formId, url, isset_var) {
  var str = 1;
  if (str == 1) {
    $("#loading").show();
    let form_id = document.getElementById(formId);
    var formData = new FormData(form_id);
    formData.append("id", id);
    formData.append(isset_var, "1");
    $.ajax({
      type: "POST",
      url: url,
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);
        if (isJsonString(data)) {
          let response = JSON.parse(data);
          let status = response[0];
          let msg = response[1];
          if (status == "false") {
            $.toast({
              heading: "Error",
              text: msg,
              position: "top-right",
              loaderBg: "#ff6849",
              icon: "error",
              hideAfter: 3500,
            });
            $("#loading").hide();
          } else if (status == "true") {
            console.log(response);
            if (
              response[2] != "#" &&
              response[3] != "#" &&
              response[4] != "#"
            ) {
              let getUrl = response[2];
              let getIsset = response[3];
              let targetDiv = response[4];
              getdata(getUrl, getIsset, targetDiv);
            }

            if (response[5] != "" && response[5] != "#") {
              formId = response[5];
              $(`#${formId}`).submit();
            }

            $.toast({
              heading: "Success",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "success",
              hideAfter: 3500,
            });
            $("#loading").hide();
            $("#mymodal1").modal("hide");
          }
        } else {
          $.toast({
            heading: "Error",
            text: "Task Incomplete",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "error",
            hideAfter: 3500,
          });
          $("#loading").hide();
        }
      },
    });
  }
}

function DependantDropDown(source, target, url, isset_var) {
  let selectedValue = document.getElementById(source).value;
  let dependant = document.getElementById(target);
  var formData = new FormData();
  formData.append("selected_id", selectedValue);
  formData.append(isset_var, "1");
  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (response) {
      console.log(response);
      dependant.innerHTML = response;
    },
  });
}

function addBankDetails() {
  let account_holder_name = $("#account_holder_name").val();
  let account_no = $("#account_no").val();
  let account_type = $("select#account_type option:checked").val();
  let bank_name = $("#bank_name").val();
  let branch_name = $("#branch_name").val();
  let ifsc_code = $("#ifsc_code").val();
  let swift = $("#swift").val();

  if (
    account_holder_name != "" &&
    account_no != "" &&
    account_type != "" &&
    bank_name != "" &&
    branch_name != "" &&
    ifsc_code != ""
  ) {
    var formData = new FormData();
    formData.append("account_holder_name", account_holder_name);
    formData.append("account_no", account_no);
    formData.append("account_type", account_type);
    formData.append("bank_name", bank_name);
    formData.append("branch_name", branch_name);
    formData.append("ifsc_code", ifsc_code);
    formData.append("swift", swift);
    formData.append("isset_addBankDetailsTemp", "1");
    $.ajax({
      type: "POST",
      url: "ajaxpage/addDataajax.php",
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
        if (isJsonString(data)) {
          let response = JSON.parse(data);
          let status = response[0];
          let msg = response[1];
          if (status == "false") {
            $.toast({
              heading: "Error",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "error",
              hideAfter: 3500,
            });
          } else {
            let url = response[2];
            let issetVAR = response[3];
            let targetedDIV = response[4];
            getdata(url, issetVAR, targetedDIV);
            $("#account_holder_name").val("");
            $("#account_no").val("");
            $("select#account_type").val("");
            $("#bank_name").val("");
            $("#branch_name").val("");
            $("#ifsc_code").val("");
            $("#swift").val("");
          }
        } else {
          $.toast({
            heading: "Error",
            text: "Task Incomplete.!!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "error",
            hideAfter: 3500,
          });
        }
      },
    });
  } else {
    if (account_holder_name == "") {
      $("#account_holder_name").css("border", "1px solid red");
    }
    if (account_no == "") {
      $("#account_no").css("border", "1px solid red");
    }
    if (account_type == "") {
      $("#account_type").css("border", "1px solid red");
    }
    if (bank_name == "") {
      $("#bank_name").css("border", "1px solid red");
    }
    if (branch_name == "") {
      $("#branch_name").css("border", "1px solid red");
    }
    if (ifsc_code == "") {
      $("#ifsc_code").css("border", "1px solid red");
    }
    $.toast({
      heading: "Error",
      text: "Please Fill All Required Fields.!!!",
      position: "top-right",
      loaderBg: "#2DB81D",
      icon: "error",
      hideAfter: 3500,
    });
  }
}
function addContactDetails() {
  let person_name = $("#person_name").val();
  let designation = $("#designation").val();
  let contact_no = $("#contact_no").val();
  let contact_no2 = $("#contact_no2").val();
  let landline = $("#landline").val();
  let email_id = $("#email_id").val();
  let remark = $("#remark").val();

  if (person_name != "" && contact_no != "" && email_id != "") {
    var formData = new FormData();
    formData.append("person_name", person_name);
    formData.append("designation", designation);
    formData.append("contact_no", contact_no);
    formData.append("contact_no2", contact_no2);
    formData.append("landline", landline);
    formData.append("email_id", email_id);
    formData.append("remark", remark);
    formData.append("isset_addContactDetailsTemp", "1");
    $.ajax({
      type: "POST",
      url: "ajaxpage/addDataajax.php",
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
        if (isJsonString(data)) {
          let response = JSON.parse(data);
          let status = response[0];
          let msg = response[1];
          if (status == "false") {
            $.toast({
              heading: "Error",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "error",
              hideAfter: 3500,
            });
          } else {
            let url = response[2];
            let issetVAR = response[3];
            let targetedDIV = response[4];
            getdata(url, issetVAR, targetedDIV);
            $("#person_name").val("");
            $("#designation").val("");
            $("#contact_no").val("");
            $("#contact_no2").val("");
            $("#landline").val("");
            $("#email_id").val("");
            $("#remark").val("");
          }
        } else {
          $.toast({
            heading: "Error",
            text: "Task Incomplete.!!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "error",
            hideAfter: 3500,
          });
        }
      },
    });
  } else {
    if (person_name == "") {
      $("#person_name").css("border", "1px solid red");
    }
    if (contact_no == "") {
      $("#contact_no").css("border", "1px solid red");
    }
    if (email_id == "") {
      $("#email_id").css("border", "1px solid red");
    }
    $.toast({
      heading: "Error",
      text: "Please Fill All Required Fields.!!!",
      position: "top-right",
      loaderBg: "#2DB81D",
      icon: "error",
      hideAfter: 3500,
    });
  }
}

function deleteData(variables) {
  // deleteData(['database_table_name', 'database_col_id', 'isset_var'])
  let table_name = variables[0];
  let database_col_id = variables[1];
  let isset_var = variables[2];
  let c = confirm("Do You Really Want to Delete This Data !!!");
  var formData = new FormData();
  formData.append("table_name", table_name);
  formData.append("database_col_id", database_col_id);
  formData.append(isset_var, "1");
  if (c === true) {
    $.ajax({
      type: "POST",
      url: "ajaxpage/DeleteDataajax.php",
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
        if (isJsonString(data)) {
          let response = JSON.parse(data);
          let status = response[0];
          let msg = response[1];
          if (status == "false") {
            $.toast({
              heading: "Error",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "error",
              hideAfter: 3500,
            });
          } else {
            let url = response[2];
            let issetVAR = response[3];
            let targetedDIV = response[4];
            getdata(url, issetVAR, targetedDIV);
          }
        } else {
          $.toast({
            heading: "Error",
            text: "Task Incomplete.!!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "error",
            hideAfter: 3500,
          });
        }
      },
    });
  }
}

function uploadData(formid, isset_var, btnbox, url, event) {
  event.preventDefault();
  let btn_box_data = document.getElementById(btnbox);
  btn_box_data.innerHTML = `Submiting...`;

  var form = document.getElementById(formid);
  var form_data = new FormData(form);
  form_data.append(isset_var, "1");

  $.ajax({
    url: url,
    type: "POST",
    data: form_data,
    contentType: false,
    processData: false,
    cache: false,
    success: function (data) {
      if (isJsonString(data)) {
        let response = JSON.parse(data);
        let status = response[0];
        let msg = response[1];
        if (status == "false") {
          $.toast({
            heading: "Error",
            text: msg,
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
          btn_box_data.innerHTML = `Submit`;
        } else {
          let location = response[2];
          $.toast({
            heading: "Success",
            text: msg,
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });

          window.location.href = location;
          form.reset();
          btn_box_data.innerHTML = `Submit`;
        }
      } else {
        $.toast({
          heading: "Error",
          text: "Task Incomplete",
          position: "top-right",
          loaderBg: "#ff6849",
          icon: "error",
          hideAfter: 3500,
        });
        btn_box_data.innerHTML = `Submit`;
      }
    },
  });
}

function inputWithNumber(id) {
  let input_id = document.getElementById(id);
  input_id.value = input_id.value.replace(/[^0-9]/g, "");
}

$(document).ready(function () {
  $(".js-example-basic-single").select2();
});

function mapestablishmentCompliance() {
  let targetData = document.getElementById("datadiv");
  let entityType = $("#entityType").val();
  let entity = $("#entity_name").val();
  let EntityDetails = entity.split("-");
  let EntityId = EntityDetails[0];
  let EntityName = EntityDetails[1];
  if (entityType != "" && EntityId != "") {
    var formData = new FormData();
    formData.append("entityType", entityType);
    formData.append("entityId", EntityId);
    $.ajax({
      type: "POST",
      url: "ajaxpage/mapestablishment_certificate.php",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        $("#establishmentID").html(EntityId);
        $("#establishmentName").html(EntityName);
        targetData.innerHTML = data;
        $("select.multiselect-ui").multiselect({
          columns: 1,
          selectAll: true,
        });
      },
    });
  } else {
    if (entityType == "") {
      $.toast({
        heading: "Error",
        text: "Select Entity Type",
        position: "top-right",
        loaderBg: "#2DB81D",
        icon: "error",
        hideAfter: 3500,
      });
    } else if (EntityId == "") {
      $.toast({
        heading: "Error",
        text: "Select Entity ",
        position: "top-right",
        loaderBg: "#2DB81D",
        icon: "error",
        hideAfter: 3500,
      });
    }
  }
}

function add_mapestablishment_certi(
  compliance_name,
  compliance_type_id,
  entity_id
) {
  let checkedStatus = $("#Checked-" + compliance_name).is(":checked")
    ? "Yes"
    : "No";
  let select_user_l1 = $("#UserL1-" + compliance_name + " option:selected")
    .toArray()
    .map((item) => item.value)
    .toString();
  let select_user_l2 = $("#UserL2-" + compliance_name + " option:selected")
    .toArray()
    .map((item) => item.value)
    .toString();
  let select_user_l3 = $("#UserL3-" + compliance_name + " option:selected")
    .toArray()
    .map((item) => item.value)
    .toString();
  let select_user_l4 = $("#UserL4-" + compliance_name + " option:selected")
    .toArray()
    .map((item) => item.value)
    .toString();

  $.ajax({
    type: "POST",
    url: "ajaxpage/addDataajax.php",
    data: {
      applicable: checkedStatus,
      compliance_name: compliance_name,
      userL1: select_user_l1,
      userL2: select_user_l2,
      userL3: select_user_l3,
      userL4: select_user_l4,
      complianceTypeID: compliance_type_id,
      EntityId: entity_id,
      isset_mapestablishment_certificate: "1",
    },
    success: function (data) {
      console.log(data);
      if (isJsonString(data)) {
        let response = JSON.parse(data);
        let status = response[0];
        let msg = response[1];
        if (status == "false") {
          $.toast({
            heading: "Error",
            text: msg,
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        } else {
          // let location = response[2];
          $.toast({
            heading: "Success",
            text: msg,
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
        }
      } else {
        $.toast({
          heading: "Error",
          text: "Task Incomplete",
          position: "top-right",
          loaderBg: "#ff6849",
          icon: "error",
          hideAfter: 3500,
        });
      }
    },
  });
}

function getDataForm(url, isset_var, formId, target_div, event) {
  //alert();
  event.preventDefault();
  $("#loading").show();
  let form_id = document.getElementById(formId);
  var formData = new FormData(form_id);
  formData.append(isset_var, "1");
  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (data) {
      console.log(data);
      //alert(data);
      // console.log($(target_div));
      $(target_div).html(data);
      $("#loading").hide();
      $("#regservice").DataTable({
        scrollX: true,
        bDestroy: true,
        dom: "Bfrtip",
        buttons: ["csv", "excel"],
        order: []
      });
    },
  });
}

function AccepetRejectStatus(submissionType, Certificate_id) {
  // let button = document.getElementById(id);
  let remark = document.getElementById("verification_reamark").value;
  if (submissionType == "reject" && remark == "") {
    $.toast({
      heading: "Error",
      text: "Please Enter Remark Of Rejection",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
  } else {
    $.ajax({
      type: "POST",
      url: "ajaxpage/updateajax.php",
      data: {
        certificate_id: Certificate_id,
        remark: remark,
        submissionType: submissionType,
        isset_acceptRejectCertificate: 1,
      },
      success: function (data) {
        console.log(data);
        if (isJsonString(data)) {
          let response = JSON.parse(data);
          let status = response[0];
          let msg = response[1];
          if (status == "false") {
            $.toast({
              heading: "Error",
              text: msg,
              position: "top-right",
              loaderBg: "#ff6849",
              icon: "error",
              hideAfter: 3500,
            });
          } else {
            $.toast({
              heading: "Success",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "success",
              hideAfter: 3500,
            });
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          }
        }
      },
    });
  }

  // if()
}

function calculateTotalAmount(id1, id2) {
  let v1 = document.getElementById(id1).value;
  let v2 = document.getElementById(id2).value;
  v1 = Number(v1);
  v2 = Number(v2);
  let total_amount = v1 + v2;
  target_input = document.getElementById("total_amount");
  target_input.value = total_amount;
}

function renewal_status_form(renewal_status) {
  const status = document.getElementById(renewal_status).value;
  const rejectedFieldContainer = document.getElementById("rejected_field");
  const confirmedFieldContainer = document.getElementById("confirmed_fields");
  if (status === "rejected") {
    rejectedFieldContainer.style.cssText = "display:block";
    confirmedFieldContainer.style.cssText = "display:none";
  } else if (status === "confirmed") {
    confirmedFieldContainer.style.cssText = "display:block";
    rejectedFieldContainer.style.cssText = "display:none";
  } else if (status === "") {
    confirmedFieldContainer.style.cssText = "display:none";
    rejectedFieldContainer.style.cssText = "display:none";
  }
}

function defineKitchenRights(id) {
  const L1_user = $(`#L1_user_${id} option:selected`).val();
  const L2_user = $(`#L2_user_${id} option:selected`).val();
  const L3_user = $(`#L3_user_${id} option:selected`).val();
  const L4_user = $(`#L4_user_${id} option:selected`).val();
  const kitchen_id = id;

  $.ajax({
    type: "POST",
    url: "ajaxpage/addDataajax.php",
    data: {
      L1_user: L1_user,
      L2_user: L2_user,
      L3_user: L3_user,
      L4_user: L4_user,
      kitchen_id: kitchen_id,
      isset_defineKitchenRights: 1,
    },
    success: function (data) {
      if (isJsonString(data)) {
        let response = JSON.parse(data);
        let status = response[0];
        let msg = response[1];
        if (status == "false") {
          $.toast({
            heading: "Error",
            text: msg,
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        } else {
          $.toast({
            heading: "Success",
            text: msg,
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          getDataForm(
            "ajaxpage/get_define_kitchen_rights.php",
            "isset_getDefineKitchenRights",
            "getDefineKitchenRights",
            "#datadiv",
            event
          );
        }
      }
    },
  });
}

function verificationpopup(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/verification_popup.php",
    data: {
      id: id,
    },
    cache: false,
    success: function (data) {
      $("#verificationModal").modal("show");
      $("#verificationModalDiv").html(data);
      $("#loading").hide();
    },
  });
}
function verificationpopupRenew(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/verification_popup_renew.php",
    data: {
      id: id,
    },
    cache: false,
    success: function (data) {
      $("#verificationModal").modal("show");
      $("#verificationModalDiv").html(data);
      $("#loading").hide();
    },
  });
}

function rejectedpopup(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/rejected_popup.php",
    data: {
      id: id,
    },
    cache: false,
    success: function (data) {
      $("#RejectedModal").modal("show");
      $("#RejectedModalDiv").html(data);
      $("#loading").hide();
    },
  });
}
function rejectedpopupRenew(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/rejected_popup_renew.php",
    data: {
      id: id,
    },
    cache: false,
    success: function (data) {
      $("#RejectedModal").modal("show");
      $("#RejectedModalDiv").html(data);
      $("#loading").hide();
    },
  });
}

function AccepetRejectStatusRenew(submissionType, renew_id) {
  // let button = document.getElementById(id);
  let remark = document.getElementById("verification_reamark").value;
  if (submissionType == "reject" && remark == "") {
    $.toast({
      heading: "Error",
      text: "Please Enter Remark Of Rejection",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
  } else {
    $.ajax({
      type: "POST",
      url: "ajaxpage/updateajax.php",
      data: {
        renew_id: renew_id,
        remark: remark,
        submissionType: submissionType,
        isset_acceptRejectRenewCertificate: 1,
      },
      success: function (data) {
        console.log(data);
        if (isJsonString(data)) {
          let response = JSON.parse(data);
          let status = response[0];
          let msg = response[1];
          if (status == "false") {
            $.toast({
              heading: "Error",
              text: msg,
              position: "top-right",
              loaderBg: "#ff6849",
              icon: "error",
              hideAfter: 3500,
            });
          } else {
            $.toast({
              heading: "Success",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "success",
              hideAfter: 3500,
            });
            setTimeout(() => {
              window.location.reload();
            }, 1500);
          }
        }
      },
    });
  }

  // if()
}

function editComplianceCertificate(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/edit_compliance_certificate.php",
    data: {
      id: id,
    },
    cache: false,
    success: function (data) {
      console.log("hello");
      console.log(data);
      $("#mymodal1").modal("show");
      $("#editdiv").html(data);
      $("#loading").hide();
    },
  });
}


function sendWhatsappMsg(alert_id){
  $.ajax({
    type: "POST",
    url: "ajaxpage/send_whatsapp_msg.php",
    data: {
      alert_id: alert_id,
    },
    cache: false,
    success: function (data) {
      // console.log(data);
      if (isJsonString(data)) {
        let response = JSON.parse(data);
        let status = response[0];
        let msg = response[1];
        if (status == "false") {
          $.toast({
            heading: "Error",
            text: msg,
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        } else {
          $.toast({
            heading: "Success",
            text: msg,
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          getdata('ajaxpage/get_data_ajax.php','isset_get_whatsapp_msg_manually','#datadiv');
        }
      }
    },
  });
}

function sendMailMsg(alert_id,btn_id){
  btn_id.innerHTML = "Sending...";
  $.ajax({
    type: "POST",
    url: "ajaxpage/send_mail_msg.php",
    data: {
      alert_id: alert_id,
    },
    cache: false,
    success: function (data) {
      // console.log(data);
      if (isJsonString(data)) {
        let response = JSON.parse(data);
        let status = response[0];
        let msg = response[1];
        if (status == "false") {
          $.toast({
            heading: "Error",
            text: msg,
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
          btn_id.innerHTML = "<i class='fa fa-telegram'></i> Send";
        } else {
          $.toast({
            heading: "Success",
            text: msg,
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          getdata('ajaxpage/get_data_ajax.php','isset_get_mail_msg_manually','#datadiv');
        }
      }
    },
  });
}