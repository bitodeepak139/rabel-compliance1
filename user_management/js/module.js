function addpopup() {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/module_add_popup.php",
    data: {},
    cache: false,
    success: function (data) {
      $("#mymodal").modal("show");
      $("#adddiv").html(data);
      $("#loading").hide();
    },
  });
}

function inputWithNumber(id) {
  let input_id = document.getElementById(id);
  input_id.value = input_id.value.replace(/[^0-9]/g, "");
}

function adddata() {
  var str = check();
  if (str == 1) {
    $("#loading").show();
    var s1, s2;
    s1 = $("#cntname").val();
    s2 = $("#mdurl").val();
    let sub_module_status = $("#sub_module_status option:selected").val();
    // let module_seq = $("#mdseq").val();
    var formData = new FormData();
    formData.append("name", s1);
    formData.append("url", s2);
    // formData.append("module_seq", module_seq);
    formData.append("sub_module_status", sub_module_status);
    $.ajax({
      type: "POST",
      url: "ajaxpage/module_add_qy.php",
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
            text: "Module Added Successfully..!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          $("#mdurl").val("");
          $("#cntname").val("");
          $("#mymodal").modal("hide");
        } else if (data == 2)
          $.toast({
            heading: "Error",
            text: "Module Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "Module Url Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: "Module Sequence Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 0)
          $.toast({
            heading: "Error",
            text: "Module Name & Module Url & Sequence Required Field..!!",
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
  s2 = $("#mdurl").val();
  s3 = $("#mdseq").val();
  if (s1 == "") {
    $.toast({
      heading: "Error",
      text: "Module Name Required..!!",
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
      text: "Module URL Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#mdurl").focus();
    a = 0;
  } else if (s3 == "") {
    $.toast({
      heading: "Error",
      text: "Module Sequence Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#mdseq").focus();
    a = 0;
  } else a = 1;
  return a;
}
function getdata() {
  //alert();
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/module_get_data.php",
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

function editpopup(id) {
  $("#loading").show();
  $("#mymodal1").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/module_edit_popup.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      $("#editdiv").html(data);
      $("#mymodal1").modal("show");
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
    s1 = $("#ucntname").val();
    s2 = $("#ucntcode").val();
    s3 = $("#hname").val();
    s4 = $("#hcode").val();
    s5 = $("#hseq").val();
    s6 = $("#module_seq").val();
    let sub_module_status = $("#sub_module_status option:selected").val();
    var formData = new FormData();
    formData.append("id", id);
    formData.append("name", s1);
    formData.append("code", s2);
    formData.append("hname", s3);
    formData.append("hcode", s4);
    formData.append("hseq", s5);
    formData.append("seq", s6);
    formData.append("sub_module_status", sub_module_status);

    $.ajax({
      type: "POST",
      url: "ajaxpage/module_edit_qy.php",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        // console.log(data);
        if (data == 1) {
          getdata();
          $.toast({
            heading: "Success",
            text: "Module Details Updated Successfully..!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          $("#mymodal1").modal("hide");
        } else if (data == 0)
          $.toast({
            heading: "Error",
            text: "Module Code & Module Url Required..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 2)
          $.toast({
            heading: "Error",
            text: "Module Url Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "Module Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: "Module Sequence Already Exist..!!",
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
  var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11;
  s1 = $("#ucntname").val();
  s2 = $("#ucntcode").val();
  if (s1 == "") {
    $.toast({
      heading: "Error",
      text: "Module Name Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#ucntname").focus();
    a = 0;
  } else if (s2 == "") {
    $.toast({
      heading: "Error",
      text: "Module Url Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#ucntcode").focus();
    a = 0;
  } else a = 1;
  return a;
}
