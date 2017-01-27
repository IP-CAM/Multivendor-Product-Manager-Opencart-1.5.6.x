<div class="box">
  <div class="box-heading"><?php echo $heading_title; ?></div>
  <div class="box-content">
    <div class="box-product">
      <?php foreach ($members as $member) { ?>
      <div>
        <?php if ($member['image']) { ?>
        <div class="image"><a href="<?php echo $member['href']; ?>"><img src="<?php echo $member['image']; ?>" alt="<?php echo $member['name']; ?>" /></a></div>
        <?php } ?>
        <div class="name"><a href="<?php echo $member['href']; ?>"><?php echo $member['name']; ?></a></div>
        <?php if ($product_count) { ?>  
		<div><a href="<?php echo $member['href']; ?>"><?php echo $member['text_products']; ?></a></div>
		<?php } ?>
        <?php if ($custom_fields) { ?>  
		<ul class="custom-fields" style="list-style-type:none; padding:0;">
			<li <?php if (!$entry_cpm_custom_field_01 || empty($member['cpm_custom_field_01'])) echo 'style="display:none;"'; ?>>
				<b><?php echo $entry_cpm_custom_field_01; ?>:</b> <?php echo $member['cpm_custom_field_01']; ?></li>
			<li <?php if (!$entry_cpm_custom_field_02 || empty($member['cpm_custom_field_02'])) echo 'style="display:none;"'; ?>>
				<b><?php echo $entry_cpm_custom_field_02; ?>:</b> <?php echo $member['cpm_custom_field_02']; ?></li>
			<li <?php if (!$entry_cpm_custom_field_03 || empty($member['cpm_custom_field_03'])) echo 'style="display:none;"'; ?>>
				<b><?php echo $entry_cpm_custom_field_03; ?>:</b> <?php echo $member['cpm_custom_field_03']; ?></li>
			<li <?php if (!$entry_cpm_custom_field_04 || empty($member['cpm_custom_field_04'])) echo 'style="display:none;"'; ?>>
				<b><?php echo $entry_cpm_custom_field_04; ?>:</b> <?php echo $member['cpm_custom_field_04']; ?></li>
			<li <?php if (!$entry_cpm_custom_field_05 || empty($member['cpm_custom_field_05'])) echo 'style="display:none;"'; ?>>
				<b><?php echo $entry_cpm_custom_field_05; ?>:</b> <?php echo $member['cpm_custom_field_05']; ?></li>
			<li <?php if (!$entry_cpm_custom_field_06 || empty($member['cpm_custom_field_06'])) echo 'style="display:none;"'; ?>>
				<b><?php echo $entry_cpm_custom_field_06; ?>:</b> <?php echo $member['cpm_custom_field_06']; ?></li>
		</ul>
        <?php } ?>
        <?php if ($member['rating']) { ?>
        <div class="rating"><img src="catalog/view/theme/default/image/stars-<?php echo $member['rating']; ?>.png" alt="<?php echo $member['reviews']; ?>" /></div>
        <?php } ?>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
