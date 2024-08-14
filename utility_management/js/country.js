function addpopup() {
	$("#loading").show();
	$.ajax({
		type: 'POST',
		url: 'ajaxpage/country_add_popup.php',
		data: {},
		cache: false,
		success: function (data) {
			$('#mymodal').modal('show');
			$('#adddiv').html(data);
			$("#loading").hide();
		}
	});
}
function adddata() {
	var str = check();
	if (str == 1) {
		$('#loading').show();
		var s1, s2;
		s1 = $('#cntcode').val(); s2 = $('#cntname').val();
		var formData = new FormData();
		formData.append('code', s1); formData.append('name', s2);
		$.ajax({
			type: 'POST',
			url: 'ajaxpage/country_add_qy.php',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				//alert(data);
				if (data == 1) {
					getdata();
					$.toast({ heading: 'Success', text: 'Country Added Successfully..!!', position: 'top-right', loaderBg: '#2DB81D', icon: 'success', hideAfter: 3500 });
					$('#cntcode').val(''); $('#cntname').val('');
					$('#mymodal').modal('hide');
				}
				else if (data == 2)
					$.toast({ heading: 'Error', text: 'Country Code Already Exist..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else if (data == 3)
					$.toast({ heading: 'Error', text: 'Country Name Already Exist..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else if (data == 0)
					$.toast({ heading: 'Error', text: 'Country Code & Country Name Required Field..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else
					$.toast({ heading: 'Error', text: 'Data not added due to some error..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				$('#loading').hide();
			}
		});
	}
}
function check() {
	var s1, s2, s3;
	s1 = $('#cntcode').val(); s2 = $('#cntname').val();
	if (s1 == '') {
		$.toast({ heading: 'Error', text: 'Country Code Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
		$('#cntcode').focus();
		a = 0;
	}
	else if (s2 == '') {
		$.toast({ heading: 'Error', text: 'Country Name Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
		$('#cntname').focus();
		a = 0;
	}
	else
		a = 1;
	return a;
}
function getdata() {
	//alert();
	$('#loading').show();
	$.ajax({
		type: 'POST',
		url: 'ajaxpage/country_get_data.php',
		data: {},
		cache: false,
		success: function (data) {
			//alert(data);					   
			$('#datadiv').html(data);
			$('#loading').hide();
			$('#regservice').DataTable({dom: 'Bfrtip', buttons: ['csv', 'excel']});
		}
	});
}
function deltrecord(id, tbid, tbname) {
	var r = confirm("Are you sure to delete this record..?");
	if (r == true) {
		$('#loading').show();
		var $ele1 = $('#delt' + id).parent().parent();
		$.ajax({
			type: 'POST',
			url: '../delete.php',
			data: { id: id, tbname: tbname, tbid: tbid },
			cache: false,
			success: function (data) {
				$ele1.remove();
				$('#loading').hide();
			}
		});
	}
}

function editpopup(id) {
	$("#loading").show();
	$("#mymodal1").modal('hide');
	$.ajax({
		type: 'POST',
		url: 'ajaxpage/country_edit_popup.php',
		data: { id: id },
		cache: false,
		success: function (data) {
			$('#editdiv').html(data);
			$("#mymodal1").modal('show');
			$("#loading").hide();
		}
	})
}
function edit(id) {
	var str = check1();
	if (str == 1) {
		$('#loading').show();
		var $ele2 = $('#edt' + id).parent().parent();
		var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11, s12, s13;
		s1 = $('#ucntname').val(); s2 = $('#ucntcode').val(); s3 = $('#hname').val(); s4 = $('#hcode').val();
		var formData = new FormData();
		formData.append('id', id); formData.append('name', s1); formData.append('code', s2); formData.append('hname', s3); formData.append('hcode', s4);
		$.ajax({
			type: 'POST',
			url: 'ajaxpage/country_edit_qy.php',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data == 1) {
					getdata();
					$.toast({ heading: 'Success', text: "Country Details Updated Successfully..!!", position: 'top-right', loaderBg: '#2DB81D', icon: 'success', hideAfter: 3500 });
					$("#mymodal1").modal('hide');
				}
				else if (data == 0)
					$.toast({ heading: 'Error', text: 'Country Code & Country Name Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else if (data == 2)
					$.toast({ heading: 'Error', text: 'Country Code Already Exist..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else if (data == 3)
					$.toast({ heading: 'Error', text: 'Country Name Already Exist..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else
					$.toast({ heading: 'Error', text: 'Data not updated due to some error..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				$('#loading').hide();
			}
		});
	}
}
function check1() {
	var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11;
	s1 = $('#ucntname').val(); s2 = $('#ucntcode').val();
	if (s1 == '') {
		$.toast({ heading: 'Error', text: 'Country Name Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
		$('#ucntname').focus();
		a = 0;
	}else if (s2 == '') {
		$.toast({ heading: 'Error', text: 'Country Code Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
		$('#ucntcode').focus();
		a = 0;
	}
	else
	a = 1;
	return a;
}