<?php 
class ControllerAccountProduct extends Controller {
	private $error = array();
		
	public function index() {
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_product_manager')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}

        $this->load->language('account/product');
        		
		$this->load->model('account/product');
 		
    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->getList();
	}
	
  	public function insert() {
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_product_manager')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}

        $language = $this->load->language('account/product');
        $this->data = array_merge($this->data, $language);

    	$this->document->setTitle($this->language->get('heading_title')); 
		
		$this->load->model('account/product');
		
		if (!$this->validateNew($customer_id)) {
			$this->getList();
		} else {
			if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			$data['customer_id'] = $customer_id;
			
			$this->model_account_product->addProduct($data);
	  		
			$this->session->data['success'] = $this->language->get('text_success');
	  
			$url = '';
			
			if (isset($this->request->get['cpm_filter_name'])) {
				$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}
			
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
			
			$this->redirect($this->url->link('account/product', $url, 'SSL'));
    	}
    	
		$this->getForm();
		}
  	}

  	public function update() {
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_product_manager')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}

        $language = $this->load->language('account/product');
        $this->data = array_merge($this->data, $language);

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/product');
	
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$data = $this->request->post;
			$data['customer_id'] = $customer_id;

			$this->model_account_product->editProduct($this->request->get['cpm_product_id'], $data);
			
			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['cpm_filter_name'])) {
				$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
			
			$this->redirect($this->url->link('account/product', $url, 'SSL'));
		}

    	$this->getForm();
  	}

  	public function delete() {
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_product_manager')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product', '', 'SSL');
	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}

    	$this->load->language('account/product');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/product');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_account_product->deleteProduct($product_id, $customer_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['cpm_filter_name'])) {
				$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
			
			$this->redirect($this->url->link('account/product', $url, 'SSL'));
		}

    	$this->getList();
  	}

  	public function copy() {
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_product_manager')) {  
      		$this->session->data['redirect'] = $this->url->link('account/product', '', 'SSL');

	  		$this->redirect($this->url->link('account/login', '', 'SSL'));
    	}
		
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}

    	$this->load->language('account/product');

    	$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/product');
		
		if (isset($this->request->post['selected']) && $this->validateNew($customer_id)) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_account_product->copyProduct($product_id, $customer_id);
	  		}

			$this->session->data['success'] = $this->language->get('text_success');
			
			$url = '';
			
			if (isset($this->request->get['cpm_filter_name'])) {
				$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
			}
		  
			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
		
			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
			
			$this->redirect($this->url->link('account/product', $url, 'SSL'));
		}

    	$this->getList();
  	}
	
	public function enable() {
		if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_product_manager')) {  
			$this->session->data['redirect'] = $this->url->link('account/product', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
			
		if ($this->customer->getId()) {
			$customer_id = $this->customer->getId();
		} else {
			$customer_id = 0;
		}

		$this->load->language('account/product');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/product');
		
		if (isset($this->request->post['selected'])) {
			$enabled_count = 0;
			
			foreach ($this->request->post['selected'] as $product_id) {
				$product_info = $this->model_account_product->getProduct($product_id, $customer_id);
						  
				if ($product_info && !$product_info['status']) {
				  $this->model_account_product->enableProduct($product_id, $customer_id);
				  $enabled_count++;
				}
			} 
			
			$this->session->data['success'] = sprintf($this->language->get('text_product_enabled'), $enabled_count);	
			
			$url = '';
				
			if (isset($this->request->get['cpm_filter_name'])) {
			  $url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_model'])) {
			  $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}
			
			if (isset($this->request->get['filter_price'])) {
			  $url .= '&filter_price=' . $this->request->get['filter_price'];
			}
			
			if (isset($this->request->get['filter_quantity'])) {
			  $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}	
			
			if (isset($this->request->get['filter_approved'])) {
			  $url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
						
		  $this->redirect($this->url->link('account/product', $url, 'SSL'));			
	  } else {
		$this->error['warning'] = $this->language->get('error_notchecked');
	  }
	  
	  $this->getList();
  }

	public function disable() {
		if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_product_manager')) {  
			$this->session->data['redirect'] = $this->url->link('account/product', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		if ($this->customer->getId()) {
			$customer_id = $this->customer->getId();
		} else {
			$customer_id = 0;
		}

        $this->load->language('account/product');
				  
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/product');
		
		if (isset($this->request->post['selected'])) {
			  $disabled_count = 0;
			  
			  foreach ($this->request->post['selected'] as $product_id) {
				  $product_info = $this->model_account_product->getProduct($product_id, $customer_id);
				  
				  if ($product_info && $product_info['status']) {
					  $this->model_account_product->disableProduct($product_id, $customer_id);
					  
					  $disabled_count++;
				  }
			  } 
			  
			  $this->session->data['success'] = sprintf($this->language->get('text_product_disabled'), $disabled_count);	
			  
			  $url = '';
					
			  if (isset($this->request->get['cpm_filter_name'])) {
				  $url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
			  }
			
			  if (isset($this->request->get['filter_model'])) {
				  $url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			  }
			  
			  if (isset($this->request->get['filter_price'])) {
				  $url .= '&filter_price=' . $this->request->get['filter_price'];
			  }
			  
			  if (isset($this->request->get['filter_quantity'])) {
				  $url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			  }	
		  
			  if (isset($this->request->get['filter_approved'])) {
				  $url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
							
			  $this->redirect($this->url->link('account/product', $url, 'SSL'));			
		} else {
			$this->error['warning'] = $this->language->get('error_notchecked');
		}
		
		$this->getList();
	}
	
  	private function getList() {						
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}
		
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
		
		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}
	
		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = null;
		}
		
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
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
						
		if (isset($this->request->get['cpm_filter_name'])) {
			$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
			
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
			'href'      => $this->url->link('account/product', $url, 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);
						
		$this->data['enable'] = $this->url->link('account/product/enable', $url, 'SSL');
		$this->data['disable'] = $this->url->link('account/product/disable', $url, 'SSL');
		$this->data['insert'] = $this->url->link('account/product/insert', $url, 'SSL');
		$this->data['copy'] = $this->url->link('account/product/copy', $url, 'SSL');	
		$this->data['delete'] = $this->url->link('account/product/delete', $url, 'SSL');
    	
		$this->data['products'] = array();

		$data = array(
			'customer_id'	  => $customer_id,
			'cpm_filter_name' => $cpm_filter_name, 
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_approved' => $filter_approved,
			'filter_status'   => $filter_status,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * ($this->config->get('cpm_product_manager_limit') ? $this->config->get('cpm_product_manager_limit') : 12),
			'limit'           => ($this->config->get('cpm_product_manager_limit') ? $this->config->get('cpm_product_manager_limit') : 12)
		);
		
		$this->load->model('tool/image');
		
		$product_total = $this->model_account_product->getTotalProducts($data);
		
		$results = $this->model_account_product->getProducts($data);
						    	
		foreach ($results as $result) {
			$action = array();
			
			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('account/product/update', '&cpm_product_id=' . $result['product_id'] . $url, 'SSL')
			);
			
			if ($result['image'] && file_exists(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_wishlist_width'), $this->config->get('config_image_wishlist_height'));
			}
	
			$special = false;
			
			$product_specials = $this->model_account_product->getProductSpecials($result['product_id']);
			
			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
					$special = $product_special['price'];
			
					break;
				}					
			}
	
      		$this->data['products'][] = array(
				'product_id' => $result['product_id'],  // cpm_product_id?
				'name'       => $result['name'],
				'model'      => $result['model'],
				'href'    	 => $this->url->link('product/product','&product_id=' . $result['product_id']),
				'price'      => $result['price'],
				'special'    => $special,
				'image'      => $image,
				'quantity'   => $result['quantity'],
				'approved'   => ($result['cpm_approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'status'     => ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'selected'   => isset($this->request->post['selected']) && in_array($result['product_id'], $this->request->post['selected']),
				'action'     => $action
			);
    	}

		$this->data['heading_title'] = $this->language->get('heading_title');		
				
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');	
		$this->data['text_enabled'] = $this->language->get('text_enabled');		
		$this->data['text_disabled'] = $this->language->get('text_disabled');		
		$this->data['text_no_results'] = $this->language->get('text_no_results');		
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
			
		$this->data['column_image'] = $this->language->get('column_image');		
		$this->data['column_name'] = $this->language->get('column_name');		
		$this->data['column_model'] = $this->language->get('column_model');		
		$this->data['column_price'] = $this->language->get('column_price');		
		$this->data['column_quantity'] = $this->language->get('column_quantity');
		$this->data['column_approved'] = $this->language->get('column_approved');		
		$this->data['column_status'] = $this->language->get('column_status');		
		$this->data['column_action'] = $this->language->get('column_action');		
				
		$this->data['button_enable'] = $this->language->get('button_enable');		
		$this->data['button_disable'] = $this->language->get('button_disable');		
		$this->data['button_copy'] = $this->language->get('button_copy');		
		$this->data['button_insert'] = $this->language->get('button_insert');		
		$this->data['button_delete'] = $this->language->get('button_delete');		
		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_continue'] = $this->language->get('button_continue');
		 		
 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['max_products'])) {
			$this->data['error_max_products'] = $this->error['max_products'];
		} else {
			$this->data['error_max_products'] = '';
		}	

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$url = '';

		if (isset($this->request->get['cpm_filter_name'])) {
			$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}
		
		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
					
		$this->data['sort_name'] = $this->url->link('account/product', '&sort=pd.name' . $url, 'SSL');
		$this->data['sort_model'] = $this->url->link('account/product', '&sort=p.model' . $url, 'SSL');
		$this->data['sort_price'] = $this->url->link('account/product', '&sort=p.price' . $url, 'SSL');
		$this->data['sort_quantity'] = $this->url->link('account/product', '&sort=p.quantity' . $url, 'SSL');
		$this->data['sort_approved'] = $this->url->link('account/product', '&sort=p.cpm_approved' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('account/product', '&sort=p.status' . $url, 'SSL');
		$this->data['sort_order'] = $this->url->link('account/product', '&sort=p.sort_order' . $url, 'SSL');
		
		$url = '';

		if (isset($this->request->get['cpm_filter_name'])) {
			$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}
		
		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
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
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = ($this->config->get('cpm_product_manager_limit') ? $this->config->get('cpm_product_manager_limit') : 12);
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/product', $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();
		
		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
	
		$this->data['cpm_filter_name'] = $cpm_filter_name;
		$this->data['filter_model'] = $filter_model;
		$this->data['filter_price'] = $filter_price;
		$this->data['filter_quantity'] = $filter_quantity;
		$this->data['filter_approved'] = $filter_approved;
		$this->data['filter_status'] = $filter_status;
		
		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/cpm.css')) {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/' . $this->config->get('config_template') . '/stylesheet/cpm.css');
		} else {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/default/stylesheet/cpm.css');
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/product_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/product_list.tpl';
		} else {
			$this->template = 'default/template/account/product_list.tpl';
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
		if ($this->customer->getId()) {
      		$customer_id = $this->customer->getId();
		} else {
      		$customer_id = 0;
    	}

 		if (isset($this->error['name'])) {
			$this->data['error_name'] = $this->error['name'];
		} else {
			$this->data['error_name'] = array();
		}

   		if (isset($this->error['description'])) {
			$this->data['error_description'] = $this->error['description'];
		} else {
			$this->data['error_description'] = array();
		}
		
		$error_messages = array(
			'warning'			=>	'error_warning',
			'image'				=>	'error_image',
			'model'				=>	'error_model',
			'price'				=>	'error_price',
			'dimensions'		=>	'error_dimensions',
			'weight'			=>	'error_weight',
			'quantity'			=>	'error_quantity',
			'date_available'	=>	'error_date_available',
			'manufacturer'		=>	'error_manufacturer',
			'product_category'	=>	'error_product_category'
		);

        foreach ($error_messages as $error_message_key => $error_message_value) {
            if (isset($this->error[$error_message_key])) {
				$this->data[$error_message_value] = $this->error[$error_message_key];
            } else {
				$this->data[$error_message_value] = '';
            }
        }

		$url = '';

		if (isset($this->request->get['cpm_filter_name'])) {
			$url .= '&cpm_filter_name=' . urlencode(html_entity_decode($this->request->get['cpm_filter_name'], ENT_QUOTES, 'UTF-8'));
		}
		
		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}
		
		$url_strings = array(
			'filter_price',
			'filter_quantity',
			'filter_approved',
			'filter_status',
			'sort',
			'order',
			'page'
		);

        foreach ($url_strings as $url_string) {
            if (isset($this->request->get[$url_string])) {
				$url .= '&' . $url_string . '=' . $this->request->get[$url_string];
            }
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
			'href'      => $this->url->link('account/product', $url, 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);
      	
		if (!isset($this->request->get['cpm_product_id'])) {
			$this->data['action'] = $this->url->link('account/product/insert', $url, 'SSL');
			$this->data['product_id'] = 0;// digital file downloads
		} else {
			$this->data['action'] = $this->url->link('account/product/update', '&cpm_product_id=' . $this->request->get['cpm_product_id'] . $url, 'SSL');
			$this->data['product_id'] = $this->request->get['cpm_product_id'];// digital file downloads
		}
		
		$this->data['cancel'] = $this->url->link('account/product', $url, 'SSL');

		if (isset($this->request->get['cpm_product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
      		$product_info = $this->model_account_product->getProduct($this->request->get['cpm_product_id'], $customer_id);
    	}
		
		$data['customer_id'] = $customer_id;
		$product_total = $this->model_account_product->getTotalProducts($data);
				
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
		
		if (isset($this->request->post['product_description'])) {
			$this->data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_description'] = $this->model_account_product->getProductDescriptions($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_description'] = array();
		}
		
		$config_data_fields_empty = array(
			'sku',
			'upc',
			'ean',
			'jan',
			'isbn',
			'mpn',
			'location',
			'image',
			'price',
			'model',
			'keyword',
			'weight',
			'length',
			'width',
			'height',
			'points'
		);

        foreach ($config_data_fields_empty as $config_data_field) {
            if (isset($this->request->post[$config_data_field])) {
                $this->data[$config_data_field] = $this->request->post[$config_data_field];
            } elseif (!empty($product_info)) {
                $this->data[$config_data_field] = $product_info[$config_data_field];
            } else {
				$this->data[$config_data_field] = '';
			}
        }

		$this->load->model('setting/store');
		
		$this->data['stores'] = $this->model_setting_store->getStores();
		
		if (isset($this->request->post['product_store'])) {
			$this->data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_store'] = $this->model_account_product->getProductStores($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_store'] = array(0);
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['image']) && file_exists(DIR_IMAGE . $this->request->post['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
		} elseif (!empty($product_info) && $product_info['image'] && file_exists(DIR_IMAGE . $product_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($product_info['image'], $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
		} else {
			$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));
		}
	
		if (!empty($product_info)) {
			$this->data['customer_id'] = $product_info['cpm_customer_id'];
		} elseif ($this->customer->getId()) {
      		$this->data['customer_id'] = $this->customer->getId();
		} else {
      		$this->data['customer_id'] = 0;
    	}

		$this->load->model('catalog/manufacturer');
		
    	$this->data['manufacturers'] = $this->model_catalog_manufacturer->getManufacturers();
		
    	if (isset($this->request->post['manufacturer_id'])) {
      		$this->data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$this->data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
      		$this->data['manufacturer_id'] = 0;
    	}
		
    	if (isset($this->request->post['shipping'])) {
      		$this->data['shipping'] = $this->request->post['shipping'];
    	} elseif (!empty($product_info)) {
      		$this->data['shipping'] = $product_info['shipping'];
    	} else {
			$this->data['shipping'] = 1;
		}
				
		$this->data['tax_classes'] = $this->model_account_product->getTaxClasses();
    	
		if (isset($this->request->post['tax_class_id'])) {
      		$this->data['tax_class_id'] = $this->request->post['tax_class_id'];
    	} elseif (!empty($product_info)) {
			$this->data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
      		$this->data['tax_class_id'] = 0;
    	}		      	

		if (isset($this->request->post['date_available'])) {
       		$this->data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($product_info)) {
			$this->data['date_available'] = date('Y-m-d', strtotime($product_info['date_available']));
		} else {
			$this->data['date_available'] = date('Y-m-d', time() - 86400);
		}
											
    	if (isset($this->request->post['quantity'])) {
      		$this->data['quantity'] = $this->request->post['quantity'];
    	} elseif (!empty($product_info)) {
      		$this->data['quantity'] = $product_info['quantity'];
    	} else {
			$this->data['quantity'] = 1;
		}
		
		if (isset($this->request->post['minimum'])) {
      		$this->data['minimum'] = $this->request->post['minimum'];
    	} elseif (!empty($product_info)) {
      		$this->data['minimum'] = $product_info['minimum'];
    	} else {
			$this->data['minimum'] = 1;
		}
		
		if (isset($this->request->post['subtract'])) {
      		$this->data['subtract'] = $this->request->post['subtract'];
    	} elseif (!empty($product_info)) {
      		$this->data['subtract'] = $product_info['subtract'];
    	} else {
			$this->data['subtract'] = 1;
		}
		
		if (isset($this->request->post['sort_order'])) {
      		$this->data['sort_order'] = $this->request->post['sort_order'];
    	} elseif (!empty($product_info)) {
      		$this->data['sort_order'] = $product_info['sort_order'];
    	} else {
			$this->data['sort_order'] = 1;
		}
		
		$this->data['stock_statuses'] = $this->model_account_product->getStockStatuses();
    	
		if (isset($this->request->post['stock_status_id'])) {
      		$this->data['stock_status_id'] = $this->request->post['stock_status_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['stock_status_id'] = $product_info['stock_status_id'];
    	} else {
			$this->data['stock_status_id'] = $this->config->get('config_stock_status_id');
		}
				
    	if (!empty($product_info)) {
			$this->data['approved'] = $product_info['cpm_approved'];
		} else {
			$this->data['approved'] = 0;  // default cpm product not approved
		}
		
		if (isset($this->request->post['status'])) {
      		$this->data['status'] = $this->request->post['status'];
    	} elseif (!empty($product_info)) {
			$this->data['status'] = $product_info['status'];
		} else {
      		$this->data['status'] = 1;
    	}
		
		$this->data['weight_classes'] = $this->model_account_product->getWeightClasses();
    	
		if (isset($this->request->post['weight_class_id'])) {
      		$this->data['weight_class_id'] = $this->request->post['weight_class_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
      		$this->data['weight_class_id'] = $this->config->get('config_weight_class_id');
    	}
		
		$this->data['length_classes'] = $this->model_account_product->getLengthClasses();
    	
		if (isset($this->request->post['length_class_id'])) {
      		$this->data['length_class_id'] = $this->request->post['length_class_id'];
    	} elseif (!empty($product_info)) {
      		$this->data['length_class_id'] = $product_info['length_class_id'];
    	} else {
      		$this->data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		if (isset($this->request->post['product_attribute'])) {
			$this->data['product_attributes'] = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_attributes'] = $this->model_account_product->getProductAttributes($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_attributes'] = array();
		}
		
		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$product_options = $this->model_account_product->getProductOptions($this->request->get['cpm_product_id']);			
		} else {
			$product_options = array();
		}			
		
		$this->data['product_options'] = array();
			
		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				$product_option_value_data = array();
				
				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],						
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']	
					);						
				}
				
				$this->data['product_options'][] = array(
					'product_option_id'    => $product_option['product_option_id'],
					'product_option_value' => $product_option_value_data,
					'option_id'            => $product_option['option_id'],
					'name'                 => $product_option['name'],
					'type'                 => $product_option['type'],
					'required'             => $product_option['required']
				);				
			} else {
				$this->data['product_options'][] = array(
					'product_option_id' => $product_option['product_option_id'],
					'option_id'         => $product_option['option_id'],
					'name'              => $product_option['name'],
					'type'              => $product_option['type'],
					'option_value'      => $product_option['option_value'],
					'required'          => $product_option['required']
				);				
			}
		}
		
		$this->data['option_values'] = array();
		
		foreach ($product_options as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($this->data['option_values'][$product_option['option_id']])) {
					$this->data['option_values'][$product_option['option_id']] = $this->model_account_product->getOptionValues($product_option['option_id']);
				}
			}
		}
				
		$this->data['customer_groups'] = $this->model_account_product->getCustomerGroups();
		
		if (isset($this->request->post['product_discount'])) {
			$this->data['product_discounts'] = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_discounts'] = $this->model_account_product->getProductDiscounts($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_discounts'] = array();
		}

		if (isset($this->request->post['product_special'])) {
			$this->data['product_specials'] = $this->request->post['product_special'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_specials'] = $this->model_account_product->getProductSpecials($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_specials'] = array();
		}
		
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$product_images = $this->model_account_product->getProductImages($this->request->get['cpm_product_id']);
		} else {
			$product_images = array();
		}
		
		$this->data['product_images'] = array();
		
		foreach ($product_images as $product_image) {
			if ($product_image['image'] && file_exists(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
			} else {
				$image = 'no_image.jpg';
			}
			
			$this->data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($image, $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height')),
				'sort_order' => $product_image['sort_order']
			);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_related_width'), $this->config->get('config_image_related_height'));

		$this->load->model('account/product_download');
		
		$this->data['downloads'] = $this->model_account_product_download->getDownloads($data);
		
		if (isset($this->request->post['product_download'])) {
			$this->data['product_download'] = $this->request->post['product_download'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_download'] = $this->model_account_product->getProductDigitalDownloads($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_download'] = array();
		}
		
		$data['filter_status'] = 1;
		// $data['filter_member_id'] = $customer_id;
		
		$this->data['categories'] = $this->model_account_product->getAllCPMCategories($data); //getAllCategories //getCategoriesCPM(0); // getAllCPMCategories($data)
		
		if (isset($this->request->post['product_category'])) {
			$this->data['product_category'] = $this->request->post['product_category'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_category'] = $this->model_account_product->getProductCategories($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_category'] = array();
		}

		$this->data['filters'] = $this->model_account_product->getFilters();

		if (isset($this->request->post['product_filters'])) {
			$this->data['product_filters'] = $this->request->post['product_filters'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_filters'] = $this->model_account_product->getProductFilters($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_filters'] = array();
		}

		$this->data['profiles'] = $this->model_account_product->getProfiles();

		if (isset($this->request->post['product_profiles'])) {
			$this->data['product_profiles'] = $this->request->post['product_profiles'];
		} elseif (!empty($product_info)) {
			$this->data['product_profiles'] = $this->model_account_product->getProductProfiles($product_info['product_id']);
		} else {
			$this->data['product_profiles'] = array();
		}
		
		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['cpm_product_id'])) {		
			$products = $this->model_account_product->getProductRelated($this->request->get['cpm_product_id']);
		} else {
			$products = $this->model_account_product->getCPMProductRelated($this->customer->getId()); // $products = array();
		}
	
		$this->data['product_related'] = array();
		
		foreach ($products as $product_id) {
			$related_info = $this->model_account_product->getProduct($product_id, $customer_id);
			
			if ($related_info) {
				$this->data['product_related'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}
						
		if (isset($this->request->post['product_reward'])) {
			$this->data['product_reward'] = $this->request->post['product_reward'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_reward'] = $this->model_account_product->getProductRewards($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_reward'] = array();
		}
		
		if (isset($this->request->post['product_layout'])) {
			$this->data['product_layout'] = $this->request->post['product_layout'];
		} elseif (isset($this->request->get['cpm_product_id'])) {
			$this->data['product_layout'] = $this->model_account_product->getProductLayouts($this->request->get['cpm_product_id']);
		} else {
			$this->data['product_layout'] = array();
		}

		$this->load->model('design/layout');
		
		$this->data['layouts'] = $this->model_design_layout->getLayouts();
										
		$this->data['continue'] = $this->url->link('account/product', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/cpm.css')) {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/' . $this->config->get('config_template') . '/stylesheet/cpm.css');
		} else {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/default/stylesheet/cpm.css');
		}
				
		$this->document->addScript(basename(DIR_APPLICATION) . '/view/javascript/jquery/tabscpm.js');
	
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/product_form.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/product_form.tpl';
		} else {
			$this->template = 'default/template/account/product_form.tpl';
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
    	
    	if (isset($this->request->get['cpm_product_id'])) {
			$product_description_data = $this->model_account_product->getProductDescriptions($this->request->get['cpm_product_id']);
		} else {
			$product_description_data = array();
		}

    	foreach ($this->request->post['product_description'] as $language_id => $value) {
      		if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
        		$this->error['name'][$language_id] = $this->language->get('error_name');
      		}
      		/* uncomment to enforce unique Product Names
      		if (((isset($this->request->get['cpm_product_id']) && ($product_description_data[$language_id]['name'] != $value['name'])) || (!isset($this->request->get['cpm_product_id']))) && ($this->model_account_product->getTotalProductsByName($value['name'], $language_id))) {
        		$this->error['name'][$language_id] = $this->language->get('error_name_exists');
      		}
      		* */
      		if ((utf8_strlen($value['description']) < $this->config->get('cpm_data_field_description_min')) || (utf8_strlen($value['description']) > $this->config->get('cpm_data_field_description_max'))) {
        		$this->error['description'][$language_id] = sprintf($this->language->get('error_description'), $this->config->get('cpm_data_field_description_min'), $this->config->get('cpm_data_field_description_max'));
      		}
    	}
		
		if ($this->config->get('cpm_data_field_image') && empty($this->request->post['image'])) {
			$this->error['image'] = $this->language->get('error_image');
		}
		
		if ($this->config->get('cpm_data_field_model')) {
			if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
				$this->error['model'] = $this->language->get('error_model');
			}
		}

    	if ($this->request->post['price'] <= 0) {
      		$this->error['price'] = $this->language->get('error_price');
    	}

    	if ($this->config->get('cpm_data_field_quantity') && $this->request->post['quantity'] <= 0) {
      		$this->error['quantity'] = $this->language->get('error_quantity');
    	}

    	if ($this->config->get('cpm_data_field_date') && empty($this->request->post['date_available'])) {
      		$this->error['date_available'] = $this->language->get('error_date_available');
    	}
		
		if ($this->config->get('cpm_data_field_dimensions')) {
			if ($this->request->post['length'] <= 0 || $this->request->post['width'] <= 0 || $this->request->post['height'] <= 0) {
				$this->error['dimensions'] = $this->language->get('error_dimensions');
			}
		}

		if ($this->config->get('cpm_data_field_weight') && $this->request->post['weight'] <= 0) {
			$this->error['weight'] = $this->language->get('error_weight');
		}
		
		/* uncomment to also require Manufacturer, Location, and Category data fields when they are enabled in the module settings
		if ($this->config->get('cpm_data_field_manufacturer') && empty($this->request->post['manufacturer_id'])) {
			$this->error['manufacturer'] = $this->language->get('error_manufacturer');
		}

		if ($this->config->get('cpm_data_field_location') && empty($this->request->post['location'])) {
			$this->error['location'] = $this->language->get('error_location');
		}

    	if ($this->config->get('cpm_data_field_category') && empty($this->request->post['product_category'])) {
      		$this->error['product_category'] = $this->language->get('error_product_category');
    	}
		*/
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
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

		$customer_max_products = $this->customer->getCPMMaxProducts();
		if($customer_max_products  == '-1') return true;
		
		$data['customer_id'] = $customer_id;
		$product_total = $this->model_account_product->getTotalProducts($data);
		if ($product_total >= $customer_max_products) {
			$this->error['max_products'] = $this->language->get('error_max_products');
		}
		
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

	public function autocomplete() {
		$json = array();
		
		if (isset($this->request->get['cpm_filter_name']) || isset($this->request->get['filter_model']) || isset($this->request->get['filter_category_id'])) {
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
						
			if (isset($this->request->get['filter_category_id'])) {
				$filter_category_id = $this->request->get['filter_category_id'];
			} else {
				$filter_category_id = '';
			}
			
			if (isset($this->request->get['filter_sub_category'])) {
				$filter_sub_category = $this->request->get['filter_sub_category'];
			} else {
				$filter_sub_category = '';
			}
			
			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];	
			} else {
				$limit = 20;	
			}			
						
			$data = array(
				'customer_id'			=> $customer_id,
				'cpm_filter_name'         => $cpm_filter_name,
				'filter_model'        => $filter_model,
				'filter_category_id'  => $filter_category_id,
				'filter_sub_category' => $filter_sub_category,
				'start'               => 0,
				'limit'               => $limit
			);
			
			$results = $this->model_account_product->getProducts($data);
			
			foreach ($results as $result) {
				$option_data = array();
				
				$product_options = $this->model_account_product->getProductOptions($result['product_id']);	
				
				foreach ($product_options as $product_option) {
					if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
						$option_value_data = array();
					
						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_data[] = array(
								'product_option_value_id' => $product_option_value['product_option_value_id'],
								'option_value_id'         => $product_option_value['option_value_id'],
								'name'                    => $product_option_value['name'],
								'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
								'price_prefix'            => $product_option_value['price_prefix']
							);	
						}
					
						$option_data[] = array(
							'product_option_id' => $product_option['product_option_id'],
							'option_id'         => $product_option['option_id'],
							'name'              => $product_option['name'],
							'type'              => $product_option['type'],
							'option_value'      => $option_value_data,
							'required'          => $product_option['required']
						);	
					} else {
						$option_data[] = array(
							'product_option_id' => $product_option['product_option_id'],
							'option_id'         => $product_option['option_id'],
							'name'              => $product_option['name'],
							'type'              => $product_option['type'],
							'option_value'      => $product_option['option_value'],
							'required'          => $product_option['required']
						);				
					}
				}
					
				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),	
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);	
			}
		}

		$this->response->setOutput(json_encode($json));
	}
	
	public function autocomplete_attribute() {
		$json = array();
		
		if (isset($this->request->get['cpm_filter_name'])) {
			$this->load->model('account/product');
			
			$data = array(
				'cpm_filter_name' => $this->request->get['cpm_filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$json = array();
			
			$results = $this->model_account_product->getAttributes($data);
			
			foreach ($results as $result) {
				$json[] = array(
					'attribute_id'    => $result['attribute_id'], 
					'name'            => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'attribute_group' => $result['attribute_group']
				);		
			}		
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}
	
	public function autocomplete_option() {
		$json = array();
		
		if (isset($this->request->get['cpm_filter_name'])) {
			$this->load->language('account/product');
			
			$this->load->model('account/product');
			
			$this->load->model('tool/image');
			
			$data = array(
				'cpm_filter_name' => $this->request->get['cpm_filter_name'],
				'start'       => 0,
				'limit'       => 20
			);
			
			$options = $this->model_account_product->getOptions($data);
			
			foreach ($options as $option) {
				$option_value_data = array();
				
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$option_values = $this->model_account_product->getOptionValues($option['option_id']);
					
					foreach ($option_values as $option_value) {
						if ($option_value['image'] && file_exists(DIR_IMAGE . $option_value['image'])) {
							$image = $this->model_tool_image->resize($option_value['image'], 50, 50);
						} else {
							$image = '';
						}
													
						$option_value_data[] = array(
							'option_value_id' => $option_value['option_value_id'],
							'name'            => html_entity_decode($option_value['name'], ENT_QUOTES, 'UTF-8'),
							'image'           => $image					
						);
					}
					
					$sort_order = array();
				  
					foreach ($option_value_data as $key => $value) {
						$sort_order[$key] = $value['name'];
					}
			
					array_multisort($sort_order, SORT_ASC, $option_value_data);					
				}
				
				$type = '';
				
				if ($option['type'] == 'select' || $option['type'] == 'radio' || $option['type'] == 'checkbox' || $option['type'] == 'image') {
					$type = $this->language->get('text_choose');
				}
				
				if ($option['type'] == 'text' || $option['type'] == 'textarea') {
					$type = $this->language->get('text_input');
				}
				
				if ($option['type'] == 'file') {
					$type = $this->language->get('text_file');
				}
				
				if ($option['type'] == 'date' || $option['type'] == 'datetime' || $option['type'] == 'time') {
					$type = $this->language->get('text_date');
				}
												
				$json[] = array(
					'option_id'    => $option['option_id'],
					'name'         => strip_tags(html_entity_decode($option['name'], ENT_QUOTES, 'UTF-8')),
					'category'     => $type,
					'type'         => $option['type'],
					'option_value' => $option_value_data
				);
			}
		}

		$sort_order = array();
	  
		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);
				
		$this->response->setOutput(json_encode($json));
	}
	
}
?>