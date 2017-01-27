<?php 
class ControllerAccountRegisterCPM extends Controller {
	private $error = array();
	      
  	public function index() {
		if ($this->customer->isLogged()) {
	  		$this->redirect($this->url->link('account/account', '', 'SSL'));
    	}
    	
		if (!$this->config->get('cpm_status') || !$this->config->get('cpm_registration')) {
			$this->redirect($this->url->link('account/register', '', 'SSL'));
		}

    	$this->language->load('account/register_cpm');
		
		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('account/customer');
		
    	if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$data = array();
			$data = $this->request->post;
			
			$data['sort_order'] = '0';
			$data['viewed'] = '0';
			
			if ($this->config->get('cpm_member_alias')) {
				$data['keyword'] = 'member-' . $this->friendlyURL($this->request->post['cpm_account_name']);
			} else {
				$data['keyword'] = '';
			}
			
			// $data['cpm_account_description'][1]['meta_description'] = $this->request->post['cpm_account_description'];
			
			if (!$this->config->get('cpm_member_paypal')) {
				$data['cpm_paypal_account'] = '';
			}
			
			if($this->config->get('cpm_member_directories')) {
				$cpm_directory_images = str_replace('../', '', $this->config->get('cpm_image_upload_directory') . "/" . $this->db->escape($data['keyword']));
				$directory = DIR_IMAGE . 'data/' . $cpm_directory_images;
				if (!is_dir($directory)) {
					if(mkdir($directory, 0755, true)) {
						$data['cpm_directory_images'] = $cpm_directory_images;
						if (!empty($this->request->post['cpm_account_image']) && is_file(DIR_IMAGE . $this->request->post['cpm_account_image'])) {
							$new_filename = 'account-image.' . substr(strrchr(strtolower($this->request->post['cpm_account_image']), '.'), 1);
							rename(DIR_IMAGE . $this->request->post['cpm_account_image'], $directory . '/' . $new_filename);
							$data['cpm_account_image'] = 'data/' . $cpm_directory_images . '/' . $new_filename;
							// $this->log->write("SUCCESS: File '" . DIR_IMAGE . $this->request->post['cpm_account_image'] . "' was moved to file location '" . $directory . '/account-image.' . substr(strrchr(strtolower($this->request->post['cpm_account_image']), '.'), 1) . "' for new Member (CPM) '" . $this->request->post['lastname'] . ", " . $this->request->post['firstname'] . "'");
						} else {
							$this->log->write("ERROR: File '" . DIR_IMAGE . $this->request->post['cpm_account_image'] . "' could NOT be moved to file location '" . $directory . '/account-image.' . substr(strrchr(strtolower($this->request->post['cpm_account_image']), '.'), 1) . "' for new Member (CPM) '" . $this->request->post['lastname'] . ", " . $this->request->post['firstname'] . "'");
						}
					} else {
						$this->log->write("ERROR: Directory '" . $cpm_directory_images . "' could NOT be created for new Member (CPM) '" . $this->request->post['lastname'] . ", " . $this->request->post['firstname'] . "'");
					}
				} else {
					$this->log->write("ERROR: Directory '" . $cpm_directory_images . "' already EXISTS. Please set a private Image Upload Directory for new Member (CPM) '" . $this->request->post['lastname'] . ", " . $this->request->post['firstname'] . "'");					
				}
				$cpm_directory_downloads = str_replace('../', '', $this->config->get('cpm_download_directory') . "/" . $this->db->escape($data['keyword']));
				$directory = DIR_DOWNLOAD . $cpm_directory_downloads;
				if (!is_dir($directory)) {
					if(mkdir($directory, 0755, true)) {
						$data['cpm_directory_downloads'] = $cpm_directory_downloads;
					} else {
						$this->log->write("ERROR: Directory '" . $cpm_directory_downloads . "' could NOT be created for new Member (CPM) '" . $this->request->post['lastname'] . ", " . $this->request->post['firstname'] . "'");
					}
				} else {
					$this->log->write("ERROR: Directory '" . $cpm_directory_downloads . "' already EXISTS. Please set a private Downloads Directory for new Member (CPM) '" . $this->request->post['lastname'] . ", " . $this->request->post['firstname'] . "'");					
				}
			}
							
			$this->model_account_customer->addCustomer($data);

			$this->customer->login($this->request->post['email'], $this->request->post['password']);
			
			unset($this->session->data['guest']);
			
			// Default Shipping Address
			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_country_id'] = $this->request->post['country_id'];
				$this->session->data['shipping_zone_id'] = $this->request->post['zone_id'];
				$this->session->data['shipping_postcode'] = $this->request->post['postcode'];				
			}
			
