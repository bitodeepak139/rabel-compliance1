function getdata(url, isset_var) {
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
      $("#datadiv").html(data);
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

function adddata(formId, url, isset_var) {
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
            icon: "success",
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
