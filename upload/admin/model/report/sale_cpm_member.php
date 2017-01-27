<?php
class ModelReportSaleCPMMember extends Model {
	
	public function getOrders($data = array()) {		
		$sql = "SELECT MIN(o.date_added) AS date_start, MAX(o.date_added) AS date_end,
		o.order_id, o.firstname, o.lastname, os.name as status, o.date_added, o.total, o.currency_code, o.currency_value, 
		cpm.cpm_account_name, cpm.cpm_paypal_account,";
		
		if (!empty($data['cpm_shipping_enabled'])) {
			$sql .= " SUM(ocpmp.rate) AS package_shipping, SUM(ocpmp.insurance) AS package_insurance,"; 
		}
		
		$sql .= " op.order_id, op.cpm_customer_id,
		COUNT(DISTINCT op.order_id) AS orders,
		COUNT(DISTINCT op.order_product_id) AS products,
		SUM(op.total) AS products_total, 
		SUM(op.commission) AS products_commission, 
		SUM(op.quantity * op.tax) AS products_tax
		FROM `" . DB_PREFIX . "order_product` op 
		LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)
		LEFT JOIN `" . DB_PREFIX . "customer_cpm_account` cpm ON (op.cpm_customer_id = cpm.customer_id) 
		LEFT JOIN `" . DB_PREFIX . "order_status` os ON (o.order_status_id = os.order_status_id)";
		 
		if (!empty($data['cpm_shipping_enabled'])) {
			$sql .= " LEFT JOIN `" . DB_PREFIX . "order_cpm_package` ocpmp ON (o.order_id = ocpmp.order_id AND op.cpm_customer_id = ocpmp.cpm_customer_id)";
		}
		
		$sql .= " WHERE os.language_id = '" . (int)$this->config->get('config_language_id') . "'";
		
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}
				
		if (!empty($data['filter_cpm_customer_id'])) {
			$sql .= " AND op.cpm_customer_id = '" . (int)$data['filter_cpm_customer_id'] . "'";
		} else {
			$sql .= " AND op.cpm_customer_id > '0'";
		}
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'order';
		}
		
		switch($group) {
			case 'day';
				$sql .= " GROUP BY DAY(o.date_added)";
				break;
			case 'week':
				$sql .= " GROUP BY WEEK(o.date_added)";
				break;	
			case 'month':
				$sql .= " GROUP BY MONTH(o.date_added)";
				break;
			case 'year':
				$sql .= " GROUP BY YEAR(o.date_added)";
				break;									
			default:
			case 'order':
				$sql .= " GROUP BY op.order_id, op.cpm_customer_id";
				break;
		}
		
		$sql .= " ORDER BY op.order_id DESC";
		
		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}			

			if ($data['limit'] < 1) {
				$data['limit'] = 50;
			}	
			
			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}	
		
		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getTotalOrders($data = array()) {
		if (!empty($data['filter_group'])) {
			$group = $data['filter_group'];
		} else {
			$group = 'order';
		}
		
		switch($group) {
			case 'day';
				$sql = "SELECT COUNT(DISTINCT DAY(o.date_added)) AS total";
				break;
			case 'week':
				$sql = "SELECT COUNT(DISTINCT WEEK(o.date_added)) AS total";
				break;	
			case 'month':
				$sql = "SELECT COUNT(DISTINCT MONTH(o.date_added)) AS total";
				break;
			case 'year':
				$sql = "SELECT COUNT(DISTINCT YEAR(o.date_added)) AS total";
				break;
			default:
				$sql = "SELECT COUNT(DISTINCT CONCAT(o.order_id, '_', op.cpm_customer_id)) AS total";
				break;												
		}
		
		$sql .= " FROM `" . DB_PREFIX . "order` o LEFT JOIN `" . DB_PREFIX . "order_product` op ON (o.order_id = op.order_id)";
		
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " WHERE o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " WHERE o.order_status_id > '0'";
		}
				
		if (!empty($data['filter_cpm_customer_id'])) {
			$sql .= " AND op.cpm_customer_id = '" . (int)$data['filter_cpm_customer_id'] . "'";
		} else {
			$sql .= " AND op.cpm_customer_id > '0'";
		}
				
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}

		$query = $this->db->query($sql);

		return $query->row['total'];	
	}
	
	public function getOrdersCPMMembers($data = array()) {			
		$sql = "SELECT DISTINCT op.cpm_customer_id, cpm.cpm_account_name
		FROM `" . DB_PREFIX . "order_product` op 
		INNER JOIN `" . DB_PREFIX . "customer_cpm_account` cpm ON (op.cpm_customer_id = cpm.customer_id) 
		LEFT JOIN `" . DB_PREFIX . "order` o ON (op.order_id = o.order_id)
		WHERE op.cpm_customer_id > '0'";
		
		if (!empty($data['filter_order_status_id'])) {
			$sql .= " AND o.order_status_id = '" . (int)$data['filter_order_status_id'] . "'";
		} else {
			$sql .= " AND o.order_status_id > '0'";
		}
		
		if (!empty($data['filter_date_start'])) {
			$sql .= " AND DATE(o.date_added) >= '" . $this->db->escape($data['filter_date_start']) . "'";
		}

		if (!empty($data['filter_date_end'])) {
			$sql .= " AND DATE(o.date_added) <= '" . $this->db->escape($data['filter_date_end']) . "'";
		}
		
		$sql .= " ORDER BY cpm.cpm_account_name ASC";

		$query = $this->db->query($sql);
	
		return $query->rows;
	}
	
	public function getOrderProductsTotal($order_id) {
		$query = $this->db->query("SELECT SUM(total) AS cpm_total FROM `" . DB_PREFIX . "order_product` WHERE order_id = '" . (int)$order_id . "'");	
		return $query->row['cpm_total'];
	}
	
	public function getTotalOrderProductsByOrderId($order_id) {
		$query = $this->db->query("SELECT DISTINCT COUNT(*) AS total
			FROM `" . DB_PREFIX . "order_product` op 
			WHERE op.order_id = '" . (int)$order_id . "'");
		return $query->row['total'];
	}
		
}
?>