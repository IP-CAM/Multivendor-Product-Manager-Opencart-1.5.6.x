<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <?php if ($error_warning) { ?>
  <div class="warning"><?php echo $error_warning; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('#form').submit();" class="button"><?php echo $button_save; ?></a><a href="<?php echo $cancel; ?>" class="button"><?php echo $button_cancel; ?></a></div>
    </div>
    <div class="content">
      <div id="htabs" class="htabs"><a href="#tab-general"><?php echo $tab_general; ?></a><a href="#tab-settings"><?php echo $tab_settings; ?></a><a href="#tab-custom-fields"><?php echo $tab_custom_fields; ?></a></div>
      <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
        <div id="tab-general">
            <h2><?php echo $heading_customer; ?></h2>
            <table class="form">
              <tr>
				  <td><?php echo $entry_customer; ?></td>
				  <td style="width:200px;">
				  <?php if ($customers) { ?>
				  <select name="customer_id">
					  <option value="0" selected="selected"><?php echo $text_select; ?></option>
					  <?php foreach ($customers as $customer) { ?>
					  <?php if ($customer['customer_id'] == $customer_id) { ?>
					  <option value="<?php echo $customer['customer_id']; ?>" selected="selected"><?php echo $customer['customer_name']; ?></option>
					  <?php } else { ?>
					  <option value="<?php echo $customer['customer_id']; ?>"><?php echo $customer['customer_name']; ?></option>
					  <?php } ?>
					  <?php } ?>
					</select>
				  <?php } elseif (!$member_id && $total_customers_not_cpm == 0) { ?>
				  <?php echo $text_no_customers; ?>
				  <?php } else { ?>
				  <input type="text" name="customer_name" value="<?php echo $customer_name; ?>" size="25" />
				  <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
				  <?php } ?>
				  </td>
				  <td><span class="help"><?php echo ($member_id) ? $help_customer_name . '  ' : ''; ?><?php echo $help_customer_account; ?></span>
				  <?php if ($error_customer) { ?><span class="error"><?php echo $error_customer; ?></span><?php } ?></td>
              </tr> 
				<tr>
				  <td><?php echo $entry_cpm_status; ?></td>
				  <td><select name="cpm_enabled" <?php echo (!$member_id ? 'disabled="disabled" style="color:rgb(84, 84, 84); background-color:rgb(235, 235, 228);"' : ''); ?>>
					  <?php if ($customer_cpm_enabled) { ?>
					  <option value="1" selected="selected"><?php echo $button_cpm_enable; ?></option>
					  <option value="0"><?php echo $button_cpm_disable; ?></option>
					  <?php } else { ?>
					  <option value="1"><?php echo $button_cpm_enable; ?></option>
					  <option value="0" selected="selected"><?php echo $button_cpm_disable; ?></option>
					  <?php } ?>
					</select>
					</td>
				  <td><p><span class="help"><?php echo (!$member_id ? $help_cpm_no_customer : $help_cpm_status); ?></span></p></td>
				</tr>              
              <tr>
                <td><?php echo $text_customer_group; ?></td>
                <?php if ($member_id || $customer_id) { ?>
                <td id="customer-group"><?php echo $customer_group; ?></td>
                <td><span class="help"><?php echo $help_customer_group; ?></span></td>
                <?php } else {?>
                <td id="customer-group"></td>
                <td></td>
                <?php } ?>
              </tr>
              <tr>
                <td><?php echo $text_customer_status; ?></td>
                <?php if ($member_id || $customer_id) { ?>
                <td id="customer-status"><?php echo (($customer_status) ? $text_enabled : $text_disabled); ?></td>
                <td><span class="help"><?php echo $help_customer_status; ?></span></td>
                <?php } else {?>
                <td id="customer-status"></td>
                <td></td>
                <?php } ?>
              </tr>
              <tr>
                <td><?php echo $text_customer_approved; ?></td>
                <?php if ($member_id || $customer_id) { ?>
                <td id="customer-approved" style="font-weight:bold;color:<?php echo ($customer_approved ? '#8EC74B' : '#DC313E'); ?>;"><?php echo (($customer_approved) ? $text_yes : $text_no); ?></td>
                <td><span class="help"><?php echo $help_customer_approved; ?></span></td>
                <?php } else {?>
                <td id="customer-approved"></td>
                <td></td>
                <?php } ?>
              </tr>
            </table>
            
            <h2><?php echo $heading_membership; ?></h2>
			<table class="form">
			    <tr>
			      <td><?php echo $entry_cpm_account_name; ?></td>
			      <td>
				<input type="text" name="cpm_account_name" value="<?php echo $cpm_account_name; ?>" size="40" />
				   <?php if ($error_cpm_account_name) { ?>
				     <span class="error"><?php echo $error_cpm_account_name; ?></span>
				   <?php } ?>
			      </td>
			    </tr>
			    <tr>
			      <td><?php echo $entry_cpm_account_description; ?></td>
			      <td><textarea name="cpm_account_description" id="cpm_account_description"><?php echo $cpm_account_description; ?></textarea>
				<?php if ($error_cpm_account_description) { ?>
				     <span class="error"><?php echo $error_cpm_account_description; ?></span>
				   <?php } ?></td>
			    </tr>
			    <tr>
			      <td><?php echo $entry_cpm_account_image; ?></td>				    
			      <td><div class="image"><img src="<?php echo $cpm_account_image_thumb; ?>" alt="" id="cpm_account_image_thumb" /><br />
				  <input type="hidden" name="cpm_account_image" value="<?php echo $cpm_account_image; ?>" id="cpm_account_image" />
				  <a onclick="image_upload('cpm_account_image', 'cpm_account_image_thumb');"><?php echo $text_browse; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#cpm_account_image_thumb').attr('src', '<?php echo $no_image; ?>'); $('#cpm_account_image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
			    </tr>
			    <tr>
			      <td><?php echo $entry_keyword; ?></td>
			      <td>
				<input type="text" name="keyword" value="<?php echo $keyword; ?>" size="40" />
				<p><span class="help"><?php echo $help_keyword; ?></span></p>
			      </td>
			    </tr>
			    <tr>
			      <td><?php echo $entry_sort_order; ?></td>
			      <td>
				<input type="text" name="sort_order" value="<?php echo $sort_order; ?>" size="2" />
				<p><span class="help"><?php echo $help_sort_order; ?></span></p>
			      </td>
			    </tr>
			</table>
        </div>

		<div id="tab-settings">
			<h2><?php echo $heading_settings; ?></h2>
			<table class="form">
			    <tr>
			      <td><?php echo $entry_cpm_directory_images; ?></td>
			      <td>
				<input type="text" name="cpm_directory_images" value="<?php echo $cpm_directory_images; ?>" size="40" />
				<p><span class="help"><?php echo $help_cpm_directory_images; ?></span></p>
				    <?php if ($error_cpm_directory_images) { ?>
					<span class="error"><?php echo $error_cpm_directory_images; ?></span>
				    <?php } ?>
			      </td>
			      </tr>
			    <tr>
			      <td><?php echo $entry_cpm_directory_downloads; ?></td>
			      <td>
				<input type="text" name="cpm_directory_downloads" value="<?php echo $cpm_directory_downloads; ?>" size="40" />
				<p><span class="help"><?php echo $help_cpm_directory_downloads; ?></span></p>
				    <?php if ($error_cpm_directory_downloads) { ?>
					<span class="error"><?php echo $error_cpm_directory_downloads; ?></span>
				    <?php } ?>
			      </td>
			      </tr>
			    <tr>
			      <td><?php echo $entry_cpm_paypal_account; ?></td>
			      <td>
				<input type="text" name="cpm_paypal_account" value="<?php echo $cpm_paypal_account; ?>" size="40" />
				<p><span class="help"><?php echo $help_cpm_paypal_account; ?></span></p>
				    <?php if ($error_cpm_paypal_account) { ?>
					<span class="error"><?php echo $error_cpm_paypal_account; ?></span>
				    <?php } ?>
			      </td>
			      </tr>
			    <tr>
			      <td><?php echo $entry_cpm_max_products; ?></td>
			      <td>
				<input type="text" name="cpm_max_products" value="<?php echo $cpm_max_products; ?>" size="4" />
				<p><span class="help"><?php echo $help_cpm_max_products; ?></span></p>
				    <?php if ($error_cpm_max_products) { ?>
					<span class="error"><?php echo $error_cpm_max_products; ?></span>
				    <?php } ?>
			      </td>
			    </tr>
			    <tr>
			      <td><?php echo $entry_cpm_commission_rate; ?></td>
			      <td>
				<input type="text" name="cpm_commission_rate" value="<?php echo $cpm_commission_rate; ?>" size="4" /> %
				<p><span class="help"><?php echo $help_cpm_commission_rate; ?></span></p>
				    <?php if ($error_cpm_commission_rate) { ?>
					<span class="error"><?php echo $error_cpm_commission_rate; ?></span>
				    <?php } ?>
			      </td>
			    </tr>
			</table>
		</div>

		<div id="tab-custom-fields">
			<h2><?php echo $heading_custom_fields; ?></h2>
			<p><?php echo $help_cpm_custom_fields; ?></p>
		    <?php if ($error_cpm_custom_fields) { ?>
		    <p><span class="error"><?php echo $error_cpm_custom_fields; ?></span></p>
		    <?php } ?>
		    <?php if (!$entry_cpm_custom_field_01 && !$entry_cpm_custom_field_02 && !$entry_cpm_custom_field_03 && !$entry_cpm_custom_field_04 && !$entry_cpm_custom_field_05 && !$entry_cpm_custom_field_06) { ?>
		    <p class="alert warning"><?php echo $error_cpm_no_custom_fields; ?></p>
		    <?php } ?>		    
			<div id="custom-fields" <?php if (!$entry_cpm_custom_field_01 && !$entry_cpm_custom_field_02 && !$entry_cpm_custom_field_03 && !$entry_cpm_custom_field_04 && !$entry_cpm_custom_field_05 && !$entry_cpm_custom_field_06) echo 'style="display:none;"'; ?>>
				<table class="form">
				   <tr>
					  <td><strong><?php echo $text_cpm_field_name; ?></strong></td>
					  <td><strong><?php echo $text_cpm_field_value; ?></strong></td>
				   </tr>
				   <tr <?php if (!$entry_cpm_custom_field_01) echo 'style="display:none;"'; ?>>
				      <td><?php echo $entry_cpm_custom_field_01; ?></td>
				      <td><input type="text" name="cpm_custom_field_01" value="<?php echo $cpm_custom_field_01; ?>" size="40" /></td>
				    </tr>
				    <tr <?php if (!$entry_cpm_custom_field_02) echo 'style="display:none;"'; ?>>
				      <td><?php echo $entry_cpm_custom_field_02; ?></td>
				      <td><input type="text" name="cpm_custom_field_02" value="<?php echo $cpm_custom_field_02; ?>" size="40" /></td>
				    </tr>
				    <tr <?php if (!$entry_cpm_custom_field_03) echo 'style="display:none;"'; ?>>
				      <td><?php echo $entry_cpm_custom_field_03; ?></td>
				      <td><input type="text" name="cpm_custom_field_03" value="<?php echo $cpm_custom_field_03; ?>" size="40" /></td>
				    </tr>
				   <tr <?php if (!$entry_cpm_custom_field_04) echo 'style="display:none;"'; ?>>
				      <td><?php echo $entry_cpm_custom_field_04; ?></td>
				      <td><input type="text" name="cpm_custom_field_04" value="<?php echo $cpm_custom_field_04; ?>" size="40" /></td>
				    </tr>
				    <tr <?php if (!$entry_cpm_custom_field_05) echo 'style="display:none;"'; ?>>
				      <td><?php echo $entry_cpm_custom_field_05; ?></td>
				      <td><input type="text" name="cpm_custom_field_05" value="<?php echo $cpm_custom_field_05; ?>" size="40" /></td>
				    </tr>
				    <tr <?php if (!$entry_cpm_custom_field_06) echo 'style="display:none;"'; ?>>
				      <td><?php echo $entry_cpm_custom_field_06; ?></td>
				      <td><input type="text" name="cpm_custom_field_06" value="<?php echo $cpm_custom_field_06; ?>" size="40" /></td>
				    </tr>
				</table>
			</div>
			
		</div>	
		<input type="hidden" name="viewed" value="<?php echo $viewed; ?>" />	
      </form>
    </div>
  </div>
</div>
<script type="text/javascript" src="view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('cpm_account_description', {
	filebrowserBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashBrowseUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserImageUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>',
	filebrowserFlashUploadUrl: 'index.php?route=common/filemanager&token=<?php echo $token; ?>'
});
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
					url: 'index.php?route=common/filemanager/image&token=<?php echo $token; ?>&image=' + encodeURIComponent($('#' + field).attr('value')),
					dataType: 'text',
					success: function(text) {
						$('#' + thumb).replaceWith('<img src="' + text + '" alt="" id="' + thumb + '" />');
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
// Customer
$('input[name=\'customer_name\']').autocomplete({
	minLength: 0,
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/member/autocomplete&token=<?php echo $token; ?>&member_id=<?php echo $member_id; ?>&filter_cpm_enabled=0&filter_customer_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.customer_name,
						value: item.customer_id,
						group: item.customer_group,
						status: item.customer_status,
						cpm: item.customer_cpm,
						approved: item.customer_approved
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'customer_id\']').attr('value', ui.item.value);
		$('input[name=\'customer_name\']').attr('value', ui.item.label);
		$('select[name=\'cpm_enabled\']').attr('value', ui.item.cpm);
		$('select[name=\'cpm_enabled\']').removeAttr('disabled style');
		$('#customer-group').text(ui.item.group);
		$('#customer-status').text((ui.item.status ? '<?php echo $text_enabled; ?>' : '<?php echo $text_disabled; ?>'));
		$('#customer-approved').text((ui.item.approved ? '<?php echo $text_yes; ?>' : '<?php echo $text_no; ?>'));
	
		return false;
	},
	focus: function(event, ui) {
      return false;
   }
}).on('focus', function(event) {
    $(this).autocomplete("search", "");
});
//--></script>
<?php if (empty($member_id) && $this->config->get('cpm_member_directories')) { ?>
<script type="text/javascript"><!--
$(document).ready(function () {
	$('input[name=\'cpm_account_name\']').change(function () {
		if ($(this).val()) {
			keyword = friendly_url($(this).val());
			$('input[name=\'cpm_directory_images\']').val('<?php echo $this->config->get('cpm_image_upload_directory'); ?>/member-' + keyword);
			$('input[name=\'cpm_directory_downloads\']').val('<?php echo $this->config->get('cpm_download_directory'); ?>/member-' + keyword);
		}
	}).trigger('change');
});

function friendly_url(name) {
	return name
		.toLowerCase()
        .replace(/(&amp;|&)/g,'-and-')
        .replace(/[^a-zA-Z01-9]/g,'-')
        .replace(/(-+)/g,'-')
        .replace(/(-$|^-)/g,'')
        // .replace(/ /g,'-') // change spaces to hyphens
        // .replace(/[^\w-]+/g,'') // remove anything not alphanumeric, underscore, or hyphen
        ;
}
//--></script>
<?php } ?>
<script type="text/javascript"><!--
$('.htabs a').tabs();
//--></script> 
<?php echo $footer; ?>
