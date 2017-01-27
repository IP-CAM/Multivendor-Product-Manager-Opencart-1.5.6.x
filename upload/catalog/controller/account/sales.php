<?php 
class ControllerAccountSales extends Controller {
	private $error = array();
		
	public function index() {
		if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_report')) {  
			$this->session->data['redirect'] = $this->url->link('account/sales', '', 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$this->language->load('account/sales');
		
		$this->load->model('account/sales');

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
		
		$url = '';
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
				
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('account/sales', $url, 'SSL'),        	
        	'separator' => $this->language->get('text_separator')
      	);

		$this->data['heading_title'] = $this->language->get('heading_title');

		$this->data['text_sale_id'] = $this->language->get('text_sale_id');
		$this->data['text_status'] = $this->language->get('text_status');
		$this->data['text_date_added'] = $this->language->get('text_date_added');
		$this->data['text_customer'] = $this->language->get('text_customer');
		$this->data['text_info'] = $this->language->get('text_info');
		$this->data['text_products'] = $this->language->get('text_products');
		$this->data['text_sales'] = $this->language->get('text_sales');
		$this->data['text_revenue'] = $this->language->get('text_revenue');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_grand_total'] = $this->language->get('text_grand_total');
		$this->data['text_commission'] = $this->language->get('text_commission');
		$this->data['text_empty'] = $this->language->get('text_empty');
		
		if ($this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax') && $this->config->get('cpm_report_sales_tax_add')) {
			$this->data['text_total_calculation'] = $this->language->get('text_total') . ' - ' . $this->language->get('text_commission') . ' + ' . $this->language->get('text_tax');
		} elseif ($this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax') && !$this->config->get('cpm_report_sales_tax_add')) {
			$this->data['text_total_calculation'] = $this->language->get('text_total') . ' - ' . $this->language->get('text_commission') . ' - ' . $this->language->get('text_tax');
		} elseif ($this->config->get('cpm_report_sales_commission') && !$this->config->get('cpm_report_sales_tax')) {
			$this->data['text_total_calculation'] = $this->language->get('text_total') . ' - ' . $this->language->get('text_commission');			
		} elseif (!$this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax') && $this->config->get('cpm_report_sales_tax_add')) {
			$this->data['text_total_calculation'] = $this->language->get('text_total') . ' + ' . $this->language->get('text_tax');
		} elseif (!$this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax') && !$this->config->get('cpm_report_sales_tax_add')) {
			$this->data['text_total_calculation'] = $this->language->get('text_total') . ' - ' . $this->language->get('text_tax');
		} elseif (!$this->config->get('cpm_report_sales_commission') && !$this->config->get('cpm_report_sales_tax')) {
			$this->data['text_total_calculation'] = $this->language->get('text_total');
		} else {
			$this->data['text_total_calculation'] = '';
		}

		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_continue'] = $this->language->get('button_continue');
		
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
			
		$total_products = 0;
		$total_commissions = 0;
		$total_tax = 0;
		$total_grand = 0;
		$currencies = array();
		
		$this->data['sales'] = array();
		$this->data['totals'] = array();
		
		$sales_total = $this->model_account_sales->getTotalSales();
		
		$results = $this->model_account_sales->getSales(($page - 1) * 10, 10);
		
		foreach ($results as $result) {
			$product_total = $this->model_account_sales->getTotalSalesProductsBySalesId($result['order_id']);
			// $voucher_total = $this->model_account_sales->getTotalSalesVouchersBySalesId($result['sale_id']); // cpm edit - removed because no specific vouchers configured yet for CPM-enabled customer accounts

			if (!$this->config->get('cpm_report_sales_tax_add')) {
				$result['products_tax'] = -abs($result['products_tax']);
			}

			$this->data['sales'][] = array(
				'order_id'   => $result['order_id'],
				'name'       => $result['lastname'] . ', ' . $result['firstname'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'products'   => ($product_total), //+ $voucher_total),
				'revenue'	 => $this->currency->format(($result['products_total'] - $result['products_commission']), $result['currency_code'], $result['currency_value']),
				'sales'		 => $this->currency->format($result['products_total'], $result['currency_code'], $result['currency_value']),
				'total'      => $this->currency->format(($result['products_total'] + $result['products_tax'] - $result['products_commission']), $result['currency_code'], $result['currency_value']),
				'commission' => $this->currency->format($result['products_commission'], $result['currency_code'], $result['currency_value']),
				'tax'		 => $this->currency->format(abs($result['products_tax']), $result['currency_code'], $result['currency_value']),				
				'href'       => $this->url->link('account/sales/info', 'sale_id=' . $result['order_id'], 'SSL'),
			);
			
			// keep track of currencies
			if (!array_key_exists($result['currency_code'], $currencies)) {
				$currencies[$result['currency_code']] = $result['currency_value'];
			}
			// calculate totals only if not more than one currency
			if (count($currencies) <= 1) {
				$total_products += $product_total;
				$total_commissions += $result['products_commission'];
				$total_tax += $result['products_tax'];
				$total_grand += $result['products_total'];
			}
		}
		
		// totals only relevant if every sale made in the same currency
		if (count($currencies) == 1) {
			foreach ($currencies as $key => $value) {
				$this->data['totals']['products'] = $total_products;
				$this->data['totals']['commissions'] = $this->currency->format($total_commissions, $key, $value);
				$this->data['totals']['tax'] = $this->currency->format(abs($total_tax), $key, $value);
				$this->data['totals']['sales'] = $this->currency->format($total_grand, $key, $value);		
				$this->data['totals']['grand'] = $this->currency->format($total_grand + $total_tax - $total_commissions, $key, $value);
				$this->data['totals']['revenue'] = $this->currency->format($total_grand - $total_commissions, $key, $value);
			}
		}

		$pagination = new Pagination();
		$pagination->total = $sales_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/sales', 'page={page}', 'SSL');
		
		$this->data['pagination'] = $pagination->render();

		$this->data['continue'] = $this->url->link('account/account', '', 'SSL');
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/cpm.css')) {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/' . $this->config->get('config_template') . '/stylesheet/cpm.css');
		} else {
			$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/default/stylesheet/cpm.css');
		}

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/sales_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/sales_list.tpl';
		} else {
			$this->template = 'default/template/account/sales_list.tpl';
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
	
	public function info() {
		if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_report')) {  
			$this->session->data['redirect'] = $this->url->link('account/sales/info', 'sale_id=' . $sale_id, 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		if (isset($this->request->get['sale_id'])) {
			$sale_id = $this->request->get['sale_id'];
		} else {
			$sale_id = 0;
		}
		
		if ($this->customer->getId()) {
			$customer_id = $this->customer->getId();
		} else {
			$customer_id = 0;
		}
		
		$this->language->load('account/sales');
						
		$this->load->model('account/sales');
			
		$sale_info = $this->model_account_sales->getSale($sale_id);
		
		if ($sale_info) {
			$this->document->setTitle($this->language->get('text_sales'));
			
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
			
			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('heading_title'),
				'href'      => $this->url->link('account/sales', $url, 'SSL'),      	
				'separator' => $this->language->get('text_separator')
			);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_sales'),
				'href'      => $this->url->link('account/sales/info', 'sale_id=' . $this->request->get['sale_id'] . $url, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
					
      		$this->data['heading_title'] = $this->language->get('text_sales');
			
			$this->data['text_sales_detail'] = $this->language->get('text_sales_detail');
			$this->data['text_invoice_no'] = $this->language->get('text_invoice_no');
    		$this->data['text_sale_id'] = $this->language->get('text_sale_id');
			$this->data['text_date_added'] = $this->language->get('text_date_added');
      		$this->data['text_shipping_method'] = $this->language->get('text_shipping_method');
			$this->data['text_shipping_address'] = $this->language->get('text_shipping_address');
      		$this->data['text_payment_method'] = $this->language->get('text_payment_method');
      		$this->data['text_payment_address'] = $this->language->get('text_payment_address');
      		$this->data['text_history'] = $this->language->get('text_history');
      		$this->data['text_no_history'] = $this->language->get('text_no_history');
			$this->data['text_comment'] = $this->language->get('text_comment');
			$this->data['text_emailed'] = $this->language->get('text_emailed');
			$this->data['text_history'] = $this->language->get('text_history');
			$this->data['text_history_add'] = $this->language->get('text_history_add');
			$this->data['text_grand_total'] = $this->language->get('text_grand_total');
			$this->data['text_order_status'] = $this->language->get('text_order_status');
			$this->data['text_wait'] = $this->language->get('text_wait');

      		$this->data['column_image'] = $this->language->get('column_image');
      		$this->data['column_name'] = $this->language->get('column_name');
      		$this->data['column_model'] = $this->language->get('column_model');
      		$this->data['column_member'] = $this->language->get('column_member');
      		$this->data['column_quantity'] = $this->language->get('column_quantity');
      		$this->data['column_price'] = $this->language->get('column_price');
      		$this->data['column_total'] = $this->language->get('column_total');
			$this->data['column_action'] = $this->language->get('column_action');
			$this->data['column_date_added'] = $this->language->get('column_date_added');
      		$this->data['column_status'] = $this->language->get('column_status');
      		$this->data['column_comment'] = $this->language->get('column_comment');
			$this->data['column_emailed'] = $this->language->get('column_emailed');
			
      		$this->data['button_back'] = $this->language->get('button_back');
			$this->data['button_add_history'] = $this->language->get('button_add_history');
		
			if ($sale_info['invoice_no']) {
				$this->data['invoice_no'] = $sale_info['invoice_prefix'] . $sale_info['invoice_no'];
			} else {
				$this->data['invoice_no'] = '';
			}
			
			$this->data['order_id'] = $this->request->get['sale_id'];
			$this->data['date_added'] = date($this->language->get('date_format_short'), strtotime($sale_info['date_added']));
			
			if ($sale_info['payment_address_format']) {
      			$format = $sale_info['payment_address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
		
    		$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
				'{zone_code}',
      			'{country}'
			);
	
			$replace = array(
	  			'firstname' => $sale_info['payment_firstname'],
	  			'lastname'  => $sale_info['payment_lastname'],
	  			'company'   => $sale_info['payment_company'],
      			'address_1' => $sale_info['payment_address_1'],
      			'address_2' => $sale_info['payment_address_2'],
      			'city'      => $sale_info['payment_city'],
      			'postcode'  => $sale_info['payment_postcode'],
      			'zone'      => $sale_info['payment_zone'],
				'zone_code' => $sale_info['payment_zone_code'],
      			'country'   => $sale_info['payment_country']  
			);
			
			$this->data['payment_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

      		$this->data['payment_method'] = $sale_info['payment_method'];
			
			if ($sale_info['shipping_address_format']) {
      			$format = $sale_info['shipping_address_format'];
    		} else {
				$format = '{firstname} {lastname}' . "\n" . '{company}' . "\n" . '{address_1}' . "\n" . '{address_2}' . "\n" . '{city} {postcode}' . "\n" . '{zone}' . "\n" . '{country}';
			}
		
    		$find = array(
	  			'{firstname}',
	  			'{lastname}',
	  			'{company}',
      			'{address_1}',
      			'{address_2}',
     			'{city}',
      			'{postcode}',
      			'{zone}',
				'{zone_code}',
      			'{country}'
			);
	
			$replace = array(
	  			'firstname' => $sale_info['shipping_firstname'],
	  			'lastname'  => $sale_info['shipping_lastname'],
	  			'company'   => $sale_info['shipping_company'],
      			'address_1' => $sale_info['shipping_address_1'],
      			'address_2' => $sale_info['shipping_address_2'],
      			'city'      => $sale_info['shipping_city'],
      			'postcode'  => $sale_info['shipping_postcode'],
      			'zone'      => $sale_info['shipping_zone'],
				'zone_code' => $sale_info['shipping_zone_code'],
      			'country'   => $sale_info['shipping_country']  
			);

			$this->data['shipping_address'] = str_replace(array("\r\n", "\r", "\n"), '<br />', preg_replace(array("/\s\s+/", "/\r\r+/", "/\n\n+/"), '<br />', trim(str_replace($find, $replace, $format))));

			$this->data['shipping_method'] = $sale_info['shipping_method'];
			
			$this->data['products'] = array();
			
			if ($this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax') && $this->config->get('cpm_report_sales_tax_add')) {
				$text_total_calculation = $this->language->get('text_total') . ' - ' . $this->language->get('text_commission') . ' + ' . $this->language->get('text_tax');
			} elseif ($this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax') && !$this->config->get('cpm_report_sales_tax_add')) {
				$text_total_calculation = $this->language->get('text_total') . ' - ' . $this->language->get('text_commission') . ' - ' . $this->language->get('text_tax');
			} elseif ($this->config->get('cpm_report_sales_commission') && !$this->config->get('cpm_report_sales_tax')) {
				$text_total_calculation = $this->language->get('text_total') . ' - ' . $this->language->get('text_commission');			
			} elseif (!$this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax') && $this->config->get('cpm_report_sales_tax_add')) {
				$text_total_calculation = $this->language->get('text_total') . ' + ' . $this->language->get('text_tax');
			} elseif (!$this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax') && !$this->config->get('cpm_report_sales_tax_add')) {
				$text_total_calculation = $this->language->get('text_total') . ' - ' . $this->language->get('text_tax');
			} elseif (!$this->config->get('cpm_report_sales_commission') && !$this->config->get('cpm_report_sales_tax')) {
				$text_total_calculation = $this->language->get('text_total');
			} else {
				$text_total_calculation = '';
			}
		
			$total_sales = array('title' => $this->language->get('text_total'), 'text' => '', 'value' => 0);
			$total_commissions = array('title' => $this->language->get('text_commission'), 'text' => '', 'value' => 0);
			$total_tax = array('title' => $this->language->get('text_tax'), 'text' => '', 'value' => 0);
			$total_revenue = array('title' => $this->language->get('text_revenue') . ' (' . $this->language->get('text_total') . ' - ' . $this->language->get('text_commission') . ')', 'text' => '', 'value' => 0);
			$total_grand = array('title' => $this->language->get('text_grand_total') . ' (' . $text_total_calculation . ')', 'text' => '', 'value' => 0);
		
			$products = $this->model_account_sales->getSalesProducts($this->request->get['sale_id']);

			$this->load->model('tool/image');

      		foreach ($products as $product) {
				$option_data = array();
				
				$options = $this->model_account_sales->getSalesOptions($this->request->get['sale_id'], $product['order_product_id']);
        		
        		foreach ($options as $option) {
					if ($option['type'] != 'file') {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => $option['value'],
							'type'  => $option['type']
						);
					} else {
						$option_data[] = array(
							'name'  => $option['name'],
							'value' => utf8_substr($option['value'], 0, utf8_strrpos($option['value'], '.')),
							'type'  => $option['type'],
							'href'  => $this->url->link('account/sales/download', '&order_id=' . $this->request->get['sale_id'] . '&order_option_id=' . $option['order_option_id'], 'SSL')
						);						
					}
				}
							
				if ($product['image'] && file_exists(DIR_IMAGE . $product['image'])) {
					$image = $this->model_tool_image->resize($product['image'], 40, 40);
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', 40, 40);
				}
				
				if (!$this->config->get('cpm_report_sales_tax_add')) {
					$product['tax'] = -abs($product['tax']);
				}

        		$this->data['products'][] = array(
          			'name'		=> $product['name'],
					'image'		=> $image,
          			'model'		=> $product['model'],
          			'member'	=> $product['cpm_account_name'],
          			'option'	=> $option_data,
          			'quantity'	=> $product['quantity'],
          			'price'		=> $this->currency->format($product['price'] + ($this->config->get('config_tax') ? $product['tax'] : 0), $sale_info['currency_code'], $sale_info['currency_value']),
					'total'		=> $this->currency->format($product['total'] + ($this->config->get('config_tax') ? ($product['tax'] * $product['quantity']) : 0), $sale_info['currency_code'], $sale_info['currency_value']),
					//'return'   => $this->url->link('account/return/insert', 'sale_id=' . $sale_info['sale_id'] . '&product_id=' . $product['product_id'], 'SSL')
        		);
        		
				$total_sales['value'] += $product['total'] + ($this->config->get('config_tax') ? $product['tax'] * $product['quantity'] : 0);
				$total_commissions['value'] += $product['commission'];
				$total_tax['value'] += $product['tax'] * $product['quantity'];
      		}
      		
      		$total_revenue['value'] += $total_sales['value'] - $total_commissions['value'];
      		$total_grand['value'] += $total_sales['value'] - $total_commissions['value'] + $total_tax['value'];

			$total_sales['text'] = $this->currency->format($total_sales['value'], $sale_info['currency_code'], $sale_info['currency_value']);
			$total_commissions['text'] = '-&nbsp;' . $this->currency->format($total_commissions['value'], $sale_info['currency_code'], $sale_info['currency_value']);
			$total_tax['text'] = (!$this->config->get('cpm_report_sales_tax_add') ? '- ' : '') . $this->currency->format(abs($total_tax['value']), $sale_info['currency_code'], $sale_info['currency_value']);
			$total_revenue['text'] = $this->currency->format($total_revenue['value'], $sale_info['currency_code'], $sale_info['currency_value']);
			$total_grand['text'] = $this->currency->format($total_grand['value'], $sale_info['currency_code'], $sale_info['currency_value']);

			/* Voucher */
			$this->data['vouchers'] = array();
			
			$vouchers = $this->model_account_sales->getSalesVouchers($this->request->get['sale_id']);
			
			foreach ($vouchers as $voucher) {
				$this->data['vouchers'][] = array(
					'description' => $voucher['description'],
					'amount'      => $this->currency->format($voucher['amount'], $sale_info['currency_code'], $sale_info['currency_value'])
				);
			}
			
			if(!$this->config->get('cpm_report_sales_unique')) {
				$this->data['totals'] = $this->model_account_sales->getSalesTotals($this->request->get['sale_id']);
			} else {
				if ($this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax')) {
					$this->data['totals'] = array($total_sales, $total_commissions, $total_tax, $total_grand);
				} elseif ($this->config->get('cpm_report_sales_commission') && !$this->config->get('cpm_report_sales_tax')) {
					$this->data['totals'] = array($total_sales, $total_commissions, $total_grand);
				} elseif (!$this->config->get('cpm_report_sales_commission') && $this->config->get('cpm_report_sales_tax')) {
					$this->data['totals'] = array($total_sales, $total_tax, $total_grand);
				} else {
					$this->data['totals'] = array($total_sales);
				}
			}
			
			$this->data['comment'] = nl2br($sale_info['comment']);
			
			$this->data['sales_statuses'] = $this->model_account_sales->getSalesStatuses();

			$this->data['sales_status_id'] = $sale_info['order_status_id'];

      		$this->data['continue'] = $this->url->link('account/sales', '', 'SSL');
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/stylesheet/cpm.css')) {
				$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/' . $this->config->get('config_template') . '/stylesheet/cpm.css');
			} else {
				$this->document->addStyle(basename(DIR_APPLICATION) . '/view/theme/default/stylesheet/cpm.css');
			}
		
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/sales_info.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/account/sales_info.tpl';
			} else {
				$this->template = 'default/template/account/sales_info.tpl';
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
    	} else {
			$this->document->setTitle($this->language->get('text_sales'));
			
      		$this->data['heading_title'] = $this->language->get('text_sales');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');
			
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
				'href'      => $this->url->link('account/sales', '', 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
			
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_sales'),
				'href'      => $this->url->link('account/sales/info', 'sale_id=' . $sale_id, 'SSL'),
				'separator' => $this->language->get('text_separator')
			);
												
      		$this->data['continue'] = $this->url->link('account/sales', '', 'SSL');
			 			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
			} else {
				$this->template = 'default/template/error/not_found.tpl';
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
		
  	private function validateCustomer() {
		if (!$this->customer->getCustomerProductManager()) { 
			$this->error['warning'] = $this->language->get('error_permission');  
		}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

	public function history() {
		if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_report')) {  
			$this->session->data['redirect'] = $this->url->link('account/sales/info', 'sale_id=' . $this->request->get['sale_id'], 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$this->language->load('account/sales');

		$this->data['error'] = '';
		$this->data['success'] = '';

		$this->load->model('account/sales');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->config->get('cpm_report_sales_history') && (!$this->data['error'])) {
			$this->model_account_sales->addSalesHistory($this->request->get['sale_id'], $this->request->post);
			$this->data['success'] = $this->language->get('text_history_success');
		}

		$this->data['text_no_history'] = $this->language->get('text_no_history');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_comment'] = $this->language->get('column_comment');
      	$this->data['column_member'] = $this->language->get('column_member');
		$this->data['column_emailed'] = $this->language->get('column_emailed');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$this->data['histories'] = array();

		$results = $this->model_account_sales->getSalesHistories($this->request->get['sale_id'], ($page - 1) * 10, 10);

		foreach ($results as $result) {
			$this->data['histories'][] = array(
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'status'     => $result['status'],
				'comment'    => nl2br($result['comment']),
				'member'     => $result['member'] ? $result['member'] : $this->language->get('text_admin'),
				'emailed'    => $result['emailed'] ? $this->language->get('text_yes') : $this->language->get('text_no')
			);
		}

		$history_total = $this->model_account_sales->getTotalSaleHistories($this->request->get['sale_id']);

		$pagination = new Pagination();
		$pagination->total = $history_total;
		$pagination->page = $page;
		$pagination->limit = 12; 
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('account/sales/history', '&sale_id=' . $this->request->get['sale_id'] . '&page={page}', 'SSL');

		$this->data['pagination'] = $pagination->render();
		 			
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/account/sales_history.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/account/sales_history.tpl';
		} else {
			$this->template = 'default/template/account/sales_history.tpl';
		}

		$this->response->setOutput($this->render());
	}
	
	public function download() {
		if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status') || !$this->config->get('cpm_report')) {  
			$this->session->data['redirect'] = $this->url->link('account/sales/info', 'sale_id=' . $this->request->get['sale_id'], 'SSL');
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$this->load->model('account/sales');
		
		if (isset($this->request->get['order_option_id'])) {
			$order_option_id = $this->request->get['order_option_id'];
		} else {
			$order_option_id = 0;
		}
		
		$option_info = $this->model_account_sales->getSaleOption($this->request->get['order_id'], $order_option_id);
		
		if ($option_info && $option_info['type'] == 'file') {
			$file = DIR_DOWNLOAD . $option_info['value'];
			$mask = basename(utf8_substr($option_info['value'], 0, utf8_strrpos($option_info['value'], '.')));

			if (!headers_sent()) {
				if (file_exists($file)) {
					header('Content-Type: application/octet-stream');
					header('Content-Description: File Transfer');
					header('Content-Disposition: attachment; filename="' . ($mask ? $mask : basename($file)) . '"');
					header('Content-Transfer-Encoding: binary');
					header('Expires: 0');
					header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
					header('Pragma: public');
					header('Content-Length: ' . filesize($file));
					
					readfile($file, 'rb');
					exit;
				} else {
					exit('Error: Could not find file ' . $file . '!');
				}
			} else {
				exit('Error: Headers already sent out!');
			}
		} else {
			$this->load->language('error/not_found');

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