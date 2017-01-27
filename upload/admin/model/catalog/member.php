<?php
class ModelCatalogMember extends Model {
	public function addMember($data) {
		$this->db->query("INSERT INTO " . DB_PREFIX . "customer_cpm_account SET customer_id = '" . (int)$data['customer_id'] . "', cpm_account_name = '" . $this->db->escape($data['cpm_account_name']) . "', cpm_account_description = '" . $this->db->escape($data['cpm_account_description']) . "', cpm_custom_field_01 = '" . $this->db->escape($data['cpm_custom_field_01']) . "', cpm_custom_field_02 = '" . $this->db->escape($data['cpm_custom_field_02']) . "', cpm_custom_field_03 = '" . $this->db->escape($data['cpm_custom_field_03']) . "', cpm_custom_field_04 = '" . $this->db->escape($data['cpm_custom_field_04']) . "', cpm_custom_field_05 = '" . $this->db->escape($data['cpm_custom_field_05']) . "', cpm_custom_field_06 = '" . $this->db->escape($data['cpm_custom_field_06']) . "', cpm_paypal_account = '" . $this->db->escape($data['cpm_paypal_account']) . "', cpm_max_products = '" . (int)$data['cpm_max_products'] . "', cpm_commission_rate = '" . (float)$data['cpm_commission_rate'] . "',  sort_order = '" . (int)$data['sort_order'] . "', viewed = '" . (int)$data['viewed'] . "', date_added = NOW()");
		$cpm_account_id = $this->db->getLastId();
		
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cpm_enabled = '1' WHERE customer_id = '" . (int)$data['customer_id'] . "'");

		if (!empty($data['cpm_account_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_account_image = '" . $this->db->escape($data['cpm_account_image']) . "' WHERE cpm_account_id = '" . (int)$cpm_account_id . "'");
		}
						
		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'member_id=" . (int)$data['customer_id'] . "', keyword = '" . $this->db->escape($data['keyword']) . "'");			
		}
		
		//cpm_directory_images = '" . $this->db->escape($data['cpm_directory_images']) . "', cpm_directory_downloads = '" . $this->db->escape($data['cpm_directory_downloads']) . "', 
		
		if (!empty($data['cpm_directory_images'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_directory_images = '" .  $this->db->escape($data['cpm_directory_images']) . "' WHERE cpm_account_id = '" . (int)$cpm_account_id . "'");
		}
		
		if (!empty($data['cpm_directory_downloads'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_directory_downloads = '" . $this->db->escape($data['cpm_directory_downloads']) . "' WHERE cpm_account_id = '" . (int)$cpm_account_id . "'");
		}
		
		// multi-language and multi-store (coming in future release)
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

	public function editMember($member_id, $data) {		
		$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_account_name = '" . $this->db->escape($data['cpm_account_name']) . "', cpm_account_description = '" . $this->db->escape($data['cpm_account_description']) . "', cpm_account_image = '" . $this->db->escape($data['cpm_account_image']) . "', cpm_custom_field_01 = '" . $this->db->escape($data['cpm_custom_field_01']) . "', cpm_custom_field_02 = '" . $this->db->escape($data['cpm_custom_field_02']) . "', cpm_custom_field_03 = '" . $this->db->escape($data['cpm_custom_field_03']) . "', cpm_custom_field_04 = '" . $this->db->escape($data['cpm_custom_field_04']) . "', cpm_custom_field_05 = '" . $this->db->escape($data['cpm_custom_field_05']) . "', cpm_custom_field_06 = '" . $this->db->escape($data['cpm_custom_field_06']) . "', cpm_directory_images = '" . $this->db->escape($data['cpm_directory_images']) . "', cpm_directory_downloads = '" . $this->db->escape($data['cpm_directory_downloads']) . "', cpm_paypal_account = '" . $this->db->escape($data['cpm_paypal_account']) . "', cpm_max_products = '" . (int)$data['cpm_max_products'] . "', cpm_commission_rate = '" . (float)$data['cpm_commission_rate'] . "', sort_order = '" . (int)$data['sort_order'] . "', viewed = '" . (int)$data['viewed'] . "' WHERE customer_id = '" . (int)$member_id . "'");

		if (isset($data['cpm_enabled'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET cpm_enabled = '" . (int)$data['cpm_enabled'] . "' WHERE customer_id = '" . (int)$member_id . "'");
		}
		
		if ($data['customer_id'] != $member_id) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET cpm_enabled = '1' WHERE customer_id = '" . (int)$data['customer_id'] . "'");
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET cpm_enabled = '0' WHERE customer_id = '" . (int)$member_id . "'");
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET customer_id = '" . (int)$data['customer_id'] . "' WHERE customer_id = '" . (int)$member_id . "'");
			$this->db->query("UPDATE " . DB_PREFIX . "product SET cpm_customer_id = '" . (int)$data['customer_id'] . "' WHERE cpm_customer_id = '" . (int)$member_id . "'");
			$this->db->query("UPDATE " . DB_PREFIX . "download SET cpm_customer_id = '" . (int)$data['customer_id'] . "' WHERE cpm_customer_id = '" . (int)$member_id . "'");
			$this->db->query("UPDATE " . DB_PREFIX . "order_history SET cpm_customer_id = '" . (int)$data['customer_id'] . "' WHERE cpm_customer_id = '" . (int)$member_id . "'");
			$this->db->query("UPDATE " . DB_PREFIX . "order_product SET cpm_customer_id = '" . (int)$data['customer_id'] . "' WHERE cpm_customer_id = '" . (int)$member_id . "'");
		}		

		// $this->db->query("DELETE cpm_account_image FROM " . DB_PREFIX . "customer_cpm_account WHERE customer_id = '" . (int)$customer_id . "'");
		/*
		if (isset($data['cpm_account_image'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_account_image = '" . $this->db->escape($data['cpm_account_image']) . "' WHERE customer_id = '" . (int)$member_id . "'");
		}
		*/
		
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'member_id=" . (int)$member_id. "'");

		if (!empty($data['keyword'])) {
			$this->db->query("INSERT INTO " . DB_PREFIX . "url_alias SET query = 'member_id=" . (int)$member_id . "', keyword = '" . $this->db->escape($data['keyword']) . "'");
		}
		
		$this->cache->delete('member');
	}

	public function deleteMember($member_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "customer_cpm_account WHERE customer_id = '" . (int)$member_id . "'");
		$this->db->query("DELETE FROM " . DB_PREFIX . "url_alias WHERE query = 'member_id=" . (int)$member_id. "'");
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cpm_enabled = '0' WHERE customer_id = '" . (int)$member_id . "'");
	}

	public function getMember($member_id) {
		$sql = "SELECT DISTINCT *, cpm.customer_id AS member_id, CONCAT(c.lastname, ', ', c.firstname) AS customer_name,
				(SELECT keyword FROM " . DB_PREFIX . "url_alias WHERE query = 'member_id=" . (int)$member_id . "') AS keyword 
				FROM " . DB_PREFIX . "customer_cpm_account cpm LEFT JOIN " . DB_PREFIX . "customer c ON (cpm.customer_id = c.customer_id) 
				WHERE cpm.customer_id = '" . (int)$member_id . "'";
				
		$query = $this->db->query($sql);
		return $query->row;
	}

	public function getMembers($data = array()) {
		$sql = "SELECT *, cpm.customer_id AS member_id, CONCAT(c.lastname, ', ', c.firstname) AS customer_name, cgd.name AS customer_group 
				FROM " . DB_PREFIX . "customer_cpm_account cpm 
				LEFT JOIN " . DB_PREFIX . "customer c ON (cpm.customer_id = c.customer_id)
				LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) 
				WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";

		$implode = array();
		
		if (!empty($data['filter_customer_name'])) {
			$implode[] = "LCASE(CONCAT(c.lastname, ', ', c.firstname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_customer_name'])) . "%'";
		}
		
		if (!empty($data['filter_cpm_account_name'])) {
			$implode[] = "LCASE(cpm_account_name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_cpm_account_name'])) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}
			
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.cpm_enabled = '" . (int)$data['filter_status'] . "'";
		}	

		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(cpm.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}

		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$sort_data = array(
			'customer_name',
			'cpm_account_name',
			'c.email',
			'customer_group',
			'cpm_commission_rate',
			'c.cpm_enabled',			
			'c.approved',
			'cpm.date_added'
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

		$query = $this->db->query($sql);

		return $query->rows;	
	}

	public function getTotalMembers($data = array()) {
		$sql = "SELECT COUNT(DISTINCT cpm.cpm_account_id) AS total
			FROM " . DB_PREFIX . "customer_cpm_account cpm
			INNER JOIN " . DB_PREFIX . "customer c ON cpm.customer_id = c.customer_id
			LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) 
			WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
			
		$implode = array();
		
		if (!empty($data['filter_customer_name'])) {
			$implode[] = "LCASE(CONCAT(c.lastname, ', ', c.firstname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_customer_name'])) . "%'";
		}

		if (!empty($data['filter_cpm_account_name'])) {
			$implode[] = "LCASE(cpm_account_name) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_cpm_account_name'])) . "%'";
		}

		if (!empty($data['filter_email'])) {
			$implode[] = "c.email LIKE '" . $this->db->escape($data['filter_email']) . "%'";
		}

		if (!empty($data['filter_customer_group_id'])) {
			$implode[] = "c.customer_group_id = '" . (int)$data['filter_customer_group_id'] . "'";
		}
			
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$implode[] = "c.cpm_enabled = '" . (int)$data['filter_status'] . "'";
		}	

		if (isset($data['filter_approved']) && !is_null($data['filter_approved'])) {
			$implode[] = "c.approved = '" . (int)$data['filter_approved'] . "'";
		}	

		if (!empty($data['filter_date_added'])) {
			$implode[] = "DATE(cpm.date_added) = DATE('" . $this->db->escape($data['filter_date_added']) . "')";
		}
		
		if ($implode) {
			$sql .= " AND " . implode(" AND ", $implode);
		}

		$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getTotalCustomersNotCPM () {
		$sql = "SELECT COUNT(*) AS total 
				FROM " . DB_PREFIX . "customer c 
				WHERE c.cpm_enabled = '0' 
				AND c.customer_id NOT IN (SELECT customer_id FROM " . DB_PREFIX . "customer_cpm_account WHERE customer_id IS NOT NULL)";

		$query = $this->db->query($sql);
		return $query->row['total'];
	}

	public function getTotalProductsByCPMCustomerId($cpm_customer_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product WHERE cpm_customer_id = '" . (int)$cpm_customer_id . "'");
		return $query->row['total'];
	}

	public function getMemberIdByCustomerId($cpm_customer_id) {
		$query = $this->db->query("SELECT cpm_account_id FROM " . DB_PREFIX . "customer_cpm_account WHERE customer_id = '" . (int)$cpm_customer_id . "'");
		return $query->row['cpm_account_id'];
	}
	
	public function checkCPMCustomer($customer_id) {
		$query = $this->db->query("SELECT customer_id FROM " . DB_PREFIX . "customer_cpm_account WHERE customer_id = '" . (int)$customer_id . "'");		
		
		if (!empty($query->row)) {
			return $query->row['customer_id'];
		} else {
			return 0;
		}
	}
	
	public function enableCPMCustomer($customer_id) {	
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cpm_enabled = '1' WHERE customer_id = '" . (int)$customer_id . "'");				
		$this->cache->delete('member');
	}

	public function disableCPMCustomer($customer_id) {
		$this->db->query("UPDATE " . DB_PREFIX . "customer SET cpm_enabled = '0' WHERE customer_id = '" . (int)$customer_id . "'");				
		$this->cache->delete('member');
	}
	
	public function getCPMCustomer($customer_id) {
		$sql = "SELECT c.customer_id, CONCAT(c.lastname, ', ', c.firstname) AS customer_name, c.status AS customer_status, c.approved AS customer_approved, cgd.name AS customer_group, c.cpm_enabled AS customer_cpm_enabled 
				FROM " . DB_PREFIX . "customer c 
				LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) 
				WHERE c.customer_id = '" . (int)$customer_id . "'
				AND cgd.language_id = '" . (int)$this->config->get('config_language_id') . "'";
				
		$query = $this->db->query($sql);		
		return $query->row;
	}
	
	public function getCPMCustomers($data = array()) {		
		if (isset($data['filter_cpm_enabled'])) {
			$sql = "SELECT c.customer_id, CONCAT(c.lastname, ', ', c.firstname) AS customer_name, cgd.name AS customer_group, c.status AS customer_status, c.approved AS customer_approved, c.cpm_enabled AS customer_cpm_enabled 
					FROM " . DB_PREFIX . "customer c 
					LEFT JOIN " . DB_PREFIX . "customer_group_description cgd ON (c.customer_group_id = cgd.customer_group_id) 
					WHERE cgd.language_id = '" . (int)$this->config->get('config_language_id') . "' 
					AND c.cpm_enabled = '" . (int)$data['filter_cpm_enabled'] . "'";
		}
		
		if (!empty($data['filter_customer_name'])) {
			$sql .= " AND LCASE(CONCAT(c.lastname, ', ', c.firstname)) LIKE '%" . $this->db->escape(utf8_strtolower($data['filter_customer_name'])) . "%'";		
		}

		$sort_data = array(
			'customer_name',
			'customer_group'
		);	

		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY customer_name";	
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
		
		$query = $this->db->query($sql);
		
		return $query->rows;
	}
			
}
?>
