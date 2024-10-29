<?php


	if ( ! defined( 'ABSPATH' ) ) {
        exit;
    }


    if (isset($_GET['id'])) {

	    global $wpdb;

	    $id = sanitize_text_field($_GET['id']);
	    $action = sanitize_text_field($_GET['action']);

		$table_name = $wpdb->prefix . "aspl_cf_form_data";
		$form_data = $wpdb->get_results("SELECT * FROM $table_name where template_id = '$id' ");
		foreach ($form_data as $key => $form_data_value) {
			// var_dump($form_data_value);
	    ?>
	    	<div class="aspl-cf-add-new-main">
				<div class="aspl-cf-title"><h1> Update Form </h1></div>
				<div class="aspl-cf-body-content">
					<form method="POST">
						<div class="aspl_cf_addnew_genral_section">
							<h2><li>Genral</li></h2>
							<table>
								<tr>
									<td><label>Form Title : </label></td>
									<td><input type="Text" name="aspl_cf_title" value="<?php echo esc_attr($form_data_value->template_title); ?>"></td>
									<td></td>
									<td>Shortcode : </td>
									<td>[aspl-contact-form text="<input type="Text" name="aspl_cf_shortcode" value="<?php echo esc_attr($form_data_value->template_shortcode); ?>" class="aspl-fc-shortcode-textbox" >"]</td>
								</tr>
								<tr>
									<td>
										<label>Subtitle:</label>
									</td>
									<td colspan="4"><input type="Text" name="aspl_cf_subtitle" value="<?php _e($form_data_value->template_subtitle); ?>" style="width:75%;"></td>
								</tr>
								<!-- <tr>
									<td><label>Use Email : </label></td>
									<td>
										<label class="switch">
										  	<input type="checkbox" class="aspl_pop_switch" name="aspl_pop_add_custon_image_status" value="enable" checked="true">
										  	<span class="slider round"></span>
										</label>
									</td>
								</tr> -->
								<tr>
									
								</tr>
							</table>			
						</div>
						<div>
							<h2><li>Add Fields</li></h2>
							<div class="aspl-cf-fields-table">
								<table style="width: 100%;"  class="aspl-cf-field-table">
									<thead>
										
									<tr>
										<th> </th>
										<th>Select</th>
										<th>Lable</th>
										<th>Fields</th>
										<th>Name</th>
										<th>ID</th>
										<th>Class</th>
									</tr>
									</thead>
									<tbody>
										
									<?php 

											$temp = $form_data_value->template_field_data;
											$fields_data = unserialize($temp);

											foreach ($fields_data as $fields_data_value) {
												// var_dump($fields_data_value);
									 			
									 			$array_data = array();
									 			$array_data[] = $fields_data_value;

												foreach ($array_data as $fields_value) {
													 ?>
													<tr>
														<td><span class="dashicons dashicons-move"></span></td>
														<td>
															<input type="checkbox" name="aspl_cf_delete">
															<input type="hidden" name="record[]">
														</td>
														<td><input type="text" name="aspl_cf_field_lable[]" value="<?php echo esc_attr($fields_value['form_field_lable']); ?>" class="aspl-input"></td>
														<td>
															<select class="aspl-input aspl-input aspl_select_field" name="aspl_cf_field_type[]">
																<option> ----- Select ----- </option>
																<option value="text" <?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'text'){
																		echo esc_attr('selected');
																	}
																 ?>>TextBox</option>
																<option value="email" <?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'email'){
																		echo esc_attr('selected');
																	}
																 ?>>E-mail</option>
																<option value="number" <?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'number'){
																		echo esc_attr('selected');
																	}
																 ?>>Number</option>
																<!-- <option value="password" <?php 
																	//$select = $fields_value['form_field_type'];
																	//if($select == 'password'){
																	//	echo esc_attr('selected');
																	//}
																 ?>>Password</option> -->
																<option value="submit" <?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'submit'){
																		echo esc_attr('selected');
																	}
																 ?>>Submit</option>
																<option value="reset" <?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'reset'){
																		echo esc_attr('selected');
																	}
																 ?>>Reset</option>
																<option value="textarea" <?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'textarea'){
																		echo esc_attr('selected');
																	}
																 ?>>Textarea</option>
																<option value="date" <?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'date'){
																		echo esc_attr('selected');
																	}
																 ?>>Date</option>
																 <option value="select" <?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'select'){
																		echo esc_attr('selected');
																	}
																 ?> >Select-Option</option>
															</select>
															<?php 
																	$select = $fields_value['form_field_type'];
																	if($select == 'select'){
																	?>
																		<textarea name="aspl_field_add_option[]" class="aspl_cf_option_fields" ><?php _e($fields_value['option_fields']); ?></textarea>
																	<?php
																	}else{
																	?>
																		<textarea name="aspl_field_add_option[]" class="aspl_cf_option_fields" style="display:none;" >Option1|Option2</textarea>
																	<?php

																	}
																 ?>
														</td>
														<td><input type="text" name="aspl_cf_field_name[]" value="<?php echo esc_attr($fields_value['form_field_name']); ?>" class="aspl-input"></td>
														<td><input type="text" name="aspl_cf_field_attr_id[]" value="<?php echo esc_attr($fields_value['form_field_attr_id']); ?>" class="aspl-input"></td>
														<td><input type="text" name="aspl_cf_field_class[]" value="<?php echo esc_attr($fields_value['form_field_class']); ?>" class="aspl-input"></td>
														<!-- <tr class="aspl_cf_option_fields" style="display:none;">
															<td></td>
															<td></td>
															<td></td>
															<td></td>
															<td>
																<textarea name="aspl_field_add_option[]">Option1|Option2</textarea>
															</td>	
															<td></td>
															<td></td>
														</tr> -->

													</tr>
													<?php 

												}

											}

									?>
									</tbody>
								</table>
								<div class="aspl-cf-row-button-section">
									<br><span class="button-primary aspl-cf-button add-row">Add Row</span> &nbsp <span class="button-primary aspl-cf-button delete-row"> Delete Row</span><br>
								</div>
							</div>
						</div>
						<div>
						<h2><li>E-mail Setting</li></h2>
						<div class="aspl_cf_email_switch">
							<table class="aspl_cf_email_config_switch_table">
								<tr>
									<td>Email</td>
									<td>
										<label class="switch">
										  	<input type="checkbox" class="aspl_cf_email_switch_check" name="aspl_cf_email_switch" value="enable" checked="true">
										  	<span class="slider round"></span>

										</label>
									</td>	
									<td><p><strong>*</strong> This Email setting is work on 'Submit' type of field.</p></td>
								</tr>
							</table>
						</div>
						<div class="aspl_email_config_section" style="display: block;">
							<table class="aspl_cf_email_config_table">
								<tr>
									<td>To</td>
									<?php 

										// $current_user = wp_get_current_user();
										$to_email = $form_data_value->template_email_to;
										$subject = $form_data_value->template_email_subject;
										$messages = $form_data_value->template_email_msg;

									 ?>
									<td><input type="email" class="aspl-input" name="aspl_cf_email_to" value="<?php _e($to_email); ?>"></td>
								</tr>
