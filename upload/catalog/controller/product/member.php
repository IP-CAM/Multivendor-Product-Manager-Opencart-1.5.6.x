<?php 
class ControllerProductMember extends Controller { 
	public function index() {
		if (!$this->config->get('cpm_status') || !$this->config->get('cpm_member_pages')) {
			$this->redirect($this->url->link('common/home', '', 'SSL'));
		}
		
		$this->language->load('product/member');
		
		$this->load->model('catalog/member');
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image');

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} elseif ($this->config->get('cpm_member_sort')) {
			$sort = 'sort_order';
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

		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}
		
		// get Members List info from CPM Module config settings
		$language_id = (int)$this->config->get('config_language_id');
		$members_list_description = $this->config->get('cpm_members_list_description');
		
		$members_list_info = array(
			'name'					=> $members_list_description[$language_id]['name'],
			'description'			=> $members_list_description[$language_id]['description'],
			'meta_description'		=> $members_list_description[$language_id]['meta_description'],
			'meta_keyword'			=> $members_list_description[$language_id]['meta_keyword'],
			'image'					=> $this->config->get('cpm_members_list_image'),
			'keyword'				=> $this->config->get('cpm_members_list_keyword')
		);

		$text_members_list = (!empty($members_list_info['name']) ? $members_list_info['name'] : $this->language->get('heading_title'));
		
		$this->document->setTitle($text_members_list);
		
		if (!empty($members_list_info['meta_description'])) {
			$this->document->setDescription($members_list_info['meta_description']);
		}
		
		if (!empty($members_list_info['meta_keyword'])) {
			$this->document->setKeywords($members_list_info['meta_keyword']);
		}
				
		$this->data['heading_title'] = $text_members_list;
		
		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

		$this->data['breadcrumbs'] = array();
		
      	$this->data['breadcrumbs'][] = array(
        	'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
        	'separator' => false
      	);
		
		$this->data['breadcrumbs'][] = array(
			'text'      => $this->language->get('text_member'),
			'href'      => $this->url->link('product/member'),
			'separator' => $this->language->get('text_separator')
		);
		
		$this->data['text_index'] = $this->language->get('text_index');
		$this->data['text_empty_members'] = $this->language->get('text_empty_members');
		$this->data['text_products'] = $this->language->get('text_products');
		$this->data['text_sort'] = $this->language->get('text_sort');
		$this->data['text_limit'] = $this->language->get('text_limit');
		
		$this->data['button_continue'] = $this->language->get('button_continue');
		$this->data['button_back'] = $this->language->get('button_back');
		
		$this->load->model('tool/image'); 

		if (!empty($members_list_info['image'])) {
			$this->data['thumb'] = $this->model_tool_image->resize($members_list_info['image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
		} else {
			$this->data['thumb'] = false;
		}

		if (!empty($members_list_info['description'])) {
			$this->data['description'] = html_entity_decode($members_list_info['description'], ENT_QUOTES, 'UTF-8');
		} else {
			$this->data['description'] = false;
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

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}
		
		$this->data['categories'] = array();

		$data = array(
			'sort'               => $sort,
			'order'              => $order,
			'start'              => ($page - 1) * $limit,
			'limit'              => $limit
		);
		
		$members_total = $this->model_catalog_member->getTotalMembers($data); 
		
		$results = $this->model_catalog_member->getMembers($data);
		
		foreach ($results as $result) {
			$total_products = $this->model_catalog_product->getTotalProductsByCPMCustomerId($result['customer_id']);
			
			if ($total_products > 0) {
				if ($sort == 'sort_order') {
					$key = (int)$result['sort_order'];
				} elseif (is_numeric(utf8_substr($result['cpm_account_name'], 0, 1))) {
					$key = '0 - 9';
				} else {
					$key = utf8_substr(utf8_strtoupper($result['cpm_account_name']), 0, 1);
				}
				
				if (!isset($this->data['members'][$key])) {
					$this->data['categories'][$key]['cpm_account_name'] = $key;
					$this->data['categories'][$key]['href'] = $this->url->link('product/member', $url);
				}

				if ($result['cpm_account_image']) {
					$image = $this->model_tool_image->resize($result['cpm_account_image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				} else {
					$image = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
				}

				$this->data['categories'][$key]['member'][] = array(
					'name' => $result['cpm_account_name'],
					'image' => $image,
					'total_products' => $total_products,
					'href' => $this->url->link('product/member/info', 'member_id=' . $result['customer_id'] . $url)
				);
			}
		}

		$url = '';

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$this->data['sorts'] = array();

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_name_asc'),
			'value' => 'cpm_account_name-ASC',
			'href'  => $this->url->link('product/member', '&sort=cpm_account_name&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_name_desc'),
			'value' => 'cpm_account_name-DESC',
			'href'  => $this->url->link('product/member', '&sort=cpm_account_name&order=DESC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_sort_order_asc'),
			'value' => 'sort_order-ASC',
			'href'  => $this->url->link('product/member', '&sort=sort_order&order=ASC' . $url)
		);

		$this->data['sorts'][] = array(
			'text'  => $this->language->get('text_sort_order_desc'),
			'value' => 'sort_order-DESC',
			'href'  => $this->url->link('product/member', '&sort=sort_order&order=DESC' . $url)
		);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$this->data['limits'] = array();

		$limits = array_unique(array($this->config->get('config_catalog_limit'), 25, 50, 75, 100));

		sort($limits);

		foreach($limits as $value){
			$this->data['limits'][] = array(
				'text'  => $value,
				'value' => $value,
				'href'  => $this->url->link('product/member', $url . '&limit=' . $value)
			);
		}

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}	

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['limit'])) {
			$url .= '&limit=' . $this->request->get['limit'];
		}

