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
      $("#regservice").DataTable({ dom: "Bfrtip", buttons: ["csv", "excel"] });
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

function adddata(formId, url, isset_var, event) {
  event.preventDefault();
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
            let getUrl = response[2];
            let getIsset = response[3];
            getdata(getUrl, getIsset);
            $.toast({
              heading: "Success",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "success",
              hideAfter: 3500,
            });
            form_id.reset();
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
            let getUrl = response[2];
            let getIsset = response[3];
            getdata(getUrl, getIsset);
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
      url: "ajaxpage/addDataAjax.php",
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
        console.log(data);
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
      url: "ajaxpage/addDataAjax.php",
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
        console.log(data);
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
        console.log(data);
        if (isJsonString(data)) {
          const response = JSON.parse(data);
          const status = response[0];
          const msg = response[1];
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
            const url = response[2];
            const issetVAR = response[3];
            const targetedDIV = response[4];
            if (
              issetVAR == "isset_bank_details_update" ||
              issetVAR == "isset_contact_details_update"
            ) {
              const entityID = response[5];
              getDataForm(url, issetVAR, entityID, targetedDIV);
            } else {
              getdata(url, issetVAR, targetedDIV);
            }
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
          getdata(
            "ajaxpage/get_data_ajax.php",
            "isset_bank_details_temp",
            "#datadiv"
          );
          getdata(
            "ajaxpage/get_data_ajax.php",
            "isset_contact_details_temp",
            "#resultData"
          );
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
      console.log(data);
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

function getDataFormWithEvent(url, isset_var, formId, target_div, event) {
  event.preventDefault();
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
      if (isJsonString(data)) {
        let response = JSON.parse(data);
        let status = response[0];
        let msg = response[1];
        console.log(response);
        if (status == "false") {
          $.toast({
            heading: "Error",
            text: msg,
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        }
      } else {
        $(target_div).html(data);
        
        $("#regservice").DataTable({
          bDestroy: true,
          dom: "Bfrtip",
          buttons: ["csv", "excel"],
        });
      }
    },
  });
}

function getDataForm(url, isset_var, Id, target_div) {
  //alert();
  $.ajax({
    type: "POST",
    url: url,
    data: { id: Id, isset_var: isset_var },
    success: function (data) {
      console.log(data);
      //alert(data);
      // console.log($(target_div));
      $(target_div).html(data);
      //   $("#loading").hide();
      $("#regservice").DataTable({
        bDestroy: true,
        dom: "Bfrtip",
        buttons: ["csv", "excel"],
      });
    },
  });
}

function addBankDetailsInUpdate(entityID) {
  const account_holder_name = $("#account_holder_name").val();
  const account_no = $("#account_no").val();
  const account_type = $("select#account_type option:checked").val();
  const bank_name = $("#bank_name").val();
  const branch_name = $("#branch_name").val();
  const ifsc_code = $("#ifsc_code").val();
  const swift = $("#swift").val();

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
    formData.append("entityID", entityID);
    formData.append("isset_addBankDetailsUpdate", "1");
    $.ajax({
      type: "POST",
      url: "ajaxpage/addDataAjax.php",
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
        console.log(data);
        if (isJsonString(data)) {
          const response = JSON.parse(data);
          const status = response[0];
          const msg = response[1];
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
            const url = response[2];
            const issetVAR = response[3];
            const targetedDIV = response[4];
            const entityID = response[5];
            getDataForm(url, issetVAR, entityID, targetedDIV);
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
        console.log(data);
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

function addContactDetailsUpdate(entityID) {
  const person_name = $("#person_name").val();
  const designation = $("#designation").val();
  const contact_no = $("#contact_no").val();
  const contact_no2 = $("#contact_no2").val();
  const landline = $("#landline").val();
  const email_id = $("#email_id").val();
  const remark = $("#remark").val();

  if (person_name != "" && contact_no != "" && email_id != "") {
    var formData = new FormData();
    formData.append("person_name", person_name);
    formData.append("designation", designation);
    formData.append("contact_no", contact_no);
    formData.append("contact_no2", contact_no2);
    formData.append("landline", landline);
    formData.append("email_id", email_id);
    formData.append("remark", remark);
    formData.append("entityID", entityID);
    formData.append("isset_addContactDetailsUpdate", "1");
    $.ajax({
      type: "POST",
      url: "ajaxpage/addDataAjax.php",
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
        if (isJsonString(data)) {
          console.log(data);
          const response = JSON.parse(data);
          console.log(response);
          const status = response[0];
          const msg = response[1];
          if (status == "false") {
            $.toast({
              heading: "Error",
              text: msg,
              position: "top-right",
              loaderBg: "#c70039",
              icon: "error",
              hideAfter: 3500,
            });
          } else {
            const url = response[2];
            const issetVAR = response[3];
            const targetedDIV = response[4];
            const entityID = response[5];
            getDataForm(url, issetVAR, entityID, targetedDIV);
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
            loaderBg: "#C70039",
            icon: "error",
            hideAfter: 3500,
          });
        }
        console.log(data);
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
      loaderBg: "#C70039",
      icon: "error",
      hideAfter: 3500,
    });
  }
}

function updateBankDetails(id, entityID) {
  const holder_name = $(`#holder_name_${id}`).val();
  const account_no = $(`#account_no_${id}`).val();
  const account_type = $(`#account_type_${id}`).val();
  const bank_name = $(`#bank_name_${id}`).val();
  const branch_name = $(`#branch_name_${id}`).val();
  const ifsc_code = $(`#ifsc_code_${id}`).val();
  const swift = $(`#swift_code_${id}`).val();

  if (
    holder_name != "" &&
    account_no != "" &&
    account_type != "" &&
    bank_name != "" &&
    branch_name != "" &&
    ifsc_code != ""
  ) {
    var formData = new FormData();
    formData.append("holder_name", holder_name);
    formData.append("account_no", account_no);
    formData.append("account_type", account_type);
    formData.append("bank_name", bank_name);
    formData.append("branch_name", branch_name);
    formData.append("ifsc_code", ifsc_code);
    formData.append("swift", swift);
    formData.append("id", id);
    formData.append("entityID", entityID);
    formData.append("isset_addBankDetailsUpdateSingleRow", "1");
    $.ajax({
      type: "POST",
      url: "ajaxpage/updateajax.php",
      data: formData,
      contentType: false,
      processData: false,
      cache: false,
      success: function (data) {
        console.log(data);
        if (isJsonString(data)) {
          const response = JSON.parse(data);
          const status = response[0];
          const msg = response[1];
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
            const url = response[2];
            const issetVAR = response[3];
            const targetedDIV = response[4];
            const entityID = response[5];
            $.toast({
              heading: "success",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "success",
              hideAfter: 3500,
            });
            getDataForm(url, issetVAR, entityID, targetedDIV);
            $(`#holder_name_${id}`).val("");
            $(`#account_no_${id}`).val("");
            $(`#account_type_${id}`).val("");
            $(`#bank_name_${id}`).val("");
            $(`#branch_name_${id}`).val("");
            $(`#ifsc_code_${id}`).val("");
            $(`#swift_code_${id}`).val("");
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
        console.log(data);
      },
    });
  } else {
    if (holder_name == "") {
      $(`#holder_name_${id}`).css("border", "1px solid red");
    }
    if (account_no == "") {
      $(`#account_no_${id}`).css("border", "1px solid red");
    }
    if (account_type == "") {
      $(`#account_type_${id}`).css("border", "1px solid red");
    }
    if (bank_name == "") {
      $(`#bank_name_${id}`).css("border", "1px solid red");
    }
    if (branch_name == "") {
      $(`#branch_name_${id}`).css("border", "1px solid red");
    }
    if (ifsc_code == "") {
      $(`#ifsc_code_${id}`).css("border", "1px solid red");
    }
    $.toast({
      heading: "Error",
      text: "Please Fill All Required Fields.!!!",
      position: "top-right",
      loaderBg: "#C70039",
      icon: "error",
      hideAfter: 3500,
    });
  }
}

function updateContactDetailsEnt(id, entityID) {
  const person_name = $(`#person_name_${id}`).val();
  const designation = $(`#designation_${id}`).val();
  const mobile1 = $(`#mobile1_${id}`).val();
  const mobile2 = $(`#mobile2_${id}`).val();
  const landline = $(`#landline_${id}`).val();
  const email = $(`#email_${id}`).val();
  const remark = $(`#remark_${id}`).val();

  if (person_name != "" && contact_no != "" && email_id != "") {
    var formData = new FormData();
    formData.append("person_name", person_name);
    formData.append("designation", designation);
    formData.append("contact_no", mobile1);
    formData.append("contact_no2", mobile2);
    formData.append("landline", landline);
    formData.append("email_id", email);
    formData.append("remark", remark);
    formData.append("id", id);
    formData.append("entityID", entityID);
    formData.append("isset_addContactDetailsUpdateSingleRow", "1");
    $.ajax({
      type: "POST",
      url: "ajaxpage/updateajax.php",
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
            let entityID = response[5];
            getdata(url, issetVAR, entityID, targetedDIV);
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
        console.log(data);
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

function print_data(id) {
  let bodydata = document.body.innerHTML;
  let print_box = document.getElementById(id).innerHTML;

  document.body.innerHTML = print_box;
  window.print();
  document.body.innerHTML = bodydata;
}


function adddataSearchContact(formId, url, isset_var, event) {
  event.preventDefault();
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
            
            getDataFormWithEvent('ajaxpage/get_data_ajax.php','isset_searchContact','searchContact','#datadiv',event)
            $("#mymodal1").modal("hide");
            $.toast({
              heading: "Success",
              text: msg,
              position: "top-right",
              loaderBg: "#2DB81D",
              icon: "success",
              hideAfter: 3500,
            });

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
