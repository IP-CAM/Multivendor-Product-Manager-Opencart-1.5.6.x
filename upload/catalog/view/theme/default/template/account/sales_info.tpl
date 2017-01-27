<?php echo $header; ?>
	
<?php echo $column_left; ?><?php echo $column_right; ?>

<div id="content"><?php echo $content_top; ?>

  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
  <h1><?php echo $heading_title; ?></h1>

	<table class="list">
	
		<thead>
			<tr>
				<td class="left" colspan="2">
				<?php echo $text_sales_detail; ?>
				</td>
			</tr>
		</thead>
	
		<tbody>
			<tr>
				<td class="left" style="width: 50%;">
					<?php if ($invoice_no) { ?>
						<b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
					<?php } ?>
	
					<b><?php echo $text_sale_id; ?></b> #<?php echo $order_id; ?><br />
	
					<b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?>
				</td>
				<td class="left">
					<b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
					<?php if ($shipping_method) { ?>
						<b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
					<?php } ?>
				</td>
			</tr>
		</tbody>
	
	</table>
	
	<table class="list">
	
		<thead>
			<tr>
				<td class="left">
				<?php echo $text_payment_address; ?>
				</td>
				<?php if ($shipping_address) { ?>
				<td class="left">
				<?php echo $text_shipping_address; ?>
				</td>
				<?php } ?>
			</tr>
		</thead>
	
		<tbody>
			<tr>
				<td class="left"><?php echo $payment_address; ?></td>
				<?php if ($shipping_address) { ?>
				<td class="left"><?php echo $shipping_address; ?></td>
				<?php } ?>
			</tr>
		</tbody>
	
	</table>
	
	<table class="list">
	
		<thead>
			<tr>
				<td class="cener"><?php echo $column_image; ?></td>
				<td class="left"><?php echo $column_name; ?></td>
				<td class="center"><?php echo $column_quantity; ?></td>
				<td class="right"><?php echo $column_price; ?></td>
				<td class="right"><?php echo $column_total; ?></td>
			</tr>
		</thead>
	
		<tbody>
	
			<?php foreach ($products as $product) { ?>
	
				<tr>
					<td class="center"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
					<td class="left">
					<b><?php echo $product['name']; ?></b>
						<ul>
							<li><small><?php echo $column_model; ?>: <?php echo $product['model']; ?></small></li>
							<?php if ($product['member']) { ?>
							<li><small><?php echo $column_member; ?>: <?php echo $product['member']; ?></small></li>
							<?php } ?>
							<?php foreach ($product['option'] as $option) { ?>
							<?php if ($option['type'] != 'file') { ?>
			                <li><small><?php echo $option['name']; ?>: <?php echo $option['value']; ?></small></li>
			                <?php } else { ?>
			                <li><small><?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small></li>
			                <?php } ?>
							<?php } ?>
						</ul>
					</td>
					<td class="center"><?php echo $product['quantity']; ?></td>
					<td class="right"><?php echo $product['price']; ?></td>
					<td class="right"><?php echo $product['total']; ?></td>
				</tr>
	
			<?php } ?>
	
			<?php foreach ($vouchers as $voucher) { ?>
	
				<tr>
					<td class="center">&nbsp;</td>
					<td class="left"><?php echo $voucher['description']; ?></td>
					<td class="center">1</td>
					<td class="right"><?php echo $voucher['amount']; ?></td>
					<td class="right"><?php echo $voucher['amount']; ?></td>
				</tr>
			<?php } ?>
	
		</tbody>
	
		<tfoot>
			<?php foreach ($totals as $total) { ?>
			<tr>
				<td colspan="4" class="right"><b><?php echo $total['title']; ?>:</b></td>
				<td class="right"><?php echo $total['text']; ?></td>
			</tr>
			<?php } ?>
		</tfoot>
	</table>
	
	<?php if ($comment) { ?>
	<table class="list">
		<thead>
			<tr><td class="left"><?php echo $text_comment; ?></td></tr>
		</thead>
		<tbody>
			<tr><td class="left"><?php echo $comment; ?></td></tr>
		</tbody>
	</table>
	<?php } ?>
	
	<h2><?php echo $text_history; ?></h2>

	<div id="history"></div>
	
	<?php if ($this->config->get('cpm_report_sales_history')) { ?>
	<h3><?php echo $text_history_add; ?></h3>
	<table class="form">
	  <tr>
		<td><?php echo $text_order_status; ?></td>
		<td>
		  <select name="order_status_id">
			<?php foreach ($sales_statuses as $sales_statuses) { ?>
			<?php if ($sales_statuses['order_status_id'] == $sales_status_id) { ?>
			<option value="<?php echo $sales_statuses['order_status_id']; ?>" selected="selected"><?php echo $sales_statuses['name']; ?></option>
			<?php } else { ?>
			<option value="<?php echo $sales_statuses['order_status_id']; ?>"><?php echo $sales_statuses['name']; ?></option>
			<?php } ?>
			<?php } ?>
		  </select>
		</td>
	  </tr>
	  <tr>
		<td><?php echo $text_emailed; ?></td>
		<td><input type="checkbox" name="emailed" value="0" /></td>
	  </tr>
	  <tr>
		<td><?php echo $text_comment; ?></td>
		<td>
			<textarea name="comment" cols="40" rows="8" style="width: 99%"></textarea>
			<div style="margin-top: 10px; text-align: right;"><a id="button-history" class="button"><?php echo $button_add_history; ?></a></div>
		</td>
	  </tr>
	</table>
	<?php } ?>
	
<div class="buttons">
    <div class="left"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_back; ?></a></div>
</div>

<?php echo $content_bottom; ?></div><!-- #content -->
<script type="text/javascript"><!--
$('#history .pagination a').live('click', function() {
	$('#history').load(this.href);	
	return false;
});

$('#history').load('index.php?route=account/sales/history&sale_id=<?php echo $order_id; ?>');

<?php if ($this->config->get('cpm_report_sales_history')) { ?>
$('#button-history').live('click', function() {
	$.ajax({
		url: 'index.php?route=account/sales/history&sale_id=<?php echo $order_id; ?>',
		type: 'post',
		dataType: 'html',
		data: 'order_status_id=' + encodeURIComponent($('select[name=\'order_status_id\']').val()) + '&emailed=' + encodeURIComponent($('input[name=\'emailed\']').attr('checked') ? 1 : 0) + '&comment=' + encodeURIComponent($('textarea[name=\'comment\']').val()),
		beforeSend: function() {
			$('.success, .warning').remove();
			$('#button-history').attr('disabled', true);
			$('#history').prepend('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		complete: function() {
			$('#button-history').attr('disabled', false);
			$('.attention').remove();
		},
		success: function(html) {
			$('#history').html(html);
			
			$('textarea[name=\'comment\']').val('');
			
			$('#order-status').html($('select[name=\'order_status_id\'] option:selected').text());
		}
	});
});
<?php } ?>
//--></script>
<?php echo $footer; ?>