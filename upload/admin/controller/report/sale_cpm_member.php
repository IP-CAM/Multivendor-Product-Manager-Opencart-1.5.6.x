<?php
class ControllerReportSaleCPMMember extends Controller { 
	public function index() {  
		$this->load->language('report/sale_cpm_member');

		$this->document->setTitle($this->language->get('heading_title'));

		if (isset($this->request->get['filter_date_start'])) {
			$filter_date_start = $this->request->get['filter_date_start'];
		} else {
			$filter_date_start = date('Y-m-d', strtotime(date('Y') . '-' . date('m') . '-01'));
		}

		if (isset($this->request->get['filter_date_end'])) {
			$filter_date_end = $this->request->get['filter_date_end'];
		} else {
			$filter_date_end = date('Y-m-d');
		}
		
		if (isset($this->request->get['filter_group'])) {
			$filter_group = $this->request->get['filter_group'];
		} else {
			$filter_group = 'order';
		}
		
		if (isset($this->request->get['filter_order_status_id'])) {
			$filter_order_status_id = $this->request->get['filter_order_status_id'];
		} else {
			$filter_order_status_id = 0;
		}
		
		if (isset($this->request->get['filter_cpm_customer_id'])) {
			$filter_cpm_customer_id = $this->request->get['filter_cpm_customer_id'];
		} else {
			$filter_cpm_customer_id = 0;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'o.order_id';
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
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		
		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}		

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}		

		if (isset($this->request->get['filter_cpm_customer_id'])) {
			$url .= '&filter_cpm_customer_id=' . $this->request->get['filter_cpm_customer_id'];
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
			'href'      => $this->url->link('report/sale_cpm_member', 'token=' . $this->session->data['token'] . $url, 'SSL'),
      		'separator' => ' :: '
   		);

		$this->data['heading_title'] = $this->language->get('heading_title');
		
		$this->data['text_no_results'] = $this->language->get('text_no_results');
		$this->data['text_all_status'] = $this->language->get('text_all_status');
		$this->data['text_all_members'] = $this->language->get('text_all_members');
		$this->data['text_total'] = $this->language->get('text_total');
		$this->data['text_sales'] = $this->language->get('text_sales');
		$this->data['text_revenue'] = $this->language->get('text_revenue');
		$this->data['text_commission'] = $this->language->get('text_commission');
		$this->data['text_tax'] = $this->language->get('text_tax');
		$this->data['text_shipping'] = $this->language->get('text_shipping'); // ship
		$this->data['text_insurance'] = $this->language->get('text_insurance'); // ship
		$this->data['text_total_calculation'] = $this->language->get('text_sales') . ' - ' . $this->language->get('text_commission') . ' + ' . $this->language->get('text_tax');
		if ($this->config->get('cpm_shipping_enabled')) {
			$this->data['text_total_calculation'] .= ' + ' . $this->language->get('text_shipping') . ' + ' . $this->language->get('text_insurance');
		}
		
		$this->data['column_date_start'] = $this->language->get('column_date_start');
		$this->data['column_date_end'] = $this->language->get('column_date_end');
    	$this->data['column_orders'] = $this->language->get('column_orders');
		$this->data['column_products'] = $this->language->get('column_products');
		$this->data['column_tax'] = $this->language->get('column_tax');
		$this->data['column_total'] = $this->language->get('column_total');
		$this->data['column_action'] = $this->language->get('column_action');
		
		$this->data['column_order_id'] = $this->language->get('column_order_id');
		$this->data['column_status'] = $this->language->get('column_status');
		$this->data['column_date_added'] = $this->language->get('column_date_added');
		$this->data['column_customer'] = $this->language->get('column_customer');
		$this->data['column_member'] = $this->language->get('column_member');
		$this->data['column_paypal'] = $this->language->get('column_paypal');
		$this->data['column_sales'] = $this->language->get('column_sales');
		$this->data['column_revenue'] = $this->language->get('column_revenue');
		$this->data['column_commission'] = $this->language->get('column_commission');
		$this->data['column_order_status'] = $this->language->get('column_order_status');
		$this->data['column_shipping'] = $this->language->get('column_shipping');		// ship
		$this->data['column_insurance'] = $this->language->get('column_insurance');		// ship
		
		$this->data['entry_date_start'] = $this->language->get('entry_date_start');
		$this->data['entry_date_end'] = $this->language->get('entry_date_end');
		$this->data['entry_member'] = $this->language->get('entry_member');	
		$this->data['entry_group'] = $this->language->get('entry_group');	
		$this->data['entry_status'] = $this->language->get('entry_status');

