<?php  
class ControllerAccountProductDownload extends Controller { 

	private $error = array();
   
  	public function index() {
	
	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product_download', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}

	$this->load->language('account/product_download');

    	$this->document->setTitle($this->language->get('heading_title'));
	
		$this->load->model('account/product_download');
		
    	$this->getList();
  	}
  	        
  	public function insert() {

    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product_download', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}

		$this->load->language('account/product_download');
    
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/product_download');
	
	if (!$this->validateNew($customer_id)) {
			$this->getList();
		} else {
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
				$data = $this->request->post;
				// $data['filename'] = $this->customer->getCPMDownloadsDirectory() . '/' . $data['filename'];
				$data['customer_id'] = $customer_id;
				$this->model_account_product_download->addDownload($data);
				
				$this->session->data['success'] = $this->language->get('text_success');
		  
				$url = '';
				
				if (isset($this->request->get['sort'])) {
					$url .= '&sort=' . $this->request->get['sort'];
				}

				if (isset($this->request->get['order'])) {
					$url .= '&order=' . $this->request->get['order'];
				}

				if (isset($this->request->get['page'])) {
					$url .= '&page=' . $this->request->get['page'];
				}
				
				$this->redirect($this->url->link('account/product_download', $url, 'SSL'));
			}
	
		$this->getForm();
		}
 	}

  	public function update() {

    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product_download', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}
		$this->load->language('account/product_download');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/product_download');
			
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			$data['customer_id'] = $customer_id;
			
			$this->model_account_product_download->editDownload($this->request->get['download_id'], $data);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	      
			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('account/product_download', $url, 'SSL'));
		}
		
    	$this->getForm();
  	}

  	public function delete() {

    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product_download', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}
	
		$this->load->language('account/product_download');
 
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/product_download');
			
    	if (isset($this->request->post['selected']) && $this->validateDelete()) {	  
			foreach ($this->request->post['selected'] as $download_id) {
				$this->model_account_product_download->deleteDownload($download_id, $customer_id);
			}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
			
			$this->redirect($this->url->link('account/product_download', $url, 'SSL'));
    	}

    	$this->getList();
  	}
    
  	private function getList() {
		$this->model_account_product_download->checkProductDownloadCPM();
									
		if ($this->customer->getId()) {
			$customer_id = $this->customer->getId();
		} else {
			$customer_id = 0;
		}
		
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'dd.name';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
				
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),       		
      		'separator' => false
   		); 

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),        	
			'separator' => $this->language->get('text_separator')
		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/product_download', $url, 'SSL'),
      		'separator' => $this->language->get('text_separator')
   		);
							
		$this->data['insert'] = $this->url->link('account/product_download/insert', $url, 'SSL');
		$this->data['delete'] = $this->url->link('account/product_download/delete', $url, 'SSL');	

		$this->data['downloads'] = array();

		$data = array(
			'customer_id' => $customer_id,
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit' => $this->config->get('config_admin_limit')
		);
		
		$download_total = $this->model_account_product_download->getTotalDownloads($customer_id);
	
		$results = $this->model_account_product_download->getDownloads($data);
 
    	foreach ($results as $result) {
			$action = array();
						
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('account/product_download/update', '' . '&download_id=' . $result['download_id'] . $url, 'SSL')
			);
						
			$this->data['downloads'][] = array(
				'download_id' => $result['download_id'],
				'name'        => $result['name'],
				'remaining'   => $result['remaining'],
				'selected'    => isset($this->request->post['selected']) && in_array($result['download_id'], $this->request->post['selected']),
				'action'      => $action
			);
		}	
	
		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_confirm'] = $this->language->get('text_confirm');

		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_remaining'] = $this->language->get('column_remaining');
		$this->data['column_action'] = $this->language->get('column_action');		
		
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
 		$this->data['button_continue'] = $this->language->get('button_continue');

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}
		
		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_name'] = $this->url->link('account/product_download', '' . '&sort=dd.name' . $url, 'SSL');
		$this->data['sort_remaining'] = $this->url->link('account/product_download', '' . '&sort=d.remaining' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $download_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/product_download', $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/cpm.css')) {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/' . $this->config->get('config_template') . '/stylesheet/cpm.css');
		} else {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/default/stylesheet/cpm.css');
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/product_download_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/product_download_list.tpl';
		} else {
			$this->template = 'default/template/account/product_download_list.tpl';
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
  
  	private function getForm() {
		$this->model_account_product_download->checkProductDownloadCPM();

		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
   
    	$this->data['entry_name'] = $this->language->get('entry_name');
    	$this->data['entry_filename'] = $this->language->get('entry_filename');
		$this->data['entry_mask'] = $this->language->get('entry_mask');
    	$this->data['entry_remaining'] = $this->language->get('entry_remaining');
    	$this->data['entry_update'] = $this->language->get('entry_update');
  
    	$this->data['button_save'] = $this->language->get('button_save');
    	$this->data['button_cancel'] = $this->language->get('button_cancel');
  		$this->data['button_upload'] = $this->language->get('button_upload');
		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}
		
  		if (isset($this->error['filename'])) {
			$this->data['error_filename'] = $this->error['filename'];
		} else {
			$this->data['error_filename'] = '';
		}
		
  		if (isset($this->error['mask'])) {
			$this->data['error_mask'] = $this->error['mask'];
		} else {
			$this->data['error_mask'] = '';
		}
				
		$url = '';
			
		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', '', 'SSL'),
      		'separator' => false
   		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_account'),
				'href'      => $this->url->link('account/account', '', 'SSL'),        	
			'separator' => $this->language->get('text_separator')
		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/product_download', $url, 'SSL'),      		
      		'separator' => $this->language->get('text_separator')
   		);
							
		if (!isset($this->request->get['download_id'])) {
			$this->data['action'] = $this->url->link('account/product_download/insert', $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('account/product_download/update', '' . '&download_id=' . $this->request->get['download_id'] . $url, 'SSL');
		}
		
		$this->data['cancel'] = $this->url->link('account/product_download', $url, 'SSL');
		
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();

    	if (isset($this->request->get['download_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$download_info = $this->model_account_product_download->getDownload($this->request->get['download_id'], $customer_id);
    	}
  
  		if (isset($this->request->get['download_id'])) {
			$this->data['download_id'] = $this->request->get['download_id'];
		} else {
			$this->data['download_id'] = 0;
		}
		
		if (isset($this->request->post['download_description'])) {
			$this->data['download_description'] = $this->request->post['download_description'];
		} elseif (isset($this->request->get['download_id'])) {
			$this->data['download_description'] = $this->model_account_product_download->getDownloadDescriptions($this->request->get['download_id']);
		} else {
			$this->data['download_description'] = array();
		}   
		
    	if (isset($this->request->post['filename'])) {
    		$this->data['filename'] = $this->request->post['filename'];
    	} elseif (!empty($download_info)) {
      		$this->data['filename'] = $download_info['filename'];
		} else {
			$this->data['filename'] = '';
		}
		
    	if (isset($this->request->post['mask'])) {
    		$this->data['mask'] = $this->request->post['mask'];
    	} elseif (!empty($download_info)) {
      		$this->data['mask'] = $download_info['mask'];		
		} else {
			$this->data['mask'] = '';
		}
		
		if (isset($this->request->post['remaining'])) {
      		$this->data['remaining'] = $this->request->post['remaining'];
    	} elseif (!empty($download_info)) {
      		$this->data['remaining'] = $download_info['remaining'];
    	} else {
      		$this->data['remaining'] = 1;
    	}
				 	  
    	if (isset($this->request->post['update'])) {
      		$this->data['update'] = $this->request->post['update'];
    	} else {
      		$this->data['update'] = false;
    	}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/cpm.css')) {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/' . $this->config->get('config_template') . '/stylesheet/cpm.css');
		} else {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/default/stylesheet/cpm.css');
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/product_download_form.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/product_download_form.tpl';
		} else {
			$this->template = 'default/template/account/product_download_form.tpl';
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

  	private function validateForm() {  
    	if (!$this->validateCustomer()) { 
      		$this->error['warning'] = $this->language->get('error_permission');
    	}
	
    	foreach ($this->request->post['download_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 64)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
    	}	

		if ((utf8_strlen($this->request->post['filename']) < 3) || (utf8_strlen($this->request->post['filename']) > 128)) {
			$this->error['filename'] = $this->language->get('error_filename');
		}	
		
		if (!file_exists(DIR_DOWNLOAD . $this->request->post['filename']) && !is_file(DIR_DOWNLOAD . $this->request->post['filename'])) {
			$this->error['filename'] = $this->language->get('error_exists');
		}
				
		if ((utf8_strlen($this->request->post['mask']) < 3) || (utf8_strlen($this->request->post['mask']) > 128)) {
			$this->error['mask'] = $this->language->get('error_mask');
		}	
			
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

  	private function validateDelete() {
    	if (!$this->validateCustomer()) { 
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		$this->load->model('catalog/product');

		foreach ($this->request->post['selected'] as $download_id) {
  			$product_total = $this->model_catalog_product->getTotalProductsByDownloadId($download_id);
    
			if ($product_total) {
	  			$this->error['warning'] = sprintf($this->language->get('error_product'), $product_total);	
			}	
		}	
			  	  	 
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		} 
  	}
	
  	private function validateNew($customer_id) {
    	if (!$this->validateCustomer()) { 
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}

		/* Placeholder for potential futuer feature, additional field CPM Max Downloads allowed per Customer account
		$this->customer->getCPMMaxDownloads();
		if($customer_max_downloads  == '-1') return true;
		
		$download_total = $this->model_account_product_download->getTotalDownloads($customer_id);
		if ($download_total >= $customer_max_downloads) {
			$this->error['max_downloads'] = $this->language->get('error_max_downloads');
		}
		*/
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}
		
  	private function validateCustomer() {
    	if ($this->customer->getCustomerProductManager() !== '1') { 
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

	public function upload() {
	
	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) {  
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		$this->load->language('account/product_download');
		
		$json = array();
		
		if (!empty($this->request->files['file']['name'])) {
			$filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
			
			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
				$json['error'] = $this->language->get('error_filename');
			}	  	
					
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
	
		if (!isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$ext = md5(mt_rand());
				 
				$json['filename'] = $this->customer->getCPMDownloadsDirectory() . '/' . $filename . '.' . $ext;
				$json['mask'] = $filename;
								
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_DOWNLOAD . $this->customer->getCPMDownloadsDirectory() . '/' . $filename . '.' . $ext);
			}
						
			$json['success'] = $this->language->get('text_upload');
		}	
	
		$this->response->setOutput(json_encode($json));
	}	
}
?>