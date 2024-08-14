function getdata() {
  //alert();
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/user_get_data.php",
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
    url: "ajaxpage/user_add_popup.php",
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
          if (size1 > 200000) {
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

function adddata() {
  var str = check();
  if (str == 1) {
    $("#loading").show();
    var s1, s2;
    s2 = $("#cntname").val();
    s6 = $("#phone").val();
    s7 = $("#altno").val();
    s8 = $("#email").val();
    s1 = $("#pass").val();
    s9 = $("#design option:selected").val();
    let type_of_user_id = $("#type_of_user option:selected").val();

    var formData = new FormData();
    formData.append("name", s2);
    formData.append("phone", s6);
    formData.append("altno", s7);
    formData.append("email", s8);
    formData.append("password", s1);
    formData.append("design", s9);
    formData.append("type_of_user_id", type_of_user_id);
    formData.append("file", $("#file")[0].files[0]);
    $.ajax({
      type: "POST",
      url: "ajaxpage/user_add_qy.php",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data == 1) {
          getdata();
          $.toast({
            heading: "Success",
            text: "User Details Added Successfully..!!",
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
            text: "User Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "User Contact No. Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: "User Email Already Exist..!!",
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
  s3 = $("#phone").val();
  s4 = $("#email").val();
  s2 = $("#pass").val();
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
  } else if (s4 == "") {
    $.toast({
      heading: "Error",
      text: "Email Id Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#email").focus();
    a = 0;
  } else if (reg.test(s4) == false) {
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
  } else if (s2 == "") {
    $.toast({
      heading: "Error",
      text: "Password Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#pass").focus();
    a = 0;
  } else a = 1;
  return a;
}

function viewpopup(id) {
  $("#loading").show();
  $("#mymodal2").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/user_view_popup.php",
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
    url: "ajaxpage/user_edit_popup.php",
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
          if (size1 > 200000) {
            $.toast({
              heading: "Error",
              text: "File Size Exceed, Select Maximum 200Kb File..!!",
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

function edit(id) {
  var str = check1();
  if (str == 1) {
    $("#loading").show();
    var $ele2 = $("#edt" + id)
      .parent()
      .parent();
    var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13;
    s2 = $("#ucntname").val();
    s6 = $("#uphone").val();
    s7 = $("#ualtno").val();
    s8 = $("#uemail").val();
    s9 = $("#upass").val();
    s10 = $("#hfile").val();
    s1 = $("#udesign option:selected").val();
    let type_of_user_id = $("#utype_of_user option:selected").val();
    console.log(type_of_user_id)
    s3 = $("#hname").val();
    s4 = $("#hphone").val();
    s5 = $("#hemail").val();
    var formData = new FormData();
    formData.append("id", id);
    formData.append("name", s2);
    formData.append("phone", s6);
    formData.append("altno", s7);
    formData.append("email", s8);
    formData.append("pass", s9);
    formData.append("type_of_user", type_of_user_id);
    formData.append("design", s1);
    formData.append("hname", s3);
    formData.append("hphone", s4);
    formData.append("hemail", s5);
    formData.append("hfile", s10);
    formData.append("file", $("#ufile")[0].files[0]);
    $.ajax({
      type: "POST",
      url: "ajaxpage/user_edit_qy.php",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        console.log(data);
        if (data == 1) {
          getdata();
          $.toast({
            heading: "Success",
            text: "User Details Updated Successfully..!!",
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
            text: "User Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "Contact No. Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: "Email Already Exist..!!",
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
  } else if (reg.test(s4) == false) {
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
