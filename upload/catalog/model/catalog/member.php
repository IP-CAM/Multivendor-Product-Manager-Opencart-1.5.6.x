<?php
class ModelCatalogMember extends Model {
	public function getMember($cpm_customer_id) {
		$query = $this->db->query("SELECT *, CONCAT(c.firstname, ', ', c.lastname) AS name, (SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'member_id=" . (int)$cpm_customer_id . "') AS keyword 
		FROM " . DB_PREFIX . "customer_cpm_account cpm
		INNER JOIN " . DB_PREFIX . "customer c ON cpm.customer_id = c.customer_id
		WHERE cpm.customer_id = '" . (int)$cpm_customer_id . "'
		AND c.status = '1'
		AND c.cpm_enabled = '1'
		AND c.approved = '1'");
		return $query->row;	
	}

	public function getMemberIdByCustomerId($cpm_customer_id) {
		$query = $this->db->query("SELECT cpm_account_id FROM " . DB_PREFIX . "customer_cpm_account WHERE customer_id = '" . (int)$cpm_customer_id . "'");
		return $query->row['cpm_account_id'];
	}
	
	public function getMembers($data = array()) {
		$cache = md5(http_build_query($data));
				
		$member_data = $this->cache->get('member.' . (int)$this->config->get('config_store_id') . '.' . $cache);
		
		if (!$member_data) {
			$sql = "SELECT *, CONCAT(c.firstname, ', ', c.lastname) AS fullname 	
			FROM " . DB_PREFIX . "customer_cpm_account cpm
			INNER JOIN " . DB_PREFIX . "customer c ON cpm.customer_id = c.customer_id
			WHERE c.status = '1' 
			AND c.cpm_enabled = '1' 
			AND c.approved = '1'";
	
			$sort_data = array(
				'cpm_account_name',
				'cpm.date_added',
				'sort_order'
			);
	
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY cpm_account_name";	
			}
	
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
	
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
	
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}
			
			$member_data = array();
					
			$query = $this->db->query($sql);
			
			$member_data = $query->rows;
			
			$this->cache->set('member.' . (int)$this->config->get('config_store_id') . '.' . $cache, $member_data);		
		}
			 
