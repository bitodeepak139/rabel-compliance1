function checkStatusContactMIS(id, targetDiv, data) {
  const allCheckedOption = document.querySelectorAll(".contactMisCheck");
  allCheckedOption.forEach((element) => {
    if (id == `#${element.id}`) {
      element.checked = true;
      $.ajax({
        type: "POST",
        url: "ajaxpage/getcontactMIS.php",
        data: {data : data},
        success: function (response) {
          $(targetDiv).html(response);
        }
      });
    } else {
      element.checked = false;
    }
  });
}


function viewpopup(id) {
  console.log(id);
  $("#loading").show();
  $("#mymodal2").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/contactMIS_view_popup.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#viewdiv").html(data);
      $("#mymodal2").modal("show");
      $("#loading").hide();
    },
  });
}

function ContactEdit(id, formId, url, isset_var) {
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
            let selectedID = response[2];
            let selectedLetter = response[3];
            checkStatusContactMIS(selectedID,'#datadiv', selectedLetter)
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

function individual_bulk_Update(id,target_tr){
  const state = $(`#state${id}`).val();
  const district = $(`#district${id}`).val();
  const zone = $(`#zone${id}`).val();
  const region = $(`#region${id}`).val();
  const gst_no = $(`#gst_no${id}`).val();
  const email = $(`#email${id}`).val();
  const mobile = $(`#mobile${id}`).val();

  if (state != '' && district != '' && zone != '' && region != '' && gst_no != '') {
    var formData = new FormData();
    formData.append("state",state);
    formData.append("district",district);
    formData.append("zone",zone);
    formData.append("region",region);
    formData.append("gst_no",gst_no);
    formData.append("email",email);
    formData.append("mobile",mobile);
    formData.append("id", id);
    formData.append("isset_individual_bulk_update_SingleRow", "1");
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
    if (state == "") {
      $(`#state${id}`).css("border", "1px solid red");
    }
    if (district == "") {
      $(`#district${id}`).css("border", "1px solid red");
    }
    if (zone == "") {
      $(`#zone${id}`).css("border", "1px solid red");
    }
    if (region == "") {
      $(`#region${id}`).css("border", "1px solid red");
    }
    if (gst_no == "") {
      $(`#gst_no${id}`).css("border", "1px solid red");
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