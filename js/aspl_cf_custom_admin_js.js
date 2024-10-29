jQuery(document).ready(function($){

		 $(".add-row").click(function(e){

            e.preventDefault();
            var currency = $(document).find('.currency').text();
            var markup3 = $('<tr class="tr "> <td><span class="dashicons dashicons-move"></span></td><td><input type="checkbox" name="aspl_cf_delete" ><input type="hidden" name="record[]"></td><td><input type="text" name="aspl_cf_field_lable[]" class="aspl-input"></td><td><select class="aspl-input aspl_select_field" name="aspl_cf_field_type[]"><option> ----- Select ----- </option><option value="text">TextBox</option><option value="email">E-mail</option><option value="number">Number</option><option value="submit">Submit</option><option value="reset">Reset</option><option value="textarea">Textarea</option><option value="date">Date</option><option value="select">Select-Option</option></select><textarea name="aspl_field_add_option[]" class="aspl_cf_option_fields" style="display:none;" >Option1|Option2</textarea></td><td><input type="text" name="aspl_cf_field_name[]" class="aspl-input"></td><td><input type="text" name="aspl_cf_field_attr_id[]" class="aspl-input"></td><td><input type="text" name="aspl_cf_field_class[]" class="aspl-input"></td></tr>').hide();
            
            $(".aspl-cf-field-table tbody").append(markup3);
            markup3.show(1000);

        });

		$(document).on("click", ".delete-row" , function(e) {
            e.preventDefault();
            $(".aspl-cf-field-table tbody").find('input[name="aspl_cf_delete"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").fadeOut(1000, function(){ $(this).remove();});
                }
            });
        });
    
        $('.aspl_cf_email_switch_check').change(function() {

             $(".aspl_email_config_section").toggle(1000);

        });


        $(document).on("change", ".aspl_select_field" , function() {

            var select_value = $(this).val();

            if ( select_value == 'select' ) {
             $(this).parents("tr").find('.aspl_cf_option_fields').css("display","block ");
              // $(this).parent( "tr" ).find(".aspl_cf_option_fields").show();

            }else{

              $(this).parents("tr").find('.aspl_cf_option_fields').css("display","none");
            
            }

        });

        $('.aspl-cf-field-table tbody ').sortable();

});