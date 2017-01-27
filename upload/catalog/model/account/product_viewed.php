<?php
class ModelAccountProductViewed extends Model {
		
	public function getProductsViewed($data = array()) {
		$sql = "SELECT p.product_id, pd.name, p.model, p.date_added, p.status, p.image, p.viewed FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.cpm_customer_id = '" . (int)$data['customer_id'] . "' AND p.cpm_approved = 1";
					
		if (!empty($data['cpm_filter_name'])) {
			$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['cpm_filter_name'])) . "%'";
			}

		if (!empty($data['filter_model'])) {
			$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_model'])) . "%'";
		}
			
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
			
		$sort_data = array(
				'pd.name',
				'p.model',
				'p.date_added',
				'p.status',
				'p.sort_order'
			);	
			
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY p.viewed";
			}
			
			if (isset($data['order']) && ($data['order'] == 'ASC')) {
				$sql .= " ASC";
			} else {
				$sql .= " DESC";
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
	
	public function getTotalProductsViewed($data) {
		$sql = "SELECT COUNT(*) AS total FROM " . DB_PREFIX . "product p LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p.cpm_customer_id = '" . (int)$data['customer_id'] . "' AND p.cpm_approved = 1";
		      	
      	if (!empty($data['cpm_filter_name'])) {
			$sql .= " AND LCASE(pd.name) LIKE '" . $this->db->escape(utf8_strtolower($data['cpm_filter_name'])) . "%'";
			}

		if (!empty($data['filter_model'])) {
			$sql .= " AND LCASE(p.model) LIKE '" . $this->db->escape(utf8_strtolower($data['filter_model'])) . "%'";
		}
			
		if (isset($data['filter_status']) && !is_null($data['filter_status'])) {
			$sql .= " AND p.status = '" . (int)$data['filter_status'] . "'";
		}
		
      	$query = $this->db->query($sql);

		return $query->row['total'];
	}
	
	public function getTotalProductViews($customer_id) {
      	$sql = "SELECT SUM(viewed) AS total FROM " . DB_PREFIX . "product p WHERE p.cpm_customer_id = '" . (int)$customer_id . "' AND p.cpm_approved = 1 ";
		
      	$query = $this->db->query($sql);

		return $query->row['total'];
	}	
		
	public function getTotalMemberViews($customer_id) {
		$query = $this->db->query("SELECT viewed FROM " . DB_PREFIX . "customer_cpm_account cpm WHERE cpm.customer_id = '" . (int)$customer_id . "'");
		
		return $query->row['viewed'];
	}
	
	public function checkMemberViewedCPM() {
		$sql = "DESCRIBE " . DB_PREFIX . "customer_cpm_account viewed";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "customer_cpm_account ADD viewed INT(5) NOT NULL DEFAULT 0";
			$this->db->query($sql);
		}
	}
}
?>