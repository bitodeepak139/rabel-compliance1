function getdata() {
	//alert();
	$('#loading').show();
	$.ajax({
		type: 'POST',
		url: 'ajaxpage/state_get_data.php',
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
function addpopup() {
	$("#loading").show();
	$.ajax({
		type: 'POST',
		url: 'ajaxpage/state_add_popup.php',
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
		s1 = $('#country option:selected').val(); s2 = $('#cntname').val();
		var formData = new FormData();
		formData.append('country', s1); formData.append('name', s2);
		$.ajax({
			type: 'POST',
			url: 'ajaxpage/state_add_qy.php',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				//alert(data);
				if (data == 1) {
					getdata();
					$.toast({ heading: 'Success', text: 'State Added Successfully..!!', position: 'top-right', loaderBg: '#2DB81D', icon: 'success', hideAfter: 3500 });
					$('#country').val(''); $('#cntname').val('');
					$('#mymodal').modal('hide');
				}
				else if (data == 2)
					$.toast({ heading: 'Error', text: 'State Name Already Exist..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else if (data == 0)
					$.toast({ heading: 'Error', text: 'Country & State Name Required Field..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else
					$.toast({ heading: 'Error', text: 'Data not added due to some error..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				$('#loading').hide();
			}
		});
	}
}
function check() {
	var s1, s2, s3;
	s1 = $('#country option:selected').val(); s2 = $('#cntname').val();
	if (s1 == '') {
		$.toast({ heading: 'Error', text: 'Country Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
		$('#country').focus();
		a = 0;
	}
	else if (s2 == '') {
		$.toast({ heading: 'Error', text: 'State Name Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
		$('#cntname').focus();
		a = 0;
	}
	else
		a = 1;
	return a;
}

function editpopup(id) {
	$("#loading").show();
	$("#mymodal1").modal('hide');
	$.ajax({
		type: 'POST',
		url: 'ajaxpage/state_edit_popup.php',
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
		s1 = $('#ucntname').val(); s2 = $('#ucountry option:selected').val(); s3 = $('#hname').val();
		var formData = new FormData();
		formData.append('id', id); formData.append('name', s1); formData.append('country', s2); formData.append('hname', s3);
		$.ajax({
			type: 'POST',
			url: 'ajaxpage/state_edit_qy.php',
			data: formData,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if (data == 1) {
					getdata();
					$.toast({ heading: 'Success', text: "State Details Updated Successfully..!!", position: 'top-right', loaderBg: '#2DB81D', icon: 'success', hideAfter: 3500 });
					$("#mymodal1").modal('hide');
				}
				else if (data == 0)
					$.toast({ heading: 'Error', text: 'Country & State Name Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				else if (data == 2)
					$.toast({ heading: 'Error', text: 'State Name Already Exist..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });				
				else
					$.toast({ heading: 'Error', text: 'Data not updated due to some error..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
				$('#loading').hide();
			}
		});
	}
}
function check1() {
	var s1, s2, s3, s4, s5, s6, s7, s8, s9, s10, s11;
	s1 = $('#ucntname').val();
	if (s1 == '') {
		$.toast({ heading: 'Error', text: 'State Name Required..!!', position: 'top-right', loaderBg: '#ff6849', icon: 'error', hideAfter: 3500 });
		$('#ucntname').focus();
		a = 0;
	}
	else
	a = 1;
	return a;
}