<!-- 								<tr>
									<td>From</td>
									<td><input type="email" class="aspl-input" name=""></td>
								</tr> -->
								<tr>
									<td>Subject</td>
									<td><input type="text" class="aspl-input" name="aspl_cf_email_subject" value="<?php _e($subject); ?>"></td>
								</tr>
								<tr>
									<td>Message</td>
									<td><textarea class="aspl-input" name="aspl_cf_email_msg"><?php _e($messages); ?></textarea></td>
								</tr>
							</table>
						</div>
					</div>
						<div>
							<input type="submit" name="aspl_cf_form_update_btn" class="button button-primary aspl-cf-button" value="Update">
						</div>
					</form>
				</div>
			</div>
	    <?php
		
		}


		if (isset($_POST['aspl_cf_form_update_btn'])) {

			$field_data_inner = array();
				$field_data_outer = array();

				$form_title = sanitize_text_field($_POST['aspl_cf_title']);
				$form_subtitle = sanitize_text_field($_POST['aspl_cf_subtitle']);
				$form_shortcode = sanitize_text_field($_POST['aspl_cf_shortcode']);
				$form_field_lable = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_lable'] );
				$form_field_type = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_type'] );
				$form_field_name = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_name']);
				$form_field_attr_id = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_attr_id']);
				$form_field_class = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_class']);
				$form_field_option = array_map( 'sanitize_text_field', $_POST['aspl_field_add_option']);


				if ($_POST['aspl_cf_email_switch'] != '') {
					
					$to = sanitize_email($_POST['aspl_cf_email_to']);
					$subject = sanitize_text_field($_POST['aspl_cf_email_subject']);
					$msg = sanitize_text_field($_POST['aspl_cf_email_msg']);
					
				}else{

					$to = '';
					$subject = '';
					$msg = '';

				}

				$date = date("Y-m-d H:i:s");

				$record = array_map('sanitize_text_field',$_POST['record']);
				$rec_count = count($record);

				for( $i = 0 ;$i < $rec_count ; $i++ ){

					$field_data_inner['form_field_lable'] = $form_field_lable[$i];
					$field_data_inner['form_field_type']= $form_field_type[$i];
					$field_data_inner['form_field_name']= $form_field_name[$i];
					$field_data_inner['form_field_attr_id']= $form_field_attr_id[$i];
					$field_data_inner['form_field_class']= $form_field_class[$i];
					if ($field_data_inner['form_field_type'] == 'select') {
						$field_data_inner['option_fields'] = $form_field_option[$i];
					}

					$field_data_outer[] = $field_data_inner;

				}

				$field_data_outer_serialize = serialize($field_data_outer); 

				global $wpdb;
				$table_name1 = $wpdb->prefix . "aspl_cf_form_data";
				$data = [ 
					'template_title' => $form_title,
					'template_subtitle' => $form_subtitle,
				    'template_shortcode' => $form_shortcode,
				    'template_date' => $date, 
				    'template_field_data' => $field_data_outer_serialize,
				    'template_email_to' => $to,
					'template_email_subject' => $subject,
					'template_email_msg' => $msg
				]; 
				$where = [ 'template_id' => $id ];
				$wpdb->update( $wpdb->prefix . 'aspl_cf_form_data', $data, $where); 

				wp_redirect( admin_url( '/admin.php?page=aspl_contact_form' ) );

		}

    }else{
	
		?>
		<div class="aspl-cf-add-new-main">
			<div class="aspl-cf-title"><h1> Create Form </h1></div>
			<div class="aspl-cf-body-content">
				<form method="POST">
					<div class="aspl_cf_addnew_genral_section">
						<h2><li>Genral</li></h2>
						<table style="border-spacing: 15px;border-collapse: separate;">
							<tr>
								<td><label>Form Title : </label></td>
								<td><input type="Text" name="aspl_cf_title"></td>
								<td></td>
								<td>Shortcode : </td>
								<td>[aspl-contact-form text="<input type="Text" name="aspl_cf_shortcode" class="aspl-fc-shortcode-textbox" >"]</td>
							</tr>
							<tr>
								<td>
									<label>Subtitle:</label>
								</td>
								<td colspan="4"><input type="Text" name="aspl_cf_subtitle" style="width:75%;"></td>
							</tr>
							<!-- <tr>
								<td><label>Use Email : </label></td>
								<td>
									<label class="switch">
									  	<input type="checkbox" class="aspl_pop_switch" name="aspl_pop_add_custon_image_status" value="enable" checked="true">
									  	<span class="slider round"></span>
									</label>
								</td>
							</tr> -->
	<!-- 							<tr>
									
								</tr> -->
						</table>			
					</div>
					<div>
						<h2><li>Add Fields</li></h2>
						<div class="aspl-cf-fields-table">
							<table style="width: 100%;"  class="aspl-cf-field-table" >
								<thead>	
									<tr>
										<th></th>
										<th>Select</th>
										<th>Lable</th>
										<th>Fields</th>
										<th>Name</th>
										<th>ID</th>
										<th>Class</th>
									</tr>
								</thead>
								<tbody>
									<tr class="tr">
										<td><span class="dashicons dashicons-move"></span></td>
										<td>
											<input type="checkbox" name="aspl_cf_delete">
											<input type="hidden" name="record[]">
										</td>
										<td><input type="text" name="aspl_cf_field_lable[]" class="aspl-input"></td>
										<td>
											<select class="aspl-input aspl_select_field" name="aspl_cf_field_type[]" >
												<option> ----- Select ----- </option>
												<option value="text">TextBox</option>
												<option value="email">E-mail</option>
												<option value="number">Number</option>
												<!-- <option value="password">Password</option> -->
												<option value="submit">Submit</option>
												<option value="reset">Reset</option>
												<option value="textarea">Textarea</option>
												<option value="date">Date</option>
												<option value="select">Select-Option</option>
											</select>
											<textarea name="aspl_field_add_option[]" class="aspl_cf_option_fields" style="display:none;" >Option1|Option2</textarea>
										</td>
										<td><input type="text" name="aspl_cf_field_name[]" class="aspl-input"></td>
										<td><input type="text" name="aspl_cf_field_attr_id[]" class="aspl-input"></td>
										<td><input type="text" name="aspl_cf_field_class[]" class="aspl-input"></td>
										<!-- <tr class="aspl_cf_option_fields" style="display:none;">
											<td></td>
											<td></td>
											<td></td>
											<td></td>
											<td >
												<textarea name="aspl_field_add_option[]">Option1|Option2</textarea>
											</td>	
											<td></td>
											<td></td>
										</tr> -->
									</tr>
								</tbody>
							</table>
							<div class="aspl-cf-row-button-section">
								<br><span class="button-primary aspl-cf-button add-row">Add Row</span> &nbsp <span class="button-primary aspl-cf-button delete-row"> Delete Row</span><br>
							</div>
						</div>
					</div>
					<div>
						<h2><li>E-mail Setting</li></h2>
						<div class="aspl_cf_email_switch">
							<table class="aspl_cf_email_config_switch_table">
								<tr>
									<td>Email</td>
									<td>
										<label class="switch">
										  	<input type="checkbox" class="aspl_cf_email_switch_check" name="aspl_cf_email_switch" value="enable" >
										  	<span class="slider round"></span>

										</label>
									</td>	
									<td><p><strong>*</strong> This Email setting is work on 'Submit' type of field.</p></td>
								</tr>
							</table>
						</div>
						<div class="aspl_email_config_section" >
							<table class="aspl_cf_email_config_table">
								<tr>
									<td>To</td>
									<?php 

										$current_user = wp_get_current_user();
										$to_email = $current_user->user_email;
										$subject = 'Your Subject';
										$messages = 'Your Messages';

									 ?>
									<td><input type="email" class="aspl-input" name="aspl_cf_email_to" value="<?php _e($to_email); ?>"></td>
								</tr>
<!-- 								<tr>
									<td>From</td>
									<td><input type="email" class="aspl-input" name=""></td>
								</tr> -->
								<tr>
									<td>Subject</td>
									<td><input type="text" class="aspl-input" name="aspl_cf_email_subject" value="<?php _e($subject); ?>"></td>
								</tr>
								<tr>
									<td>Message</td>
									<td><textarea class="aspl-input" name="aspl_cf_email_msg"><?php _e($messages); ?></textarea></td>
								</tr>
							</table>
						</div>
					</div>
					<div class="aspl-cf-save-button-div">
						<input type="submit" name="aspl_cf_form_create_btn" class="button button-primary aspl-cf-button" value="Create">
					</div>
				</form>
			</div>
		</div>

		<?php 

			if (isset($_POST['aspl_cf_form_create_btn'])) {
				
				$form_title = sanitize_text_field($_POST['aspl_cf_title']);
				$form_subtitle = sanitize_text_field($_POST['aspl_cf_subtitle']);
				$form_shortcode = sanitize_text_field($_POST['aspl_cf_shortcode']);

				if ( !empty($form_title) && !empty($form_shortcode) ){


					$field_data_inner = array();
					$field_data_outer = array();

					$form_field_lable = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_lable']);
					$form_field_type = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_type']);
					$form_field_name = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_name']);
					$form_field_attr_id = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_attr_id']);
					$form_field_class = array_map( 'sanitize_text_field', $_POST['aspl_cf_field_class']);
					$form_field_option = array_map( 'sanitize_text_field', $_POST['aspl_field_add_option']);
					
					// $switch_status = $_POST['aspl_cf_email_switch'];
					// var_dump($switch_status);

					if ($_POST['aspl_cf_email_switch'] != '') {
						
						$to = sanitize_email($_POST['aspl_cf_email_to']);
						$subject = sanitize_text_field($_POST['aspl_cf_email_subject']);
						$msg = sanitize_text_field($_POST['aspl_cf_email_msg']);
						
					}else{

						$to = '';
						$subject = '';
						$msg = '';

					}

					$date = date("Y-m-d H:i:s");

					$record = array_map('sanitize_text_field',$_POST['record']);
					$rec_count = count($record);

					for( $i = 0 ;$i < $rec_count ; $i++ ){

						$field_data_inner['form_field_lable'] = $form_field_lable[$i];
						$field_data_inner['form_field_type']= $form_field_type[$i];
						$field_data_inner['form_field_name']= $form_field_name[$i];
						$field_data_inner['form_field_attr_id']= $form_field_attr_id[$i];
						$field_data_inner['form_field_class']= $form_field_class[$i];
						if ($field_data_inner['form_field_type'] == 'select') {
							$field_data_inner['option_fields'] = $form_field_option[$i];
						}

						$field_data_outer[] = $field_data_inner;

					}

					$field_data_outer_serialize = serialize($field_data_outer); 

					global $wpdb;
					$table_name1 = $wpdb->prefix . "aspl_cf_form_data";
					$q = $wpdb->insert($table_name1, array(
							    'template_title' => $form_title,
							    'template_subtitle' => $form_subtitle,
							    'template_shortcode' => $form_shortcode,
							    'template_date' => $date, 
							    'template_field_data' => $field_data_outer_serialize,
							    'template_email_to' => $to,
							    'template_email_subject' => $subject,
							    'template_email_msg' => $msg,
							));

					wp_redirect( admin_url( '/admin.php?page=aspl_contact_form' ) );

				}else{

					

				}
				
			}

	}
?>