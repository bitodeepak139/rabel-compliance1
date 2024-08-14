// <!-- ========== Check Data is JSON type or Not Start Section ========== -->
function isJsonString(str) {
  try {
    JSON.parse(str);
  } catch {
    return false;
  }
  return true;
}
// <!-- ========== Check Data is JSON type or Not End Section ========== -->

// <!-- ========== Upload function Code Start Section ========== -->
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
          $.toast({
            heading: "Success",
            text: msg,
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          btn_box_data.innerHTML = `Submit`;
          form.reset();
          window.location.reload();
        }
      } else {
        $.growl.error({
          message: "Task Incomplete",
        });
        btn_box_data.innerHTML = `Submit`;
      }
    },
  });
}
// <!-- ========== Upload function Code End Section ========== -->

function ImagePreview(ImageId, event) {
  let previewImageId = document.getElementById(ImageId);
  previewImageId.src = URL.createObjectURL(event.target.files[0]);
  previewImageId.onload = function () {
    URL.revokeObjectURL(previewImageId.src); // free memory
  };
}

function getdata() {
  //alert();
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/org_get_data.php",
    data: {},
    cache: false,
    success: function (data) {
      //alert(data);
      $("#datadiv").html(data);
      $("#loading").hide();
      $("#regservice").DataTable({ dom: "Bfrtip", buttons: ["csv", "excel"] });
    },
  });
}
function addpopup() {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/org_add_popup.php",
    data: {},
    cache: false,
    success: function (data) {
      $("#mymodal").modal("show");
      $("#adddiv").html(data);
      $("#loading").hide();
      $("#file").change(function () {
        var ext1 = this.value.match(/\.(.+)$/)[1];
        ext = ext1.toLowerCase();
        var size1 = this.files[0].size;
        if (ext == "jpeg" || ext == "jpg" || ext == "png") {
          if (size1 > 100000) {
            $.toast({
              heading: "Error",
              text: "File Size Exceed, Select Maximum 100Kb File..!!",
              position: "top-right",
              loaderBg: "#ff6849",
              icon: "error",
              hideAfter: 3500,
            });
            this.value = "";
            return false;
          }
        } else {
          $.toast({
            heading: "Error",
            text: "Select only jpg png and jpeg file..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
          this.value = "";
          return false;
        }
      });
    },
  });
}
function getstate(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/get_state.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#city").val("");
      $("#statediv").html(data);
      $("#loading").hide();
    },
  });
}
function getcity(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/get_city.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#citydiv").html(data);
      $("#loading").hide();
    },
  });
}
function adddata() {
  var str = check();
  if (str == 1) {
    $("#loading").show();
    var s1, s2;
    s1 = $("#country option:selected").val();
    s2 = $("#cntname").val();
    s3 = $("#state option:selected").val();
    s4 = $("#city option:selected").val();
    s5 = $("#address").val();
    s6 = $("#phone").val();
    s7 = $("#altno").val();
    s8 = $("#email").val();
    s9 = $("#website").val();
    var formData = new FormData();
    formData.append("country", s1);
    formData.append("name", s2);
    formData.append("state", s3);
    formData.append("city", s4);
    formData.append("address", s5);
    formData.append("phone", s6);
    formData.append("altno", s7);
    formData.append("email", s8);
    formData.append("website", s9);
    formData.append("file", $("#file")[0].files[0]);
    $.ajax({
      type: "POST",
      url: "ajaxpage/org_add_qy.php",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        //alert(data);
        if (data == 1) {
          getdata();
          $.toast({
            heading: "Success",
            text: "Organization Details Added Successfully..!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          $("#country").val("");
          $("#cntname").val("");
          $("#mymodal").modal("hide");
        } else if (data == 2)
          $.toast({
            heading: "Error",
            text: "Organization Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "Organization Contact No. Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: "Logo Required..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 0)
          $.toast({
            heading: "Error",
            text: "Fill All Required Field..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else
          $.toast({
            heading: "Error",
            text: "Data not added due to some error..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        $("#loading").hide();
      },
    });
  }
}
function check() {
  var s1, s2, s3;
  s1 = $("#cntname").val();
  s2 = $("#file").val();
  s3 = $("#phone").val();
  s4 = $("#email").val();
  var phoneno = /^\d{10}$/;
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  if (s1 == "") {
    $.toast({
      heading: "Error",
      text: "Name Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#cntname").focus();
    a = 0;
  } else if (s2 == "") {
    $.toast({
      heading: "Error",
      text: "Logo Image Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#file").focus();
    a = 0;
  } else if (s3 == "") {
    $.toast({
      heading: "Error",
      text: "Contact No. Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#phone").focus();
    a = 0;
  } else if (!s3.match(phoneno)) {
    $("#phone").focus();
    $.toast({
      heading: "Error",
      text: "Contact No. Not Valid..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    a = 0;
  } else if (s4 != "" && reg.test(s4) == false) {
    $("#email").focus();
    $.toast({
      heading: "Error",
      text: "Email ID Not Valid..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    a = 0;
  } else a = 1;
  return a;
}

function viewpopup(id) {
  $("#loading").show();
  $("#mymodal2").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/org_view_popup.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#viewdiv").html(data);
      $("#mymodal2").modal("show");
      $("#loading").hide();
    },
  });
}

function editpopup(id) {
  $("#loading").show();
  $("#mymodal1").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/org_edit_popup.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#editdiv").html(data);
      $("#mymodal1").modal("show");
      $("#loading").hide();
      $("#ufile").change(function () {
        var ext1 = this.value.match(/\.(.+)$/)[1];
        ext = ext1.toLowerCase();
        var size1 = this.files[0].size;
        if (ext == "jpeg" || ext == "jpg" || ext == "png") {
          if (size1 > 100000) {
            $.toast({
              heading: "Error",
              text: "File Size Exceed, Select Maximum 100Kb File..!!",
              position: "top-right",
              loaderBg: "#ff6849",
              icon: "error",
              hideAfter: 3500,
            });
            this.value = "";
            return false;
          }
        } else {
          $.toast({
            heading: "Error",
            text: "Select only jpg png and jpeg file..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
          this.value = "";
          return false;
        }
      });
    },
  });
}
function getstate1(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/get_state1.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#ustatediv").html(data);
      $("#ucity").val("");
      $("#loading").hide();
    },
  });
}
function getcity1(id) {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/get_city1.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#ucitydiv").html(data);
      $("#loading").hide();
    },
  });
}
function edit(id) {
  var str = check1();
  if (str == 1) {
    $("#loading").show();
    var $ele2 = $("#edt" + id)
      .parent()
      .parent();
    var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13;
    s1 = $("#ucountry option:selected").val();
    s2 = $("#ucntname").val();
    s3 = $("#ustate option:selected").val();
    s4 = $("#ucity option:selected").val();
    s5 = $("#uaddress").val();
    s6 = $("#uphone").val();
    s7 = $("#ualtno").val();
    s8 = $("#uemail").val();
    s9 = $("#uwebsite").val();
    s10 = $("#hfile").val();
    var formData = new FormData();
    formData.append("id", id);
    formData.append("country", s1);
    formData.append("name", s2);
    formData.append("state", s3);
    formData.append("city", s4);
    formData.append("address", s5);
    formData.append("phone", s6);
    formData.append("altno", s7);
    formData.append("email", s8);
    formData.append("website", s9);
    formData.append("hfile", s10);
    formData.append("file", $("#ufile")[0].files[0]);
    $.ajax({
      type: "POST",
      url: "ajaxpage/org_edit_qy.php",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data == 1) {
          getdata();
          $.toast({
            heading: "Success",
            text: "Organization Details Updated Successfully..!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          $("#mymodal1").modal("hide");
        } else if (data == 0)
          $.toast({
            heading: "Error",
            text: "Fill All Required Field..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 2)
          $.toast({
            heading: "Error",
            text: "File Not Valid..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else
          $.toast({
            heading: "Error",
            text: "Data not updated due to some error..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        $("#loading").hide();
      },
    });
  }
}
function check1() {
  var s1, s2, s3;
  s1 = $("#ucntname").val();
  s3 = $("#uphone").val();
  s4 = $("#uemail").val();
  var phoneno = /^\d{10}$/;
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
  if (s1 == "") {
    $.toast({
      heading: "Error",
      text: "Name Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#ucntname").focus();
    a = 0;
  } else if (s3 == "") {
    $.toast({
      heading: "Error",
      text: "Contact No. Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#uphone").focus();
    a = 0;
  } else if (!s3.match(phoneno)) {
    $("#uphone").focus();
    $.toast({
      heading: "Error",
      text: "Contact No. Not Valid..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    a = 0;
  } else if (s4 != "" && reg.test(s4) == false) {
    $("#uemail").focus();
    $.toast({
      heading: "Error",
      text: "Email ID Not Valid..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    a = 0;
  } else a = 1;
  return a;
}
