<?php
class ControllerModuleCPM extends Controller {
	protected function index($setting) {
		$this->language->load('module/cpm');
		
		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['button_cart'] = $this->language->get('button_cart');
				
		$this->load->model('catalog/member');
		
		$this->load->model('catalog/product');

		$this->load->model('tool/image');
		
		$this->data['members'] = array();
		
		$data = array(
			'sort'  => $setting['order_by'],
			'order' => $setting['order'],
			'start' => 0,
			'limit' => $setting['limit']
		);
			
		$this->data['custom_fields'] = (isset($setting['custom_fields']) ? $setting['custom_fields'] : false);
		$this->data['product_count'] = $setting['product_count'];
		
		$this->data['entry_cpm_custom_field_01'] = $this->config->get('cpm_custom_field_01');
		$this->data['entry_cpm_custom_field_02'] = $this->config->get('cpm_custom_field_02');
		$this->data['entry_cpm_custom_field_03'] = $this->config->get('cpm_custom_field_03');
		$this->data['entry_cpm_custom_field_04'] = $this->config->get('cpm_custom_field_04');
		$this->data['entry_cpm_custom_field_05'] = $this->config->get('cpm_custom_field_05');
		$this->data['entry_cpm_custom_field_06'] = $this->config->get('cpm_custom_field_06');

		$results = $this->model_catalog_member->getMembers($data);

		foreach ($results as $result) {	
			$total_products = $this->model_catalog_product->getTotalProductsByCPMCustomerId($result['customer_id']);
			
			if ($total_products > 0) {				
				if ($result['cpm_account_image']) {
					$image = $this->model_tool_image->resize($result['cpm_account_image'], $setting['image_width'], $setting['image_height']);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', $setting['image_width'], $setting['image_height']);
				}
			
				/*
				if ($this->config->get('config_review_status')) {
					$rating = $result['rating'];
				} else {
					$rating = false;
				}
				*/
				
				$this->data['members'][] = array(
					'member_id' => $result['customer_id'],
					'image'   	 => $image,
					'name'    	 => $result['cpm_account_name'],
					'text_products' => sprintf($this->language->get('text_products'), (int)$total_products),
					'cpm_custom_field_01' => (isset($result['cpm_custom_field_01']) ? $result['cpm_custom_field_01'] : ''),
					'cpm_custom_field_02' => (isset($result['cpm_custom_field_02']) ? $result['cpm_custom_field_02'] : ''),
					'cpm_custom_field_03' => (isset($result['cpm_custom_field_03']) ? $result['cpm_custom_field_03'] : ''),
					'cpm_custom_field_04' => (isset($result['cpm_custom_field_04']) ? $result['cpm_custom_field_04'] : ''),
					'cpm_custom_field_05' => (isset($result['cpm_custom_field_05']) ? $result['cpm_custom_field_05'] : ''),
					'cpm_custom_field_06' => (isset($result['cpm_custom_field_06']) ? $result['cpm_custom_field_06'] : ''),				
					'rating'     => false, // $rating,
					// 'reviews'    => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'    	 => $this->url->link('product/member/info', 'member_id=' . $result['customer_id']),
				);
			}
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/module/cpm.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/module/cpm.tpl';
		} else {
			$this->template = 'default/template/module/cpm.tpl';
		}

		$this->render();
	}
}
?>