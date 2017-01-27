<?php
class ModelModuleCPM extends Model {
	public function installCPM() {
		$data = array();
		$msg = '';
		$success = false;
		
		// Modify 'product' table - add two new columns:  cpm_customer_id and cpm_approved
		$sql = "DESCRIBE " . DB_PREFIX . "product cpm_customer_id";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "product ADD cpm_customer_id INT(11) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id ADDED to product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT added to product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_customer_id already EXISTS in product table.<br> ";
		}
		
		$sql = "DESCRIBE " . DB_PREFIX . "product cpm_approved";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "product ADD cpm_approved TINYINT(1) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_approved ADDED to product table.<br> ";
				$sql = "UPDATE " . DB_PREFIX . "product SET cpm_approved = '1' WHERE status='1'";
				if ($this->db->query($sql)) {
					$msg .= "SUCCESS: all enabled products automatically approved.<br> ";
					$success = true;
				} else {
					$msg .= "NOTE: NO products were automatically approved during install.<br> ";					
				}
			} else {
				$msg .= "FAIL: cpm_approved NOT added to product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_approved already EXISTS in product table.<br> ";
		}
		
		// Modify 'customer' table - add one new column, cpm_enabled
		$sql = "DESCRIBE " . DB_PREFIX . "customer cpm_enabled";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "customer ADD cpm_enabled TINYINT(1) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_enabled ADDED to customer table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_enabled NOT added to customer table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_enabled already EXISTS in customer table.<br> ";
		}
		
		// Modify 'download' table - add one new column, cpm_customer_id
		$sql = "DESCRIBE " . DB_PREFIX . "download cpm_customer_id";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "download ADD cpm_customer_id INT(11) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id ADDED to download table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT added to download table.<br> ";
				exit($msg);
			}
		}
		
		// Add NEW 'customer_cpm_account' table
		$sql = "SHOW TABLES LIKE '" . DB_PREFIX . "customer_cpm_account'";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "customer_cpm_account (
				  `cpm_account_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `customer_id` int(11) unsigned NOT NULL,
				  `cpm_account_name` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_account_description` text COLLATE utf8_bin NOT NULL,
				  `cpm_account_image` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_01` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_02` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_03` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_04` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_05` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_06` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_directory_images` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_directory_downloads` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_paypal_account` varchar(96) COLLATE utf8_bin NOT NULL,
				  `cpm_max_products` int(11) NOT NULL,
				  `cpm_commission_rate` DECIMAL(15,4) NOT NULL DEFAULT 0,
				  `sort_order` int(3) NOT NULL,
				  `viewed` int(11) NOT NULL,
				  `date_added` datetime NOT NULL,
				  PRIMARY KEY (`cpm_account_id`),
				  UNIQUE KEY `customer_id` (`customer_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account table CREATED.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account table NOT created.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account table already EXISTS.<br> ";
		}
		
		// future release:
		/*
		// Add NEW 'customer_cpm_account_description' table
		$sql = "SHOW TABLES LIKE '" . DB_PREFIX . "customer_cpm_account_description'";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "customer_cpm_account_description (
				  `cpm_account_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `language_id` int(11) unsigned NOT NULL DEFAULT 1,
				  `name` varchar(255) COLLATE utf8_bin NOT NULL,
				  `description` text COLLATE utf8_bin NOT NULL,
				  PRIMARY KEY (`cpm_account_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account_description table CREATED.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account_description table NOT created.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account_description table already EXISTS.<br> ";
		}
		
		// Add NEW 'customer_cpm_account_to_store' table
		$sql = "SHOW TABLES LIKE '" . DB_PREFIX . "customer_cpm_account_to_store'";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "customer_cpm_account_to_store (
				  `cpm_account_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `store_id` int(11) unsigned NOT NULL DEFAULT 0,
				  PRIMARY KEY (`cpm_account_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account_to_store table CREATED.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account_to_store table NOT created.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account_to_store table already EXISTS.<br> ";
		}
		* */
		
		// Modify order_product table - add cpm_customer_id, commission, and product image
		$sql = "DESCRIBE " . DB_PREFIX . "order_product cpm_customer_id";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product ADD cpm_customer_id INT(11) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id ADDED to order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT added to order_product table.<br> ";
				exit($msg);
			}
		}
		
		// Modify 'order_product' table - add commission
		$sql = "DESCRIBE " . DB_PREFIX . "order_product commission";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product ADD commission DECIMAL(15,4) NOT NULL DEFAULT 0 AFTER total";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: commission ADDED to order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: commission NOT added to order_product table.<br> ";
				exit($msg);
			}
		}
			
		// Modify 'order_product' table - add image
		$sql = "DESCRIBE " . DB_PREFIX . "order_product image";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product ADD image VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL AFTER name";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: image ADDED to order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: image NOT added to order_product table.<br> ";
				exit($msg);
			}
		}
		
		// Modify 'order_history' table - add cpm_customer_id
		$sql = "DESCRIBE " . DB_PREFIX . "order_history cpm_customer_id";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_history ADD cpm_customer_id INT(11) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id ADDED to order_history table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT added to order_history table.<br> ";
				exit($msg);
			}
		}
		
		// END MODS //
		
		$data['success'] = $success;
		$data['message'] = $msg;
		
		if ($success) {
			$data['message'] = "<b>CPM Module successfully installed!</b><br><br> " . $msg;
			$this->log->write("CPM Module successfully installed: " . $msg);			
			return $data;
		} else {
			$data['message'] = "<b>NO CHANGES MADE</b><br><br> " . $msg;
			$this->log->write("CPM Module unsuccessfully installed (NO CHANGES MADE): " . $msg);
			return $data;
		}
	}
	
	public function uninstallCPM() {
		$data = array();
		$msg = '';
		$success = false;
		
		// Modify 'product' table - remove two new columns:  cpm_customer_id and cpm_approved
		$sql = "DESCRIBE " . DB_PREFIX . "product cpm_customer_id";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "product DROP cpm_customer_id";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id REMOVED from product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT removed from product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_customer_id already REMOVED from product table.<br> ";
		}
		
		$sql = "DESCRIBE " . DB_PREFIX . "product cpm_approved";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "product DROP cpm_approved";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_approved REMOVED from product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_approved NOT removed from product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_approved already REMOVED from product table.<br> ";
		}
		
		// Modify 'customer' table - remove cpm_enabled
		$sql = "DESCRIBE " . DB_PREFIX . "customer cpm_enabled";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "customer DROP cpm_enabled";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_enabled REMOVED from customer table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_enabled NOT removed from customer table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_enabled already REMOVED from customer table.<br> ";
		}
		
		// Modify 'download' table - remove cpm_customer_id
		$sql = "DESCRIBE " . DB_PREFIX . "download cpm_customer_id";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "download DROP cpm_customer_id";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id REMOVED from download table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT removed from download table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_customer_id already REMOVED from download table.<br> ";
		}
		
		// Remove 'customer_cpm_account' table from database
		$sql = "DESCRIBE " . DB_PREFIX . "customer_cpm_account";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "DROP TABLE " . DB_PREFIX . "customer_cpm_account";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account table REMOVED from database.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account table NOT removed from database.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account table already removed from database.<br> ";
		}
		
		// future release:
		/*
		// Remove 'customer_cpm_account_description' table from database
		$sql = "DESCRIBE " . DB_PREFIX . "customer_cpm_account_description";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "DROP TABLE " . DB_PREFIX . "customer_cpm_account_description";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account_description table REMOVED from database.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account_description table NOT removed from database.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account_description table already removed from database.<br> ";
		}
		* */
		
		// Remove 'commission' field from 'order_product' table
		$sql = "DESCRIBE " . DB_PREFIX . "order_product commission";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product DROP commission";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: commission REMOVED from order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: commission NOT removed from order_product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: commission already REMOVED from order_product table.<br> ";
		}
		
		// Remove 'cpm_customer_id' field from 'order_product' table
		$sql = "DESCRIBE " . DB_PREFIX . "order_product cpm_customer_id";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product DROP cpm_customer_id";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id REMOVED from order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT removed from order_product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_customer_id already REMOVED from order_product table.<br> ";
		}
		
		// Modify 'order_product' table - remove image
		$sql = "DESCRIBE " . DB_PREFIX . "order_product image";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product DROP image";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: image REMOVED from order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: image NOT removed from order_product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: image already REMOVED from order_product table.<br> ";
		}
		
		// Remove 'cpm_customer_id' field from 'order_history' table
		$sql = "DESCRIBE " . DB_PREFIX . "order_history cpm_customer_id";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_history DROP cpm_customer_id";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id REMOVED from order_history table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT removed from order_history table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_customer_id already REMOVED from order_history table.<br> ";
		}
				
		// future release:
		/*		
		// Remove 'customer_cpm_account_to_store' table from database
		$sql = "DESCRIBE " . DB_PREFIX . "customer_cpm_account_to_store";
		$query = $this->db->query($sql);
		if ($query->num_rows) {
			$sql = "DROP TABLE " . DB_PREFIX . "customer_cpm_account_to_store";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account_to_store table REMOVED from database.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account_to_store table NOT removed from database.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account_to_store table already removed from database.<br> ";
		}
		* */
		
		// END MODS //
		
		$data['success'] = $success;
		$data['message'] = $msg;
		
		if ($success) {
			$data['message'] = "<b>CPM Module successfully uninstalled!</b><br><br> " . $msg . "<br><b>DON'T FORGET TO REMOVE vqmod XML files!</b> ;)";
			$this->log->write("CPM Module successfully uninstalled (DON'T FORGET TO REMOVE vqmod XML files): " . $msg);
			return $data;
		} else {
			$data['message'] = "<b>NO CHANGES MADE</b><br> " . $msg;
			$this->log->write("CPM Module unsuccessfully uninstalled (NO CHANGES MADE): " . $msg);
			return $data;
		}
	}

	public function updateCPM() {
		$data = array();
		$msg = '';
		$success = false;
		
		// for updating from < CPM 2.0.0
		
		// Add NEW 'customer_cpm_account' table
		$sql = "SHOW TABLES LIKE '" . DB_PREFIX . "customer_cpm_account'";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "customer_cpm_account (
				  `cpm_account_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `customer_id` int(11) unsigned NOT NULL,
				  `cpm_account_name` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_account_description` text COLLATE utf8_bin NOT NULL,
				  `cpm_account_image` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_01` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_02` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_03` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_04` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_05` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_custom_field_06` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_directory_images` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_directory_downloads` varchar(255) COLLATE utf8_bin NOT NULL,
				  `cpm_paypal_account` varchar(96) COLLATE utf8_bin NOT NULL,
				  `cpm_max_products` int(11) NOT NULL,
				  `sort_order` int(3) NOT NULL,
				  `viewed` int(11) NOT NULL,
				  `date_added` datetime NOT NULL,
				  PRIMARY KEY (`cpm_account_id`),
				  UNIQUE KEY `customer_id` (`customer_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account table CREATED.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account table NOT created.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account table already EXISTS.<br> ";
		}
		
		$sql = "DESCRIBE " . DB_PREFIX . "download cpm_customer_id";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "download ADD cpm_customer_id INT(11) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id ADDED to download table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT added to download table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_customer_id already EXISTS in download table.<br> ";
		}
	
		// for updating from < CPM 2.1.0
		
		$sql = "DESCRIBE " . DB_PREFIX . "customer_cpm_account sort_order";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "customer_cpm_account ADD sort_order INT(3) NOT NULL";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: sort_order ADDED to customer_cpm_account table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: sort_order NOT added to customer_cpm_account table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: sort_order already EXISTS in customer_cpm_account table.<br> ";
		}
		
		$sql = "DESCRIBE " . DB_PREFIX . "customer_cpm_account viewed";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "customer_cpm_account ADD viewed INT(11) NOT NULL";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: viewed ADDED to customer_cpm_account table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: viewed NOT added to customer_cpm_account table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: viewed already EXISTS in customer_cpm_account table.<br> ";
		}
		
		$sql = "DESCRIBE " . DB_PREFIX . "order_product cpm_customer_id";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product ADD cpm_customer_id INT(11) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id ADDED to order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT added to order_product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_customer_id already EXISTS in order_product table.<br> ";
		}
		
		$sql = "DESCRIBE " . DB_PREFIX . "order_product commission";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product ADD commission DECIMAL(15,4) NOT NULL DEFAULT 0 AFTER total";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: commission ADDED to order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: commission NOT added to order_product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: commission already EXISTS in order_product table.<br> ";
		}
			
		$sql = "DESCRIBE " . DB_PREFIX . "order_product image";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_product ADD image VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT NULL AFTER name";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: image ADDED to order_product table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: image NOT added to order_product table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: image already EXISTS in order_product table.<br> ";
		}
		
		$sql = "DESCRIBE " . DB_PREFIX . "order_history cpm_customer_id";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "order_history ADD cpm_customer_id INT(11) NOT NULL DEFAULT 0";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_customer_id ADDED to order_history table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_customer_id NOT added to order_history table.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_customer_id already EXISTS in order_history table.<br> ";
		}

		// for updating from < CPM 2.2.0
		
		$sql = "DESCRIBE " . DB_PREFIX . "customer_cpm_account cpm_commission_rate";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "ALTER TABLE " . DB_PREFIX . "customer_cpm_account ADD cpm_commission_rate DECIMAL(15,4) NOT NULL DEFAULT 0 AFTER cpm_max_products";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: cpm_commission_rate ADDED to customer_cpm_account table.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: cpm_commission_rate NOT added to customer_cpm_account table.<br> ";
				exit($msg);
			}
			$sql = "UPDATE " . DB_PREFIX . "customer_cpm_account SET cpm_commission_rate = " . $this->config->get('cpm_commission_rate');
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: NEW cpm_commission_rate UPDATED from 0 to CPM module settings default value in customer_cpm_account table for all existing members.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: NEW cpm_commission_rate NOT updated from 0 to CPM module settings default value in customer_cpm_account table for all existing members.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: cpm_commission_rate already EXISTS in customer_cpm_account table.<br> ";
		}
		
		// for updating from < CPM 2.3.0
		
		// future release:
		/*		
		$sql = "SHOW TABLES LIKE '" . DB_PREFIX . "customer_cpm_account_description'";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "customer_cpm_account_description (
				  `cpm_account_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `language_id` int(11) unsigned NOT NULL DEFAULT 1,
				  `name` varchar(255) COLLATE utf8_bin NOT NULL,
				  `description` text COLLATE utf8_bin NOT NULL
				  PRIMARY KEY (`cpm_account_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account_description table CREATED.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account_description table NOT created.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account_description table already EXISTS.<br> ";
		}
		
		$sql = "SHOW TABLES LIKE '" . DB_PREFIX . "customer_cpm_account_to_store'";
		$query = $this->db->query($sql);
		if (!$query->num_rows) {
			$sql = "CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "customer_cpm_account_to_store (
				  `cpm_account_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
				  `store_id` int(11) unsigned NOT NULL DEFAULT 0,
				  PRIMARY KEY (`cpm_account_id`)
				) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=1";
			if ($this->db->query($sql)) {
				$msg .= "SUCCESS: customer_cpm_account_to_store table CREATED.<br> ";
				$success = true;
			} else {
				$msg .= "FAIL: customer_cpm_account_to_store table NOT created.<br> ";
				exit($msg);
			}
		} else {
			$msg .= "NOTE: customer_cpm_account_to_store table already EXISTS.<br> ";
		}
		* */
		
		// END UPDATES //
		
		$data['success'] = $success;
		$data['message'] = $msg;
		
		if ($success) {
			$data['message'] = "<b>CPM Module successfully updated!</b><br><br> " . $msg;
			$this->log->write("CPM Module successfully updated: " . $msg);			
			return $data;
		} else {
			$data['message'] = "<b>NO CHANGES MADE</b><br><br> " . $msg;
			$this->log->write("CPM Module unsuccessfully updated (NO CHANGES MADE): " . $msg);
			return $data;
		}
		
	}
	
}
?>