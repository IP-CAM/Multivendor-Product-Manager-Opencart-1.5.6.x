<?php echo $header; ?>
<?php if ($error_warning) { ?>
<div class="warning"><?php echo $error_warning; ?></div>
<?php } ?>
<?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <p><?php echo $text_account_already; ?></p>
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
    <h2><?php echo $text_your_details; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_firstname; ?></td>
          <td><input type="text" name="firstname" value="<?php echo $firstname; ?>" />
            <?php if ($error_firstname) { ?>
            <span class="error"><?php echo $error_firstname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_lastname; ?></td>
          <td><input type="text" name="lastname" value="<?php echo $lastname; ?>" />
            <?php if ($error_lastname) { ?>
            <span class="error"><?php echo $error_lastname; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_email; ?></td>
          <td><input type="text" name="email" value="<?php echo $email; ?>" />
            <?php if ($error_email) { ?>
            <span class="error"><?php echo $error_email; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_telephone; ?></td>
          <td><input type="text" name="telephone" value="<?php echo $telephone; ?>" />
            <?php if ($error_telephone) { ?>
            <span class="error"><?php echo $error_telephone; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_fax; ?></td>
          <td><input type="text" name="fax" value="<?php echo $fax; ?>" /></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_your_cpm_account; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_cpm_account_name; ?></td>
          <td><input type="text" name="cpm_account_name" value="<?php echo $cpm_account_name; ?>" size="40" />
            <?php if ($error_cpm_account_name) { ?>
            <span class="error"><?php echo $error_cpm_account_name; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_cpm_account_description; ?></td>
		  <td><textarea name="cpm_account_description" cols="25" rows="3"><?php echo $cpm_account_description; ?></textarea>
            <?php if ($error_cpm_account_description) { ?>
            <span class="error"><?php echo $error_cpm_account_description; ?></span>
            <?php } ?></td>
        </tr>
		<tr>
			<td><?php echo $entry_cpm_account_image; ?></td>				    
			<td><div class="image" style="border:1px solid #EEEEEE; padding:10px; display:inline-block;"><img src="<?php echo $cpm_account_image_thumb; ?>" alt="" id="cpm_account_image_thumb" style="padding-bottom:5px;" /><br />
			<input type="hidden" name="cpm_account_image" value="<?php echo $cpm_account_image; ?>" id="cpm_account_image" />
			<a id="button-upload"><?php echo $button_upload; ?></a>&nbsp;&nbsp;|&nbsp;&nbsp;<a onclick="$('#cpm_account_image_thumb').attr('src', '<?php echo $no_image; ?>'); $('#cpm_account_image').attr('value', '');"><?php echo $text_clear; ?></a></div></td>
		</tr>
        <?php if ($this->config->get('cpm_member_paypal')) { ?>
        <tr>
          <td><?php if ($this->config->get('cpm_member_paypal_require')) { ?><span class="required">*</span>&nbsp;<?php } ?><?php echo $entry_cpm_paypal_account; ?></td>
          <td><input type="text" name="cpm_paypal_account" value="<?php echo $cpm_paypal_account; ?>" />
			<span class="help"><input type="checkbox" name="copy_email" id="copy-email" value="0" /><?php echo $text_copy_email; ?></span>
			<?php if($this->config->get('cpm_member_paypal_require')) { ?><br /><em><?php echo $help_cpm_paypal_account; ?></em><?php } ?>
            <?php if ($error_cpm_paypal_account) { ?>
            <span class="error"><?php echo $error_cpm_paypal_account; ?></span>
            <?php } ?></td>
        </tr>
		<?php } ?>
      </table>
      <table class="form" <?php if (!$entry_cpm_custom_field_01 && !$entry_cpm_custom_field_02 && !$entry_cpm_custom_field_03 && !$entry_cpm_custom_field_04 && !$entry_cpm_custom_field_05 && !$entry_cpm_custom_field_06) echo 'style="display:none;"'; ?>>
	<?php if ($error_cpm_custom_fields) { ?>
	<h3><?php echo $text_custom_fields; ?></h3>
	<p><span class="error"><?php echo $error_cpm_custom_fields; ?></span></p>
	<?php } ?>
	<tr <?php if (!$entry_cpm_custom_field_01) echo 'style="display:none;"'; ?>>
		<td><?php echo $entry_cpm_custom_field_01; ?></td>
		<td><input type="text" name="cpm_custom_field_01" value="<?php echo $cpm_custom_field_01; ?>" /></td>
	</tr>
	<tr <?php if (!$entry_cpm_custom_field_02) echo 'style="display:none;"'; ?>>
		<td><?php echo $entry_cpm_custom_field_02; ?></td>
		<td><input type="text" name="cpm_custom_field_02" value="<?php echo $cpm_custom_field_02; ?>" /></td>
	</tr>
	<tr <?php if (!$entry_cpm_custom_field_03) echo 'style="display:none;"'; ?>>
		<td><?php echo $entry_cpm_custom_field_03; ?></td>
		<td><input type="text" name="cpm_custom_field_03" value="<?php echo $cpm_custom_field_03; ?>" /></td>
	</tr>
	<tr <?php if (!$entry_cpm_custom_field_04) echo 'style="display:none;"'; ?>>
		<td><?php echo $entry_cpm_custom_field_04; ?></td>
		<td><input type="text" name="cpm_custom_field_04" value="<?php echo $cpm_custom_field_04; ?>" /></td>
	</tr>
	<tr <?php if (!$entry_cpm_custom_field_05) echo 'style="display:none;"'; ?>>
		<td><?php echo $entry_cpm_custom_field_05; ?></td>
		<td><input type="text" name="cpm_custom_field_05" value="<?php echo $cpm_custom_field_05; ?>" /></td>
	</tr>
	<tr <?php if (!$entry_cpm_custom_field_06) echo 'style="display:none;"'; ?>>
		<td><?php echo $entry_cpm_custom_field_06; ?></td>
		<td><input type="text" name="cpm_custom_field_06" value="<?php echo $cpm_custom_field_06; ?>" /></td>
	</tr>
      </table>
    </div>
    <h2><?php echo $text_your_address; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_company; ?></td>
          <td><input type="text" name="company" value="<?php echo $company; ?>" /></td>
        </tr>     
        <tr <?php if (!$company_id_display) echo 'style="display:none;"';  ?>>
          <td><span id="company-id-required" class="required" <?php if (!$company_id_required) echo 'style="display:none;"';  ?>>*</span> <?php echo $entry_company_id; ?></td>
          <td><input type="text" name="company_id" value="<?php echo $company_id; ?>" />
            <?php if ($error_company_id) { ?>
            <span class="error"><?php echo $error_company_id; ?></span>
            <?php } ?></td>
        </tr>
        <tr <?php if (!$tax_id_display) echo 'style="display:none;"';  ?>>
          <td><span id="tax-id-required" class="required" <?php if (!$tax_id_required) echo 'style="display:none;"';  ?>>*</span> <?php echo $entry_tax_id; ?></td>
          <td><input type="text" name="tax_id" value="<?php echo $tax_id; ?>" />
            <?php if ($error_tax_id) { ?>
            <span class="error"><?php echo $error_tax_id; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_address_1; ?></td>
          <td><input type="text" name="address_1" value="<?php echo $address_1; ?>" />
            <?php if ($error_address_1) { ?>
            <span class="error"><?php echo $error_address_1; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><?php echo $entry_address_2; ?></td>
          <td><input type="text" name="address_2" value="<?php echo $address_2; ?>" /></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_city; ?></td>
          <td><input type="text" name="city" value="<?php echo $city; ?>" />
            <?php if ($error_city) { ?>
            <span class="error"><?php echo $error_city; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span id="postcode-required" class="required">*</span> <?php echo $entry_postcode; ?></td>
          <td><input type="text" name="postcode" value="<?php echo $postcode; ?>" />
            <?php if ($error_postcode) { ?>
            <span class="error"><?php echo $error_postcode; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_country; ?></td>
          <td><select name="country_id">
              <option value=""><?php echo $text_select; ?></option>
              <?php foreach ($countries as $country) { ?>
              <?php if ($country['country_id'] == $country_id) { ?>
              <option value="<?php echo $country['country_id']; ?>" selected="selected"><?php echo $country['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $country['country_id']; ?>"><?php echo $country['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select>
            <?php if ($error_country) { ?>
            <span class="error"><?php echo $error_country; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_zone; ?></td>
          <td><select name="zone_id">
            </select>
            <?php if ($error_zone) { ?>
            <span class="error"><?php echo $error_zone; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_your_password; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><span class="required">*</span> <?php echo $entry_password; ?></td>
          <td><input type="password" name="password" value="<?php echo $password; ?>" />
            <?php if ($error_password) { ?>
            <span class="error"><?php echo $error_password; ?></span>
            <?php } ?></td>
        </tr>
        <tr>
          <td><span class="required">*</span> <?php echo $entry_confirm; ?></td>
          <td><input type="password" name="confirm" value="<?php echo $confirm; ?>" />
            <?php if ($error_confirm) { ?>
            <span class="error"><?php echo $error_confirm; ?></span>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <h2><?php echo $text_newsletter; ?></h2>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_newsletter; ?></td>
          <td><?php if ($newsletter) { ?>
            <input type="radio" name="newsletter" value="1" checked="checked" />
            <?php echo $text_yes; ?>
            <input type="radio" name="newsletter" value="0" />
            <?php echo $text_no; ?>
            <?php } else { ?>
            <input type="radio" name="newsletter" value="1" />
            <?php echo $text_yes; ?>
            <input type="radio" name="newsletter" value="0" checked="checked" />
            <?php echo $text_no; ?>
            <?php } ?></td>
        </tr>
      </table>
    </div>
    <?php if ($text_agree) { ?>
    <div class="buttons">
      <div class="right"><?php echo $text_agree; ?>
        <?php if ($agree) { ?>
        <input type="checkbox" name="agree" value="1" checked="checked" />
        <?php } else { ?>
        <input type="checkbox" name="agree" value="1" />
        <?php } ?>
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } else { ?>
    <div class="buttons">
      <div class="right">
        <input type="submit" value="<?php echo $button_continue; ?>" class="button" />
      </div>
    </div>
    <?php } ?>
    <input type="hidden" name="customer_group_id" value="<?php echo $customer_group_id; ?>" id="customer_group_id" />
  </form>
  <?php echo $content_bottom; ?></div>
<script type="text/javascript" src="catalog/view/javascript/ckeditor/ckeditor.js"></script> 
<script type="text/javascript"><!--
CKEDITOR.replace('cpm_account_description');
//--></script>
  <script type="text/javascript" src="catalog/view/javascript/jquery/ajaxupload.js"></script> 
<script type="text/javascript"><!--
new AjaxUpload('#button-upload', {
	action: 'index.php?route=account/register_cpm/upload',
	name: 'file',
	autoSubmit: true,
	responseType: 'json',
	onSubmit: function(file, extension) {
		$('#button-upload').after('<img src="catalog/view/theme/default/image/loading.gif" class="loading" style="padding-left: 5px;" />');
		$('#button-upload').attr('disabled', true);
	},
	onComplete: function(file, json) {
		$('#button-upload').attr('disabled', false);
		
		if (json['success']) {
			alert(json['success']);
			$('input[name=\'cpm_account_image\']').attr('value', json['filename']);
			$('#cpm_account_image_thumb').attr('src', json['thumb']);
		}
		
		if (json['error']) {
			alert(json['error']);
		}
		
		$('.loading').remove();	
	}
});
//--></script> 
<script type="text/javascript"><!--
$('select[name=\'country_id\']').bind('change', function() {
	$.ajax({
		url: 'index.php?route=account/register/country&country_id=' + this.value,
		dataType: 'json',
		beforeSend: function() {
			$('select[name=\'country_id\']').after('<span class="wait">&nbsp;<img src="catalog/view/theme/default/image/loading.gif" alt="" /></span>');
		},
		complete: function() {
			$('.wait').remove();
		},			
		success: function(json) {
			if (json['postcode_required'] == '1') {
				$('#postcode-required').show();
			} else {
				$('#postcode-required').hide();
			}
			
			html = '<option value=""><?php echo $text_select; ?></option>';
			
			if (json['zone'] != '') {
				for (i = 0; i < json['zone'].length; i++) {
        			html += '<option value="' + json['zone'][i]['zone_id'] + '"';
	    			
					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
	      				html += ' selected="selected"';
	    			}
	
	    			html += '>' + json['zone'][i]['name'] + '</option>';
				}
			} else {
				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
			}
			
			$('select[name=\'zone_id\']').html(html);
		},
		error: function(xhr, ajaxOptions, thrownError) {
			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		}
	});
});

$('select[name=\'country_id\']').trigger('change');
//--></script>
<script type="text/javascript"><!--
$(document).ready(function () {
	$('#copy-email').on("click", function () {
		if ($(this).is(":checked")) {
			$('input[name=\'cpm_paypal_account\']').val($('input[name=\'email\']').val());
		}
	});

	$('input[name=\'email\']').on("keypress", function () {
		if ($('#copy-email').is(":checked")) {
			$('input[name=\'cpm_paypal_account\']').val($('input[name=\'email\']').val());
		}
	});
});
//--></script>
<?php echo $footer; ?>
