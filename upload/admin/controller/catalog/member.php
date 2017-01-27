<?php    
class ControllerCatalogMember extends Controller { 
	private $error = array();

	public function index() {
		$this->language->load('catalog/member');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/member');

		$this->getList();
	}

	public function insert() {
		$this->language->load('catalog/member');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/member');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_member->addMember($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_customer_name'])) {
				$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_cpm_account_name'])) {
				$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}		  
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			$this->redirect($this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function update() {
		$this->language->load('catalog/member');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/member');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_member->editMember($this->request->get['member_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_customer_name'])) {
				$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_cpm_account_name'])) {
				$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}		  
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			$this->redirect($this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getForm();
	}

	public function delete() {
		$this->language->load('catalog/member');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/member');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $member_id) {
				$this->model_catalog_member->deleteMember($member_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_customer_name'])) {
				$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_cpm_account_name'])) {
				$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			} 
			
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			$this->redirect($this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url, 'SSL'));
		}

		$this->getList();
	}
	
	protected function getList() {		
		if (isset($this->request->get['filter_customer_name'])) {
			$filter_customer_name = $this->request->get['filter_customer_name'];
		} else {
			$filter_customer_name = null;
		}
		
		if (isset($this->request->get['filter_cpm_account_name'])) {
			$filter_cpm_account_name = $this->request->get['filter_cpm_account_name'];
		} else {
			$filter_cpm_account_name = null;
		}

		if (isset($this->request->get['filter_email'])) {
			$filter_email = $this->request->get['filter_email'];
		} else {
			$filter_email = null;
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$filter_customer_group_id = $this->request->get['filter_customer_group_id'];
		} else {
			$filter_customer_group_id = null;
		}
			
		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_approved'])) {
			$filter_approved = $this->request->get['filter_approved'];
		} else {
			$filter_approved = null;
		}

		if (isset($this->request->get['filter_date_added'])) {
			$filter_date_added = $this->request->get['filter_date_added'];
		} else {
			$filter_date_added = null;
		}		

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'cpm_account_name'; 
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

		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_cpm_account_name'])) {
			$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}	  
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_default'] = $this->language->get('text_default');
		$this->data['text_confirm'] = $this->language->get('text_confirm');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['column_image'] = $this->language->get('column_image');
		$this->data['column_customer_name'] = $this->language->get('column_customer_name');
		$this->data['column_cpm_account_name'] = $this->language->get('column_cpm_account_name');
		$this->data['column_email'] = $this->language->get('column_email');
		$this->data['column_customer_group'] = $this->language->get('column_customer_group');
		$this->data['column_product_count'] = $this->language->get('column_product_count');
		$this->data['column_commission'] = $this->language->get('column_commission');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_approved'] = $this->language->get('column_approved');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_login'] = $this->language->get('column_login');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['button_cpm_enable'] = $this->language->get('button_cpm_enable');
		$this->data['button_cpm_disable'] = $this->language->get('button_cpm_disable');
		$this->data['button_insert'] = $this->language->get('button_insert');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_filter'] = $this->language->get('button_filter');

		$this->data['token'] = $this->session->data['token'];

		$this->data['insert'] = $this->url->link('catalog/member/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['delete'] = $this->url->link('catalog/member/delete', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['enable'] = $this->url->link('catalog/member/enable', 'token=' . $this->session->data['token'] . $url, 'SSL');
		$this->data['disable'] = $this->url->link('catalog/member/disable', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->session->data['warning'])) {
			$this->data['error_warning'] = $this->session->data['warning'];
			unset($this->session->data['warning']);
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		$this->data['members'] = array();

		$data = array(
			'filter_customer_name'     => $filter_customer_name, 
			'filter_cpm_account_name'  => $filter_cpm_account_name, 
			'filter_email'             => $filter_email, 
			'filter_customer_group_id'   => $filter_customer_group_id,
			'filter_status'            => $filter_status, 
			'filter_approved'          => $filter_approved, 
			'filter_date_added'        => $filter_date_added,
			'sort'                     => $sort,
			'order'                    => $order,
			'start'                    => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                    => $this->config->get('config_admin_limit')
		);

		$member_total = $this->model_catalog_member->getTotalMembers($data);

		$results = $this->model_catalog_member->getMembers($data);

		$this->load->model('tool/image');
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 40, 40);

		foreach ($results as $result) {
			$product_count = $this->model_catalog_member->getTotalProductsByCPMCustomerId($result['member_id']);
			
			$action = array();

			$action[] = array(
				'text' => $this->language->get('text_edit'),
				'href' => $this->url->link('catalog/member/update', 'token=' . $this->session->data['token'] . '&member_id=' . $result['member_id'] . $url, 'SSL')
			);
	
			if (!empty($result['cpm_account_image']) && file_exists(DIR_IMAGE . $result['cpm_account_image'])) {
				$image = $this->model_tool_image->resize($result['cpm_account_image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
			}

			$this->data['members'][] = array(
				'image'			 => $image,
				'member_id'		 => $result['member_id'],
				'customer_name'  => $result['customer_name'],
				'customer_href'	 => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['member_id'] . '&filter_cpm_status=1' . $url, 'SSL'),
				'cpm_account_name'  => $result['cpm_account_name'],
				'email'          => $result['email'],
				'customer_group'   => $result['customer_group'],
				'status'         => ($result['cpm_enabled'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled')),
				'approved'       => ($result['approved'] ? $this->language->get('text_yes') : $this->language->get('text_no')),
				'product_count'  => $product_count,
				'product_href'	 => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&filter_cpm_customer_name=' . urlencode(utf8_strtolower($result['customer_name'])), 'SSL'),
				'commission'  	 => number_format($result['cpm_commission_rate'],2),
				'date_added'     => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'selected'       => isset($this->request->post['selected']) && in_array($result['member_id'], $this->request->post['selected']),
				'action'         => $action
			);
		}

		$url = '';

		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_cpm_account_name'])) {
			$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$this->data['sort_customer_name'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=customer_name' . $url, 'SSL');
		$this->data['sort_cpm_account_name'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=cpm_account_name' . $url, 'SSL');
		$this->data['sort_email'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=c.email' . $url, 'SSL');
		$this->data['sort_customer_group'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=customer_group' . $url, 'SSL');
		// $this->data['sort_product_count'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=product_count' . $url, 'SSL');			
		$this->data['sort_commission'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=cpm_commission_rate' . $url, 'SSL');			
		$this->data['sort_status'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=c.cpm_enabled' . $url, 'SSL');			
		$this->data['sort_approved'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=c.approved' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . '&sort=cpm.date_added' . $url, 'SSL');
			
		$url = '';

		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_cpm_account_name'])) {
			$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}		  
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $member_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();

		$this->data['filter_customer_name'] = $filter_customer_name;
		$this->data['filter_cpm_account_name'] = $filter_cpm_account_name;
		$this->data['filter_email'] = $filter_email;
		$this->data['filter_customer_group_id'] = $filter_customer_group_id;
		$this->data['filter_status'] = $filter_status;
		$this->data['filter_approved'] = $filter_approved;
		$this->data['filter_date_added'] = $filter_date_added;

		$this->load->model('sale/customer_group');

		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		$this->load->model('setting/store');

		$this->data['stores'] = $this->model_setting_store->getStores();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;

		$this->template = 'catalog/member_list.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function getForm() {
		$this->data['heading_title'] = $this->language->get('heading_title');
		$this->data['heading_customer'] = $this->language->get('heading_customer');
		$this->data['heading_membership'] = $this->language->get('heading_membership');
		$this->data['heading_settings'] = $this->language->get('heading_settings');
		$this->data['heading_custom_fields'] = $this->language->get('heading_custom_fields');		
		$this->data['entry_customer'] = $this->language->get('entry_customer');
		$this->data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$this->data['entry_status'] = $this->language->get('entry_status');
		$this->data['entry_cpm_status'] = $this->language->get('entry_cpm_status');		
		$this->data['entry_cpm_account_name'] = $this->language->get('entry_cpm_account_name');
		$this->data['entry_cpm_account_description'] = $this->language->get('entry_cpm_account_description');
		$this->data['entry_cpm_account_image'] = $this->language->get('entry_cpm_account_image');
		$this->data['entry_cpm_custom_field_01'] = $this->config->get('cpm_custom_field_01');
		$this->data['entry_cpm_custom_field_02'] = $this->config->get('cpm_custom_field_02');
		$this->data['entry_cpm_custom_field_03'] = $this->config->get('cpm_custom_field_03');
		$this->data['entry_cpm_custom_field_04'] = $this->config->get('cpm_custom_field_04');
		$this->data['entry_cpm_custom_field_05'] = $this->config->get('cpm_custom_field_05');
		$this->data['entry_cpm_custom_field_06'] = $this->config->get('cpm_custom_field_06');
		$this->data['entry_cpm_directory_images'] = $this->language->get('entry_cpm_directory_images');
		$this->data['entry_cpm_directory_downloads'] = $this->language->get('entry_cpm_directory_downloads');
		$this->data['entry_cpm_paypal_account'] = $this->language->get('entry_cpm_paypal_account');
		$this->data['entry_cpm_commission_rate'] = $this->language->get('entry_cpm_commission_rate');
		$this->data['entry_cpm_max_products'] = $this->language->get('entry_cpm_max_products');
		$this->data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$this->data['entry_keyword'] = $this->language->get('entry_keyword');
		$this->data['text_cpm_field_name'] = $this->language->get('text_cpm_field_name');
		$this->data['text_cpm_field_value'] = $this->language->get('text_cpm_field_value');
		$this->data['text_image_manager'] = $this->language->get('text_image_manager');
		$this->data['text_browse'] = $this->language->get('text_browse');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_customer_name'] = $this->language->get('text_customer_name');
		$this->data['text_customer_group'] = $this->language->get('text_customer_group');
		$this->data['text_customer_status'] = $this->language->get('text_customer_status');
		$this->data['text_customer_approved'] = $this->language->get('text_customer_approved');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');	
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['button_cpm_enable'] = $this->language->get('button_cpm_enable');
		$this->data['button_cpm_disable'] = $this->language->get('button_cpm_disable');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
		$this->data['text_wait'] = $this->language->get('text_wait');
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_no_customers'] = $this->language->get('text_no_customers');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_action'] = $this->language->get('column_action');
		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['tab_general'] = $this->language->get('tab_general');
		$this->data['tab_settings'] = $this->language->get('tab_settings');
		$this->data['tab_custom_fields'] = $this->language->get('tab_custom_fields');
		$this->data['help_cpm_status'] = $this->language->get('help_cpm_status');
		$this->data['help_cpm_no_customer'] = $this->language->get('help_cpm_no_customer');
		$this->data['help_cpm_directory_images'] = $this->language->get('help_cpm_directory_images');
		$this->data['help_cpm_directory_downloads'] = $this->language->get('help_cpm_directory_downloads');
		$this->data['help_cpm_paypal_account'] = $this->language->get('help_cpm_paypal_account');
		$this->data['help_cpm_max_products'] = $this->language->get('help_cpm_max_products');
		$this->data['help_cpm_commission_rate'] = $this->language->get('help_cpm_commission_rate');
		$this->data['help_cpm_custom_fields'] = $this->language->get('help_cpm_custom_fields');
		$this->data['help_keyword'] = $this->language->get('help_keyword');
		$this->data['help_sort_order'] = $this->language->get('help_sort_order');
		$this->data['help_customer_account'] = sprintf($this->language->get('help_customer_account'), $this->url->link('sale/customer', 'token=' . $this->session->data['token'] . '&filter_cpm_status=1', 'SSL'));
		$this->data['error_cpm_no_custom_fields'] = sprintf($this->language->get('error_cpm_no_custom_fields'), $this->url->link('module/cpm', 'token=' . $this->session->data['token'], 'SSL'));
		
		$this->data['token'] = $this->session->data['token'];

		if (isset($this->request->get['member_id'])) {
			$this->data['member_id'] = $this->request->get['member_id'];
		} else {
			$this->data['member_id'] = 0;
		}

		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}

		if (isset($this->error['customer'])) {
			$this->data['error_customer'] = $this->error['customer'];
		} else {
			$this->data['error_customer'] = '';
		}

		if (isset($this->error['cpm_account_name'])) {
			$this->data['error_cpm_account_name'] = $this->error['cpm_account_name'];
		} else {
			$this->data['error_cpm_account_name'] = '';
		}

		if (isset($this->error['cpm_account_description'])) {
			$this->data['error_cpm_account_description'] = $this->error['cpm_account_description'];
		} else {
			$this->data['error_cpm_account_description'] = '';
		}

		if (isset($this->error['cpm_paypal_account'])) {
			$this->data['error_cpm_paypal_account'] = $this->error['cpm_paypal_account'];
		} else {
			$this->data['error_cpm_paypal_account'] = '';
		}

		if (isset($this->error['cpm_max_products'])) {
			$this->data['error_cpm_max_products'] = $this->error['cpm_max_products'];
		} else {
			$this->data['error_cpm_max_products'] = '';
		}

		if (isset($this->error['cpm_commission_rate'])) {
			$this->data['error_cpm_commission_rate'] = $this->error['cpm_commission_rate'];
		} else {
			$this->data['error_cpm_commission_rate'] = '';
		}

		if (isset($this->error['cpm_directory_images'])) {
			$this->data['error_cpm_directory_images'] = $this->error['cpm_directory_images'];
		} else {
			$this->data['error_cpm_directory_images'] = '';
		}

		if (isset($this->error['cpm_directory_downloads'])) {
			$this->data['error_cpm_directory_downloads'] = $this->error['cpm_directory_downloads'];
		} else {
			$this->data['error_cpm_directory_downloads'] = '';
		}

		if (isset($this->error['cpm_custom_fields'])) {
			$this->data['error_cpm_custom_fields'] = $this->error['cpm_custom_fields'];
		} else {
			$this->data['error_cpm_custom_fields'] = '';
		}
		
		$url = '';

		if (isset($this->request->get['filter_customer_name'])) {
			$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_cpm_account_name'])) {
			$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_email'])) {
			$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_customer_group_id'])) {
			$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
		}	  
			
		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_approved'])) {
			$url .= '&filter_approved=' . $this->request->get['filter_approved'];
		}	

		if (isset($this->request->get['filter_date_added'])) {
			$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
			'separator' => false
		);

		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url, 'SSL'),
			'separator' => ' :: '
		);

		if (!isset($this->request->get['member_id'])) {
			$this->data['action'] = $this->url->link('catalog/member/insert', 'token=' . $this->session->data['token'] . $url, 'SSL');
		} else {
			$this->data['action'] = $this->url->link('catalog/member/update', 'token=' . $this->session->data['token'] . '&member_id=' . $this->request->get['member_id'] . $url, 'SSL');
		}

		$this->data['cancel'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url, 'SSL');

		if (isset($this->request->get['member_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$member_info = $this->model_catalog_member->getMember($this->request->get['member_id']);
			$customer_info = $this->model_catalog_member->getCPMCustomer($this->request->get['member_id']);
			$this->data['help_customer_name'] = sprintf($this->language->get('help_customer_name'), $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->get['member_id'], 'SSL'), $customer_info['customer_name']);
			$this->data['help_customer_group'] = sprintf($this->language->get('help_customer_group'), $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'], 'SSL'));
			$this->data['help_customer_status'] = $this->language->get('help_customer_status');
			$this->data['help_customer_approved'] = $this->language->get('help_customer_approved');
		} elseif (!empty($this->request->post['customer_id'])) {
			$customer_info = $this->model_catalog_member->getCPMCustomer($this->request->post['customer_id']);
			$this->data['help_customer_name'] = sprintf($this->language->get('help_customer_name'), $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $this->request->post['customer_id'], 'SSL'), $customer_info['customer_name']);
			$this->data['help_customer_group'] = sprintf($this->language->get('help_customer_group'), $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'], 'SSL'));
			$this->data['help_customer_status'] = $this->language->get('help_customer_status');
			$this->data['help_customer_approved'] = $this->language->get('help_customer_approved');
		}

		if (!empty($customer_info)) {
			$this->data['customer_id'] = $customer_info['customer_id'];
			$this->data['customer_name'] = $customer_info['customer_name'];
			$this->data['customer_group'] = $customer_info['customer_group'];
			$this->data['customer_status'] = $customer_info['customer_status'];
			$this->data['customer_cpm_enabled'] = $customer_info['customer_cpm_enabled'];
			$this->data['customer_approved'] = $customer_info['customer_approved'];
		} else {
			$this->data['customer_id'] = 0;
			$this->data['customer_name'] = '';
			$this->data['customer_group'] = '';
			$this->data['customer_status'] = '';
			$this->data['customer_cpm_enabled'] = '';
			$this->data['customer_approved'] = '';
		}

		//$data = array('filter_cpm_enabled' => 0);
		//$this->data['customers'] = $this->model_catalog_member->getCPMCustomers($data);
		$this->data['customers'] = false;
		
		$this->data['total_customers_not_cpm'] = $this->model_catalog_member->getTotalCustomersNotCPM();
		/*
		if (!empty($member_info) && isset($member_info['member_id'])) {
			$this->data['member_id'] = $member_info['member_id'];
		} else {
			$this->data['member_id'] = 0;
		}*/

		$cpm_data_fields = array(
			'cpm_account_name',
			'cpm_account_description',
			'cpm_account_image',
			'cpm_custom_field_01',
			'cpm_custom_field_02',
			'cpm_custom_field_03',
			'cpm_custom_field_04',
			'cpm_custom_field_05',
			'cpm_custom_field_06',
			'cpm_paypal_account',
			'sort_order',
			'keyword',
			'viewed'
		);

		foreach ($cpm_data_fields as $cpm_data_field) {
			if (isset($this->request->post[$cpm_data_field])) {
				$this->data[$cpm_data_field] = $this->request->post[$cpm_data_field];
			} elseif (!empty($member_info) && isset($member_info[$cpm_data_field])) {
				$this->data[$cpm_data_field] = $member_info[$cpm_data_field];
			} else {
				$this->data[$cpm_data_field] = '';
			}
		}

		if (isset($this->request->post['cpm_directory_images'])) {
			$this->data['cpm_directory_images'] = $this->request->post['cpm_directory_images'];
		} elseif (!empty($member_info) && isset($member_info['cpm_directory_images'])) { 
			$this->data['cpm_directory_images'] = $member_info['cpm_directory_images'];
		} elseif($this->config->get('cpm_register_auto_fill')) {
			$this->data['cpm_directory_images'] = $this->config->get('cpm_image_upload_directory') . "/" . $this->db->escape($data['keyword']); // auto-fill
		} else {
			$this->data['cpm_directory_images'] = $this->config->get('cpm_image_upload_directory');  // default module setting for cpm image directory
		} 

		if (isset($this->request->post['cpm_directory_downloads'])) {
			$this->data['cpm_directory_downloads'] = $this->request->post['cpm_directory_downloads'];
		} elseif (!empty($member_info) && isset($member_info['cpm_directory_downloads'])) { 
			$this->data['cpm_directory_downloads'] = $member_info['cpm_directory_downloads'];
		} elseif($this->config->get('cpm_register_auto_fill')) {
			$this->data['cpm_directory_downloads'] = $this->config->get('cpm_download_directory') . "/" . $this->db->escape($data['keyword']); // auto-fill
		} else {
			$this->data['cpm_directory_downloads'] = $this->config->get('cpm_download_directory'); // default module setting for cpm downloads directory
		}

		if (isset($this->request->post['cpm_max_products'])) {
			$this->data['cpm_max_products'] = $this->request->post['cpm_max_products'];
		} elseif (!empty($member_info) && isset($member_info['cpm_max_products'])) { 
			$this->data['cpm_max_products'] = $member_info['cpm_max_products'];
		} else {
      		$this->data['cpm_max_products'] = $this->config->get('cpm_products_max');  // default module setting for  cpm max number of products
    	}

		if (isset($this->request->post['cpm_commission_rate'])) {
			$this->data['cpm_commission_rate'] = $this->request->post['cpm_commission_rate'];
		} elseif (!empty($member_info) && isset($member_info['cpm_commission_rate'])) { 
			$this->data['cpm_commission_rate'] = $member_info['cpm_commission_rate'];
		} else {
	    	$this->data['cpm_commission_rate'] = $this->config->get('cpm_commission_rate');  // default module setting for cpm commission rate
	    }

		$this->load->model('tool/image');
	
		if (isset($this->request->post['cpm_account_image']) && file_exists(DIR_IMAGE . $this->request->post['cpm_account_image'])) {
			$this->data['cpm_account_image_thumb'] = $this->model_tool_image->resize($this->request->post['cpm_account_image'], 100, 100);
		} elseif (!empty($member_info) && !empty($member_info['cpm_account_image']) && file_exists(DIR_IMAGE . $member_info['cpm_account_image'])) {
			$this->data['cpm_account_image_thumb'] = $this->model_tool_image->resize($member_info['cpm_account_image'], 100, 100);
		} else {
			$this->data['cpm_account_image_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);

		$this->template = 'catalog/member_form.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/member')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (empty($this->request->post['customer_id'])) {
			$this->error['customer'] = $this->language->get('error_customer');
		} else {
			$cpm_customer_exists = $this->model_catalog_member->checkCPMCustomer($this->request->post['customer_id']);

			if (!isset($this->request->get['member_id'])) {
				if ($cpm_customer_exists) {
					$member_info = $this->model_catalog_member->getMember($this->request->post['customer_id']);
					$this->error['warning'] = sprintf($this->language->get('error_exists'), $member_info['customer_name'], $member_info['cpm_account_name']);
					$this->error['customer'] = $this->language->get('error_customer');
				}
			} else {
				if ($cpm_customer_exists && ($this->request->get['member_id'] != $cpm_customer_exists)) {
					$member_info = $this->model_catalog_member->getMember($this->request->post['customer_id']);
					$this->error['warning'] = sprintf($this->language->get('error_exists'), $member_info['customer_name'], $member_info['cpm_account_name']);
					$this->error['customer'] = $this->language->get('error_customer');
				}
			}
		}

		if (utf8_strlen($this->request->post['cpm_account_description']) > 1500) {
			$this->error['cpm_account_description'] = $this->language->get('error_cpm_account_description');
	    	}

		if ((utf8_strlen($this->request->post['cpm_account_name']) < 1) || (utf8_strlen($this->request->post['cpm_account_name']) > 128)) {
	      		$this->error['cpm_account_name'] = $this->language->get('error_cpm_account_name');
	    	}

		if ((!empty($this->request->post['cpm_paypal_account'])) && (utf8_strlen($this->request->post['cpm_paypal_account']) > 96) || (!empty($this->request->post['cpm_paypal_account'])) && (!preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['cpm_paypal_account']))) {
	      		$this->error['cpm_paypal_account'] = $this->language->get('error_cpm_paypal_account');
	    	}

		if (!empty($this->request->post['cpm_directory_images'])) {
			$directory = DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['cpm_directory_images']);
			if (!is_dir($directory)) {
				if(!mkdir($directory, 0755, true)) {
					$this->error['cpm_directory_images'] = $this->language->get('error_cpm_directory_images');
					$this->log->write("ERROR: Directory '" . $directory . "' could NOT be created for new Member '" . $this->request->post['cpm_account_name'] . "'");
				}
			}
		}

		if (!empty($this->request->post['cpm_directory_downloads'])) {
			$directory = DIR_DOWNLOAD . str_replace('../', '', $this->request->post['cpm_directory_downloads']);
			if (!is_dir($directory)) {
				if(!mkdir($directory, 0755, true)) {
					$this->error['cpm_directory_downloads'] = $this->language->get('error_cpm_directory_downloads');
					$this->log->write("ERROR: Directory '" . $directory . "' could NOT be created for new Member '" . $this->request->post['cpm_account_name'] . "'");
				}
			}
		}

		if (!empty($this->request->post['cpm_max_products']) && ($this->request->post['cpm_max_products'] < -1)){
			$this->error['cpm_max_products'] = $this->language->get('error_cpm_max_products');
		}

		if (!empty($this->request->post['cpm_commission_rate']) && ($this->request->post['cpm_commission_rate'] < 0)){
			$this->error['cpm_commission_rate'] = $this->language->get('error_cpm_commission_rate');
		}

		$cpm_custom_fields = array('cpm_custom_field_01', 'cpm_custom_field_02', 'cpm_custom_field_03', 'cpm_custom_field_04', 'cpm_custom_field_05', 'cpm_custom_field_06');
		
		foreach ($cpm_custom_fields as $cpm_custom_field) {
			if (utf8_strlen($this->request->post[$cpm_custom_field]) > 128) {
		      		$this->error['cpm_custom_fields'] = $this->language->get('error_cpm_custom_fields');
		    	}
		}
	
		if ($this->request->post['cpm_enabled'] && !$this->request->post['customer_id']) {
			$this->error['warning'] = $this->language->get('help_cpm_no_customer');
		}
			
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/member')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->error) {
			return true;
		} else {
			return false;
		}  
	}

	public function enable() {
		$this->load->language('catalog/member');
    	
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/member');

		if (!$this->user->hasPermission('modify', 'catalog/member')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} elseif (isset($this->request->post['selected'])) {
			$enabled_count = 0;
			$error_warning = '';
			
			foreach ($this->request->post['selected'] as $member_id) {
				$member_info = $this->model_catalog_member->getMember($member_id);
				$cpm_customer_exists = $this->model_catalog_member->checkCPMCustomer($member_id);
		
				if ($member_info && !$member_info['cpm_enabled']) {
					if (!$cpm_customer_exists) {
						$error_warning .= sprintf($this->language->get('error_cpm_member'), $member_info['customer_name']). '<br />';
					} else {
						$this->model_catalog_member->enableCPMCustomer($member_id);
						$enabled_count++;
					}
				}
			}
			
			if ($error_warning) {
				$this->session->data['warning'] = $error_warning;
			}
			
			if ($enabled_count) {
				$this->session->data['success'] = sprintf($this->language->get('text_cpm_enabled'), $enabled_count);
			}
			
			$url = '';

			if (isset($this->request->get['filter_customer_name'])) {
				$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_cpm_account_name'])) {
				$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}	  
				
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}	

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			$this->redirect($this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url, 'SSL'));			
		}

		$this->getList();
	}

	public function disable() {
		$this->load->language('catalog/member');
    	
		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/member');

		if (!$this->user->hasPermission('modify', 'catalog/member')) {
			$this->error['warning'] = $this->language->get('error_permission');
		} elseif (isset($this->request->post['selected'])) {
			$disabled_count = 0;
	
			foreach ($this->request->post['selected'] as $member_id) {
				$member_info = $this->model_catalog_member->getMember($member_id);
		
				if ($member_info && $member_info['cpm_enabled']) {
					$this->model_catalog_member->disableCPMCustomer($member_id);
					$disabled_count++;
				}
			} 
	
			$this->session->data['success'] = sprintf($this->language->get('text_cpm_disabled'), $disabled_count);
			
			$url = '';

			if (isset($this->request->get['filter_customer_name'])) {
				$url .= '&filter_customer_name=' . urlencode(html_entity_decode($this->request->get['filter_customer_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_cpm_account_name'])) {
				$url .= '&filter_cpm_account_name=' . urlencode(html_entity_decode($this->request->get['filter_cpm_account_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_email'])) {
				$url .= '&filter_email=' . urlencode(html_entity_decode($this->request->get['filter_email'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_customer_group_id'])) {
				$url .= '&filter_customer_group_id=' . $this->request->get['filter_customer_group_id'];
			}	  
				
			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['filter_approved'])) {
				$url .= '&filter_approved=' . $this->request->get['filter_approved'];
			}	

			if (isset($this->request->get['filter_date_added'])) {
				$url .= '&filter_date_added=' . $this->request->get['filter_date_added'];
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

			$this->redirect($this->url->link('catalog/member', 'token=' . $this->session->data['token'] . $url, 'SSL'));			
		}

		$this->getList();
	}
			
	public function autocomplete() {
		$json = array();
		$sort_order = array();
		
		$this->load->model('catalog/member');
		
		if (isset($this->request->get['filter_cpm_enabled'])) {
		
			if (isset($this->request->get['member_id'])) {
				$member_info = $this->model_catalog_member->getCPMCustomer($this->request->get['member_id']);
				
				if (!empty($member_info)) {
					$json[] = array(
						'customer_id'       => $member_info['customer_id'],
						'customer_name'     => strip_tags(html_entity_decode($member_info['customer_name'], ENT_QUOTES, 'UTF-8')),
						'customer_group'	=> $member_info['customer_group'],
						'customer_status'	=> $member_info['customer_status'],
						'customer_cpm'		=> $member_info['customer_cpm_enabled'],
						'customer_approved'	=> $member_info['customer_approved']
					);
				}
					
				foreach ($json as $key => $value) {
					$sort_order[$key] = $value['customer_name'];
				}
			}
			
			if (isset($this->request->get['filter_customer_name'])) {
				$data = array(
					'filter_customer_name'  =>  $this->request->get['filter_customer_name'],
					'filter_cpm_enabled'  =>  $this->request->get['filter_cpm_enabled'],
					'start'       => 0,
					'limit'       => 20
				);

				$results = $this->model_catalog_member->getCPMCustomers($data);
				
				if (!empty($results)) {
					foreach ($results as $result) {
						if ($this->model_catalog_member->checkCPMCustomer($result['customer_id'])) {
							continue;
						}
						
						$json[] = array(
							'customer_id'       => $result['customer_id'],
							'customer_name'     => strip_tags(html_entity_decode($result['customer_name'], ENT_QUOTES, 'UTF-8')),
							'customer_group'	=> $result['customer_group'],
							'customer_status'	=> $result['customer_status'],
							'customer_cpm'		=> $result['customer_cpm_enabled'],
							'customer_approved'	=> $result['customer_approved']
						);					
					}
				}
				
				foreach ($json as $key => $value) {
					$sort_order[$key] = $value['customer_name'];
				}			
			} elseif (isset($this->request->get['filter_cpm_account_name'])) {
				$data = array(
					'filter_cpm_account_name' => $this->request->get['filter_cpm_account_name'],
					'filter_cpm_enabled'  =>  $this->request->get['filter_cpm_enabled'],
					'start'       => 0,
					'limit'       => 20
				);

				$results = $this->model_catalog_member->getMembers($data);

				foreach ($results as $result) {
					$json[] = array(
						'customer_id'       => $result['customer_id'],
						'cpm_account_name'  => strip_tags(html_entity_decode($result['cpm_account_name'], ENT_QUOTES, 'UTF-8'))
					);					
				}

				foreach ($json as $key => $value) {
					$sort_order[$key] = $value['cpm_account_name'];
				}
			}
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->setOutput(json_encode($json));
	}	

	public function login() {
		$json = array();

		if (isset($this->request->get['member_id'])) {
			$member_id = $this->request->get['member_id'];
		} else {
			$member_id = 0;
		}

		$this->load->model('sale/customer');

		$customer_info = $this->model_sale_customer->getCustomer($member_id);

		if ($customer_info) {
			$token = md5(mt_rand());

			$this->model_sale_customer->editToken($member_id, $token);

			if (isset($this->request->get['store_id'])) {
				$store_id = $this->request->get['store_id'];
			} else {
				$store_id = 0;
			}

			$this->load->model('setting/store');

			$store_info = $this->model_setting_store->getStore($store_id);

			if ($store_info) {
				$this->redirect($store_info['url'] . 'index.php?route=account/login&token=' . $token);
			} else { 
				$this->redirect(HTTP_CATALOG . 'index.php?route=account/login&token=' . $token);
			}
		} else {
			$this->language->load('error/not_found');

			$this->document->setTitle($this->language->get('heading_title'));

			$this->data['heading_title'] = $this->language->get('heading_title');

			$this->data['text_not_found'] = $this->language->get('text_not_found');

			$this->data['breadcrumbs'] = array();

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_home'),
				'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => false
			);

			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('error/not_found', 'token=' . $this->session->data['token'], 'SSL'),
				'separator' => ' :: '
			);

			$this->template = 'error/not_found.tpl';
			$this->children = array(
				'common/header',
				'common/footer'
			);

			$this->response->setOutput($this->render());
		}
	}
			
}
?>