			// Default Payment Address
			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_country_id'] = $this->request->post['country_id'];
				$this->session->data['payment_zone_id'] = $this->request->post['zone_id'];			
			}
							  	  
	  		$this->redirect($this->url->link('account/success')); // success message configurable in modified language file
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
        	'text'      => $this->language->get('text_register'),
			'href'      => $this->url->link('account/register', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_register_member'),
			'href'      => $this->url->link('account/register_cpm', '', 'SSL'),      	
        	'separator' => $this->language->get('text_separator')
      	);
		
    	$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_account_already'] = sprintf($this->language->get('text_account_already'), $this->url->link('account/login', '', 'SSL'));
		$this->data['text_your_details'] = $this->language->get('text_your_details');
    	$this->data['text_your_address'] = $this->language->get('text_your_address');
    	$this->data['text_your_password'] = $this->language->get('text_your_password');
		$this->data['text_newsletter'] = $this->language->get('text_newsletter');
		$this->data['text_yes'] = $this->language->get('text_yes');
		$this->data['text_no'] = $this->language->get('text_no');
		$this->data['text_select'] = $this->language->get('text_select');
		$this->data['text_none'] = $this->language->get('text_none');
						
    	$this->data['entry_firstname'] = $this->language->get('entry_firstname');
    	$this->data['entry_lastname'] = $this->language->get('entry_lastname');
    	$this->data['entry_email'] = $this->language->get('entry_email');
    	$this->data['entry_telephone'] = $this->language->get('entry_telephone');
    	$this->data['entry_fax'] = $this->language->get('entry_fax');
		$this->data['entry_company'] = $this->language->get('entry_company');
		$this->data['entry_company_id'] = $this->language->get('entry_company_id');
		$this->data['entry_tax_id'] = $this->language->get('entry_tax_id');
    	$this->data['entry_address_1'] = $this->language->get('entry_address_1');
    	$this->data['entry_address_2'] = $this->language->get('entry_address_2');
    	$this->data['entry_postcode'] = $this->language->get('entry_postcode');
    	$this->data['entry_city'] = $this->language->get('entry_city');
    	$this->data['entry_country'] = $this->language->get('entry_country');
    	$this->data['entry_zone'] = $this->language->get('entry_zone');
		$this->data['entry_newsletter'] = $this->language->get('entry_newsletter');
    	$this->data['entry_password'] = $this->language->get('entry_password');
    	$this->data['entry_confirm'] = $this->language->get('entry_confirm');

		$this->data['button_continue'] = $this->language->get('button_continue');
		
		/* CPM Start for Customer Form */
		$this->data['entry_cpm_account_name'] = $this->language->get('entry_cpm_account_name');
		$this->data['entry_cpm_account_description'] = $this->language->get('entry_cpm_account_description');
		$this->data['entry_cpm_account_image'] = $this->language->get('entry_cpm_account_image');
		$this->data['entry_cpm_custom_field_01'] = $this->config->get('cpm_custom_field_01');
		$this->data['entry_cpm_custom_field_02'] = $this->config->get('cpm_custom_field_02');
		$this->data['entry_cpm_custom_field_03'] = $this->config->get('cpm_custom_field_03');
		$this->data['entry_cpm_custom_field_04'] = $this->config->get('cpm_custom_field_04');
		$this->data['entry_cpm_custom_field_05'] = $this->config->get('cpm_custom_field_05');
		$this->data['entry_cpm_custom_field_06'] = $this->config->get('cpm_custom_field_06');
		$this->data['entry_cpm_paypal_account'] = $this->language->get('entry_cpm_paypal_account');
		$this->data['text_your_cpm_account'] = $this->language->get('text_your_cpm_account');
		$this->data['text_custom_fields'] = $this->language->get('text_custom_fields');
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['text_clear'] = $this->language->get('text_clear');
		$this->data['text_copy_email'] = $this->language->get('text_copy_email');
		$this->data['help_cpm_paypal_account'] = $this->language->get('help_cpm_paypal_account');
		$this->data['help_cpm_custom_fields'] = $this->language->get('help_cpm_custom_fields');

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

		if (isset($this->error['cpm_account_image'])) {
			$this->data['error_cpm_account_image'] = $this->error['cpm_account_image'];
		} else {
			$this->data['error_cpm_account_image'] = '';
		}

		if (isset($this->error['cpm_custom_fields'])) {
			$this->data['error_cpm_custom_fields'] = $this->error['cpm_custom_fields'];
		} else {
			$this->data['error_cpm_custom_fields'] = '';
		}
		/* CPM End */
    
		if (isset($this->error['warning'])) {
			$this->data['error_warning'] = $this->error['warning'];
		} else {
			$this->data['error_warning'] = '';
		}
		
		if (isset($this->error['firstname'])) {
			$this->data['error_firstname'] = $this->error['firstname'];
		} else {
			$this->data['error_firstname'] = '';
		}	
		
		if (isset($this->error['lastname'])) {
			$this->data['error_lastname'] = $this->error['lastname'];
		} else {
			$this->data['error_lastname'] = '';
		}		
	
		if (isset($this->error['email'])) {
			$this->data['error_email'] = $this->error['email'];
		} else {
			$this->data['error_email'] = '';
		}
		
		if (isset($this->error['telephone'])) {
			$this->data['error_telephone'] = $this->error['telephone'];
		} else {
			$this->data['error_telephone'] = '';
		}
		
		if (isset($this->error['password'])) {
			$this->data['error_password'] = $this->error['password'];
		} else {
			$this->data['error_password'] = '';
		}
		
 		if (isset($this->error['confirm'])) {
			$this->data['error_confirm'] = $this->error['confirm'];
		} else {
			$this->data['error_confirm'] = '';
		}
		
  		if (isset($this->error['company_id'])) {
			$this->data['error_company_id'] = $this->error['company_id'];
		} else {
			$this->data['error_company_id'] = '';
		}
		
  		if (isset($this->error['tax_id'])) {
			$this->data['error_tax_id'] = $this->error['tax_id'];
		} else {
			$this->data['error_tax_id'] = '';
		}
								
  		if (isset($this->error['address_1'])) {
			$this->data['error_address_1'] = $this->error['address_1'];
		} else {
			$this->data['error_address_1'] = '';
		}
   		
		if (isset($this->error['city'])) {
			$this->data['error_city'] = $this->error['city'];
		} else {
			$this->data['error_city'] = '';
		}
		
		if (isset($this->error['postcode'])) {
			$this->data['error_postcode'] = $this->error['postcode'];
		} else {
			$this->data['error_postcode'] = '';
		}

		if (isset($this->error['country'])) {
			$this->data['error_country'] = $this->error['country'];
		} else {
			$this->data['error_country'] = '';
		}

		if (isset($this->error['zone'])) {
			$this->data['error_zone'] = $this->error['zone'];
		} else {
			$this->data['error_zone'] = '';
		}
		
    	$this->data['action'] = $this->url->link('account/register_cpm', '', 'SSL');
		
		if (isset($this->request->post['firstname'])) {
    		$this->data['firstname'] = $this->request->post['firstname'];
		} else {
			$this->data['firstname'] = '';
		}

		if (isset($this->request->post['lastname'])) {
    		$this->data['lastname'] = $this->request->post['lastname'];
		} else {
			$this->data['lastname'] = '';
		}
		
		if (isset($this->request->post['email'])) {
    		$this->data['email'] = $this->request->post['email'];
		} else {
			$this->data['email'] = '';
		}
		
		if (isset($this->request->post['telephone'])) {
    		$this->data['telephone'] = $this->request->post['telephone'];
		} else {
			$this->data['telephone'] = '';
		}
		
		if (isset($this->request->post['fax'])) {
    		$this->data['fax'] = $this->request->post['fax'];
		} else {
			$this->data['fax'] = '';
		}
		
		if (isset($this->request->post['company'])) {
    		$this->data['company'] = $this->request->post['company'];
		} else {
			$this->data['company'] = '';
		}
		
		if (isset($this->request->post['customer_group_id'])) {
			$this->data['customer_group_id'] = $this->request->post['customer_group_id'];
		} elseif ($this->config->get('cpm_customer_group')) {
			$this->data['customer_group_id'] = $this->config->get('cpm_customer_group');   // default cpm setting value
		} else {
			$this->data['customer_group_id'] = $this->config->get('config_customer_group_id'); // default customer group
		}
		
		// Customer Group
		$this->load->model('account/customer_group');

		$customer_group = $this->model_account_customer_group->getCustomerGroup($this->data['customer_group_id']);
			
		if ($customer_group) {	
			if ($customer_group['company_id_display']) {
				$this->data['company_id_display'] = true;
			} else {
				$this->data['company_id_display'] = false;
			}
			
			if ($customer_group['tax_id_display']) {
				$this->data['tax_id_display'] = true;
			} else {
				$this->data['tax_id_display'] = false;
			}
			
			if ($customer_group['company_id_required']) {
				$this->data['company_id_required'] = true;
			} else {
				$this->data['company_id_required'] = false;
			}
			
			if ($customer_group['tax_id_required']) {
				$this->data['tax_id_required'] = true;
			} else {
				$this->data['tax_id_required'] = false;
			}
		}
		
		if (isset($this->request->post['company_id'])) {
    		$this->data['company_id'] = $this->request->post['company_id'];
		} else {
			$this->data['company_id'] = '';
		}
		
		if (isset($this->request->post['tax_id'])) {
    		$this->data['tax_id'] = $this->request->post['tax_id'];
		} else {
			$this->data['tax_id'] = '';
		}
						
		if (isset($this->request->post['address_1'])) {
    		$this->data['address_1'] = $this->request->post['address_1'];
		} else {
			$this->data['address_1'] = '';
		}

		if (isset($this->request->post['address_2'])) {
    		$this->data['address_2'] = $this->request->post['address_2'];
		} else {
			$this->data['address_2'] = '';
		}

		if (isset($this->request->post['postcode'])) {
    		$this->data['postcode'] = $this->request->post['postcode'];
		} elseif (isset($this->session->data['shipping_postcode'])) {
			$this->data['postcode'] = $this->session->data['shipping_postcode'];		
		} else {
			$this->data['postcode'] = '';
		}
		
		if (isset($this->request->post['city'])) {
    		$this->data['city'] = $this->request->post['city'];
		} else {
			$this->data['city'] = '';
		}

    	if (isset($this->request->post['country_id'])) {
      		$this->data['country_id'] = $this->request->post['country_id'];
		} elseif (isset($this->session->data['shipping_country_id'])) {
			$this->data['country_id'] = $this->session->data['shipping_country_id'];		
		} else {	
      		$this->data['country_id'] = $this->config->get('config_country_id');
    	}

    	if (isset($this->request->post['zone_id'])) {
      		$this->data['zone_id'] = $this->request->post['zone_id']; 	
		} elseif (isset($this->session->data['shipping_zone_id'])) {
			$this->data['zone_id'] = $this->session->data['shipping_zone_id'];			
		} else {
      		$this->data['zone_id'] = '';
    	}
		
		$this->load->model('localisation/country');
		
    	$this->data['countries'] = $this->model_localisation_country->getCountries();
	
		/* CPM START  */
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
			'cpm_paypal_account'
		);

		foreach ($cpm_data_fields as $cpm_data_field) {
			if (isset($this->request->post[$cpm_data_field])) {
				$this->data[$cpm_data_field] = $this->request->post[$cpm_data_field];
			} else {
				$this->data[$cpm_data_field] = '';
			}
		}
		
		/*	
		$this->data['cpm_directory_images'] = $this->config->get('cpm_image_upload_directory');  // default CPM setting value	
		$this->data['cpm_directory_downloads'] = $this->config->get('cpm_download_directory');  // default CPM setting value
      	$this->data['cpm_max_products'] = $this->config->get('cpm_products_max');  // default CPM setting value
      	* */

		$this->load->model('tool/image');
	
		if (isset($this->request->post['cpm_account_image']) && file_exists(DIR_IMAGE . $this->request->post['cpm_account_image'])) {
			$this->data['cpm_account_image_thumb'] = $this->model_tool_image->resize($this->request->post['cpm_account_image'], 100, 100);
		} else {
			$this->data['cpm_account_image_thumb'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		}

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);			
		/* CPM END */
	
		if (isset($this->request->post['password'])) {
    		$this->data['password'] = $this->request->post['password'];
		} else {
			$this->data['password'] = '';
		}
		
		if (isset($this->request->post['confirm'])) {
    		$this->data['confirm'] = $this->request->post['confirm'];
		} else {
			$this->data['confirm'] = '';
		}
		
		if (isset($this->request->post['newsletter'])) {
    		$this->data['newsletter'] = $this->request->post['newsletter'];
		} else {
			$this->data['newsletter'] = '';
		}

		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info) {
				$this->data['text_agree'] = sprintf($this->language->get('text_agree'), $this->url->link('information/information/info', 'information_id=' . $this->config->get('config_account_id'), 'SSL'), $information_info['title'], $information_info['title']);
			} else {
				$this->data['text_agree'] = '';
			}
		} else {
			$this->data['text_agree'] = '';
		}
		
		if (isset($this->request->post['agree'])) {
      		$this->data['agree'] = $this->request->post['agree'];
		} else {
			$this->data['agree'] = false;
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/register_cpm.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/register_cpm.tpl';
		} else {
			$this->template = 'default/template/account/register_cpm.tpl';
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

  	private function validate() {
    	if ((utf8_strlen($this->request->post['firstname']) < 1) || (utf8_strlen($this->request->post['firstname']) > 32)) {
      		$this->error['firstname'] = $this->language->get('error_firstname');
    	}

    	if ((utf8_strlen($this->request->post['lastname']) < 1) || (utf8_strlen($this->request->post['lastname']) > 32)) {
      		$this->error['lastname'] = $this->language->get('error_lastname');
    	}

    	if ((utf8_strlen($this->request->post['email']) > 96) || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['email'])) {
      		$this->error['email'] = $this->language->get('error_email');
    	}

    	if ($this->model_account_customer->getTotalCustomersByEmail($this->request->post['email'])) {
      		$this->error['warning'] = $this->language->get('error_exists');
    	}
		
    	if ((utf8_strlen($this->request->post['telephone']) < 3) || (utf8_strlen($this->request->post['telephone']) > 32)) {
      		$this->error['telephone'] = $this->language->get('error_telephone');
    	}
		
		$this->load->model('account/customer_group');
			
		$customer_group = $this->model_account_customer_group->getCustomerGroup($this->request->post['customer_group_id']);
				
		if ($customer_group) {
			if ($customer_group['company_id_display'] && $customer_group['company_id_required'] && empty($this->request->post['company_id'])) {
				$this->error['company_id'] = $this->language->get('error_company_id');
			}
		
			if ($customer_group['tax_id_display'] && $customer_group['tax_id_required'] && empty($this->request->post['tax_id'])) {
				$this->error['tax_id'] = $this->language->get('error_tax_id');
			}
		}
		
    	if ((utf8_strlen($this->request->post['address_1']) < 3) || (utf8_strlen($this->request->post['address_1']) > 128)) {
      		$this->error['address_1'] = $this->language->get('error_address_1');
    	}

    	if ((utf8_strlen($this->request->post['city']) < 2) || (utf8_strlen($this->request->post['city']) > 128)) {
      		$this->error['city'] = $this->language->get('error_city');
    	}

		$this->load->model('localisation/country');
		
		$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);
		
		if ($country_info) {
			if ($country_info['postcode_required'] && (utf8_strlen($this->request->post['postcode']) < 2) || (utf8_strlen($this->request->post['postcode']) > 10)) {
				$this->error['postcode'] = $this->language->get('error_postcode');
			}
			
			// VAT Validation
			$this->load->helper('vat');
			
			if ($this->config->get('config_vat') && $this->request->post['tax_id'] && (vat_validation($country_info['iso_code_2'], $this->request->post['tax_id']) == 'invalid')) {
				$this->error['tax_id'] = $this->language->get('error_vat');
			}
		}

    	if ($this->request->post['country_id'] == '') {
      		$this->error['country'] = $this->language->get('error_country');
    	}
		
    	if ($this->request->post['zone_id'] == '') {
      		$this->error['zone'] = $this->language->get('error_zone');
    	}

    	if ((utf8_strlen($this->request->post['password']) < 4) || (utf8_strlen($this->request->post['password']) > 20)) {
      		$this->error['password'] = $this->language->get('error_password');
    	}

    	if ($this->request->post['confirm'] != $this->request->post['password']) {
      		$this->error['confirm'] = $this->language->get('error_confirm');
    	}
		
		if ($this->config->get('config_account_id')) {
			$this->load->model('catalog/information');
			
			$information_info = $this->model_catalog_information->getInformation($this->config->get('config_account_id'));
			
			if ($information_info && !isset($this->request->post['agree'])) {
      			$this->error['warning'] = sprintf($this->language->get('error_agree'), $information_info['title']);
			}
		}
		
		// validation for CPM Customer Account fields on Customer Form	
		if ((utf8_strlen($this->request->post['cpm_account_description']) < 1) || (utf8_strlen($this->request->post['cpm_account_description']) > 1500)) {
			$this->error['cpm_account_description'] = $this->language->get('error_cpm_account_description');
	    }

		if ((utf8_strlen($this->request->post['cpm_account_name']) < 1) || (utf8_strlen($this->request->post['cpm_account_name']) > 128)) {
	      		$this->error['cpm_account_name'] = $this->language->get('error_cpm_account_name');
	    }

		if (!empty($this->request->post['cpm_paypal_account'])) {
	      	if (utf8_strlen($this->request->post['cpm_paypal_account']) > 96 || !preg_match('/^[^\@]+@.*\.[a-z]{2,6}$/i', $this->request->post['cpm_paypal_account'])) {
	      		$this->error['cpm_paypal_account'] = $this->language->get('error_cpm_paypal_account');
			}
			
			if (!$this->config->get('cpm_member_paypal')) {
	      		$this->error['cpm_paypal_account'] = $this->language->get('error_cpm_paypal_account_disabled');				
			}
	    } elseif ($this->config->get('cpm_member_paypal_require')) {
			$this->error['cpm_paypal_account'] = $this->language->get('error_cpm_paypal_account_required');
		}
		
		/* uncomment to require image */
		/*
		if (empty($this->request->post['cpm_account_image'])) {
	      	$this->error['cpm_account_image'] = $this->language->get('error_cpm_account_image');
		}
		* */

		$cpm_custom_fields = array('cpm_custom_field_01', 'cpm_custom_field_02', 'cpm_custom_field_03', 'cpm_custom_field_04', 'cpm_custom_field_05', 'cpm_custom_field_06');
		foreach ($cpm_custom_fields as $cpm_custom_field) {
			if (!empty($this->request->post[$cpm_custom_field]) && utf8_strlen($this->request->post[$cpm_custom_field]) > 128) {
				$this->error['cpm_custom_fields'] = $this->language->get('error_cpm_custom_fields');
		    }
		}	
		// end CPM

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
    	if (!$this->error) {
      		return true;
    	} else {
      		return false;
    	}
  	}
	
	public function country() {
		$json = array();
		
		$this->load->model('localisation/country');

    	$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);
		
		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']		
			);
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function upload() {
	
	if ($this->config->get('cpm_status') !== '1') {
		$this->redirect($this->url->link('account/register', '', 'SSL'));
	}
		
		$this->language->load('account/register_cpm');
		
		$json = array();
		
		if (!empty($this->request->files['file']['name'])) {
			// $filename = basename(html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8'));
			$filename = basename(preg_replace('/[^a-zA-Z0-9\.\-\s+]/', '', html_entity_decode($this->request->files['file']['name'], ENT_QUOTES, 'UTF-8')));

			if ((utf8_strlen($filename) < 3) || (utf8_strlen($filename) > 128)) {
				$json['error'] = $this->language->get('error_filename');
			}	  	
					
			// Allowed file extension types
			$allowed = array(
					'jpg',
					'jpeg',
					'gif',
					'png',
				);
			
			if (!in_array(substr(strrchr(strtolower($filename), '.'), 1), $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}	
			
			// Allowed file mime types		
			$allowed = array(
				'image/jpeg',
				'image/pjpeg',
				'image/gif',
				'image/png'
			);
							
			if (!in_array($this->request->files['file']['type'], $allowed)) {
				$json['error'] = $this->language->get('error_filetype');
			}
			
			if ($this->request->files['file']['error'] != UPLOAD_ERR_OK) {
				$json['error'] = $this->language->get('error_upload_' . $this->request->files['file']['error']);
			}
		} else {
			$json['error'] = $this->language->get('error_upload');
		}
	
		if (!isset($json['error'])) {
			if (is_uploaded_file($this->request->files['file']['tmp_name']) && file_exists($this->request->files['file']['tmp_name'])) {
				$this->load->model('tool/image');				 
				$json['filename'] = 'data/' . $this->config->get('cpm_image_upload_directory') . '/' . $filename;
				move_uploaded_file($this->request->files['file']['tmp_name'], DIR_IMAGE . 'data/' . $this->config->get('cpm_image_upload_directory') . '/' . $filename);
				$json['thumb'] = $this->model_tool_image->resize($json['filename'], 100, 100);
			}
						
			$json['success'] = $this->language->get('text_upload');
		}	
	
		$this->response->setOutput(json_encode($json));
	}
	
	private function friendlyURL($inputString) {
		$url = strtolower($inputString);
		$patterns = $replacements = array();
		$patterns[0] = '/(&amp;|&)/i';
		$replacements[0] = '-and-';
		$patterns[1] = '/[^a-zA-Z01-9]/i';
		$replacements[1] = '-';
		$patterns[2] = '/(-+)/i';
		$replacements[2] = '-';
		$patterns[3] = '/(-$|^-)/i';
		$replacements[3] = '';
		$url = preg_replace($patterns, $replacements, $url);
		return $url;
	}
		
}
?>
