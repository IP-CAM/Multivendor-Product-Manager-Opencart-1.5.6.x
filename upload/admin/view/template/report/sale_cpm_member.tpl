<?php echo $header; ?>
<div id="content">
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <div class="box">
    <div class="heading">
      <h1><img src="view/image/report.png" alt="" /> <?php echo $heading_title; ?></h1>
    </div>
    <div class="content">
      <table class="form">
        <tr>
          <td><?php echo $entry_date_start; ?>
            <input type="text" name="filter_date_start" value="<?php echo $filter_date_start; ?>" id="date-start" size="12" /></td>
          <td><?php echo $entry_date_end; ?>
            <input type="text" name="filter_date_end" value="<?php echo $filter_date_end; ?>" id="date-end" size="12" /></td>
          <td><?php echo $entry_group; ?>
            <select name="filter_group">
              <?php foreach ($groups as $groups) { ?>
              <?php if ($groups['value'] == $filter_group) { ?>
              <option value="<?php echo $groups['value']; ?>" selected="selected"><?php echo $groups['text']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $groups['value']; ?>"><?php echo $groups['text']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td><?php echo $entry_member; ?>
            <select name="filter_cpm_customer_id">
              <option value="0"><?php echo $text_all_members; ?></option>
              <?php foreach ($members as $member) { ?>
              <?php if ($member['cpm_customer_id'] == $filter_cpm_customer_id) { ?>
              <option value="<?php echo $member['cpm_customer_id']; ?>" selected="selected"><?php echo $member['cpm_account_name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $member['cpm_customer_id']; ?>"><?php echo $member['cpm_account_name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td><?php echo $entry_status; ?>
            <select name="filter_order_status_id">
              <option value="0"><?php echo $text_all_status; ?></option>
              <?php foreach ($order_statuses as $order_status) { ?>
              <?php if ($order_status['order_status_id'] == $filter_order_status_id) { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
              <?php } else { ?>
              <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
              <?php } ?>
              <?php } ?>
            </select></td>
          <td style="text-align: right;"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
        </tr>
      </table>
      <table class="list">
        <thead>
          <tr>
			<?php if ($filter_group == 'order') { ?>
			    <td class="center"><?php echo $column_order_id; ?></td>
			    <td class="center"><?php echo $column_status; ?></td>
			    <td class="center"><?php echo $column_date_added; ?></td>
				<td class="left"><?php echo $column_member; ?></td>
				<td class="left"><?php echo $column_paypal; ?></td>
			<?php } else { ?>
				<td class="left"><?php echo $column_date_start; ?></td>
				<td class="left"><?php echo $column_date_end; ?></td>
				<td class="center"><?php echo $column_orders; ?></td>
			<?php } ?>						
				<td class="center"><?php echo $column_products; ?></td>
				<td class="right"><?php echo $column_sales; ?></td>
				<td class="right"><?php echo $column_commission; ?></td>
				<td class="right"><?php echo $column_tax; ?></td>
				<?php if ($this->config->get('cpm_shipping_enabled')) { ?>
				<td class="right"><?php echo $column_shipping; ?></td> <!-- // ship -->
				<td class="right"><?php echo $column_insurance; ?></td> <!-- // ship -->
				<?php } ?>
				<!--<td class="right"><?php echo $column_revenue; ?></td>-->
				<td class="right"><?php echo $column_total; ?> <span style="font-weight:100;">*</span></td>
			<?php if ($filter_group == 'order') { ?>	
				<td class="right"><?php echo $column_action; ?></td>
			<?php } ?>
          </tr>
        </thead>
        <tbody>
          <?php if ($orders) { ?>
          <?php foreach ($orders as $order) { ?>
          <tr>
			<?php if ($filter_group == 'order') { ?>
				<td class="center"><b><?php echo $order['order_id']; ?></b></td>
				<td class="center"><?php echo $order['status']; ?></td>
				<td class="center"><?php echo $order['date_added']; ?></td>
				<td class="left"><a href="<?php echo $order['member_url']; ?>" title="<?php echo $order['member']; ?>" target="_blank"><?php echo $order['member']; ?></a></td>
				<td class="left"><?php echo $order['paypal']; ?></td>
			<?php } else { ?>
				<td class="left"><?php echo $order['date_start']; ?></td>
				<td class="left"><?php echo $order['date_end']; ?></td>
				<td class="center"><?php echo $order['orders']; ?></td>
			<?php } ?>
				<td class="center"><?php echo $order['products']; ?></td>
				<td class="right"><?php echo $order['sales']; ?></td>
				<td class="right"><?php echo $order['commission']; ?></td>
				<td class="right"><?php echo $order['tax']; ?></td>
				<?php if ($this->config->get('cpm_shipping_enabled')) { ?>
				<td class="right"><?php echo $order['shipping']; ?></td> <!-- // ship -->
				<td class="right"><?php echo $order['insurance']; ?></td> <!-- // ship -->
				<?php } ?>
				<!--<td class="right"><?php echo $order['revenue']; ?></td>-->
				<td class="right"><b><?php echo $order['total']; ?></b></td>
			<?php if ($filter_group == 'order') { ?>
				<td class="right">
					[&nbsp;<a href="<?php echo $order['href']; ?>" title="<?php echo $button_view; ?>" target="_blank"><?php echo $button_view; ?></a>&nbsp;]
					<?php if ($this->config->get('cpm_paypal_email')) { ?>
					[&nbsp;<a href="<?php echo $order['send_money']; ?>" title="<?php echo $button_send_money; ?>" target="_blank"><?php echo $button_send_money; ?></a>&nbsp;]
					[&nbsp;<a href="<?php echo $order['pay']; ?>" title="<?php echo $button_pay; ?>" target="_blank"><?php echo $button_pay; ?></a>&nbsp;]
					<?php } ?>
				</td>
			<?php } ?>
          </tr>
          <?php } ?>
			<tr>
				<td colspan="<?php echo ($filter_group == 'order') ? '5' : '3'; ?>" class="right">* <?php echo $text_total_calculation; ?></td>
				<td class="center"><b><?php echo $totals['products']; ?></b></td>
				<td class="right"><b><?php echo $totals['sales']; ?></b></td>
				<td class="right"><b><?php echo $totals['commissions']; ?></b></td>
				<td class="right"><b><?php echo $totals['tax']; ?></b></td>
				<?php if ($this->config->get('cpm_shipping_enabled')) { ?>
				<td class="right"><b><?php echo $totals['shipping']; ?></b></td> <!-- // ship -->
				<td class="right"><b><?php echo $totals['insurance']; ?></td> <!-- // ship -->
				<?php } ?>
				<!--<td class="right"><b><?php echo $totals['revenue']; ?></b></td>-->
				<td class="right"><b><?php echo $totals['grand']; ?></b></td>
			    <?php if ($filter_group == 'order') { ?><td>&nbsp;</td><?php } ?>
			</tr>
          <?php } else { ?>
          <tr>
            <td class="center" colspan="<?php echo ($filter_group == 'order') ? '13' : '11'; ?>"><?php echo $text_no_results; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="pagination"><?php echo $pagination; ?></div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=report/sale_cpm_member&token=<?php echo $token; ?>';
	
	var filter_date_start = $('input[name=\'filter_date_start\']').attr('value');
	
	if (filter_date_start) {
		url += '&filter_date_start=' + encodeURIComponent(filter_date_start);
	}

	var filter_date_end = $('input[name=\'filter_date_end\']').attr('value');
	
	if (filter_date_end) {
		url += '&filter_date_end=' + encodeURIComponent(filter_date_end);
	}
		
	var filter_group = $('select[name=\'filter_group\']').attr('value');
	
	if (filter_group) {
		url += '&filter_group=' + encodeURIComponent(filter_group);
	}
	
	var filter_order_status_id = $('select[name=\'filter_order_status_id\']').attr('value');
	
	if (filter_order_status_id != 0) {
		url += '&filter_order_status_id=' + encodeURIComponent(filter_order_status_id);
	}
	
	var filter_cpm_customer_id = $('select[name=\'filter_cpm_customer_id\']').attr('value');
	
	if (filter_cpm_customer_id != 0) {
		url += '&filter_cpm_customer_id=' + encodeURIComponent(filter_cpm_customer_id);
	}	

	location = url;
}
//--></script> 
<script type="text/javascript"><!--
$(document).ready(function() {
	$('#date-start').datepicker({dateFormat: 'yy-mm-dd'});
	$('#date-end').datepicker({dateFormat: 'yy-mm-dd'});
});
//--></script> 
<?php echo $footer; ?>