		return $member_data;
	}

	public function addMember($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_cpm_account SET customer_id = '" . (int)$data['customer_id'] . "', cpm_account_name = '" . $this->db->escape($data['cpm_account_name']) . "', cpm_account_description = '" . $this->db->escape($data['cpm_account_description']) . "', cpm_custom_field_01 = '" . $this->db->escape($data['cpm_custom_field_01']) . "', cpm_custom_field_02 = '" . $this->db->escape($data['cpm_custom_field_02']) . "', cpm_custom_field_03 = '" . $this->db->escape($data['cpm_custom_field_03']) . "', cpm_custom_field_04 = '" . $this->db->escape($data['cpm_custom_field_04']) . "', cpm_custom_field_05 = '" . $this->db->escape($data['cpm_custom_field_05']) . "', cpm_custom_field_06 = '" . $this->db->escape($data['cpm_custom_field_06']) . "', cpm_directory_images = '" . $this->config->get('cpm_image_upload_directory')  . "', cpm_directory_downloads = '" . $this->config->get('cpm_download_directory') . "', cpm_paypal_account = '" . $this->db->escape($data['cpm_paypal_account']) . "', cpm_max_products = '" . (int)$this->config->get('cpm_products_max') . "', cpm_commission_rate = '" . (float)$this->config->get('cpm_commission_rate') . "', sort_order = '" . (int)$data['sort_order'] . "', viewed = '" . (int)$data['viewed'] . "', date_added = NOW()");
		$cpm_account_id = $this->db->getLastId();

		// CPM Product Manager automatically enabled for new Member Accounts, but approval is still dependent upon Customer Group settings
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cpm_enabled = '1' WHERE customer_id = '" . (int)$data['customer_id'] . "'");

		if (isset($data['cpm_account_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_account_image = '" . $this->db->escape($data['cpm_account_image']) . "' WHERE cpm_account_id = '" . (int)$cpm_account_id . "'");
		}
								
		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'member_id=" . (int)$data['customer_id'] . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		if (!empty($data['cpm_directory_images'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_directory_images = '" .  $this->db->escape($data['cpm_directory_images']) . "' WHERE cpm_account_id = '" . (int)$cpm_account_id . "'");
		}
		
		if (!empty($data['cpm_directory_downloads'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_directory_downloads = '" . $this->db->escape($data['cpm_directory_downloads']) . "' WHERE cpm_account_id = '" . (int)$cpm_account_id . "'");
		}
				
		// multi-language and multi-store (coming next release)
		/*
		foreach ($data['meta_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_cpm_account_description SET cpm_account_id = '" . (int)$cpm_account_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', title = '" . $this->db->escape($value['title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}

		if (isset($data['member_store'])) {
			foreach ($data['member_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_cpm_account_to_store SET cpm_account_id = '" . (int)$cpm_account_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		*/
		
		$this->cache->delete('member');
	}

	public function editMember($data) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET firstname = '" . $this->db->escape($data['firstname']) . "', lastname = '" . $this->db->escape($data['lastname']) . "', email = '" . $this->db->escape($data['email']) . "', telephone = '" . $this->db->escape($data['telephone']) . "', fax = '" . $this->db->escape($data['fax']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_account_name = '" . $this->db->escape($data['cpm_account_name']) . "', cpm_account_description = '" . $this->db->escape($data['cpm_account_description']) . "', cpm_custom_field_01 = '" . $this->db->escape($data['cpm_custom_field_01']) . "', cpm_custom_field_02 = '" . $this->db->escape($data['cpm_custom_field_02']) . "', cpm_custom_field_03 = '" . $this->db->escape($data['cpm_custom_field_03']) . "', cpm_custom_field_04 = '" . $this->db->escape($data['cpm_custom_field_04']) . "', cpm_custom_field_05 = '" . $this->db->escape($data['cpm_custom_field_05']) . "', cpm_custom_field_06 = '" . $this->db->escape($data['cpm_custom_field_06']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
				
		if (!empty($data['cpm_account_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_account_image = '" . $this->db->escape($data['cpm_account_image']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}
		
		if (!empty($data['cpm_paypal_account'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_paypal_account = '" . $this->db->escape($data['cpm_paypal_account']) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}
		
		// multi-language and multi-store (coming next release)
		/* 
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_cpm_account_description WHERE member_id = '" . (int)$member_id . "'");

		foreach ($data['member_description'] as $language_id => $value) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "customer_cpm_account_description SET cpm_account_id = '" . (int)$cpm_account_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "', description = '" . $this->db->escape($value['description']) . "', title = '" . $this->db->escape($value['title']) . "', meta_description = '" . $this->db->escape($value['meta_description']) . "', meta_keywords = '" . $this->db->escape($value['meta_keywords']) . "', tag = '" . $this->db->escape($value['tag']) . "'");
		}

		if (isset($data['member_store'])) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "customer_cpm_account_to_store WHERE cpm_account_id = '" . (int)$cpm_account_id . "'");
			foreach ($data['member_store'] as $store_id) {
				$this->db->query("INSERT INTO " . DB_PREFIX . "customer_cpm_account_to_store SET cpm_account_id = '" . (int)$cpm_account_id . "', store_id = '" . (int)$store_id . "'");
			}
		}
		*/

		if (!empty($data['keyword'])) {
			$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'member_id=" . (int)$this->customer->getId() . "'");
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'member_id=" . (int)$this->customer->getId() . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}

		$this->cache->delete('member');
	}

	public function getTotalMembers($data = array()) {
		$sql = "SELECT COUNT(DISTINCT cpm.cpm_account_id) AS total 	
			FROM " . DB_PREFIX . "customer_cpm_account cpm
			INNER JOIN " . DB_PREFIX . "customer c ON cpm.customer_id = c.customer_id
			WHERE c.status = '1' 
			AND c.cpm_enabled = '1' 
			AND c.approved = '1'";

		$query = $this->db->query($sql);

		return $query->row['total'];
	}

	public function updateViewed($member_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET viewed = (viewed + 1) WHERE customer_id = '" . (int)$member_id . "'");
	}
	
}
?>