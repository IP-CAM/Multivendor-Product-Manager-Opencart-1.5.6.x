<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
  <?php if ($success) { ?><div class="success"><?php echo $success; ?></div><?php } ?>
  <?php if ($error) { ?><div class="warning"><?php echo $error; ?></div><?php } ?>
  <?php if ($error_warning) { ?><div class="warning"><?php echo $error_warning; ?></div><?php } ?>

  <div class="box">
    <div class="heading">
      <h1><img src="view/image/module.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons">
        <a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a>
        <a onclick="location = '<?php echo $cancel; ?>';" class="button"><?php echo $button_cancel; ?></a>
        <a onclick="location = '<?php echo $update; ?>';" class="button" style="background-color:#545454;"><?php echo $button_update; ?></a>
      </div>
    </div>
    <div class="content">
      <div id="tabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-member"><?php echo $tab_member; ?></a><a href="#tab-data"><?php echo $tab_data; ?></a><a href="#tab-registration"><?php echo $tab_registration; ?></a><a href="#tab-report"><?php echo $tab_report; ?></a><a href="#tab-image"><?php echo $tab_image; ?></a><a href="#tab-info"><?php echo $tab_info; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
		<div id="tab-general">
		
		  <table class="form">
			<tr>
				<td style="border-bottom:none;"><?php echo $entry_status; ?></td>
				<td style="border-bottom:none;"><select name="cpm_status">
					<?php if ($cpm_status) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
				  </select></td>
			</tr>
		  </table>
			  
			<div id="tabs-general" class="htabs"><a href="#tab-general-default"><?php echo $tab_general_defaults; ?></a><a href="#tab-general-settings"><?php echo $tab_general_settings; ?></a></div>
			<div id="tab-general-default">			  
			  <h2><?php echo $heading_defaults; ?></h2>
			  
			  <table class="form"> 
				<tr>
					<td><?php echo $entry_customer_group; ?></td>
					<td>
						<select name="cpm_customer_group">
						<option value="0" selected="selected"><?php echo $text_none; ?></option>
						<?php foreach ($customer_groups as $customer_group) { ?>
						<?php if ($customer_group['customer_group_id'] == $cpm_customer_group) { ?>
						<option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
						<?php } else { ?>
						<option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
						<p><small><?php echo $text_customer_group_help; ?></small></p>
					   <?php if ($error_customer_group) { ?>
						 <span class="error"><?php echo $error_customer_group; ?></span>
					   <?php } ?>
					</td>
				</tr>
				<tr>
					<td><span class="required">*</span> <?php echo $entry_products_max; ?></td>
					<td>
						<input type="text" name="cpm_products_max" value="<?php echo $cpm_products_max; ?>" size="4" />
						<p><small><?php echo $text_products_max_help; ?></small></p>
						<?php if ($error_products_max) { ?>
							<span class="error"><?php echo $error_products_max; ?></span>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_commission_rate; ?></td>
					<td>
						<input type="text" name="cpm_commission_rate" value="<?php echo $cpm_commission_rate; ?>" size="4" /> %
						<p><small><?php echo $text_commission_rate_help; ?></small></p>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_image_upload_directory; ?></td>
					<td>
						<input type="text" name="cpm_image_upload_directory" value="<?php echo $cpm_image_upload_directory; ?>" size="12" />
						<p><small><?php echo $text_image_upload_directory_help; ?></small></p>
						<?php if ($error_image_upload_directory) { ?>
							<span class="error"><?php echo $error_image_upload_directory; ?></span>
						<?php } ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_download_directory; ?></td>
					<td>
						<input type="text" name="cpm_download_directory" value="<?php echo $cpm_download_directory; ?>" size="12" />
						<p><small><?php echo $text_download_directory_help; ?></small></p>
						<?php if ($error_download_directory) { ?>
							<span class="error"><?php echo $error_download_directory; ?></span>
						<?php } ?>
					</td>
				</tr>
			  </table>
			  </div>
			  
			  <div id="tab-general-settings">
			  <h2><?php echo $heading_general_settings; ?></h2>
			  
			  <table class="form">
				<tr>
					<td><?php echo $entry_auto_approve_products; ?></td>
					<td><select name="cpm_auto_approve_products">
						<?php if ($cpm_auto_approve_products) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select>
					  <p><small><?php echo $text_auto_approve_products_help; ?></small></p></td>
				</tr>
				<tr>
					<td><?php echo $entry_email_new_products; ?></td>
					<td><select name="cpm_email_new_products">
						<?php if ($cpm_email_new_products) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select>
					  <p><small><?php echo $text_email_new_products_help; ?></small></p></td>
				</tr>
				<tr>
					<td><?php echo $entry_email_customers; ?></td>
					<td><select name="cpm_email_customers">
						<?php if ($cpm_email_customers) { ?>
						<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						<option value="0"><?php echo $text_disabled; ?></option>
						<?php } else { ?>
						<option value="1"><?php echo $text_enabled; ?></option>
						<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						<?php } ?>
					  </select>
					  <p><small><?php echo $text_email_customers_help; ?></small></p>
					  <?php if (!$this->config->get('config_alert_mail')) { ?>
							<span class="error"><?php echo $error_email_customers; ?></span>
					  <?php } ?></td>
				</tr>
				<tr>
					<td><?php echo $entry_paypal_email; ?></td>
					<td>
						<input type="text" name="cpm_paypal_email" value="<?php echo $cpm_paypal_email; ?>" size="25" />
						<p><small><?php echo $text_paypal_email_help; ?></small></p>
					</td>
				</tr>
			  </table>
			  </div>
         </div>
         
         <div id="tab-member">
		
		  <table class="form">
			<tr>
				<td style="border-bottom:none;"><?php echo $entry_member_pages; ?></td>
				<td style="border-bottom:none;"><select name="cpm_member_pages">
					<?php if ($cpm_member_pages) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
				  </select>&nbsp;&nbsp;<small><?php echo $text_member_pages_help; ?></small></td>
			</tr>
		  </table>
		  
			<div id="tabs-member" class="htabs"><a href="#tab-members-list"><?php echo $tab_members_list; ?></a><a href="#tab-member-pages"><?php echo $tab_member_pages; ?></a><a href="#tab-member-module"><?php echo $tab_member_module; ?></a></div>
			<div id="tab-members-list">
					 
				<h2><?php echo $heading_members_list; ?></h2>
				  <table class="form">
		            <tr>
		                <td><?php echo $entry_member_nav_menu; ?></td>
		                <td><select name="cpm_members_nav_menu">
		                    <?php if ($cpm_members_nav_menu) { ?>
		                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
		                    <option value="0"><?php echo $text_disabled; ?></option>
		                    <?php } else { ?>
		                    <option value="1"><?php echo $text_enabled; ?></option>
		                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
		                    <?php } ?>
		                  </select>
		                  <p><small><?php echo $text_member_nav_menu_help; ?></small></p></td>
		            </tr>
					<tr>
		                <td><?php echo $entry_member_sort; ?></td>
						<td>
							<?php if ($cpm_members_list_sort) { ?>
								<input type="radio" name="cpm_members_list_sort" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_members_list_sort" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_members_list_sort" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_members_list_sort" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_member_sort_help; ?></small></p>
						</td>
					</tr>
		          </table>
			 
				  <div id="tabs-members-list-languages" class="htabs">
					<?php foreach ($languages as $language) { ?>
					<a href="#tabs-members-list-language<?php echo $language['language_id']; ?>"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a>
					<?php } ?>
				  </div>
				  <?php foreach ($languages as $language) { ?>
				  <div id="tabs-members-list-language<?php echo $language['language_id']; ?>">
					<table class="form">
					  <tr>
						<td><span class="required">*</span> <?php echo $entry_name; ?></td>
						<td><input type="text" name="cpm_members_list_description[<?php echo $language['language_id']; ?>][name]" size="100" value="<?php echo isset($cpm_members_list_description[$language['language_id']]) ? $cpm_members_list_description[$language['language_id']]['name'] : ''; ?>" />
						  <?php if (isset($error_members_list_name[$language['language_id']])) { ?>
						  <span class="error"><?php echo $error_members_list_name[$language['language_id']]; ?></span>
						  <?php } ?></td>
					  </tr>
					  <tr>
						<td><?php echo $entry_meta_description; ?></td>
						<td><textarea name="cpm_members_list_description[<?php echo $language['language_id']; ?>][meta_description]" cols="40" rows="5"><?php echo isset($cpm_members_list_description[$language['language_id']]) ? $cpm_members_list_description[$language['language_id']]['meta_description'] : ''; ?></textarea></td>
					  </tr>
					  <tr>
						<td><?php echo $entry_meta_keyword; ?></td>
						<td><textarea name="cpm_members_list_description[<?php echo $language['language_id']; ?>][meta_keyword]" cols="40" rows="5"><?php echo isset($cpm_members_list_description[$language['language_id']]) ? $cpm_members_list_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea></td>
					  </tr>
					  <tr>
						<td><?php echo $entry_description; ?></td>
						<td><textarea name="cpm_members_list_description[<?php echo $language['language_id']; ?>][description]" id="members-list-description<?php echo $language['language_id']; ?>"><?php echo isset($cpm_members_list_description[$language['language_id']]) ? $cpm_members_list_description[$language['language_id']]['description'] : ''; ?></textarea></td>
					  </tr>
					</table>
				  </div>
				  <?php } ?>
				  <table class="form">
					<tr>
					  <td><?php echo $entry_keyword; ?></td>
					  <td><input type="text" name="cpm_members_list_keyword" value="<?php echo $cpm_members_list_keyword; ?>" /></td>
					</tr>
					<tr>
					  <td><?php echo $entry_image; ?></td>
					  <td valign="top"><div class="image"><img src="<?php echo $cpm_members_list_thumb; ?>" alt="" id="cpm_members_list_thumb" />
						  <input type="hidden" name="cpm_members_list_image" value="<?php echo $cpm_members_list_image; ?>" id="cpm_members_list_image" />
						  <br />
						  <a onclick="image_upload('cpm_members_list_image', 'cpm_members_list_thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#cpm_members_list_thumb').attr('src', '<?php echo $no_image; ?>'); $('#cpm_members_list_image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
					</tr>
				  </table>		
			</div>
			
			<div id="tab-member-pages">
				<h2><?php echo $heading_member_pages; ?></h2>

			    <!--<h3><?php echo $heading_general_settings; ?></h3>-->
		
			    <h3><?php echo $heading_custom_fields; ?></h3>

				<table class="form">
		            <tr>
		                <td><?php echo $entry_cpm_display_custom_fields; ?></td>
		                <td>
		                    <?php if ($cpm_display_custom_fields) { ?>
		                        <input type="radio" name="cpm_display_custom_fields" value="1" checked="checked" /><?php echo $text_yes; ?>
		                        <input type="radio" name="cpm_display_custom_fields" value="0" /><?php echo $text_no; ?>
		                    <?php } else { ?>
		                        <input type="radio" name="cpm_display_custom_fields" value="1" /><?php echo $text_yes; ?>
		                        <input type="radio" name="cpm_display_custom_fields" value="0" checked="checked" /><?php echo $text_no; ?>
		                    <?php } ?>
		                    <p><small><?php echo $text_display_custom_fields_help; ?></small></p>
		                </td>
		            </tr>
				   <tr><td colspan="2"><p><?php echo $text_custom_fields_help; ?></p></td></tr>
				   <tr>
				      <td><?php echo $entry_cpm_custom_field_01; ?></td>
				      <td><input type="text" name="cpm_custom_field_01" value="<?php echo $cpm_custom_field_01; ?>" /></td>
				    </tr>
				    <tr>
				      <td><?php echo $entry_cpm_custom_field_02; ?></td>
				      <td><input type="text" name="cpm_custom_field_02" value="<?php echo $cpm_custom_field_02; ?>" /></td>
				    </tr>
				    <tr>
				      <td><?php echo $entry_cpm_custom_field_03; ?></td>
				      <td><input type="text" name="cpm_custom_field_03" value="<?php echo $cpm_custom_field_03; ?>" /></td>
				    </tr>
				   <tr>
				      <td><?php echo $entry_cpm_custom_field_04; ?></td>
				      <td><input type="text" name="cpm_custom_field_04" value="<?php echo $cpm_custom_field_04; ?>" /></td>
				    </tr>
				    <tr>
				      <td><?php echo $entry_cpm_custom_field_05; ?></td>
				      <td><input type="text" name="cpm_custom_field_05" value="<?php echo $cpm_custom_field_05; ?>" /></td>
				    </tr>
				    <tr>
				      <td><?php echo $entry_cpm_custom_field_06; ?></td>
				      <td><input type="text" name="cpm_custom_field_06" value="<?php echo $cpm_custom_field_06; ?>" /></td>
				    </tr>
				</table>
				</div>

			<div id="tab-member-module">
				<h2><?php echo $heading_member_module; ?></h2>
			
				<table id="member-module" class="list">
				  <thead>
					<tr>
					  <td class="left"><?php echo $entry_module_limit; ?></td>
					  <td class="left"><?php echo $entry_module_image; ?></td>
					  <td class="left"><?php echo $entry_module_order_by; ?></td>
					  <td class="left"><?php echo $entry_module_custom_fields; ?></td>
					  <td class="left"><?php echo $entry_module_product_count; ?></td>
					  <td class="left"><?php echo $entry_module_layout; ?></td>
					  <td class="left"><?php echo $entry_module_position; ?></td>
					  <td class="left"><?php echo $entry_module_status; ?></td>
					  <td class="right"><?php echo $entry_module_sort_order; ?></td>
					  <td></td>
					</tr>
				  </thead>
				  <?php $member_module_row = 0; ?>
				  <?php foreach ($member_modules as $member_module) { ?>
				  <tbody id="member-module-row<?php echo $member_module_row; ?>">
					<tr>
					  <td class="left"><input type="text" name="cpm_module[<?php echo $member_module_row; ?>][limit]" value="<?php echo $member_module['limit']; ?>" size="1" /></td>
					  <td class="left"><input type="text" name="cpm_module[<?php echo $member_module_row; ?>][image_width]" value="<?php echo $member_module['image_width']; ?>" size="3" />
						<input type="text" name="cpm_module[<?php echo $member_module_row; ?>][image_height]" value="<?php echo $member_module['image_height']; ?>" size="3" />
						<?php if (isset($error_module_image[$member_module_row])) { ?>
						<span class="error"><?php echo $error_module_image[$member_module_row]; ?></span>
						<?php } ?></td>
					  <td>
						<select name="cpm_module[<?php echo $member_module_row; ?>][order_by]">
						<?php foreach ($sort_data as $order_by) { ?>
						<?php if ($order_by['value'] == $member_module['order_by']) { ?>
						  <option value="<?php echo $order_by['value']; ?>" selected="selected"><?php echo $order_by['name']; ?></option>
						<?php } else { ?>
						  <option value="<?php echo $order_by['value']; ?>"><?php echo $order_by['name']; ?></option>
						<?php } ?>
						<?php } ?>
						</select>
						<select name="cpm_module[<?php echo $member_module_row; ?>][order]">
						  <option value="<?php echo $text_asc; ?>" <?php echo ($text_asc == $member_module['order'] ? 'selected="selected"' : ''); ?>><?php echo $text_asc; ?></option>
						  <option value="<?php echo $text_desc; ?>" <?php echo ($text_desc == $member_module['order'] ? 'selected="selected"' : ''); ?>><?php echo $text_desc; ?></option>
						</select>
					  </td>
					  <td class="left">
						  <?php if (isset($member_module['custom_fields'])) { ?>
						  <input type="checkbox" name="cpm_module[<?php echo $member_module_row; ?>][custom_fields]" value="1" checked="checked" />&nbsp;<?php echo $text_display; ?>
						  <?php } else { ?>
						  <input type="checkbox" name="cpm_module[<?php echo $member_module_row; ?>][custom_fields]" value="1" />&nbsp;<?php echo $text_display; ?>
						  <?php } ?></td>
					  <td class="left">
						  <?php if (isset($member_module['product_count'])) { ?>
						  <input type="checkbox" name="cpm_module[<?php echo $member_module_row; ?>][product_count]" value="1" checked="checked" />&nbsp;<?php echo $text_display; ?>
						  <?php } else { ?>
						  <input type="checkbox" name="cpm_module[<?php echo $member_module_row; ?>][product_count]" value="1" />&nbsp;<?php echo $text_display; ?>
						  <?php } ?></td>
					  <td class="left"><select name="cpm_module[<?php echo $member_module_row; ?>][layout_id]">
						  <?php foreach ($layouts as $layout) { ?>
						  <?php if ($layout['layout_id'] == $member_module['layout_id']) { ?>
						  <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
						  <?php } else { ?>
						  <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
						  <?php } ?>
						  <?php } ?>
						</select></td>
					  <td class="left"><select name="cpm_module[<?php echo $member_module_row; ?>][position]">
						  <?php if ($member_module['position'] == 'content_top') { ?>
						  <option value="content_top" selected="selected"><?php echo $text_content_top; ?></option>
						  <?php } else { ?>
						  <option value="content_top"><?php echo $text_content_top; ?></option>
						  <?php } ?>
						  <?php if ($member_module['position'] == 'content_bottom') { ?>
						  <option value="content_bottom" selected="selected"><?php echo $text_content_bottom; ?></option>
						  <?php } else { ?>
						  <option value="content_bottom"><?php echo $text_content_bottom; ?></option>
						  <?php } ?>
						  <?php if ($member_module['position'] == 'column_left') { ?>
						  <option value="column_left" selected="selected"><?php echo $text_column_left; ?></option>
						  <?php } else { ?>
						  <option value="column_left"><?php echo $text_column_left; ?></option>
						  <?php } ?>
						  <?php if ($member_module['position'] == 'column_right') { ?>
						  <option value="column_right" selected="selected"><?php echo $text_column_right; ?></option>
						  <?php } else { ?>
						  <option value="column_right"><?php echo $text_column_right; ?></option>
						  <?php } ?>
						</select></td>
					  <td class="left"><select name="cpm_module[<?php echo $member_module_row; ?>][status]">
						  <?php if ($member_module['status']) { ?>
						  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
						  <option value="0"><?php echo $text_disabled; ?></option>
						  <?php } else { ?>
						  <option value="1"><?php echo $text_enabled; ?></option>
						  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
						  <?php } ?>
						</select></td>
					  <td class="right"><input type="text" name="cpm_module[<?php echo $member_module_row; ?>][sort_order]" value="<?php echo $member_module['sort_order']; ?>" size="3" /></td>
					  <td class="left"><a onclick="$('#member-module-row<?php echo $member_module_row; ?>').remove();" class="button"><?php echo $button_remove; ?></a></td>
					</tr>
				  </tbody>
				  <?php $member_module_row++; ?>
				  <?php } ?>
				  <tfoot>
					<tr>
					  <td colspan="9"></td>
					  <td class="left"><a onclick="addMemberModule();" class="button"><?php echo $button_add_module; ?></a></td>
					</tr>
				  </tfoot>
				</table>
			</div>
			          
         </div>
         
         <div id="tab-data">
		
		  <table class="form">
			<tr>
				<td style="border-bottom:none;"><?php echo $entry_product_manager; ?></td>
				<td style="border-bottom:none;"><select name="cpm_product_manager">
					<?php if ($cpm_product_manager) { ?>
					<option value="1" selected="selected"><?php echo $text_enabled; ?></option>
					<option value="0"><?php echo $text_disabled; ?></option>
					<?php } else { ?>
					<option value="1"><?php echo $text_enabled; ?></option>
					<option value="0" selected="selected"><?php echo $text_disabled; ?></option>
					<?php } ?>
				  </select>&nbsp;&nbsp;<small><?php echo $text_product_manager_help; ?></small></td>
			</tr>
            <tr>
				<td style="border-bottom:none;"><?php echo $entry_product_manager_limit; ?></td>
				<td style="border-bottom:none;">
					<input type="text" name="cpm_product_manager_limit" value="<?php echo $cpm_product_manager_limit; ?>" size="4" />
					&nbsp;&nbsp;<small><?php echo $text_product_manager_limit_help; ?></small>
					<?php if ($error_product_manager_limit) { ?>
						<span class="error"><?php echo $error_product_manager_limit; ?></span>
					<?php } ?>
				</td>
			</tr>
		  </table>
		    
			<div id="tabs-data" class="htabs"><a href="#tab-data-general"><?php echo $tab_data_general; ?></a><a href="#tab-data-data"><?php echo $tab_data_data; ?></a><a href="#tab-data-links"><?php echo $tab_data_links; ?></a><a href="#tab-data-other"><?php echo $tab_data_other; ?></a></div>
			<div id="tab-data-general">	  
			  <table class="form">
				<tr>
					<td style="border-bottom:none;"><?php echo $entry_tab_general; ?></td>
					<td style="border-bottom:none;">
						<?php if ($cpm_tab_general) { ?>
							<input type="radio" name="cpm_tab_general" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_general" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_general" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_general" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_general_help; ?></small></p>
					</td>
				</tr>
			  </table>
			  
			  <h2><?php echo $heading_tab_general; ?></h2>
				<table class="form">
					<tr>
						<td><?php echo $entry_data_field_description; ?></td>
						<td>
							<?php echo $text_min; ?>:&nbsp;<input type="text" name="cpm_data_field_description_min" value="<?php echo $cpm_data_field_description_min; ?>" size="4" />&nbsp;&nbsp;&nbsp;
							<?php echo $text_max; ?>:&nbsp;<input type="text" name="cpm_data_field_description_max" value="<?php echo $cpm_data_field_description_max; ?>" size="4" />
							<p><small><?php echo $text_data_field_description_help; ?></small></p>
						</td>
					</tr>  
					<tr>
		                <td><?php echo $entry_data_field_metas; ?></td>
						<td>
							<?php if ($cpm_data_field_metas) { ?>
								<input type="radio" name="cpm_data_field_metas" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_metas" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_metas" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_metas" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_metas_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_tags; ?></td>
						<td>
							<?php if ($cpm_data_field_tags) { ?>
								<input type="radio" name="cpm_data_field_tags" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_tags" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_tags" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_tags" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_tags_help; ?></small></p>
						</td>
					</tr>
				</table>
					
			</div>
			
			<div id="tab-data-data">			  
			  <table class="form">
				<tr>
					<td style="border-bottom:none;"><?php echo $entry_tab_data; ?></td>
					<td style="border-bottom:none;">
						<?php if ($cpm_tab_data) { ?>
							<input type="radio" name="cpm_tab_data" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_data" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_data" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_data" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_data_help; ?></small></p>
					</td>
				</tr>
			  </table>
			  
			  <h2><?php echo $heading_tab_data; ?></h2>
			  <table class="form">
					<tr>
						<td><?php echo $entry_data_field_image; ?></td>
						<td>
							<?php if ($cpm_data_field_image) { ?>
								<input type="radio" name="cpm_data_field_image" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_image" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_image" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_image" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_image_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_model; ?></td>
						<td>
							<?php if ($cpm_data_field_model) { ?>
								<input type="radio" name="cpm_data_field_model" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_model" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_model" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_model" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_model_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_location; ?></td>
						<td>
							<?php if ($cpm_data_field_location) { ?>
								<input type="radio" name="cpm_data_field_location" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_location" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_location" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_location" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_location_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_tax; ?></td>
						<td>
							<?php if ($cpm_data_field_tax) { ?>
								<input type="radio" name="cpm_data_field_tax" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_tax" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_tax" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_tax" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_tax_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_quantity; ?></td>
						<td>
							<?php if ($cpm_data_field_quantity) { ?>
								<input type="radio" name="cpm_data_field_quantity" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_quantity" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_quantity" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_quantity" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_quantity_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_stock; ?></td>
						<td>
							<?php if ($cpm_data_field_stock) { ?>
								<input type="radio" name="cpm_data_field_stock" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_stock" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_stock" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_stock" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_stock_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_shipping; ?></td>
						<td>
							<?php if ($cpm_data_field_shipping) { ?>
								<input type="radio" name="cpm_data_field_shipping" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_shipping" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_shipping" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_shipping" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_shipping_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_keyword; ?></td>
						<td>
							<?php if ($cpm_data_field_keyword) { ?>
								<input type="radio" name="cpm_data_field_keyword" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_keyword" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_keyword" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_keyword" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_keyword_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_date; ?></td>
						<td>
							<?php if ($cpm_data_field_date) { ?>
								<input type="radio" name="cpm_data_field_date" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_date" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_date" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_date" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_date_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_dimensions; ?></td>
						<td>
							<?php if ($cpm_data_field_dimensions) { ?>
								<input type="radio" name="cpm_data_field_dimensions" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_dimensions" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_dimensions" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_dimensions" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_dimensions_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_weight; ?></td>
						<td>
							<?php if ($cpm_data_field_weight) { ?>
								<input type="radio" name="cpm_data_field_weight" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_weight" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_weight" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_weight" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_weight_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_sort_order; ?></td>
						<td>
							<?php if ($cpm_data_field_sort_order) { ?>
								<input type="radio" name="cpm_data_field_sort_order" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_sort_order" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_sort_order" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_sort_order" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_sort_order_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_part_numbers; ?></td>
						<td>
							<?php if ($cpm_data_field_part_numbers) { ?>
								<input type="radio" name="cpm_data_field_part_numbers" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_part_numbers" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_part_numbers" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_part_numbers" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_part_numbers_help; ?></small></p>
						</td>
					</tr>
			  </table>
			  
			</div>
			
			<div id="tab-data-links">			  
			  <table class="form">
				<tr>
					<td style="border-bottom:none;"><?php echo $entry_tab_links; ?></td>
					<td style="border-bottom:none;">
						<?php if ($cpm_tab_links) { ?>
							<input type="radio" name="cpm_tab_links" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_links" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_links" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_links" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_links_help; ?></small></p>
					</td>
				</tr>
			  </table>
			  
			  <h2><?php echo $heading_tab_links; ?></h2>
			  <table class="form">
					<tr>
						<td><?php echo $entry_data_field_category; ?></td>
						<td>
							<?php if ($cpm_data_field_category) { ?>
								<input type="radio" name="cpm_data_field_category" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_category" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_category" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_category" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_category_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_manufacturer; ?></td>
						<td>
							<?php if ($cpm_data_field_manufacturer) { ?>
								<input type="radio" name="cpm_data_field_manufacturer" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_manufacturer" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_manufacturer" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_manufacturer" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_manufacturer_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_filter; ?></td>
						<td>
							<?php if ($cpm_data_field_filter) { ?>
								<input type="radio" name="cpm_data_field_filter" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_filter" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_filter" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_filter" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_filter_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_store; ?></td>
						<td>
							<?php if ($cpm_data_field_store) { ?>
								<input type="radio" name="cpm_data_field_store" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_store" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_store" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_store" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_store_help; ?></small></p>
						</td>
					</tr>
					<tr>
						<td><?php echo $entry_data_field_related; ?></td>
						<td>
							<?php if ($cpm_data_field_related) { ?>
								<input type="radio" name="cpm_data_field_related" value="1" checked="checked" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_related" value="0" /><?php echo $text_no; ?>
							<?php } else { ?>
								<input type="radio" name="cpm_data_field_related" value="1" /><?php echo $text_yes; ?>
								<input type="radio" name="cpm_data_field_related" value="0" checked="checked" /><?php echo $text_no; ?>
							<?php } ?>
							<p><small><?php echo $text_data_field_related_help; ?></small></p>
						</td>
					</tr>
			  </table>
			</div>
			
			<div id="tab-data-other">
			  <h2><?php echo $heading_tab_other; ?></h2>
			  
			  <table class="form">
				<tr>
					<td><?php echo $entry_tab_download; ?></td>
					<td>
						<?php if ($cpm_tab_download) { ?>
							<input type="radio" name="cpm_tab_download" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_download" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_download" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_download" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_download_help; ?></small></p>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_tab_attribute; ?></td>
					<td>
						<?php if ($cpm_tab_attribute) { ?>
							<input type="radio" name="cpm_tab_attribute" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_attribute" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_attribute" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_attribute" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_attribute_help; ?></small></p>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_tab_option; ?></td>
					<td>
						<?php if ($cpm_tab_option) { ?>
							<input type="radio" name="cpm_tab_option" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_option" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_option" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_option" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_option_help; ?></small></p>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_tab_profile; ?></td>
					<td>
						<?php if ($cpm_tab_profile) { ?>
							<input type="radio" name="cpm_tab_profile" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_profile" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_profile" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_profile" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_profile_help; ?></small></p>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_tab_discount; ?></td>
					<td>
						<?php if ($cpm_tab_discount) { ?>
							<input type="radio" name="cpm_tab_discount" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_discount" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_discount" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_discount" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_discount_help; ?></small></p>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_tab_special; ?></td>
					<td>
						<?php if ($cpm_tab_special) { ?>
							<input type="radio" name="cpm_tab_special" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_special" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_special" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_special" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_special_help; ?></small></p>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_tab_image; ?></td>
					<td>
						<?php if ($cpm_tab_image) { ?>
							<input type="radio" name="cpm_tab_image" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_image" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_image" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_image" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_image_help; ?></small></p>
					</td>
				</tr>
				<tr>
					<td><?php echo $entry_tab_reward_points; ?></td>
					<td>
						<?php if ($cpm_tab_reward_points) { ?>
							<input type="radio" name="cpm_tab_reward_points" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_reward_points" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_reward_points" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_reward_points" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_reward_points_help; ?></small></p>
					</td>
				</tr>
				 <tr>
					<td><?php echo $entry_tab_design; ?></td>
					<td>
						<?php if ($cpm_tab_design) { ?>
							<input type="radio" name="cpm_tab_design" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_design" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_tab_design" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_tab_design" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_tab_design_help; ?></small></p>
					</td>
				</tr>
			 </table>
			</div>
        </div>
  
        <div id="tab-registration">
		  <table class="form">
            <tr>
                <td style="border-bottom:none;"><?php echo $entry_registration; ?></td>
                <td style="border-bottom:none;"><select name="cpm_registration">
                    <?php if ($cpm_registration) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>&nbsp;&nbsp;<small><?php echo $text_registration_help; ?></small></td>
            </tr>
          </table>
		          
			<h2><?php echo $heading_registration; ?></h2>
	
	          <table class="form">
				 <tr>
					<td><?php echo $entry_member_alias; ?></td>
					<td>
						<?php if ($cpm_member_alias) { ?>
							<input type="radio" name="cpm_member_alias" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_member_alias" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_member_alias" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_member_alias" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_member_alias_help; ?></small></p>
					</td>
				</tr>
				 <tr>
					<td><?php echo $entry_member_directories; ?></td>
					<td>
						<?php if ($cpm_member_directories) { ?>
							<input type="radio" name="cpm_member_directories" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_member_directories" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_member_directories" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_member_directories" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_member_directories_help; ?></small></p>
	                    <?php if ($error_member_directories) { ?>
	                        <span class="error"><?php echo $error_member_directories; ?></span>
	                    <?php } ?>
					</td>
				</tr>
				 <tr>
					<td><?php echo $entry_member_paypal; ?></td>
					<td>
						<?php if ($cpm_member_paypal) { ?>
							<input type="radio" name="cpm_member_paypal" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_member_paypal" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_member_paypal" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_member_paypal" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_member_paypal_help; ?></small></p>
					</td>
				</tr>
				 <tr>
					<td><?php echo $entry_member_paypal_require; ?></td>
					<td>
						<?php if ($cpm_member_paypal_require) { ?>
							<input type="radio" name="cpm_member_paypal_require" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_member_paypal_require" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_member_paypal_require" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_member_paypal_require" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_member_paypal_require_help; ?></small></p>
	                    <?php if ($error_member_paypal_require) { ?>
	                        <span class="error"><?php echo $error_member_paypal_require; ?></span>
	                    <?php } ?>
					</td>
				</tr>
	         </table>       
         </div>
  
        <div id="tab-report">
		  <table class="form">
            <tr>
                <td style="border-bottom:none;"><?php echo $entry_report; ?></td>
                <td style="border-bottom:none;"><select name="cpm_report">
                    <?php if ($cpm_report) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>&nbsp;&nbsp;<small><?php echo $text_report_help; ?></small></td>
            </tr>
          </table>
		          
			<h2><?php echo $heading_report; ?></h2>
	
			<h3><?php echo $heading_report_sales; ?></h3>
	          <table class="form">
	            <tr>
	                <td><?php echo $entry_report_sales_unique; ?></td>
	                <td><select name="cpm_report_sales_unique">
	                    <?php if ($cpm_report_sales_unique) { ?>
	                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                    <option value="0"><?php echo $text_disabled; ?></option>
	                    <?php } else { ?>
	                    <option value="1"><?php echo $text_enabled; ?></option>
	                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	                    <?php } ?>
	                  </select>
	                  <p><small><?php echo $text_report_sales_unique_help; ?></small></p></td>
	            </tr>
	            <tr>
	                <td><?php echo $entry_report_sales_history; ?></td>
	                <td><select name="cpm_report_sales_history">
	                    <?php if ($cpm_report_sales_history) { ?>
	                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
	                    <option value="0"><?php echo $text_disabled; ?></option>
	                    <?php } else { ?>
	                    <option value="1"><?php echo $text_enabled; ?></option>
	                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
	                    <?php } ?>
	                  </select>
	                  <p><small><?php echo $text_report_sales_history_help; ?></small></p></td>
	            </tr>
				 <tr>
					<td><?php echo $entry_report_sales_commission; ?></td>
					<td>
						<?php if ($cpm_report_sales_commission) { ?>
							<input type="radio" name="cpm_report_sales_commission" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_report_sales_commission" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_report_sales_commission" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_report_sales_commission" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_report_sales_commission_help; ?></small></p>
					</td>
				</tr>
				 <tr>
					<td><?php echo $entry_report_sales_tax; ?></td>
					<td>
						<?php if ($cpm_report_sales_tax) { ?>
							<input type="radio" name="cpm_report_sales_tax" value="1" checked="checked" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_report_sales_tax" value="0" /><?php echo $text_no; ?>
						<?php } else { ?>
							<input type="radio" name="cpm_report_sales_tax" value="1" /><?php echo $text_yes; ?>
							<input type="radio" name="cpm_report_sales_tax" value="0" checked="checked" /><?php echo $text_no; ?>
						<?php } ?>
						<p><small><?php echo $text_report_sales_tax_help; ?></small></p>
					</td>
				</tr>
				 <tr>
					<td><?php echo $entry_report_sales_tax_add; ?></td>
	                <td><select name="cpm_report_sales_tax_add">
	                    <?php if ($cpm_report_sales_tax_add) { ?>
	                    <option value="1" selected="selected"><?php echo $text_add; ?></option>
	                    <option value="0"><?php echo $text_subtract; ?></option>
	                    <?php } else { ?>
	                    <option value="1"><?php echo $text_add; ?></option>
	                    <option value="0" selected="selected"><?php echo $text_subtract; ?></option>
	                    <?php } ?>
	                  </select>
						<p><small><?php echo $text_report_sales_tax_add_help; ?></small></p>
	                    <?php if ($error_report_sales_tax_add) { ?>
	                        <span class="error"><?php echo $error_report_sales_tax_add; ?></span>
	                    <?php } ?>
					</td>
				</tr>
	         </table>
	         
	         <h3><?php echo $heading_report_views; ?></h3>
	          <table class="form">
	            <tr>
					<td><?php echo $entry_report_views_limit; ?></td>
					<td>
						<input type="text" name="cpm_report_views_limit" value="<?php echo $cpm_report_views_limit; ?>" size="4" />
						<p><small><?php echo $text_report_views_limit_help; ?></small></p>
						<?php if ($error_report_views_limit) { ?>
							<span class="error"><?php echo $error_report_views_limit; ?></span>
						<?php } ?>
                    </td>				
				</tr>
			  </table>    
         </div>
  
         <div id="tab-image">
			<h2><?php echo $heading_image_upload; ?></h2>
	
	          <table class="form">
	            <tr>
	                <td><?php echo $entry_image_max_number; ?></td>
	                <td>
	                    <input type="text" name="cpm_image_max_number" value="<?php echo $cpm_image_max_number; ?>" size="4" />
	                    <p><small><?php echo $text_image_max_number_help; ?></small></p>
	                    <?php if ($error_image_max_number) { ?>
	                        <span class="error"><?php echo $error_image_max_number; ?></span>
	                    <?php } ?>
	                </td>
	            </tr>
	            <tr>
	                <td><span class="required">*</span> <?php echo $entry_image_upload_filesize_max; ?></td>
	                <td>
	                    <input type="text" name="cpm_image_upload_filesize_max" value="<?php echo $cpm_image_upload_filesize_max; ?>" size="4" /> kB
	                    <p><small><?php echo $text_image_upload_filesize_max_help; ?></small></p>
	                    <?php if ($error_image_upload_filesize_max) { ?>
	                        <span class="error"><?php echo $error_image_upload_filesize_max; ?></span>
	                    <?php } ?>
	                </td>
	            </tr>
	             <tr>
	                <td><span class="required">*</span> <?php echo $entry_image_dimensions_min; ?></td>
	                <td>
	                    <input type="text" name="cpm_image_dimensions_min_width" value="<?php echo $cpm_image_dimensions_min_width; ?>" size="4" /> x
	                    <input type="text" name="cpm_image_dimensions_min_height" value="<?php echo $cpm_image_dimensions_min_height; ?>" size="4" />&nbsp;px
	                    <p><small><?php echo $text_image_dimensions_min_help; ?></small></p>
	                    <?php if ($error_image_dimensions_min) { ?>
	                        <span class="error"><?php echo $error_image_dimensions_min; ?></span>
	                    <?php } ?>
	                </td>
	            </tr>
	              <tr>
	                <td><span class="required">*</span> <?php echo $entry_image_dimensions_resize; ?></td>
	                <td>
	                    <input type="text" name="cpm_image_dimensions_resize_width" value="<?php echo $cpm_image_dimensions_resize_width; ?>" size="4" /> x
	                    <input type="text" name="cpm_image_dimensions_resize_height" value="<?php echo $cpm_image_dimensions_resize_height; ?>" size="4" />&nbsp;px
	                    <p><small><?php echo $text_image_dimensions_resize_help; ?></small></p>
	                    <?php if ($error_image_dimensions_resize) { ?>
	                        <span class="error"><?php echo $error_image_dimensions_resize; ?></span>
	                    <?php } ?>
	                </td>
	            </tr>
	         </table>       
         </div>
        
        <div id="tab-info">
			
			<p>Easy to install, upgrade, and uninstall using scripts built-in to the module.<br />
			<a href="http://code.google.com/p/vqmod/" title="vQmod" target="_blank">vQmod</a> used for file modifications - NO files overwritten from the default OpenCart installation!</p>
        
			<h2><?php echo $heading_information; ?></h2>
			
			<ul>
				<li>Installation: <a href="http://opencart.garudacrafts.com/1561/index.php?route=information/information&information_id=6" title="CPM Installation Instructions" target="_blank">installation and upgrade instructions</a></li>
				<li>FAQ: <a href="http://opencart.garudacrafts.com/1561/index.php?route=information/information&information_id=8" title="CPM FAQ" target="_blank">frequently asked questions and answers</a></li>
				<li>Changelog: <a href="http://opencart.garudacrafts.com/1561/index.php?route=information/information&information_id=7" title="CPM Changelog" target="_blank">list of releases and changes</a></li>
				<li>Features: <a href="http://opencart.garudacrafts.com/1561/index.php?route=information/information&information_id=4" title="CPM Features" target="_blank">list of module features</a></li>
				<li>Files Modified: <a href="http://opencart.garudacrafts.com/1561/index.php?route=information/information&information_id=9" title="CPM Files Modified" target="_blank">list of OpenCart default files modified by the <a href="http://code.google.com/p/vqmod/" title="vQmod" target="_blank">vQmod</a> XML file</a></li>
				<li>Screenshots: <a href="http://opencart.garudacrafts.com/1561/index.php?route=information/information&information_id=10" title="CPM Screenshots" target="_blank">set of annotated screenshot images</a>
			</ul>
			
			<h2><?php echo $heading_instructions; ?></h2>
			  
			  <ol>
				<li>Configure Customer Product Manager (CPM) module settings here (and Upgrade, if necessary)</li>
				<li>Create and manage Member accounts at <a href="<?php echo $members; ?>" title="Admin manage Member Accounts" target="_blank">Admin->Catalog->Member</a> or <a href="/index.php?route=account/register_cpm" title="Membership Registration Form" target="_blank">Store->Register->Member</a></li>
				<li>Create and manage Customer accounts at <a href="<?php echo $customers; ?>" title="Admin manager Customer Accounts" target="_blank">Admin->Sales->Customer</a> or <a href="/index.php?route=account/register_customer" title="Customer Registration Form" target="_blank">Store->Register->Customer</a></li>
				<li>Create and manage Products at <a href="<?php echo $products; ?>" title="Admin manage Products" target="_blank">Admin->Catalog->Products</a> or <a href="/index.php?route=account/product" title="Member Product Manager" target="_blank">Store->Account->Member Product Manager</a></li>
				<li>Review Orders and pay Members at <a href="<?php echo $member_sales_report; ?>" title="Admin Member Sales Report" target="_blank">Admin->Reports->Sales->Member Sales Report</a></li>
			  </ol>
		
			<h2><?php echo $heading_demo; ?><a id="demo"></a></h2>
		
			<p>NOTE: some features in the demo are disabled for security reasons</p>
			<ul>
				<li>Admin - <a href="http://opencart.garudacrafts.com/1561/admin/" title="CPM Demo Admin Dashboard" target="_blank">http://opencart.garudacrafts.com/1561/admin/</a>, login credentials: 'demo', 'demo'</li>
				<li>Store - <a href="http://opencart.garudacrafts.com/1561/" title="CPM Demo Website Store" target="_blank">http://opencart.garudacrafts.com/1561/</a></li>
			</ul>
		
        </div>
      
      <input type="hidden" name="cpm_release" value="10" /><?php // CPM version 2.3.2 ?>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
<?php foreach ($languages as $language) { ?>
CKEDITOR.replace('members-list-description<?php echo $language['language_id']; ?>', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
<?php } ?>
//--></script>
<script type="text/javascript"><!--
function image_upload(field, thumb) {
	$('#dialog').remove();
	$('#content').prepend('<div id="dialog" style="padding: 3px 0px 0px 0px;"><iframe src="index.php?route=common/filemanager&token=<?php echo $token; ?>&field=' + encodeURIComponent(field) + '" style="padding:0; margin: 0; display: block; width: 100%; height: 100%;" frameborder="no" scrolling="auto"></iframe></div>');
	$('#dialog').dialog({
		title: '<?php echo $text_image_manager; ?>',
		close: function (event, ui) {
			if ($('#' + field).attr('value')) {
				$.ajax({
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).val()),
					dataType: 'text',
					success: function(data) {
						$('#' + thumb).replaceWith('<img src="' + data + '" alt="" id="' + thumb + '" />');
					}
				});
			}
		},	
		bgiframe: false,
		width: 800,
		height: 400,
		resizable: false,
		modal: false
	});
};
//--></script>
<script type="text/javascript"><!--
var member_module_row = <?php echo $member_module_row; ?>;

function addMemberModule() {	
	html  = '<tbody id="member-module-row' + member_module_row + '">';
	html += '  <tr>';
	html += '    <td class="left"><input type="text" name="cpm_module[' + member_module_row + '][limit]" value="5" size="1" /></td>';
	html += '    <td class="left"><input type="text" name="cpm_module[' + member_module_row + '][image_width]" value="<?php echo $this->config->get('config_image_product_width'); ?>" size="3" /> <input type="text" name="cpm_module[' + member_module_row + '][image_height]" value="<?php echo $this->config->get('config_image_product_height'); ?>" size="3" /></td>';
	html += '    <td class="left"><select name="cpm_module[' + member_module_row + '][order_by]">';
	<?php foreach ($sort_data as $order_by) { ?>
	html += '      <option value="<?php echo $order_by['value']; ?>"><?php echo $order_by['name']; ?></option>';
	<?php } ?>
	html += '    </select>';
	html += '    <select name="cpm_module[' + member_module_row + '][order]">';
	html += '      <option value="<?php echo $text_asc; ?>"><?php echo $text_asc; ?></option>';
	html += '      <option value="<?php echo $text_desc; ?>"><?php echo $text_desc; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><input type="checkbox" name="cpm_module[' + member_module_row + '][custom_fields]" value="1" checked="checked"  />&nbsp;<?php echo $text_display; ?></td>';
	html += '    <td class="left"><input type="checkbox" name="cpm_module[' + member_module_row + '][product_count]" value="1" checked="checked"  />&nbsp;<?php echo $text_display; ?></td>';
	html += '    <td class="left"><select name="cpm_module[' + member_module_row + '][layout_id]">';
	<?php foreach ($layouts as $layout) { ?>
	html += '      <option value="<?php echo $layout['layout_id']; ?>"><?php echo addslashes($layout['name']); ?></option>';
	<?php } ?>
	html += '    </select></td>';
	html += '    <td class="left"><select name="cpm_module[' + member_module_row + '][position]">';
	html += '      <option value="content_top"><?php echo $text_content_top; ?></option>';
	html += '      <option value="content_bottom"><?php echo $text_content_bottom; ?></option>';
	html += '      <option value="column_left"><?php echo $text_column_left; ?></option>';
	html += '      <option value="column_right"><?php echo $text_column_right; ?></option>';
	html += '    </select></td>';
	html += '    <td class="left"><select name="cpm_module[' + member_module_row + '][status]">';
    html += '      <option value="1" selected="selected"><?php echo $text_enabled; ?></option>';
    html += '      <option value="0"><?php echo $text_disabled; ?></option>';
    html += '    </select></td>';
	html += '    <td class="right"><input type="text" name="cpm_module[' + member_module_row + '][sort_order]" value="" size="3" /></td>';
	html += '    <td class="left"><a onclick="$(\'#member-module-row' + member_module_row + '\').remove();" class="button"><?php echo $button_remove; ?></a></td>';
	html += '  </tr>';
	html += '</tbody>';
	
	$('#member-module tfoot').before(html);
	
	member_module_row++;
}
//--></script> 
<script type="text/javascript"><!--
$('#tabs a').tabs(); 
$('#tabs-general a').tabs();
$('#tabs-member a').tabs();
$('#tabs-data a').tabs();
$('#tabs-members-list-languages a').tabs();
//--></script> 
<?php echo $footer; ?>