function getdata() {
  //alert();
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/region_get_data.php",
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
    url: "ajaxpage/region_add_popup.php",
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
    let form_id = document.getElementById("addRegionForm");
    var formData = new FormData(form_id);
    $.ajax({
      type: "POST",
      url: "ajaxpage/region_add_qy.php",
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
            text: "Region Added Successfully..!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          $("#mymodal").modal("hide");
        } else if (data == 2)
          $.toast({
            heading: "Error",
            text: "Region Name Already Exist..!!",
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
  } else a = 1;
  return a;
}

function editpopup(id) {
  $("#loading").show();
  $("#mymodal1").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/region_edit_popup.php",
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
    let form_id = document.getElementById("updateRegionForm");
    var formData = new FormData(form_id);
    formData.append("id", id);
    $.ajax({
      type: "POST",
      url: "ajaxpage/region_edit_qy.php",
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      success: function (data) {
        if (data == 1) {
          getdata();
          $.toast({
            heading: "Success",
            text: "Region Details Updated Successfully..!!",
            position: "top-right",
            loaderBg: "#2DB81D",
            icon: "success",
            hideAfter: 3500,
          });
          $("#mymodal1").modal("hide");
        } else if (data == 0)
          $.toast({
            heading: "Error",
            text: "Fill All Required Fields...!!!",
            position: "top-right",
            loaderBg: "#ff6849",
            icon: "error",
            hideAfter: 3500,
          });
        else if (data == 2)
          $.toast({
            heading: "Error",
            text: "Region Already Exists",
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
  } else a = 1;
  return a;
}

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
      dependant.innerHTML = response;
    },
  });
}
