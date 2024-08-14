function getdata() {
  //alert();
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/sub_module_get_data.php",
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
function getseqno(id, isset_var,target_input) {
  $("#loading").show();
  var formData = new FormData();
  formData.append("id", id);
  formData.append(isset_var, "1");

  $.ajax({
    type: "POST",
    url: "ajaxpage/ajax.php",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      $(target_input).val(Number(data) + 1);
      $("#loading").hide();
    },
  });
}
function addpopup() {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/sub_module_add_popup.php",
    data: {},
    cache: false,
    success: function (data) {
      $("#mymodal").modal("show");
      $("#adddiv").html(data);
      $("#loading").hide();
    },
  });
}
function adddata() {
  var str = check();
  if (str == 1) {
    $("#loading").show();
    var s1, s2, s3, s4;
    s1 = $("#module option:selected").val();
    s2 = $("#smname").val();
    s3 = $("#smurl").val();
    s4 = $("#smseqno").val();

    var formData = new FormData();
    formData.append("module", s1);
    formData.append("smname", s2);
    formData.append("smurl", s3);
    formData.append("smseqno", s4);
    $.ajax({
      type: "POST",
      url: "ajaxpage/sub_module_add_qy.php",
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
            text: "Sub Module Added Successfully..!!",
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
            text: "Sub Module Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "Sequence No. Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: "Url Already Exist..!!",
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
  var s1, s2, s3 ,s4;
  s1 = $("#module option:selected").val();
  s2 = $("#smname").val();
  s3 = $("#smurl").val();
  s4 = $("#smseqno").val();
  if (s1 == "") {
    $.toast({
      heading: "Error",
      text: "Module Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#module").focus();
    a = 0;
  } else if (s2 == "") {
    $.toast({
      heading: "Error",
      text: "Sub Module Name Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#smname").focus();
    a = 0;
  } else if (s3 == "") {
    $.toast({
      heading: "Error",
      text: "Sub Module Url Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#smurl").focus();
    a = 0;
  } else if (s4 == "") {
    $.toast({
      heading: "Error",
      text: "Sequence No. Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#smseqno").focus();
    a = 0;
  } else a = 1;
  return a;
}

function editpopup(id) {
  $("#loading").show();
  $("#mymodal1").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/sub_module_edit_popup.php",
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
  var str = check();
  if (str == 1) {
    $("#loading").show();
    var $ele2 = $("#edt" + id)
      .parent()
      .parent();
    var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13;
    s1 = $("#ucntname").val();
    s2 = $("#umodule option:selected").val();
    s3 = $("#upgurl").val();
    s4 = $("#smseqno").val();
    var formData = new FormData();
    formData.append("id", id);
    formData.append("name", s1);
    formData.append("module", s2);
    formData.append("url", s3);
    formData.append("seqno", s4);

    $.ajax({
      type: "POST",
      url: "ajaxpage/sub_module_edit_qy.php",
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
            text: "Sub Module Details Updated Successfully..!!",
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
            text: "Sub Module Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "Sequence No. Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: " Url Already Exist..!!",
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
// function check1() {
//   var s1, s2, s3, s4;
//   s1 = $("#ucntname").val();
//   s3 = $("#upgurl").val();
//   s4 = $("#upgseqno").val();
//   if (s1 == "") {
//     $.toast({
//       heading: "Error",
//       text: "State Name Required..!!",
//       position: "top-right",
//       loaderBg: "#ff6849",
//       icon: "error",
//       hideAfter: 3500,
//     });
//     $("#ucntname").focus();
//     a = 0;
//   } else if (s3 == "") {
//     $.toast({
//       heading: "Error",
//       text: "Page Url Required..!!",
//       position: "top-right",
//       loaderBg: "#ff6849",
//       icon: "error",
//       hideAfter: 3500,
//     });
//     $("#pgurl").focus();
//     a = 0;
//   } else if (s4 == "") {
//     $.toast({
//       heading: "Error",
//       text: "Page Sequence No. Required..!!",
//       position: "top-right",
//       loaderBg: "#ff6849",
//       icon: "error",
//       hideAfter: 3500,
//     });
//     $("#pgseqno").focus();
//     a = 0;
//   } else if (isNaN(s4)) {
//     $.growl.error({ message: "Only Numeric Value in Sequence No..!!" });
//     $("#carton" + no).focus();
//     a = 0;
//   } else a = 1;
//   return a;
// }

function DependantDropDown(source, target, url, isset_var) {
  let selectedValue = document.getElementById(source).value;
  let dependant = document.getElementById(target);
  var formData = new FormData();
  formData.append("id", selectedValue);
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
      // dependant.innerHTML = response;
    },
  });
}
