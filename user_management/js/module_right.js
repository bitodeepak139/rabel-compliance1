function getmudule(id) {
  //alert();
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/get_module_data.php",
    data: { id: id },
    cache: false,
    success: function (data) {
      //alert(data);
      $("#datadiv").html(data);
      $("#loading").hide();
      $("#allch").click(function () {
        if ($(this).is(":checked")) {
          $("input[type='checkbox'].storingch").prop("checked", true);
        } else {
          $("input[type='checkbox'].storingch").prop("checked", false);
        }
      });
    },
  });
}

function updateRight(module_id, page_id, user_id, rightStatus, subModule = "") {
  let checkState = 0;
  $("#loading").show();
  $.ajax({
    type: "POST",
    url: "ajaxpage/manage_user_page_rights.php",
    data: {
      module_id: module_id,
      page_id: page_id,
      user_id: user_id,
      rightStatus: rightStatus,
      subModule: subModule,
    },
    cache: false,
    success: function (data) {
      if (data == 1) {
        $.toast({
          heading: "Success",
          text: "Page Right Added Successfully..!!",
          position: "top-right",
          loaderBg: "#2DB81D",
          icon: "success",
          hideAfter: 3500,
        });
        getmudule(user_id);
      } else if (data == 2) {
        $.toast({
          heading: "Success",
          text: "Page Right Updated Successfully..!!",
          position: "top-right",
          loaderBg: "#2DB81D",
          icon: "success",
          hideAfter: 3500,
        });
        getmudule(user_id);
      } else
        $.toast({
          heading: "Error",
          text: "Data not added due to some system error..!!",
          position: "top-right",
          loaderBg: "#ff6849",
          icon: "error",
          hideAfter: 3500,
        });
      $("#loading").hide();
    },
  });
}

// function updatesoil(sid, id, cid) {
//   var s1 = 0;
//   $("#loading").show();
//   if ($("#slch" + id).prop("checked") == true) s1 = 1;
//   else s1 = 0;
//   $.ajax({
//     type: "POST",
//     url: "ajaxpage/manage_plant_edit_soil_qy.php",
//     data: { id: sid, status: s1, crpid: cid },
//     cache: false,
//     success: function (data) {
//       //alert(data);
//       if (data == 1)
//         $.toast({
//           heading: "Success",
//           text: "Soil Type Added Successfully..!!",
//           position: "top-right",
//           loaderBg: "#2DB81D",
//           icon: "success",
//           hideAfter: 3500,
//         });
// else if (data == 2)
//   $.toast({
//     heading: "Success",
//     text: "Soil Type Updated Successfully..!!",
//     position: "top-right",
//     loaderBg: "#2DB81D",
//     icon: "success",
//     hideAfter: 3500,
//   });
// else
//   $.toast({
//     heading: "Error",
//     text: "Data not added due to some system error..!!",
//     position: "top-right",
//     loaderBg: "#ff6849",
//     icon: "error",
//     hideAfter: 3500,
//   });
//       $("#loading").hide();
//     },
//   });
// }
