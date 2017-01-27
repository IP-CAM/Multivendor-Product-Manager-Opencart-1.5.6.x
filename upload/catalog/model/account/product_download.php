<?php
class ModelAccountProductDownload extends Model {
	public function checkProductDownloadCPM() {
		$sql = "DESCRIBE " . DB_PREFIX . "download cpm_customer_id";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "download ADD cpm_customer_id INT(11) NOT NULL DEFAULT 0";
			$this->db->query($sql);
		}
	}
	public function addDownload($data) {
      	$this->db->query("INSERT INTO " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', remaining = '" . (int)$data['remaining'] . "', cpm_customer_id = '" . (int)$data['customer_id'] . "', date_added = NOW()");

      	$download_id = $this->db->getLastId(); 

      	foreach ($data['download_description'] as $language_id => $value) {
        	$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      	}	
	}
	
	public function editDownload($download_id, $data) {
		
        $this->db->query("UPDATE " . DB_PREFIX . "download SET filename = '" . $this->db->escape($data['filename']) . "', mask = '" . $this->db->escape($data['mask']) . "', remaining = '" . (int)$data['remaining'] . "' WHERE download_id = '" . (int)$download_id . "' AND cpm_customer_id = '" . (int)$data['customer_id'] . "'");

      	$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");

      	foreach ($data['download_description'] as $language_id => $value) {
        	$this->db->query("INSERT INTO " . DB_PREFIX . "download_description SET download_id = '" . (int)$download_id . "', language_id = '" . (int)$language_id . "', name = '" . $this->db->escape($value['name']) . "'");
      	}
	}
	
	public function deleteDownload($download_id, $customer_id) {
      	$this->db->query("DELETE FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "' AND cpm_customer_id = '" . $customer_id . "'");
	  	$this->db->query("DELETE FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");	
	}	

	public function getDownload($download_id, $customer_id) {
		$query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "download WHERE download_id = '" . (int)$download_id . "' AND cpm_customer_id = '" . $customer_id . "'");
		
		return $query->row;
	}

	public function getDownloads($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "download d LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE dd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND d.cpm_customer_id = '" . (int)$data['customer_id'] . "'";
	
		$sort_data = array(
			'dd.name',
			'd.remaining'
		);
	
		if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
			$sql .= " ORDER BY " . $data['sort'];	
		} else {
			$sql .= " ORDER BY dd.name";	
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
	
	public function getDownloadDescriptions($download_id) {
		$download_description_data = array();
		
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "download_description WHERE download_id = '" . (int)$download_id . "'");
		
		foreach ($query->rows as $result) {
			$download_description_data[$result['language_id']] = array('name' => $result['name']);
		}
		
		return $download_description_data;
	}
	
	public function getTotalDownloads($customer_id) {
      	$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "download WHERE  cpm_customer_id = '" . (int)$customer_id ."'");
		
		return $query->row['total'];
	}	
}
?>