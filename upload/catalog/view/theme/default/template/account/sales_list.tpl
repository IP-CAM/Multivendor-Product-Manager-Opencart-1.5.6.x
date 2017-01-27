<?php echo $header; ?>

<?php echo $column_left; ?><?php echo $column_right; ?>

<div id="content"><?php echo $content_top; ?>

  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  
  <h1><img src="catalog/view/theme/default/image/cpm/report.png" alt="" /> <?php echo $heading_title; ?></h1>

<?php if ($sales) { ?>

	<table class="list">
	  <thead>
		<tr>
		  <td class="center"><?php echo $text_sale_id; ?></td>
		  <td class="left"><?php echo $text_date_added; ?></td>
		  <td class="left"><?php echo $text_status; ?></td>
		  <td class="left"><?php echo $text_customer; ?></td>
		  <td class="center"><?php echo $text_products; ?></td>
		  <td class="right"><?php echo $text_total; ?></td>
		  <?php if ($this->config->get('cpm_report_sales_commission')) { ?><td class="right"><?php echo $text_commission; ?></td><?php } ?>
		  <?php if ($this->config->get('cpm_report_sales_tax')) { ?><td class="right"><?php echo $text_tax; ?></td><?php } ?>
		  <?php if ($this->config->get('cpm_report_sales_commission') || $this->config->get('cpm_report_sales_tax')) { ?><td class="right"><?php echo $text_grand_total; ?> *</td><?php } ?>
		  <td class="center"><?php echo $text_info; ?></td>
		</tr>
	  </thead>
	  <tbody>
		<?php foreach ($sales as $sale) { ?>
		<tr>
		  <td class="center"><b><?php echo $sale['order_id']; ?></b></td>
		  <td class="left"><?php echo $sale['date_added']; ?></td>
		  <td class="left"><?php echo $sale['status']; ?></td>
		  <td class="left"><?php echo $sale['name']; ?></td>
		  <td class="center"><?php echo $sale['products']; ?></td>
 		  <td class="right"><?php echo $sale['sales']; ?></td>
		  <?php if ($this->config->get('cpm_report_sales_commission')) { ?><td class="right">- <?php echo $sale['commission']; ?></td><?php } ?>
		  <?php if ($this->config->get('cpm_report_sales_tax')) { ?>
		  <?php if ($this->config->get('cpm_report_sales_tax_add')) { ?>
		  <td class="right"><?php echo $sale['tax']; ?></td>
		  <?php } else {?>
		  <td class="right">- <?php echo $sale['tax']; ?></td>
		  <?php } ?>
		  <?php } ?>
		  <?php if ($this->config->get('cpm_report_sales_commission') || $this->config->get('cpm_report_sales_tax')) { ?><td class="right"><?php echo $sale['total']; ?></td><?php } ?>
		  <td class="center"><a href="<?php echo $sale['href']; ?>" title="<?php echo $button_view; ?>"><img src="catalog/view/theme/default/image/info.png" alt="<?php echo $button_view; ?>" title="<?php echo $button_view; ?>" /></a></td>
  		</tr>
		<?php } ?>
		<tr>
		  <td class="right" colspan="4"><?php if ($this->config->get('cpm_report_sales_commission') || $this->config->get('cpm_report_sales_tax')) { ?>* <?php echo $text_total_calculation; ?><?php } ?></td>
		  <td class="center"><b><?php echo $totals['products']; ?></b></td>
		  <td class="right"><b><?php echo $totals['sales']; ?></b></td>
		  <?php if ($this->config->get('cpm_report_sales_commission')) { ?><td class="right"><b>- <?php echo $totals['commissions']; ?></b></td><?php } ?>
		  <?php if ($this->config->get('cpm_report_sales_tax')) { ?>
		  <?php if ($this->config->get('cpm_report_sales_tax_add')) { ?>
		  <td class="right"><b><?php echo $totals['tax']; ?></b></td>
		  <?php } else {?>
		  <td class="right"><b>- <?php echo $totals['tax']; ?></b></td>
		  <?php } ?>
		  <?php } ?>
		  <?php if ($this->config->get('cpm_report_sales_commission') || $this->config->get('cpm_report_sales_tax')) { ?><td class="right"><b><?php echo $totals['grand']; ?></b></td><?php } ?>
		  <td class="center">&nbsp;</td>
		</tr>
	  </tbody>
	</table>

	<div class="paginate"><?php echo $pagination; ?></div>

<?php } else { ?>

	<div class="content"><?php echo $text_empty; ?></div>

<?php } ?>

<div class="buttons">
    <div class="right"><a href="<?php echo $continue; ?>" class="button"><?php echo $button_continue; ?></a></div>
</div>
  
<?php echo $content_bottom; ?></div><!-- #content -->
<?php echo $footer; ?>