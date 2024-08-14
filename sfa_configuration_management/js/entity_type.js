function inputWithNumber(id) {
  let input_id = document.getElementById(id);
  input_id.value = input_id.value.replace(/[^0-9]/g, "");
}



function getdata() {
  //alert();
  // $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/entity_get_data.php",
    data: {},
    cache: false,
    success: function (data) {
      //alert(data);
      $("#datadiv").html(data);
      // $("#loading").hide();
      $("#regservice").DataTable({ dom: "Bfrtip", buttons: ["csv", "excel"] });
    },
  });
}

function editpopup(id) {
  $("#loading").show();
  $("#mymodal1").modal("hide");
  $.ajax({
    type: "POST",
    url: "ajaxpage/entity_type_edit_popup.php",
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
    var s1, s2,s3,s4;
    s1 = $("#typeid").val();
    s2 = $("#typename").val();
    s3 = $("#htypeid").val();
    s4 = $("#htypename").val();
    var formData = new FormData();
    formData.append("id", id);
    formData.append("typeid", s1);
    formData.append("typename", s2);
    formData.append("htypeid", s3);
    formData.append("htypename", s4);

    $.ajax({
      type: "POST",
      url: "ajaxpage/entity_type_edit_qy.php",
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