		$this->data['button_filter'] = $this->language->get('button_filter');
		$this->data['button_view'] = $this->language->get('button_view');
		$this->data['button_pay'] = $this->language->get('button_pay');  // pay
		$this->data['button_pay'] = $this->language->get('button_pay');  // pay
		$this->data['button_send_money'] = $this->language->get('button_send_money');  // pay
		
		$this->data['token'] = $this->session->data['token'];
		
		$this->load->model('localisation/order_status');
		
		$this->data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$this->data['groups'] = array();

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_order'),
			'value' => 'order'
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_year'),
			'value' => 'year'
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_month'),
			'value' => 'month'
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_week'),
			'value' => 'week'
		);

		$this->data['groups'][] = array(
			'text'  => $this->language->get('text_day'),
			'value' => 'day'
		);
		
		$this->load->model('report/sale_cpm_member');
			
		$total_products = 0;
		$total_commissions = 0;
		$total_tax = 0;
		$total_grand = 0;
		$total_shipping = 0; // ship
		$total_insurance = 0; // ship
		$currencies = array();
		
		$this->data['orders'] = array();
		$this->data['totals'] = array();
		
		$data = array(
			'filter_date_start'	     => $filter_date_start, 
			'filter_date_end'	     => $filter_date_end, 
			'filter_group'           => $filter_group,
			'filter_order_status_id' => $filter_order_status_id,
			'filter_cpm_customer_id' => $filter_cpm_customer_id,
			'cpm_shipping_enabled'	 => ($this->config->get('cpm_shipping_enabled') ? $this->config->get('cpm_shipping_enabled') : ''),
			'sort'                   => $sort,
			'order'                  => $order,
			'start'                  => ($page - 1) * $this->config->get('config_admin_limit'),
			'limit'                  => $this->config->get('config_admin_limit')
		);
		
		$this->data['members'] = $this->model_report_sale_cpm_member->getOrdersCPMMembers($data);

		$order_total = $this->model_report_sale_cpm_member->getTotalOrders($data);
		
		$results = $this->model_report_sale_cpm_member->getOrders($data);
		
		foreach ($results as $result) {
			// $product_total = $this->model_report_sale_cpm_member->getTotalOrderProductsByOrderId($result['order_id']);
			
			if ($this->config->get('cpm_shipping_enabled')) {
				$total = $result['products_total'] + $result['products_tax'] + $result['package_shipping'] + $result['package_insurance'] - $result['products_commission']; // ship
			} else {
				$total = $result['products_total'] + $result['products_tax'] - $result['products_commission'];
			}
			
			$total_formatted = number_format($total, 2, '.', '');

			$this->data['orders'][] = array(
				'date_start' => date($this->language->get('date_format_short'), strtotime($result['date_start'])),
				'date_end'   => date($this->language->get('date_format_short'), strtotime($result['date_end'])),
				'orders'     => $result['orders'],
				'products'   => $result['products'],
				'revenue'	 => $this->currency->format(($result['products_total'] - $result['products_commission']), $result['currency_code'], $result['currency_value']),
				'sales'		 => $this->currency->format($result['products_total'], $result['currency_code'], $result['currency_value']),
				'total'      => $this->currency->format($total, $result['currency_code'], $result['currency_value']),
				'commission' => $this->currency->format($result['products_commission'], $result['currency_code'], $result['currency_value']),
				'tax'		 => $this->currency->format($result['products_tax'], $result['currency_code'], $result['currency_value']),
				'shipping'	 => ($this->config->get('cpm_shipping_enabled') ? $this->currency->format($result['package_shipping'], $result['currency_code'], $result['currency_value']) : ''),		// ship		
				'insurance'	 => ($this->config->get('cpm_shipping_enabled') ? $this->currency->format($result['package_insurance'], $result['currency_code'], $result['currency_value']) : ''),		// ship	
				'order_id'   => $result['order_id'],
				'name'       => $result['lastname'] . ', ' . $result['firstname'],
				'status'     => $result['status'],
				'date_added' => date($this->language->get('date_format_short'), strtotime($result['date_added'])),
				'member_id'  => $result['cpm_customer_id'],
				'member_url' => $this->url->link('sale/customer/update', 'token=' . $this->session->data['token'] . '&customer_id=' . $result['cpm_customer_id'] . '&filter_cpm_status=1', 'SSL'),
				'member'	 => $result['cpm_account_name'],
				'paypal'	 => $result['cpm_paypal_account'],
				'pay'     	 => 'https://www.paypal.com/cgi-bin/webscr?business=' . $result['cpm_paypal_account'] . '&cmd=_xclick&currency_code=USD&amount=' . $total_formatted . '&item_name=' . 'Sales%20Order%20' . $result['order_id'],
				'send_money' => 'https://www.paypal.com/us/cgi-bin/webscr?cmd=%5fsend%2dmoney&nav=1?email=' . $result['cpm_paypal_account'] . '&sender_email=' . $this->config->get('cpm_paypal_email') . '&amount_ccode=USD&country_name=US&amount=' . $total_formatted . '&payment_type=Gift&item_name=' . 'Sales%20Order%20' . $result['order_id'],
				'href'       => $this->url->link('sale/order/info', 'token=' . $this->session->data['token'] . '&order_id=' . $result['order_id'], 'SSL')
			);
			
			// keep track of currencies
			if (!array_key_exists($result['currency_code'], $currencies)) {
				$currencies[$result['currency_code']] = $result['currency_value'];
			}
			// calculate totals only if not more than one currency
			if (count($currencies) <= 1) {
				$total_products += $result['products']; // $product_total;
				$total_commissions += $result['products_commission'];
				
				if ($this->config->get('cpm_shipping_enabled')) {
					$total_shipping += $result['package_shipping'];		// ship
					$total_insurance += $result['package_insurance'];	// ship
				}
				
				$total_tax += $result['products_tax'];
				$total_grand += $result['products_total'];
			}
		}
		
		// totals only relevant if every sale made in the same currency
		if (count($currencies) == 1) {
			foreach ($currencies as $key => $value) {
				$this->data['totals']['products'] = $total_products;
				$this->data['totals']['commissions'] = $this->currency->format($total_commissions, $key, $value);
				$this->data['totals']['shipping'] = $this->currency->format($total_shipping, $key, $value);		// ship	
				$this->data['totals']['insurance'] = $this->currency->format($total_insurance, $key, $value);	// ship
				$this->data['totals']['tax'] = $this->currency->format($total_tax, $key, $value); // display tax?
				$this->data['totals']['sales'] = $this->currency->format($total_grand, $key, $value);	
					
				if ($this->config->get('cpm_shipping_enabled')) {
					$this->data['totals']['grand'] = $this->currency->format($total_grand + $total_tax + $total_shipping + $total_insurance - $total_commissions, $key, $value); // ship
				} else {
					$this->data['totals']['grand'] = $this->currency->format($total_grand + $total_tax - $total_commissions, $key, $value);
				}
				
				$this->data['totals']['revenue'] = $this->currency->format($total_grand - $total_commissions, $key, $value);
			}
		}
		
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
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		
		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}		

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}		

		if (isset($this->request->get['filter_cpm_customer_id'])) {
			$url .= '&filter_cpm_customer_id=' . $this->request->get['filter_cpm_customer_id'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$this->data['sort_order'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.order_id' . $url, 'SSL');
		$this->data['sort_customer'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=customer' . $url, 'SSL');
		$this->data['sort_status'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=status' . $url, 'SSL');
		$this->data['sort_total'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.total' . $url, 'SSL');
		$this->data['sort_date_added'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_added' . $url, 'SSL');
		$this->data['sort_date_modified'] = $this->url->link('sale/order', 'token=' . $this->session->data['token'] . '&sort=o.date_modified' . $url, 'SSL');

		$url = '';
						
		if (isset($this->request->get['filter_date_start'])) {
			$url .= '&filter_date_start=' . $this->request->get['filter_date_start'];
		}
		
		if (isset($this->request->get['filter_date_end'])) {
			$url .= '&filter_date_end=' . $this->request->get['filter_date_end'];
		}
		
		if (isset($this->request->get['filter_group'])) {
			$url .= '&filter_group=' . $this->request->get['filter_group'];
		}		

		if (isset($this->request->get['filter_order_status_id'])) {
			$url .= '&filter_order_status_id=' . $this->request->get['filter_order_status_id'];
		}		

		if (isset($this->request->get['filter_cpm_customer_id'])) {
			$url .= '&filter_cpm_customer_id=' . $this->request->get['filter_cpm_customer_id'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
				
		$pagination = new Pagination();
		$pagination->total = $order_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_admin_limit');
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('report/sale_cpm_member', 'token=' . $this->session->data['token'] . $url . '&page={page}', 'SSL');
			
		$this->data['pagination'] = $pagination->render();		

		$this->data['filter_date_start'] = $filter_date_start;
		$this->data['filter_date_end'] = $filter_date_end;		
		$this->data['filter_group'] = $filter_group;
		$this->data['filter_order_status_id'] = $filter_order_status_id;
		$this->data['filter_cpm_customer_id'] = $filter_cpm_customer_id;

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
				 
		$this->template = 'report/sale_cpm_member.tpl';
		$this->children = array(
			'common/header',
			'common/footer'
		);
				
		$this->response->setOutput($this->render());
	}
}
?>