		$pagination = new Pagination();
		$pagination->total = $members_total;
		$pagination->page = $page;
		$pagination->limit = $limit;
		$pagination->text = $this->language->get('text_pagination');
		$pagination->url = $this->url->link('product/member', $url . '&page={page}');

		$this->data['pagination'] = $pagination->render();

		$this->data['sort'] = $sort;
		$this->data['order'] = $order;
		$this->data['limit'] = $limit;
		
		$this->data['back'] = $this->url->link('common/home');

		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/member_list.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/product/member_list.tpl';
		} else {
			$this->template = 'default/template/product/member_list.tpl';
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
		if (!$this->config->get('cpm_status') || !$this->config->get('cpm_member_pages')) {
			$this->redirect($this->url->link('common/home', '', 'SSL'));
		}
		
    	$this->language->load('product/member');
		
		$this->load->model('catalog/member');
		
		$this->load->model('catalog/product');
		
		$this->load->model('tool/image'); 
		
		if (isset($this->request->get['member_id'])) {
			$member_id = (int)$this->request->get['member_id'];
		} else {
			$member_id = 0;
		} 
										
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'p.sort_order';
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
				
		if (isset($this->request->get['limit'])) {
			$limit = $this->request->get['limit'];
		} else {
			$limit = $this->config->get('config_catalog_limit');
		}

		$this->document->addScript('catalog/view/javascript/jquery/jquery.total-storage.min.js');

		$this->data['breadcrumbs'] = array();

   		$this->data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home'),
      		'separator' => false
   		);
   		
		$this->data['breadcrumbs'][] = array( 
       		'text'      => $this->language->get('text_member'),
			'href'      => $this->url->link('product/member'),
      		'separator' => $this->language->get('text_separator')
   		);
		
		$member_info = $this->model_catalog_member->getMember($member_id);
	
		if ($member_info) {
			$this->document->setTitle(ucwords($member_info['cpm_account_name']) . ' Member Profile'); // update to title
			
			if(isset($member_info['cpm_account_description'])){
				$this->document->setDescription($member_info['cpm_account_description']); // update to meta_description
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
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
		   			
			$this->data['breadcrumbs'][] = array(
       			'text'      => $member_info['cpm_account_name'],
				'href'      => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . $url),
      			'separator' => $this->language->get('text_separator')
   			);
		
			$this->data['heading_title'] = $member_info['cpm_account_name'];
			
			$this->data['member_account_name'] = $member_info['cpm_account_name'];
			
			$this->data['entry_cpm_custom_field_01'] = $this->config->get('cpm_custom_field_01');
			$this->data['entry_cpm_custom_field_02'] = $this->config->get('cpm_custom_field_02');
			$this->data['entry_cpm_custom_field_03'] = $this->config->get('cpm_custom_field_03');
			$this->data['entry_cpm_custom_field_04'] = $this->config->get('cpm_custom_field_04');
			$this->data['entry_cpm_custom_field_05'] = $this->config->get('cpm_custom_field_05');
			$this->data['entry_cpm_custom_field_06'] = $this->config->get('cpm_custom_field_06');
			$this->data['cpm_custom_field_01'] = (isset($member_info['cpm_custom_field_01']) ? $member_info['cpm_custom_field_01'] : '');
			$this->data['cpm_custom_field_02'] = (isset($member_info['cpm_custom_field_02']) ? $member_info['cpm_custom_field_02'] : '');
			$this->data['cpm_custom_field_03'] = (isset($member_info['cpm_custom_field_03']) ? $member_info['cpm_custom_field_03'] : '');
			$this->data['cpm_custom_field_04'] = (isset($member_info['cpm_custom_field_04']) ? $member_info['cpm_custom_field_04'] : '');
			$this->data['cpm_custom_field_05'] = (isset($member_info['cpm_custom_field_05']) ? $member_info['cpm_custom_field_05'] : '');
			$this->data['cpm_custom_field_06'] = (isset($member_info['cpm_custom_field_06']) ? $member_info['cpm_custom_field_06'] : '');
						
			if(!empty($member_info['cpm_account_description'])){
				$this->data['member_account_description'] = html_entity_decode($member_info['cpm_account_description'], ENT_QUOTES, 'UTF-8');
			} else {
				$this->data['member_account_description'] = '';
			}
			
			if(!empty($member_info['cpm_account_image'])) {
				$this->data['thumb'] = $this->model_tool_image->resize($member_info['cpm_account_image'], $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));
			} else {
				$this->data['thumb'] = $this->model_tool_image->resize('no_image.jpg', $this->config->get('config_image_category_width'), $this->config->get('config_image_category_height'));;
			}
			
			$this->data['text_empty_products'] = $this->language->get('text_empty_products');
			$this->data['text_quantity'] = $this->language->get('text_quantity');
			$this->data['text_member'] = $this->language->get('text_member');
			$this->data['text_model'] = $this->language->get('text_model');
			$this->data['text_price'] = $this->language->get('text_price');
			$this->data['text_tax'] = $this->language->get('text_tax');
			$this->data['text_points'] = $this->language->get('text_points');
			$this->data['text_compare'] = sprintf($this->language->get('text_compare'), (isset($this->session->data['compare']) ? count($this->session->data['compare']) : 0));
			$this->data['text_display'] = $this->language->get('text_display');
			$this->data['text_list'] = $this->language->get('text_list');
			$this->data['text_grid'] = $this->language->get('text_grid');			
			$this->data['text_sort'] = $this->language->get('text_sort');
			$this->data['text_limit'] = $this->language->get('text_limit');
			  
			$this->data['button_cart'] = $this->language->get('button_cart');
			$this->data['button_wishlist'] = $this->language->get('button_wishlist');
			$this->data['button_compare'] = $this->language->get('button_compare');
			$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['button_back'] = $this->language->get('button_back');
			
			$this->data['compare'] = $this->url->link('product/compare');
			
			$this->data['products'] = array();
			
			$data = array(
				'filter_member_id'		 => $member_id, 
				'sort'                   => $sort,
				'order'                  => $order,
				'start'                  => ($page - 1) * $limit,
				'limit'                  => $limit
			);
					
			$product_total = $this->model_catalog_product->getTotalProducts($data);
								
			$results = $this->model_catalog_product->getProducts($data);
					
			foreach ($results as $result) {
				if ($result['image']) {
					$image = $this->model_tool_image->resize($result['image'], $this->config->get('config_image_product_width'), $this->config->get('config_image_product_height'));
				} else {
					$image = false;
				}
				
				if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
					$price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$price = false;
				}
				
				if ((float)$result['special']) {
					$special = $this->currency->format($this->tax->calculate($result['special'], $result['tax_class_id'], $this->config->get('config_tax')));
				} else {
					$special = false;
				}	
				
				if ($this->config->get('config_tax')) {
					$tax = $this->currency->format((float)$result['special'] ? $result['special'] : $result['price']);
				} else {
					$tax = false;
				}				
				
				if ($this->config->get('config_review_status')) {
					$rating = (int)$result['rating'];
				} else {
					$rating = false;
				}
			
				$this->data['products'][] = array(
					'product_id'  => $result['product_id'],
					'thumb'       => $image,
					'name'        => $result['name'],
					'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, 100) . '..',
					'price'       => $price,
					'special'     => $special,
					'tax'         => $tax,
					'rating'      => $result['rating'],
					'reviews'     => sprintf($this->language->get('text_reviews'), (int)$result['reviews']),
					'href'        => $this->url->link('product/product', $url . '&member_id=' . $result['member_id'] . '&product_id=' . $result['product_id'])
				);
			}
					
			$url = '';
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
						
			$this->data['sorts'] = array();
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_default'),
				'value' => 'p.sort_order-ASC',
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=p.sort_order&order=ASC' . $url)
			);
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_asc'),
				'value' => 'pd.name-ASC',
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=pd.name&order=ASC' . $url)
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_name_desc'),
				'value' => 'pd.name-DESC',
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=pd.name&order=DESC' . $url)
			);
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_asc'),
				'value' => 'p.price-ASC',
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=p.price&order=ASC' . $url)
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_price_desc'),
				'value' => 'p.price-DESC',
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=p.price&order=DESC' . $url)
			); 
			
			if ($this->config->get('config_review_status')) {
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_desc'),
					'value' => 'rating-DESC',
					'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=rating&order=DESC' . $url)
				); 
				
				$this->data['sorts'][] = array(
					'text'  => $this->language->get('text_rating_asc'),
					'value' => 'rating-ASC',
					'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=rating&order=ASC' . $url)
				);
			}
			
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_asc'),
				'value' => 'p.model-ASC',
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=p.model&order=ASC' . $url)
			); 
	
			$this->data['sorts'][] = array(
				'text'  => $this->language->get('text_model_desc'),
				'value' => 'p.model-DESC',
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . '&sort=p.model&order=DESC' . $url)
			);
	
			$url = '';
					
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->data['limits'] = array();
			
			$this->data['limits'][] = array(
				'text'  => $this->config->get('config_catalog_limit'),
				'value' => $this->config->get('config_catalog_limit'),
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . $url . '&limit=' . $this->config->get('config_catalog_limit'))
			);
						
			$this->data['limits'][] = array(
				'text'  => 25,
				'value' => 25,
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . $url . '&limit=25')
			);
			
			$this->data['limits'][] = array(
				'text'  => 50,
				'value' => 50,
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . $url . '&limit=50')
			);
	
			$this->data['limits'][] = array(
				'text'  => 75,
				'value' => 75,
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . $url . '&limit=75')
			);
			
			$this->data['limits'][] = array(
				'text'  => 100,
				'value' => 100,
				'href'  => $this->url->link('product/member/info', 'member_id=' . $this->request->get['member_id'] . $url . '&limit=100')
			);
					
			$url = '';
							
			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}	
	
			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
					
			$pagination = new Pagination();
			$pagination->total = $product_total;
			$pagination->page = $page;
			$pagination->limit = $limit;
			$pagination->text = $this->language->get('text_pagination');
			$pagination->url = $this->url->link('product/member/info','member_id=' . $this->request->get['member_id'] .  $url . '&page={page}');
			
			$this->data['pagination'] = $pagination->render();
			
			$this->data['sort'] = $sort;
			$this->data['order'] = $order;
			$this->data['limit'] = $limit;
			
			$this->data['continue'] = $this->url->link('common/home');
			$this->data['back'] = $this->url->link('product/member');
			
			$this->model_catalog_member->updateViewed($this->request->get['member_id']);
			
			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/product/member_info.tpl')) {
				$this->template = $this->config->get('config_template') . '/template/product/member_info.tpl';
			} else {
				$this->template = 'default/template/product/member_info.tpl';
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
			$url = '';
			
			if (isset($this->request->get['member_id'])) {
				$url .= '&member_id=' . $this->request->get['member_id'];
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
						
			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}
						
			$this->data['breadcrumbs'][] = array(
				'text'      => $this->language->get('text_error'),
				'href'      => $this->url->link('product/member', $url),
				'separator' => $this->language->get('text_separator')
			);
				
			$this->document->setTitle($this->language->get('text_error'));

      		$this->data['heading_title'] = $this->language->get('text_error');

      		$this->data['text_error'] = $this->language->get('text_error');

      		$this->data['button_continue'] = $this->language->get('button_continue');
			$this->data['button_back'] = $this->language->get('button_back');

      		$this->data['continue'] = $this->url->link('common/home');
			$this->data['back'] = $this->url->link('product/member');

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
}
?>