$("#myform").validate({
			rules: {
				name: "required",
				lastname: "required",
				mobile: {
					required: true,
					minlength: 10,
					digits:true
				},
				whatsappno: {
					required: false,
					minlength: 10,
					digits:true
				},
				panno: {
					required: false,
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
				/*email: {
					required: true,
					email: true
				},*/
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
			    hsn: "required",
				invprefix: "required",
				state: "required",
							
			    sqty: {
					required: true,
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
			gstrate: "required",
			cess: "required",
			tds: "required",
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
