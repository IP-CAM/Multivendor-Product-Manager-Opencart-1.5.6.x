<?php
class ControllerModuleCPM extends Controller {
	private $error = array();

	public function index() {
        $language = $this->load->language('module/cpm');
        $this->data = array_merge($this->data, $language);

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/setting');
		$this->load->model('sale/customer_group');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('cpm', $this->request->post);
			
			if (!empty($this->request->post['cpm_members_list_keyword'])) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'product/member', keyword = '" . $this->db->escape($this->request->post['cpm_members_list_keyword']) . "'");
			}
					
			$this->session->data['success'] = $this->language->get('text_success');
						
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		}

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_enabled'] = $this->language->get('text_enabled');
		$this->data['text_disabled'] = $this->language->get('text_disabled');
		$this->data['text_add'] = $this->language->get('text_add');
		$this->data['text_subtract'] = $this->language->get('text_subtract');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_content_top'] = $this->language->get('text_content_top');
		$this->data['text_content_bottom'] = $this->language->get('text_content_bottom');		
		$this->data['text_column_left'] = $this->language->get('text_column_left');
		$this->data['text_column_right'] = $this->language->get('text_column_right');
		$this->data['text_display'] = $this->language->get('text_display');

		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['entry_limit'] = $this->language->get('entry_limit');
		$this->data['entry_module_image'] = $this->language->get('entry_module_image');
		$this->data['entry_module_custom_fields'] = $this->language->get('entry_module_custom_fields');
		$this->data['entry_module_product_count'] = $this->language->get('entry_module_product_count');
		$this->data['entry_module_layout'] = $this->language->get('entry_module_layout');
		$this->data['entry_module_position'] = $this->language->get('entry_module_position');
		$this->data['entry_module_status'] = $this->language->get('entry_module_status');
		$this->data['entry_module_sort_order'] = $this->language->get('entry_module_sort_order');

		$this->data['button_save'] = $this->language->get('button_save');
		$this->data['button_cancel'] = $this->language->get('button_cancel');
		$this->data['button_update'] = $this->language->get('button_update');
		$this->data['button_add_module'] = $this->language->get('button_add_module');
		$this->data['button_remove'] = $this->language->get('button_remove');

		if (isset($this->session->data['success'])) {
			$this->data['success'] = $this->session->data['success'];
		
			unset($this->session->data['success']);
		} else {
			$this->data['success'] = '';
		}

		if (isset($this->session->data['error'])) {
			$this->data['error'] = $this->session->data['error'];
		
			unset($this->session->data['error']);
		} else {
			$this->data['error'] = '';
		}

 		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		$error_messages = array(
			'customer_group'				=>	'error_customer_group',
			'products_max'					=>	'error_products_max',
			'image_upload_directory'		=>	'error_image_upload_directory',
			'download_directory'			=>	'error_download_directory',
			'email_customers'				=>	'error_email_customers',
			'members_list_name'				=>	'error_members_list_name',
			'member_directories'			=>	'error_member_directories',
			'member_paypal_require'			=>	'error_member_paypal_require',
			'product_manager_limit'			=>	'error_product_manager_limit',
			'report_views_limit'			=>	'error_report_views_limit',
			'report_sales_tax_add'			=>	'error_report_sales_tax_add',
			'image_max_number'				=>	'error_image_max_number',
			'image_upload_filesize_max'		=>	'error_image_upload_filesize_max',
			'image_dimensions_min'			=>	'error_image_dimensions_min',
			'image_dimensions_resize'		=>	'error_image_dimensions_resize'
		);

        foreach ($error_messages as $error_message_key => $error_message_value) {
            if (isset($this->error[$error_message_key])) {
				$this->data[$error_message_value] = $this->error[$error_message_key];
            } else {
				$this->data[$error_message_value] = '';
            }
        }

		if (isset($this->error['module_image'])) {
			$this->data['error_module_image'] = $this->error['module_image'];
		} else {
			$this->data['error_module_image'] = array();
		}

  		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => false
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

   		$this->data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('module/cpm', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['action'] = $this->url->link('module/cpm', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['cancel'] = $this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['update'] = $this->url->link('module/cpm/update', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['settings'] = $this->url->link('setting/setting', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['members'] = $this->url->link('catalog/member', 'token=' . $this->session->data['token'], 'SSL');		
		$this->data['customers'] = $this->url->link('sale/customer', 'token=' . $this->session->data['token'], 'SSL');		
		$this->data['products'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL');		
		$this->data['customer_groups'] = $this->url->link('sale/customer_group', 'token=' . $this->session->data['token'], 'SSL');
		$this->data['member_sales_report'] = $this->url->link('report/sale_cpm_member', 'token=' . $this->session->data['token'], 'SSL');

		$this->data['token'] = $this->session->data['token'];
		
		$config_data_fields = array(
			'cpm_customer_group',
			'cpm_auto_approve_products',
			'cpm_email_new_products',
			'cpm_commission_rate',
			'cpm_email_customers',
			'cpm_paypal_email',
			'cpm_register_auto_fill',
			'cpm_members_nav_menu',
			'cpm_members_list_sort',
			'cpm_members_list_image',
			'cpm_members_list_keyword',
			'cpm_display_custom_fields',
			'cpm_custom_field_01',
			'cpm_custom_field_02',
			'cpm_custom_field_03',
			'cpm_custom_field_04',
			'cpm_custom_field_05',
			'cpm_custom_field_06',
			'cpm_tab_links',
			'cpm_tab_download',
			'cpm_tab_attribute',
			'cpm_tab_option',
			'cpm_tab_profile',
			'cpm_tab_discount',
			'cpm_tab_special',
			'cpm_tab_image',
			'cpm_tab_reward_points',
			'cpm_tab_design',
			'cpm_release'
		);

        foreach ($config_data_fields as $config_data_field) {
            if (isset($this->request->post[$config_data_field])) {
                $this->data[$config_data_field] = $this->request->post[$config_data_field];
            } else {
                $this->data[$config_data_field] = $this->config->get($config_data_field);
            }
        }
		
		$config_data_fields_enable_default = array(
			'cpm_status',
			'cpm_tab_general',
			'cpm_tab_data',
			'cpm_member_pages',
			'cpm_member_alias',
			'cpm_registration',
			'cpm_member_directories',
			'cpm_member_paypal',
			'cpm_member_paypal_require',
			'cpm_product_manager',
			'cpm_data_field_metas',
			'cpm_data_field_tags',
			'cpm_data_field_image',
			'cpm_data_field_model',
			'cpm_data_field_location',
			'cpm_data_field_tax',
			'cpm_data_field_quantity',
			'cpm_data_field_stock',
			'cpm_data_field_shipping',
			'cpm_data_field_keyword',
			'cpm_data_field_date',
			'cpm_data_field_dimensions',
			'cpm_data_field_weight',
			'cpm_data_field_sort_order',
			'cpm_data_field_part_numbers',
			'cpm_data_field_category',
			'cpm_data_field_manufacturer',
			'cpm_data_field_filter',
			'cpm_data_field_store',
			'cpm_data_field_related',
			'cpm_report',
			'cpm_report_sales_unique',
			'cpm_report_sales_history',
			'cpm_report_sales_commission',
			'cpm_report_sales_tax',
			'cpm_report_sales_tax_add',
			'cpm_report_views_pages',
		);

        foreach ($config_data_fields_enable_default as $config_data_field) {
            if (isset($this->request->post[$config_data_field])) {
                $this->data[$config_data_field] = $this->request->post[$config_data_field];
            } elseif (!is_null($this->config->get($config_data_field))) {
                $this->data[$config_data_field] = $this->config->get($config_data_field);
            } else {
				$this->data[$config_data_field] = '1';
			}
        }
		
		if (isset($this->request->post['cpm_products_max'])) {
      		$this->data['cpm_products_max'] = $this->request->post['cpm_products_max'];
    	} elseif ($this->config->get('cpm_products_max')) {
			$this->data['cpm_products_max'] = $this->config->get('cpm_products_max');
		} else {
      		$this->data['cpm_products_max'] = '10';
    	}

		if (isset($this->request->post['cpm_image_upload_directory'])) {
			$this->data['cpm_image_upload_directory'] = $this->request->post['cpm_image_upload_directory'];
		} elseif ($this->config->get('cpm_image_upload_directory')) {
			$this->data['cpm_image_upload_directory'] = $this->config->get('cpm_image_upload_directory');
		} else {
			$this->data['cpm_image_upload_directory'] = 'member';
		}
        
		if (isset($this->request->post['cpm_download_directory'])) {
			$this->data['cpm_download_directory'] = $this->request->post['cpm_download_directory'];
		} elseif ($this->config->get('cpm_download_directory')) {
			$this->data['cpm_download_directory'] = $this->config->get('cpm_download_directory');
		} else {
			$this->data['cpm_download_directory'] = 'member';
		}
		
		if (isset($this->request->post['cpm_product_manager_limit'])) {
      		$this->data['cpm_product_manager_limit'] = $this->request->post['cpm_product_manager_limit'];
    	} elseif ($this->config->get('cpm_product_manager_limit')) {
			$this->data['cpm_product_manager_limit'] = $this->config->get('cpm_product_manager_limit');
		} else {
      		$this->data['cpm_product_manager_limit'] = '12';
    	}
		
		if (isset($this->request->post['cpm_data_field_description_min'])) {
      		$this->data['cpm_data_field_description_min'] = $this->request->post['cpm_data_field_description_min'];
    	} elseif ($this->config->get('cpm_data_field_description_min')) {
			$this->data['cpm_data_field_description_min'] = $this->config->get('cpm_data_field_description_min');
		} else {
      		$this->data['cpm_data_field_description_min'] = '10';
    	}
		
		if (isset($this->request->post['cpm_data_field_description_max'])) {
      		$this->data['cpm_data_field_description_max'] = $this->request->post['cpm_data_field_description_max'];
    	} elseif ($this->config->get('cpm_data_field_description_max')) {
			$this->data['cpm_data_field_description_max'] = $this->config->get('cpm_data_field_description_max');
		} else {
      		$this->data['cpm_data_field_description_max'] = '1500';
    	}
		
		if (isset($this->request->post['cpm_report_views_limit'])) {
      		$this->data['cpm_report_views_limit'] = $this->request->post['cpm_report_views_limit'];
    	} elseif ($this->config->get('cpm_report_views_limit')) {
			$this->data['cpm_report_views_limit'] = $this->config->get('cpm_report_views_limit');
		} else {
      		$this->data['cpm_report_views_limit'] = '12';
    	}
		
		if (isset($this->request->post['cpm_image_max_number'])) {
      		$this->data['cpm_image_max_number'] = $this->request->post['cpm_image_max_number'];
    	} elseif ($this->config->get('cpm_image_max_number')) {
			$this->data['cpm_image_max_number'] = $this->config->get('cpm_image_max_number');
		} else {
      		$this->data['cpm_image_max_number'] = '5';
    	}
		
		if (isset($this->request->post['cpm_image_upload_filesize_max'])) {
      		$this->data['cpm_image_upload_filesize_max'] = $this->request->post['cpm_image_upload_filesize_max'];
    	} elseif ($this->config->get('cpm_image_upload_filesize_max')) {
			$this->data['cpm_image_upload_filesize_max'] = $this->config->get('cpm_image_upload_filesize_max');
		} else {
      		$this->data['cpm_image_upload_filesize_max'] = '1024';
    	}
		
		if (isset($this->request->post['cpm_image_dimensions_min_width'])) {
      		$this->data['cpm_image_dimensions_min_width'] = $this->request->post['cpm_image_dimensions_min_width'];
    	} elseif ($this->config->get('cpm_image_dimensions_min_width')) {
			$this->data['cpm_image_dimensions_min_width'] = $this->config->get('cpm_image_dimensions_min_width');
		} else {
      		$this->data['cpm_image_dimensions_min_width'] = '900';
    	}
		
		if (isset($this->request->post['cpm_image_dimensions_min_height'])) {
      		$this->data['cpm_image_dimensions_min_height'] = $this->request->post['cpm_image_dimensions_min_height'];
    	} elseif ($this->config->get('cpm_image_dimensions_min_height')) {
			$this->data['cpm_image_dimensions_min_height'] = $this->config->get('cpm_image_dimensions_min_height');
		} else {
      		$this->data['cpm_image_dimensions_min_height'] = '900';
    	}
		
		if (isset($this->request->post['cpm_image_dimensions_resize_width'])) {
      		$this->data['cpm_image_dimensions_resize_width'] = $this->request->post['cpm_image_dimensions_resize_width'];
    	} elseif ($this->config->get('cpm_image_dimensions_resize_width')) {
			$this->data['cpm_image_dimensions_resize_width'] = $this->config->get('cpm_image_dimensions_resize_width');
		} else {
      		$this->data['cpm_image_dimensions_resize_width'] = '900';
    	}
		
		if (isset($this->request->post['cpm_image_dimensions_resize_height'])) {
      		$this->data['cpm_image_dimensions_resize_height'] = $this->request->post['cpm_image_dimensions_resize_height'];
    	} elseif ($this->config->get('cpm_image_dimensions_resize_height')) {
			$this->data['cpm_image_dimensions_resize_height'] = $this->config->get('cpm_image_dimensions_resize_height');
		} else {
      		$this->data['cpm_image_dimensions_resize_height'] = '900';
    	}
				
		$this->load->model('localisation/language');
		
		$this->data['languages'] = $this->model_localisation_language->getLanguages();
					
		if (isset($this->request->post['cpm_members_list_description'])) {
			$this->data['cpm_members_list_description'] = $this->request->post['cpm_members_list_description'];
		} elseif ($this->config->get('cpm_members_list_description')) {
			$this->data['cpm_members_list_description'] = $this->config->get('cpm_members_list_description');
		} else {
			$this->data['cpm_members_list_description'] = array();
			$this->data['cpm_members_list_description'][1]['name'] = 'Members';
			$this->data['cpm_members_list_description'][1]['meta_description'] = '';
			$this->data['cpm_members_list_description'][1]['meta_keyword'] = '';
			$this->data['cpm_members_list_description'][1]['description'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['cpm_members_list_image']) && file_exists(DIR_IMAGE . $this->request->post['cpm_members_list_image'])) {
			$this->data['cpm_members_list_thumb'] = $this->model_tool_image->resize($this->request->post['cpm_members_list_image'], 100, 100);
		} elseif ($this->config->get('cpm_members_list_image') && file_exists(DIR_IMAGE . $this->config->get('cpm_members_list_image'))) {
			$this->data['cpm_members_list_thumb'] = $this->model_tool_image->resize($this->config->get('cpm_members_list_image'), 100, 100);
		} else {
			$this->data['cpm_members_list_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}
		
		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
        
		$this->data['customer_groups'] = $this->model_sale_customer_group->getCustomerGroups();

		$this->data['member_modules'] = array();

		$this->data['sort_data'] = array(
			array('value' => 'cpm_account_name', 'name' => 'Member Account Name'),
			array('value' => 'cpm.date_added', 'name' => 'Member Date Added'),
			array('value' => 'sort_order', 'name' => 'Member Sort Order')
		);

		$this->data['text_asc'] = $this->language->get('text_asc');
		$this->data['text_desc'] = $this->language->get('text_desc');

		if (isset($this->request->post['cpm_module'])) {
			$this->data['member_modules'] = $this->request->post['cpm_module'];
		} elseif ($this->config->get('cpm_module')) { 
			$this->data['member_modules'] = $this->config->get('cpm_module');
		}				

		$this->load->model('design/layout');

		$this->data['layouts'] = $this->model_design_layout->getLayouts();
		
		$this->template = 'module/cpm.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);

		$this->response->setOutput($this->render());
	}

	private function validate() {
		if (!$this->user->hasPermission('modify', 'module/cpm')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		
		/* uncomment to require customer group
		if (!$this->request->post['cpm_customer_group']){
			$this->error['customer_group'] = $this->language->get('error_customer_group');
		}
		*/
		
		if (!$this->request->post['cpm_products_max']) {
			$this->error['products_max'] = $this->language->get('error_products_max');
		}
		
		if (!empty($this->request->post['cpm_image_upload_directory'])) {
			$directory = DIR_IMAGE . 'data/' . str_replace('../', '', $this->request->post['cpm_image_upload_directory']);
			if (!is_dir($directory)) {
				if(!mkdir($directory, 0755, true)) {
					$this->error['image_upload_directory'] = $this->language->get('error_image_upload_directory');
				}
			}
		}
		
		if (!empty($this->request->post['cpm_download_directory'])) {
			$directory = DIR_DOWNLOAD . str_replace('../', '', $this->request->post['cpm_download_directory']);
			if (!is_dir($directory)) {
				if(!mkdir($directory, 0755, true)) {
					$this->error['download_directory'] = $this->language->get('error_download_directory');
				}
			}
		}
		
		if ($this->request->post['cpm_email_customers'] && !$this->config->get('config_alert_mail')) {
			$this->error['email_customers'] = $this->language->get('error_email_customers');
		}
		
		if ($this->request->post['cpm_member_paypal_require'] && !$this->request->post['cpm_member_paypal']) {
			$this->error['member_paypal_require'] = $this->language->get('error_member_paypal_require');
		}
		
		if ($this->request->post['cpm_member_directories'] && !$this->request->post['cpm_member_alias']) {
			$this->error['member_directories'] = $this->language->get('error_member_directories');
		}

		foreach ($this->request->post['cpm_members_list_description'] as $language_id => $value) {
			if ((mb_strlen($value['name']) < 2) || (mb_strlen($value['name']) > 255)) {
				$this->error['members_list_name'][$language_id] = $this->language->get('error_name');
			}
		}

		if ($this->request->post['cpm_product_manager_limit'] <= 0) {
			$this->error['product_manager_limit'] = $this->language->get('error_number');
		}
		
		if ($this->request->post['cpm_report_sales_tax_add'] && !$this->request->post['cpm_report_sales_tax']) {
			$this->error['report_sales_tax_add'] = $this->language->get('error_report_sales_tax_add');
		}

		if ($this->request->post['cpm_report_views_limit'] <= 0) {
			$this->error['report_views_limit'] = $this->language->get('error_number');
		}

		if ($this->request->post['cpm_image_max_number'] < 0) {
			$this->error['image_max_number'] = $this->language->get('error_image_max_number');
		}

		if (!$this->request->post['cpm_image_upload_filesize_max']) {
			$this->error['image_upload_filesize_max'] = $this->language->get('error_image_upload_filesize_max');
		}

		if (!$this->request->post['cpm_image_dimensions_min_width'] || !$this->request->post['cpm_image_dimensions_min_height']){
			$this->error['image_dimensions_min'] = $this->language->get('error_image_dimensions_min');
		}

		if (!$this->request->post['cpm_image_dimensions_resize_width'] || !$this->request->post['cpm_image_dimensions_resize_height']){
			$this->error['image_dimensions_resize'] = $this->language->get('error_image_dimensions_resize');
		}

		if (isset($this->request->post['member_module'])) {
			foreach ($this->request->post['member_module'] as $key => $value) {
				if (!$value['image_width'] || !$value['image_height']) {
					$this->error['module_image'][$key] = $this->language->get('error_module_image');
				}
			}
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
	
	public function install() {
		$data = array();
		
		$this->load->model('module/cpm');
		$data = $this->model_module_cpm->installCPM();
		
		$this->load->model('setting/setting');
		$this->model_setting_setting->editSetting('cpm', array('cpm_status'=>1));
		
		if ($data['success']) {
			$this->session->data['success'] = $data['message'];
		} else {
			$this->session->data['error'] = $data['message'];
		}
	}   
   
	public function uninstall() {
		$data = array();
		
        $this->load->model('module/cpm');
        $data = $this->model_module_cpm->uninstallCPM();
         
        $this->load->model('setting/setting');
        $this->model_setting_setting->editSetting('cpm', array('cpm_status'=>0));

		if ($data['success']) {
			$this->session->data['success'] = $data['message'];
		} else {
			$this->session->data['error'] = $data['message'];
		}
    }
	
	public function update() {
		if (!$this->user->hasPermission('modify', 'module/cpm')) {
			$this->session->data['error'] = $this->language->get('error_permission'); 
			
			$this->redirect($this->url->link('extension/module', 'token=' . $this->session->data['token'], 'SSL'));
		} else {
			$data = array();
		
			$this->load->model('module/cpm');
			$data = $this->model_module_cpm->updateCPM();
			
			if ($data['success']) {
				$this->session->data['success'] = $data['message'];
			} else {
				$this->session->data['error'] = $data['message'];
			}
			
			$this->redirect($this->url->link('module/cpm', 'token=' . $this->session->data['token'], 'SSL'));
		}
	}   

}
?>