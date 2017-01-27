<?php 
class ControllerAccountRegisterLanding extends Controller {
	private $error = array();
	
	public function index() {
		
		if ($this->customer->isLogged()) {  
      		$this->redirect($this->url->link('account/account', '', 'SSL'));
    	}
    	
		if (!$this->config->get('cpm_status') || !$this->config->get('cpm_registration')) {
			$this->redirect($this->url->link('account/register', '', 'SSL'));
		}
	
    	$this->language->load('account/register_landing');

    	$this->document->setTitle($this->language->get('heading_title'));
		
      	$this->data['breadcrumbs'] = array();

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),       	
        	'separator' => false
      	);
  
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_register'),
			'href'      => $this->url->link('account/register_landing', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->load->model('tool/image');
		
		$account_images = array(
			'customer'	=> 'data/logo.png',
			'member'	=> 'data/logo.png'
		);
		
		foreach ($account_images as $account_type => $image_location) {
			if ($image_location && file_exists(DIR_IMAGE . $image_location)) {
				$this->data['account_image'][$account_type] = $this->model_tool_image->resize($image_location, 100, 100);
			} else {
				$this->data['account_image'][$account_type] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
			}
		}
	
    	$this->data['heading_title'] = $this->language->get('heading_title');

    	$this->data['text_new_customer'] = $this->language->get('text_new_customer');
    	$this->data['text_register_customer'] = $this->language->get('text_register_customer');
    	$this->data['text_register_customer_account'] = $this->language->get('text_register_customer_account');
		$this->data['text_new_cpm'] = $this->language->get('text_new_cpm');
    	$this->data['text_register_cpm'] = $this->language->get('text_register_cpm');
    	$this->data['text_register_cpm_account'] = $this->language->get('text_register_cpm_account');
		$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', 'SSL'));
	
    	$this->data['button_continue'] = $this->language->get('button_continue');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$this->data['register_customer'] = $this->url->link('account/register_customer', '', 'SSL');
		$this->data['register_cpm'] = $this->url->link('account/register_cpm', '', 'SSL');
				
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/register_landing.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/register_landing.tpl';
		} else {
			$this->template = 'default/template/account/register_landing.tpl';
		}
		
		$this->children = array(
			'common/column_left',
			'common/column_right',
			'common/content_top',
			'common/content_bottom',
			'common/footer',
			'common/header'	
		);
						
		$this->response->setOutput($this->render());
  	}
}
?>