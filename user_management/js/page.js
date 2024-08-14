function getdata() {
  //alert();
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/page_get_data.php",
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
// function getseqno(id) {
//   $("#loading").show();
//   $.ajax({
//     type: "POST",
//     url: "ajaxpage/page_get_seqno.php",
//     data: { id: id },
//     cache: false,
//     success: function (data) {
//       $("#pgseqno").val(data);
//       $("#loading").hide();
//     },
//   });
// }


function addpopup() {
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/page_add_popup.php",
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
    var s1, s2, s3, s4, s5;
    s1 = $("#module option:selected").val();
    s5 = $("#sub-module option:selected").val();
    s2 = $("#cntname").val();
    s3 = $("#pgurl").val();
    s4 = $("#pgseqno").val();
    var formData = new FormData();
    formData.append("module", s1);
    formData.append("submodule", s5);
    formData.append("name", s2);
    formData.append("url", s3);
    formData.append("seqno", s4);
    $.ajax({
      type: "POST",
      url: "ajaxpage/page_add_qy.php",
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
            text: "Page Added Successfully..!!",
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
            text: "Page Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "Page Sequence No. Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: "Page Url Already Exist..!!",
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
  s1 = $("#module option:selected").val();
  s2 = $("#cntname").val();
  s3 = $("#pgurl").val();
  s4 = $("#pgseqno").val();
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
      text: "Page Name Required..!!",
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
      text: "Page Url Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#pgurl").focus();
    a = 0;
  } else if (s4 == "") {
    $.toast({
      heading: "Error",
      text: "Page Sequence No. Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#pgseqno").focus();
    a = 0;
  } else if (isNaN(s4)) {
    $.growl.error({ message: "Only Numeric Value in Sequence No..!!" });
    $("#carton" + no).focus();
    a = 0;
  } else a = 1;
  return a;
}

function editpopup(id) {
  $("#loading").show();
  $("#mymodal1").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/page_edit_popup.php",
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
    s2 = $("#module option:selected").val();
    subModule = $("#sub-module option:selected").val();
    console.log(s8);
    s3 = $("#upgurl").val();
    s4 = $("#upgseqno").val();
    s6 = $("#hmodule_id").val();
    s7 = $("#hsubmodule_id").val();
    s8 = $("#hpage_name").val();
    s9 = $("#hpage_url").val();
    s10 = $("#hpage_seqno").val();
   
    var formData = new FormData();
    formData.append("id", id);
    formData.append("name", s1);
    formData.append("module", s2);
    formData.append("sub-module", subModule);
    formData.append("url", s3);
    formData.append("seqno", s4);
    formData.append("hmodule_id",s6);
    formData.append("hsubmodule_id",s7);
    formData.append("hpage_name",s8);
    formData.append("hpage_url",s9);
    formData.append("hpage_seqno",s10);
   
   
    $.ajax({
      type: "POST",
      url: "ajaxpage/page_edit_qy.php",
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
            text: "Page Details Updated Successfully..!!",
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
            text: "Page Name Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 3)
          $.toast({
            heading: "Error",
            text: "Page Sequence No. Already Exist..!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 4)
          $.toast({
            heading: "Error",
            text: "Page Url Already Exist..!!",
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
  var s1, s2, s3, s4;
  s1 = $("#ucntname").val();
  s3 = $("#upgurl").val();
  s4 = $("#upgseqno").val();
  if (s1 == "") {
    $.toast({
      heading: "Error",
      text: "State Name Required..!!",
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
      text: "Page Url Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#pgurl").focus();
    a = 0;
  } else if (s4 == "") {
    $.toast({
      heading: "Error",
      text: "Page Sequence No. Required..!!",
      position: "top-right",
      loaderBg: "#ff6849",
      icon: "error",
      hideAfter: 3500,
    });
    $("#pgseqno").focus();
    a = 0;
  } else if (isNaN(s4)) {
    $.growl.error({ message: "Only Numeric Value in Sequence No..!!" });
    $("#carton" + no).focus();
    a = 0;
  } else a = 1;
  return a;
}


function isJsonString(str) {
  try {
    JSON.parse(str);
  } catch {
    return false;
  }
  return true;
}


function DependantDropDown(source, target, url, isset_var,d_sub_module,page_seq) {
  let selectedValue = document.getElementById(source).value;
  let dependant = document.getElementById(target);
  let sub_module_status = document.getElementById(d_sub_module);
  let get_module_seq = document.getElementById(page_seq);
  var formData = new FormData();
  formData.append("id", selectedValue);
  formData.append(isset_var,"1");
  $.ajax({
    type: "POST",
    url: url,
    data: formData,
    contentType: false,
    processData: false,
    cache: false,
    success: function (data) {
      console.log(data);
      if (isJsonString(data)) {
        let response = JSON.parse(data);
        let status = response[0];
        let resData = response[1];
        if(status  == "true"){
          sub_module_status.style.cssText = "display:block;";
          dependant.innerHTML = resData;
        }else{
          sub_module_status.style.cssText = "display:none;";
          get_module_seq.value = resData+1;
        }
      }else{
        console.log('Response is not in Json format');
      }
    },
  });
}

function getseqno(id, isset_var, target_input) {
  $("#loading").show();
  var formData = new FormData();
  let module = $("#module option:selected").val();
  formData.append("module_id", module);
  formData.append("submodule_id", id);
  formData.append(isset_var, "1");

  $.ajax({
    type: "POST",
    url: "ajaxpage/ajax.php",
    data: formData,
    cache: false,
    contentType: false,
    processData: false,
    success: function (data) {
      // console.log(data);
      $(target_input).val(Number(data) + 1);
      $("#loading").hide();
    },
  });
}


