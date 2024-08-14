function block(blk_id, detail, colno) {
  var r = confirm("Are you sure to block this record..?");
  if (r === true) {
    $("#loading").show();
    /*var blk_id= $(this).attr('id');	 var detail= $(this).attr('name');*/
    var $ele1 = $("#blk" + blk_id)
      .parent()
      .parent();
    $.ajax({
      type: "POST",
      url: "block.php",
      data: { id: blk_id, details: detail },
      cache: false,

      success: function (data) {
        $ele1
          .find("td")
          .eq(colno)
          .find("span")
          .removeClass("label-success label label-default");
        $ele1
          .find("td")
          .eq(colno)
          .find("span")
          .addClass("label-default label label-danger");
        $ele1.find("td").eq(colno).find("span").text("Block");
        $("#blk" + blk_id).hide();
        $("#act" + blk_id).show();
        $("#loading").hide();
      },
    });
  }
}
function actived(blk_id, detail, colno) {
  var r = confirm("Are you sure to active this record..?");
  if (r === true) {
    var $ele = $("#act" + blk_id)
      .parent()
      .parent();
    /* var blk_id= $(this).attr('id');	 var detail= $(this).attr('name');*/
    $("#loading").show();

    $.ajax({
      type: "POST",
      url: "active.php",
      data: { id: blk_id, details: detail },
      cache: false,

      success: function () {
        $ele
          .find("td")
          .eq(colno)
          .find("span")
          .removeClass("label-default label label-danger");
        $ele
          .find("td")
          .eq(colno)
          .find("span")
          .addClass("label-success label label-default");
        $ele.find("td").eq(colno).find("span").text("Active");
        $("#act" + blk_id).hide();
        $("#blk" + blk_id).show();
        $("#loading").hide();
      },
    });
  }
}
