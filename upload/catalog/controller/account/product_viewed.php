<?php
class ControllerAccountProductViewed extends Controller {
	
	public function index() {		
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_report')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product_viewed', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
    									
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}
    	
		$this->load->language('account/product_viewed');

		$this->document->setTitle($this->language->get('heading_title'));
				
		if (isset($this->request->get['cpm_filter_name'])) {
			$cpm_filter_name = $this->request->get['cpm_filter_name'];
		} else {
			$cpm_filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}
		
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.viewed';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'DESC';
		}
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';
				
		if (isset($this->request->get['cpm_filter_name'])) {
			$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
						
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
			'href'      => $this->url->link('common/home'),        	
        	'separator' => false
      	); 

      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_account'),
			'href'      => $this->url->link('account/account', '', 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);
						
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/product_viewed', $url, 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);
		
		$this->load->model('account/product_viewed');
		
		$data = array(
			'customer_id'	  => $customer_id,
			'cpm_filter_name' => $cpm_filter_name, 
			'filter_model'	  => $filter_model,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * ($this->config->get('cpm_report_views_limit') ? $this->config->get('cpm_report_views_limit') : 12),
			'limit'           => ($this->config->get('cpm_report_views_limit') ? $this->config->get('cpm_report_views_limit') : 12)
		);
		
		$this->load->model('tool/image');
				
		$product_viewed_total = $this->model_account_product_viewed->getTotalProductsViewed($data); 
		
		$product_views_total = $this->model_account_product_viewed->getTotalProductViews($customer_id);
		
		$member_views_total = $this->model_account_product_viewed->getTotalMemberViews($customer_id);
		
		$this->data['products'] = array();
		
		$results = $this->model_account_product_viewed->getProductsViewed($data);
		
		foreach ($results as $result) {
			if ($result['viewed']) {
				$percent = round($result['viewed'] / $product_views_total * 100, 2);
			} else {
				$percent = 0;
			}
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}
					
			$this->data['products'][] = array(
				'image'   => $image,
				'name'    => $result['name'],
				'model'   => $result['model'],
				'href'    => $this->url->link('product/product','&product_id=' . $result['product_id']),
				'status'  => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'date'	  => $result['date_added'],
				'viewed'  => $result['viewed'],
				'percent' => $percent . '%'			
			);
		}
 		
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_member_views'] = sprintf($this->language->get('text_member_views'), number_format($member_views_total), $this->url->link('product/member/info','&member_id=' . $customer_id, '', 'SSL'));
		 	
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		
		$this->data['help_viewed_instructions'] = $this->language->get('help_viewed_instructions');

		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_name'] = $this->language->get('column_name');
		$this->data['column_model'] = $this->language->get('column_model');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date'] = $this->language->get('column_date');
		$this->data['column_viewed'] = $this->language->get('column_viewed');
		$this->data['column_percent'] = $this->language->get('column_percent');
		
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_continue'] = $this->language->get('button_continue');
		 		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		$url = '';

		if (isset($this->request->get['cpm_filter_name'])) {
			$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}
								
		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}	
				
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
					
		$this->data['sort_name'] = $this->url->link('account/product_viewed', '&sort=pd.name' . $url, 'SSL');
		$this->data['sort_model'] = $this->url->link('account/product_viewed', '&sort=p.model' . $url, 'SSL');
		$this->data['sort_date'] = $this->url->link('account/product_viewed', '&sort=p.date_added' . $url, 'SSL');
		$this->data['sort_viewed'] = $this->url->link('account/product_viewed', '&sort=p.viewed' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('account/product_viewed', '&sort=p.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('account/product_viewed', '&sort=p.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['cpm_filter_name'])) {
			$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
						
		$pagination = new Pagination();
		$pagination->total = $product_viewed_total;
		$pagination->page = $page;
		$pagination->limit = ($this->config->get('cpm_report_views_limit') ? $this->config->get('cpm_report_views_limit') : 12);
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/product_viewed', '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
	
		$this->data['cpm_filter_name'] = $cpm_filter_name;
		$this->data['filter_model'] = $filter_model;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/cpm.css')) {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/' . $this->config->get('config_template') . '/stylesheet/cpm.css');
		} else {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/default/stylesheet/cpm.css');
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/product_viewed.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/product_viewed.tpl';
		} else {
			$this->template = 'default/template/account/product_viewed.tpl';
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

	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['cpm_filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('account/product');
			
			if ($this->customer->getId()) {
				$customer_id = $this->customer->getId();
			} else {
				$customer_id = 0;
			}

			if (isset($this->request->get['cpm_filter_name'])) {
				$cpm_filter_name = $this->request->get['cpm_filter_name'];
			} else {
				$cpm_filter_name = '';
			}
			
			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'customer_id'		  => $customer_id,
				'cpm_filter_name'     => $cpm_filter_name,
				'filter_model'        => $filter_model,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_account_product->getProducts($data);
			
			foreach ($results as $result) {					
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model']
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
  	
}
?>