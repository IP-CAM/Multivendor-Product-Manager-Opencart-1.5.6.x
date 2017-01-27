<?php echo $header; ?><?php echo $column_left; ?><?php echo $column_right; ?>
<div id="content"><?php echo $content_top; ?>
  <div class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <?php echo $breadcrumb['separator']; ?><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php } ?>
  </div>
  <h1><?php echo $heading_title; ?></h1>
  <?php if ($thumb || $description) { ?>
  <div class="category-info">
    <?php if ($thumb) { ?>
    <div class="category-image image"><img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" /></div>
    <?php } ?>
    <?php if ($description) { ?>
	<div class="category-description">
    <?php echo $description; ?>
    </div>
    <?php } ?>
  </div>
  <?php } ?>
  <?php if ($categories) { ?>
  <p><b><?php echo $text_index; ?></b>
    <?php foreach ($categories as $category) { ?>
    &nbsp;&nbsp;&nbsp;<a href="<?php echo $category['href']; ?>#<?php echo $category['cpm_account_name']; ?>"><b><?php echo $category['cpm_account_name']; ?></b></a>
    <?php } ?>
  </p>
  
  <div class="product-filter member-filter" style="border:none;margin-bottom:10px;">
    <div class="limit" style="float:right;margin-left: 15px;"><b><?php echo $text_limit; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($limits as $limits) { ?>
        <?php if ($limits['value'] == $limit) { ?>
        <option value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
    <div class="sort" style="float:right;"><b><?php echo $text_sort; ?></b>
      <select onchange="location = this.value;">
        <?php foreach ($sorts as $sorts) { ?>
        <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
        <option value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></option>
        <?php } else { ?>
        <option value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></option>
        <?php } ?>
        <?php } ?>
      </select>
    </div>
  </div>
  
  <?php foreach ($categories as $category) { ?>
  <div class="manufacturer-list">
    <div class="manufacturer-heading"><?php echo $category['cpm_account_name']; ?><a id="<?php echo $category['cpm_account_name']; ?>"></a></div>
    <div class="manufacturer-content">
      <?php if ($category['member']) { ?>
      <?php for ($i = 0; $i < count($category['member']);) { ?>
      <ul>
        <?php $j = $i + ceil(count($category['member']) / 4); ?>
        <?php for (; $i < $j; $i++) { ?>
        <?php if (isset($category['member'][$i])) { ?>
        <li>
			<?php if($category['member'][$i]['image']) { ?>
			<a href="<?php echo $category['member'][$i]['href']; ?>"><img src="<?php  echo $category['member'][$i]['image']; ?> " alt="<?php echo $category['member'][$i]['name']; ?>" title="<?php echo $category['member'][$i]['name']; ?>" /></a>
			<?php } else { ?>
			<a href="<?php echo $category['member'][$i]['href']; ?>"><img src="/image/no_image.png" height="100" width="100" alt="<?php echo $category['member'][$i]['name']; ?>" title="<?php echo $category['member'][$i]['name']; ?>" /></a>
			<?php } ?>
			<br /><a href="<?php echo $category['member'][$i]['href']; ?>"><?php echo $category['member'][$i]['name']; ?></a>
			<?php if ($this->config->get('config_product_count')) { ?><br /><a href="<?php echo $category['member'][$i]['href']; ?>"><?php echo $category['member'][$i]['total_products']; ?> <?php echo $text_products; ?></a><?php } ?>
		</li>
        <?php } ?>
        <?php } ?>
      </ul>
      <?php } ?>
      <?php } ?>
    </div>
  </div>
  <?php } ?>
  <div class="pagination"><?php echo $pagination; ?></div>
  <?php } else { ?>
  <div class="content"><?php echo $text_empty_members; ?></div>
  <?php } ?>
  <div class="buttons">
  	<div class="left"><a href="<?php echo $back; ?>" class="button"><?php echo $button_back; ?></a></div>
  </div>
  <?php echo $content_bottom; ?></div>
<?php echo $footer; ?>