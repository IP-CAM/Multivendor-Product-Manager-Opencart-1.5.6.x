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
  
  <div id="register-landing" class="login-content">

	<div id="register-landing-customer" class="category-info left" style="position:relative;">
		
		<h2><?php echo $text_register_customer; ?></h2>
		
		<div class="content">

			<div class="image">
				<a href="<?php echo $register_customer; ?>"><img alt="<?php echo $register_customer; ?>" src="<?php echo $account_image['customer']; ?>" /></a>
			</div>
				
			<p><?php echo $text_register_customer_account; ?></p>
			
			<div><a href="<?php echo $register_customer; ?>" class="button" style="position:absolute;bottom:30px;right:10px;"><?php echo $button_continue; ?></a></div>
		
		</div>
			
	</div>
	
	<div id="register-landing-member"  class="category-info right" style="position:relative;">
		
		<h2><?php echo $text_register_cpm; ?></h2>

		<div class="content">

			<div class="image">
				<a href="<?php echo $register_cpm; ?>"><img alt="<?php echo $register_cpm; ?>" src="<?php echo $account_image['member']; ?>" /></a>
			</div>
			
			<p><?php echo $text_register_cpm_account; ?></p>
			
			<div><a href="<?php echo $register_cpm; ?>" class="button" style="position:absolute;bottom:30px;right:10px;"><?php echo $button_continue; ?></a></div>
		
		</div>
			
	</div>
								
  </div>
  <?php echo $content_bottom; ?></div>
  <?php echo $footer; ?>