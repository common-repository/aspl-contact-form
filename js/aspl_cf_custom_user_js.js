jQuery(document).ready(function($){

	// aspl_email_btn
	 $(document).on("click", ".aspl_email_btn" , function() {

	 	var	from_email = $(this).parents("form").find('.aspl-contect-hidden-field-user-email').val();
	 	var	template_id = $(this).parents("form").find('.aspl-contect-hidden-field-template-id').val();
	 	var	template_form_name = '.' + $(this).parents("form").find('.aspl-contect-hidden-field-form-name').val();
	 	var	ajaxurl = $(this).parents("form").find('.ajaxurl').val();
	 	
	 	// console.log(template_form_name);
	 	// alert(from_email );
	 	// alert( template_id);
	 	// alert(template_form_name);
		
	 	var values = {};
		$.each($(template_form_name).serializeArray(), function(i, field) {
		    values[field.name] = field.value;
		});
		// console.log(values);

		$.ajax({    
		    type: "POST",
	        // dataType: "json",
	        url: ajaxurl,
	        data: {
	            action: 'aspl_cf_fuction_respons_sen_btn',
	            from_email : from_email,
	            template_id : template_id,
	            template_form_name : template_form_name,
	            field_data_value : values,

	        },
	        beforeSend: function() {
			            $(".loading").show();
			        },
	        success: function (data) {
	        	$(".loading").hide();
	        	alert('success');
	        }
        });


		alert('test');

	 });

});