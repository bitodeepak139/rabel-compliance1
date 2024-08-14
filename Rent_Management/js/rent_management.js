function getdataAgreement(url, isset_var, target_div) {
  const id = $("#entity_id").val();
  console.log(id);
  //alert();
  $("#loading").show();
  var formData = new FormData();
  formData.append(isset_var, "1");
  formData.append("entity_id", id);
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
      $("#loading").hide();
      $("#regservice").DataTable({
        scrollX: true,
        bDestroy: true,
        dom: "Bfrtip",
        buttons: ["csv", "excel"],
      });
    },
  });
}

function getdata(url, isset_var, target_div) {
  const id = $("#entity_id").val();
  //alert();
  $("#loading").show();
  var formData = new FormData();
  formData.append(isset_var, "1");
  formData.append("entity_id", id);
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
      $("#loading").hide();
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

function viewpopup(id, url) {
  $("#loading").show();
  $("#mymodal2").modal("hide");
  $.ajax({
    type: "POST",
    url: url,
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#viewdiv").html(data);
      $("#mymodal2").modal("show");
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

function editpopup(id, modal_id, target_id, url) {
  $("#loading").show();
  $(`#${modal_id}`).modal("hide");
  $.ajax({
    type: "POST",
    url: url,
    data: { id: id },
    cache: false,
    success: function (data) {
      $(`#${target_id}`).html(data);
      $(`#${modal_id}`).modal("show");
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
            let getUrl = response[2];
            let getIsset = response[3];
            let targetDiv = response[4];
            if (getUrl != "#" && getIsset != "#" && targetDiv != "#") {
              getdata(getUrl, getIsset, targetDiv);
            }
            let formId = response[5];
            if (formId != "") {
              $(formId).submit();
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
            // if (formId != "") {
            //   // $(formId).submit();
            $("#mymodal1").modal("hide");
            // }
          }
        } else {
          $.toast({
            heading: "Error",
            text: "Task Incomplete",
            position: "top-right",
            loaderBg: "#652322",
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

function getDataForm(url, isset_var, formId, target_div, event) {
  //alert();
  $("#loading").show();
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
      });
    },
  });
}
