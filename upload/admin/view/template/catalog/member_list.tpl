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
  <?php if ($success) { ?>
  <div class="success"><?php echo $success; ?></div>
  <?php } ?>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/customer.png" alt="" /> <?php echo $heading_title; ?></h1>
      <div class="buttons"><a onclick="$('form').attr('action', '<?php echo $enable; ?>'); $('form').submit();" class="button" style="background:#8EC74B;"><?php echo $button_cpm_enable; ?></a> <a onclick="$('form').attr('action', '<?php echo $disable; ?>'); $('form').submit();" class="button" style="background:#DC313E;"><?php echo $button_cpm_disable; ?></a><a href="<?php echo $insert; ?>" class="button"><?php echo $button_insert; ?></a><a onclick="$('form').attr('action', '<?php echo $delete; ?>'); $('form').submit();" class="button"><?php echo $button_delete; ?></a></div>
    </div>
    <div class="content">
      <form action="" method="post" enctype="multipart/form-data" id="form">
        <table class="list">
          <thead>
            <tr>
              <td class="center" width="1"><input type="checkbox" onclick="$('input[name*=\'selected\']').attr('checked', this.checked);" /></td>
              <td class="center"><?php echo $column_image; ?></td>
              <td class="left"><?php if ($sort == 'cpm_account_name') { ?>
                <a href="<?php echo $sort_cpm_account_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_cpm_account_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_cpm_account_name; ?>"><?php echo $column_cpm_account_name; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'customer_name') { ?>
                <a href="<?php echo $sort_customer_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_name; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_customer_name; ?>"><?php echo $column_customer_name; ?></a>
                <?php } ?></td>
              <!--
              <td class="left"><?php if ($sort == 'c.email') { ?>
                <a href="<?php echo $sort_email; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_email; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_email; ?>"><?php echo $column_email; ?></a>
                <?php } ?></td>
              -->
              <td class="left"><?php if ($sort == 'customer_group') { ?>
                <a href="<?php echo $sort_customer_group; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer_group; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_customer_group; ?>"><?php echo $column_customer_group; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'c.cpm_enabled') { ?>
                <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                <?php } ?></td>
              <!--
              <td class="left"><?php if ($sort == 'c.approved') { ?>
                <a href="<?php echo $sort_approved; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_approved; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_approved; ?>"><?php echo $column_approved; ?></a>
                <?php } ?></td>
              -->
              <td class="center"><?php echo $column_product_count; ?></td>
              <td class="right"><?php if ($sort == 'cpm_commission_rate') { ?>
                <a href="<?php echo $sort_commission; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_commission; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_commission; ?>"><?php echo $column_commission; ?></a>
                <?php } ?></td>
              <td class="left"><?php if ($sort == 'cpm.date_added') { ?>
                <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                <?php } else { ?>
                <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                <?php } ?></td>
              <td class="left"><?php echo $column_login; ?></td>
              <td class="right"><?php echo $column_action; ?></td>
            </tr>
          </thead>
          <tbody>
            <tr class="filter">
              <td class="center"></td>
              <td class="center"></td>              
              <td class="left"><input type="text" name="filter_cpm_account_name" value="<?php echo $filter_cpm_account_name; ?>" /></td>
              <td class="left"><input type="text" name="filter_customer_name" value="<?php echo $filter_customer_name; ?>" /></td>
              <!--<td class="left"><input type="text" name="filter_email" value="<?php echo $filter_email; ?>" /></td>-->
              <td class="left"><select name="filter_customer_group_id">
                  <option value="*"></option>
                  <?php foreach ($customer_groups as $customer_group) { ?>
                  <?php if ($customer_group['customer_group_id'] == $filter_customer_group_id) { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select></td>
              <td class="left"><select name="filter_status">
                  <option value="*"></option>
                  <?php if ($filter_status) { ?>
                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_enabled; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_status) && !$filter_status) { ?>
                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_disabled; ?></option>
                  <?php } ?>
                </select></td>
              <!--<td class="left"><select name="filter_approved">
                  <option value="*"></option>
                  <?php if ($filter_approved) { ?>
                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>
                  <?php } else { ?>
                  <option value="1"><?php echo $text_yes; ?></option>
                  <?php } ?>
                  <?php if (!is_null($filter_approved) && !$filter_approved) { ?>
                  <option value="0" selected="selected"><?php echo $text_no; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_no; ?></option>
                  <?php } ?>
                </select></td>-->
              <td class="center"></td>
              <td class="right"></td>
              <td class="left"><input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" size="12" id="date" /></td>
              <td class="left"></td>
              <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
            </tr>
            <?php if ($members) { ?>
            <?php foreach ($members as $member) { ?>
            <tr>
              <td style="text-align: center;"><?php if ($member['selected']) { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $member['member_id']; ?>" checked="checked" />
                <?php } else { ?>
                <input type="checkbox" name="selected[]" value="<?php echo $member['member_id']; ?>" />
                <?php } ?></td>
               <td class="center"><img src="<?php echo $member['image']; ?>" alt="<?php echo $member['cpm_account_name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
              <td class="left"><?php echo $member['cpm_account_name']; ?></td>
              <td class="left"><a href="<?php echo $member['customer_href']; ?>" alt="<?php echo $member['customer_name']; ?>" target="_blank"><?php echo $member['customer_name']; ?></a></td>
              <!--<td class="left"><?php echo $member['email']; ?></td>-->
              <td class="left"><?php echo $member['customer_group']; ?></td>
              <td class="left" style="color:#FFF;font-weight:bold;background:<?php echo ($member['status'] === $text_enabled ? '#8EC74B' : '#DC313E'); ?>;"><?php echo $member['status']; ?></td>
              <!--<td class="left" style="color:#FFF;font-weight:bold;background:<?php echo ($member['approved'] === $text_yes ? '#8EC74B' : '#DC313E'); ?>;"><?php echo $member['approved']; ?></td>-->
              <td class="center"><a href="<?php echo $member['product_href']; ?>" alt="<?php echo $member['product_count']; ?>" target="_blank"><?php echo $member['product_count']; ?></a></td>			
              <td class="right"><?php echo $member['commission']; ?>%</td>
              <td class="left"><?php echo $member['date_added']; ?></td>
              <td class="left"><select onchange="((this.value !== '') ? window.open('index.php?route=sale/customer/login&token=<?php echo $token; ?>&customer_id=<?php echo $member['member_id']; ?>&store_id=' + this.value) : null); this.value = '';">
                  <option value=""><?php echo $text_select; ?></option>
                  <option value="0"><?php echo $text_default; ?></option>
                  <?php foreach ($stores as $store) { ?>
                  <option value="<?php echo $store['store_id']; ?>"><?php echo $store['name']; ?></option>
                  <?php } ?>
                </select></td>
              <td class="right"><?php foreach ($member['action'] as $action) { ?>
                [ <a href="<?php echo $action['href']; ?>"><?php echo $action['text']; ?></a> ]
                <?php } ?></td>
            </tr>
            <?php } ?>
            <?php } else { ?>
            <tr>
              <td class="center" colspan="10"><?php echo $text_no_results; ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </form>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script>
<script type="text/javascript">
$(document).ready(function(){
    // Confirm Delete
    $('#form').submit(function(){
        if ($(this).attr('action').indexOf('delete',1) != -1) {
            if (!confirm('<?php echo $text_confirm; ?>')) {
                return false;
            }
        }
    });
});
</script>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=catalog/member&token=<?php echo $token; ?>';
	
	var filter_customer_name = $('input[name=\'filter_customer_name\']').attr('value');
	
	if (filter_customer_name) {
		url += '&filter_customer_name=' + encodeURIComponent(filter_customer_name);
	}
	
	var filter_cpm_account_name = $('input[name=\'filter_cpm_account_name\']').attr('value');
	
	if (filter_cpm_account_name) {
		url += '&filter_cpm_account_name=' + encodeURIComponent(filter_cpm_account_name);
	}
	
	var filter_email = $('input[name=\'filter_email\']').attr('value');
	
	if (filter_email) {
		url += '&filter_email=' + encodeURIComponent(filter_email);
	}
	
	var filter_customer_group_id = $('select[name=\'filter_customer_group_id\']').attr('value');
	
	if (filter_customer_group_id != '*') {
		url += '&filter_customer_group_id=' + encodeURIComponent(filter_customer_group_id);
	}
			
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status); 
	}	
	/*
	var filter_approved = $('select[name=\'filter_approved\']').attr('value');
	
	if (filter_approved != '*') {
		url += '&filter_approved=' + encodeURIComponent(filter_approved);
	}*/
		
	var filter_date_added = $('input[name=\'filter_date_added\']').attr('value');
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	location = url;
}
//--></script>
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script>
<script type="text/javascript"><!--
$('input[name=\'filter_customer_name\']').autocomplete({
	minLength: 0,
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/member/autocomplete&token=<?php echo $token; ?>&filter_cpm_enabled=1&filter_customer_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.customer_name,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_customer_name\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
$('input[name=\'filter_cpm_account_name\']').autocomplete({
	minLength: 0,
	delay: 500,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/member/autocomplete&token=<?php echo $token; ?>&filter_cpm_enabled=1&filter_cpm_account_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.cpm_account_name,
						value: item.customer_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_cpm_account_name\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script>
<?php echo $footer; ?> 
