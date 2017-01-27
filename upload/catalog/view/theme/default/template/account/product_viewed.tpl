<?php echo $header; ?>

<?php echo $column_left; ?><?php echo $column_right; ?>

<div id="content"><?php echo $content_top; ?>

  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
    <?php if ($error_warning) { ?>
    <div class="alert warning"><?php echo $error_warning; ?><a class="close" href="#" data-dismiss="alert">&times;</a></div>
    <?php } ?>
    
	<h1><img src="catalog/view/theme/default/image/cpm/report.png" alt="" /> <?php echo $heading_title; ?></h1>
	
	<h4><?php echo $text_member_views; ?></h4>
	
	<form action="" method="post" enctype="multipart/form-data" id="form">
	  <table class="list">
		<thead>
		  <tr>
			<td class="center"><?php echo $column_image; ?></td>
			<td class="left"><?php if ($sort == 'pd.name') { ?>
				<a href="<?php echo $sort_name; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_name; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_name; ?>"><?php echo $column_name; ?></a>
				<?php } ?></td>
			<td class="left"><?php if ($sort == 'p.model') { ?>
				<a href="<?php echo $sort_model; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_model; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_model; ?>"><?php echo $column_model; ?></a>
				<?php } ?></td>
			<td width="90" class="left"><?php if ($sort == 'p.status') { ?>
				<a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
				<?php } ?></td>
			<td class="left"><?php if ($sort == 'p.date_added') { ?>
				<a href="<?php echo $sort_date; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_date; ?>"><?php echo $column_date; ?></a>
				<?php } ?></td>
			<td class="left"><?php if ($sort == 'p.viewed') { ?>
				<a href="<?php echo $sort_viewed; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_viewed; ?></a>
				<?php } else { ?>
				<a href="<?php echo $sort_viewed; ?>"><?php echo $column_viewed; ?></a>
				<?php } ?></td>
			<td class="right"><?php echo $column_percent; ?></td>
		  </tr>
		</thead>
		<tbody>
			<tr class="filter">
			  <td></td>
			  <td><input type="text" name="cpm_filter_name" value="<?php echo $cpm_filter_name; ?>" /></td>
			  <td><input type="text" name="filter_model" value="<?php echo $filter_model; ?>" /></td>
			  <td><select name="filter_status">
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
			  <td></td>
			  <td></td>
			  <td align="right"><a onclick="filter();" class="button"><?php echo $button_filter; ?></a></td>
			</tr>
		  <?php if ($products) { ?>
		  <?php foreach ($products as $product) { ?>
		  <tr>
			<td class="center"><img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" style="padding: 1px; border: 1px solid #DDDDDD;" /></td>
			<td class="left"><a href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?></a></td>
			<td class="left"><?php echo $product['model']; ?></td>
			<td class="left <?php echo (($product['status'] === $text_enabled) ? ('enabled') : ('disabled')); ?>"><?php echo $product['status']; ?></td>
			<td class="right"><?php echo $product['date']; ?></td>						
			<td class="right"><?php echo $product['viewed']; ?></td>
			<td class="right"><?php echo $product['percent']; ?></td>
		  </tr>
		  <?php } ?>
		  <?php } else { ?>
		  <tr>
			<td class="center" colspan="7"><div class="alert warning"><?php echo $text_no_results; ?></div></td>
		  </tr>
		  <?php } ?>
		</tbody>
	  </table>
	  </form>
	  
	  <div class="pagination"><?php echo $pagination; ?></div>
	
	<div class="buttons">
		<div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
	</div>

<?php echo $content_bottom; ?>

</div><!-- #content -->

<script type="text/javascript"><!--
function filter() {
	url = 'index.php?route=account/product_viewed';
	
	var cpm_filter_name = $('input[name=\'cpm_filter_name\']').attr('value');
	
	if (cpm_filter_name) {
		url += '&cpm_filter_name=' + encodeURIComponent(cpm_filter_name);
	}
	
	var filter_model = $('input[name=\'filter_model\']').attr('value');
	
	if (filter_model) {
		url += '&filter_model=' + encodeURIComponent(filter_model);
	}
	
	var filter_status = $('select[name=\'filter_status\']').attr('value');
	
	if (filter_status != '*') {
		url += '&filter_status=' + encodeURIComponent(filter_status);
	}	

	location = url;
}
//--></script>  
<script type="text/javascript"><!--
$('#form input').keydown(function(e) {
	if (e.keyCode == 13) {
		filter();
	}
});
//--></script> 
<script type="text/javascript"><!--
$('input[name=\'cpm_filter_name\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=account/product_viewed/autocomplete&cpm_filter_name=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.name,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'cpm_filter_name\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});

$('input[name=\'filter_model\']').autocomplete({
	delay: 0,
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=account/product_viewed/autocomplete&filter_model=' +  encodeURIComponent(request.term),
			dataType: 'json',
			success: function(json) {		
				response($.map(json, function(item) {
					return {
						label: item.model,
						value: item.product_id
					}
				}));
			}
		});
	}, 
	select: function(event, ui) {
		$('input[name=\'filter_model\']').val(ui.item.label);
						
		return false;
	},
	focus: function(event, ui) {
      	return false;
   	}
});
//--></script> 

<?php echo $footer; ?> 