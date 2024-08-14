$("#myform").validate({
			rules: {
				user: "required",
				lastname: "required",
				mobile: {
					required: true,
					minlength: 10,
					digits:true
				},
				whatsappno: {
					required: true,
					minlength: 10,
					digits:true
				},
				panno: {
					required: true,
					minlength: 10
				},
				password: {
					required: true,
					minlength: 5
				},
				confirm_password: {
					required: true,
					minlength: 5,
					equalTo: "#password"
				},
				email: {
					required: true,
					email: true
				},
				username: {
					required: true,
					minlength: 5
				},
				process: "required",			
			    name: "required",
				firmname: "required",
				address: "required",
			    itmname: "required",
			    munit: "required",
			    
				gstin: "required",
				state: "required",
				boaddress: "required",
				reg_type: "required",
				party_type: "required",				
			    sqty: {
					required: false,
					digits:true
				},
			  qty: {
					required: true,
					digits:true
				},
			price: {
					required: true,
					number:true
				},
				cess: {
					required: false,
					number:true
				},
				tds: {
					required: false,
					number:true
				},
			gstrate: "required",			
			hastax: "required",
			bname: "required",
			ifsccode: "required",
			branch: "required",
			defaulacc: "required",
			accountno: {
					required: true,
					digits:true
				},
			debit: {
					required: false,
					number:true
				},
			credit: {
					required: false,
					number:true
				},
			invdate: "required",
			pmode: "required",
			tnsnature: "required",
			prepareby: "required",
			checkedby: "required",
			billto: "required",
			expense: {
					required: false,
					number:true
				},
			frghtamt: {
					required: false,
					number:true
				},
			},
		});	
