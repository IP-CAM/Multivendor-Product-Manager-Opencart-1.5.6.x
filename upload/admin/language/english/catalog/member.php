<?php
// Heading
$_['heading_title']         			= 'Membership';
$_['heading_customer']          		= 'Customer Account Info';
$_['heading_membership']          		= 'Membership Page Info';
$_['heading_settings']          		= 'Membership Settings';
$_['heading_custom_fields']          	= 'Custom Fields';

// Text
$_['text_success']          			= 'Success: You have modified members!';
$_['text_default']          			= 'Default';
$_['text_enabled']          			= 'Enabled';
$_['text_disabled']          			= 'Disabled';
$_['text_cpm_enabled']         			= 'You have Membership-Enabled %s accounts!';
$_['text_cpm_disabled']        			= 'You have Membership-Disabled %s accounts!';
$_['text_approved']         			= 'You have approved %s accounts!';
$_['text_wait']             			= 'Please Wait!';
$_['text_clear']             			= 'Clear Image';
$_['text_confirm']            			= 'Confirm Delete?\n\rThe linked Customer Account will be Membership-Disabled.';
$_['text_image_manager']     			= 'Image Manager';
$_['text_browse']            			= 'Browse Files';
$_['text_customer_approved']            = 'Customer Approved:';
$_['text_customer_group']            	= 'Customer Group:';
$_['text_customer_status']            	= 'Customer Status:';
$_['text_no_customers']            		= 'No valid Customers available!';
$_['text_cpm_field_name']               = 'Custom Field Name:';
$_['text_cpm_field_value']              = 'Custom Field Value:';

// Button
$_['button_cpm_enable']					= 'Enable';
$_['button_cpm_disable']				= 'Disable';

// Tab
$_['tab_general']          				= 'General';
$_['tab_settings']          			= 'Settings';
$_['tab_custom_fields']          		= 'Custom Fields';

// Column
$_['column_image']  					= 'Image';
$_['column_cpm_account_name']  			= 'Member Name';
$_['column_customer_name'] 				= 'Customer Name';
$_['column_email']          			= 'Customer E-Mail';
$_['column_customer_group']				= 'Customer Group';
$_['column_product_count']  			= 'Product Count';
$_['column_commission']     			= 'Commission Rate';
$_['column_status']         			= 'Status'; 
$_['column_login']          			= 'Login into Store';
$_['column_approved']       			= 'Customer Approved';
$_['column_date_added']     			= 'Date Added';
$_['column_action']        				= 'Action';

// Entry
$_['entry_customer']       				= 'Customer Account Name:<br /><span class="help">(Autocomplete)</span>';
$_['entry_cpm_status'] 					= 'Customer Membership Status:';
$_['entry_cpm_account_name'] 			= 'Member Account Name:';
$_['entry_cpm_account_description'] 	= 'Member Account Description:';
$_['entry_cpm_account_image'] 			= 'Member Account Image:';
$_['entry_cpm_directory_images']		= 'Image Upload Directory:';
$_['entry_cpm_directory_downloads']  	= 'Downloads Directory:';
$_['entry_cpm_paypal_account']			= 'PayPal Account E-mail:';
$_['entry_cpm_max_products'] 			= 'Max Products:';
$_['entry_cpm_commission_rate'] 		= 'Commission Rate (%):';
$_['entry_sort_order'] 					= 'Sort Order:';
$_['entry_keyword'] 					= 'Keyword:';

// Help
$_['help_cpm_status'] 					= 'Membership-Enabled Customer Accounts ("Members") have access to features like the Member Product Manager, Member Image Manager, and Member Reports.';
$_['help_cpm_no_customer'] 				= 'Member Account must be linked to a Customer Account to Membership-Enable or Membership-Disable.';
$_['help_cpm_directory_images']         = 'Enter a sub-directory under DIR_IMAGE/data/ to save images uploaded by Membership Account. Overrides default Membership module setting.';
$_['help_cpm_directory_downloads']      = 'Enter a sub-directory under DIR_DOWNLOAD to save downloads stored by Membership Account. Overrides default Membership module setting.';
$_['help_cpm_paypal_account']           = 'Save PayPal account e-mail. Send money or pay members from the Admin Member Sales Report if an Admin PayPal account is saved in Membership module settings.';
$_['help_cpm_max_products']             = 'Set max number of products this account can manage. Overrides default Membership setting. Enter -1 for unlimited.';
$_['help_cpm_commission_rate']          = 'Set commission rate to charge as a percentage of the price of each order product listing. Overrides default Membership module setting.';
$_['help_cpm_custom_fields']            = 'Define your own custom text field values.';
$_['help_sort_order']             		= 'Sort Order for Members page. Members are sorted by Account Name by default.';
$_['help_keyword']             			= 'SEO URL keyword for Member page.';
$_['help_customer_account']             = 'A unique <a href="%s" target="_blank">Customer Account</a> is required for each Member Account.';
$_['help_customer_name']           		= 'Manage Customer Account "<a href="%s" target="_blank">%s</a>".';
$_['help_customer_group']           	= '<a href="%s" target="_blank">Customer Group</a> is set in Customer Account.';
$_['help_customer_status']             	= 'Status is set in Customer Account.';
$_['help_customer_approved']            = 'Approved is set in Customer Account.';

// Error
$_['error_warning']         			= 'Warning: Please check the form carefully for errors!';
$_['error_permission']      			= 'Warning: You do not have permission to modify Members!';
$_['error_permission_customer']      	= 'Warning: You do not have permission to modify account approvals!';
$_['error_exists']          			= 'Warning: Customer Account <b>%s</b> is already linked to Membership Account <b>%s</b>!';
$_['error_customer']          			= 'Please select a valid Customer Account!';
$_['error_cpm_account_description']     = 'Member Account Description must be less than 1500 characters.';
$_['error_cpm_account_name']            = 'Member Account Name must be less than 128 characters.';
$_['error_cpm_paypal_account']          = 'PayPal Account E-mail is invalid.';
$_['error_cpm_max_products']            = 'Max Products must be a number greater than -1 or left empty.';
$_['error_cpm_commission_rate']         = 'Commission Rate must be a number greater than 0 or left empty.';
$_['error_cpm_directory_images']        = 'Directory for Images does not exist and cannot be created on the server. Create it using an FTP client first, then assign it here.';
$_['error_cpm_directory_downloads']     = 'Directory for Downloads does not exist and cannot be created on the server. Create it using an FTP client first, then assign it here.';
$_['error_cpm_custom_fields']			= 'Custom Text Field(s) must be less than 64 characters.';
$_['error_cpm_no_custom_fields']		= '<b>NO Custom Text Field(s)</b> have been configured in the <a href="%s" target="_blank">Membership module settings</a>!';
$_['error_cpm_no_customer']				= 'Member "%s" must be linked to a Customer Account to Membership-Enable or Membership-Disable!';
?>
