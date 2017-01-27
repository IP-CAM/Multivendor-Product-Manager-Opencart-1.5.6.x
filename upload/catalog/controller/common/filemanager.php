<?php
class ControllerCommonFileManager extends Controller {
	private $error = array();
	
	public function index() {
		if (!$this->customer->isLogged() || !$this->config->get('cpm_status') || $this->customer->getCustomerProductManager() !== '1') {  
			$this->redirect($this->url->link('account/login', '', 'SSL'));
		}
		
		$this->load->language('common/filemanager');
		
		$this->data['title'] = $this->language->get('heading_title');
		
		if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
			$this->data['base'] = $this->config->get('config_ssl'); // HTTPS_SERVER;
		} else {
			$this->data['base'] = $this->config->get('config_url'); // HTTP_SERVER;
		}
		
		$this->data['entry_folder'] = $this->language->get('entry_folder');
		$this->data['entry_move'] = $this->language->get('entry_move');
		$this->data['entry_copy'] = $this->language->get('entry_copy');
		$this->data['entry_rename'] = $this->language->get('entry_rename');
		
		$this->data['button_folder'] = $this->language->get('button_folder');
		$this->data['button_delete'] = $this->language->get('button_delete');
		$this->data['button_move'] = $this->language->get('button_move');
		$this->data['button_copy'] = $this->language->get('button_copy');
		$this->data['button_rename'] = $this->language->get('button_rename');
		$this->data['button_upload'] = $this->language->get('button_upload');
		$this->data['button_refresh'] = $this->language->get('button_refresh');
		$this->data['button_submit'] = $this->language->get('button_submit'); 
		
		$this->data['error_select'] = $this->language->get('error_select');
		$this->data['error_directory'] = $this->language->get('error_directory');
		
		$this->data['cpm_image_subdir'] = $this->customer->getCPMImagesDirectory(); // cpm_image_subdir, e.g. 'customers/temp/'
		$this->data['directory'] = $this->data['base'] . 'image/data/' . $this->customer->getCPMImagesDirectory();
				
		$this->load->model('tool/image');

		$this->data['no_image'] = $this->model_tool_image->resize('no_image.jpg', 100, 100);
		
		if (isset($this->request->get['field'])) {
			$this->data['field'] = $this->request->get['field'];
		} else {
			$this->data['field'] = '';
		}
		
		if (isset($this->request->get['CKEditorFuncNum'])) {
			$this->data['fckeditor'] = $this->request->get['CKEditorFuncNum'];
		} else {
			$this->data['fckeditor'] = false;
		}
		
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/common/filemanager.tpl')) {
			$this->template = $this->config->get('config_template') . '/template/common/filemanager.tpl';
		} else {
			$this->template = 'default/template/common/filemanager.tpl';
		}
				
		$this->response->setOutput($this->render());
	}	
	
	public function image() {
		$this->load->model('tool/image');
		
		if (isset($this->request->get['image'])) {
			$this->response->setOutput($this->model_tool_image->resize(html_entity_decode($this->request->get['image'], ENT_QUOTES, 'UTF-8'), 100, 100));
		}
	}
	
	public function directory() {	
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			$directories = glob(rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath($this->request->post['directory']), '/') . '/*', GLOB_ONLYDIR); 
			
			if ($directories) {
				$i = 0;
			
				foreach ($directories as $directory) {
					$json[$i]['data'] = basename($directory);
					$json[$i]['attributes']['directory'] = utf8_substr($directory, strlen(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory()));
					
					$children = glob(rtrim($directory, '/') . '/*', GLOB_ONLYDIR);
					
					if ($children)  {
						$json[$i]['children'] = ' ';
					}
					
					$i++;
				}
			}		
		}
		
		$this->response->setOutput(json_encode($json));		
	}
	
	public function files() {
		$json = array();
		
		if (!empty($this->request->post['directory'])) {
			$directory = DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath($this->request->post['directory']);
		} else {
			$directory = DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory();
		}
		
		$allowed = array(
			'.jpg',
			'.jpeg',
			'.png',
			'.gif'
		);
		
		$files = glob(rtrim($directory, '/') . '/*');
		
		if ($files) {
			foreach ($files as $file) {
				if (is_file($file)) {
					$ext = strrchr($file, '.');
				} else {
					$ext = '';
				}	
				
				if (in_array(strtolower($ext), $allowed)) {
					$size = filesize($file);
		
					$i = 0;
		
					$suffix = array(
						'B',
						'KB',
						'MB',
						'GB',
						'TB',
						'PB',
						'EB',
						'ZB',
						'YB'
					);
		
					while (($size / 1024) > 1) {
						$size = $size / 1024;
						$i++;
					}
						
					$json[] = array(
						'filename' => basename($file),
						'file'     => utf8_substr($file, utf8_strlen(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory())),
						'size'     => round(utf8_substr($size, 0, utf8_strpos($size, '.') + 4), 2) . $suffix[$i]
					);
				}
			}
		}
		
		$this->response->setOutput(json_encode($json));	
	}	
	
	public function create() {
		$this->load->language('common/filemanager');
				
		$json = array();
		
		if (isset($this->request->post['directory'])) {
			if (isset($this->request->post['name']) || $this->request->post['name']) {
				$directory = rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath($this->request->post['directory']), '/');							   
				
				if (!is_dir($directory)) {
					$json['error'] = $this->language->get('error_directory');
				}
				
				if (file_exists($directory . '/' . $this->cleanPath($this->request->post['name']))) {
					$json['error'] = $this->language->get('error_exists');
				}
			} else {
				$json['error'] = $this->language->get('error_name');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) { 
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {	
			mkdir($directory . '/' . $this->cleanPath($this->request->post['name']), 0777);
			
			$json['success'] = $this->language->get('text_create');
		}	
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function delete() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['path'])) {
			$path = rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath(html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
			 
			if (!file_exists($path)) {
				$json['error'] = $this->language->get('error_select');
			}
			
			if ($path == rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory(), '/')) {
				$json['error'] = $this->language->get('error_delete');
			}
		} else {
			$json['error'] = $this->language->get('error_select');
		}
		
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) { 
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
			if (is_file($path)) {
				unlink($path);
			} elseif (is_dir($path)) {
				$this->recursiveDelete($path);
			}
			
			$json['success'] = $this->language->get('text_delete');
		}				
		
		$this->response->setOutput(json_encode($json));
	}

	protected function recursiveDelete($directory) {
		if (is_dir($directory)) {
			$handle = opendir($directory);
		}
		
		if (!$handle) {
			return false;
		}
		
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				if (!is_dir($directory . '/' . $file)) {
					unlink($directory . '/' . $file);
				} else {
					$this->recursiveDelete($directory . '/' . $file);
				}
			}
		}
		
		closedir($handle);
		
		rmdir($directory);
		
		return true;
	}

	public function move() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['from']) && isset($this->request->post['to'])) {
			$from = rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath(html_entity_decode($this->request->post['from'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($from)) {
				$json['error'] = $this->language->get('error_missing');
			}
			
			if ($from == DIR_IMAGE . 'data') {
				$json['error'] = $this->language->get('error_default');
			}
			
			$to = rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath(html_entity_decode($this->request->post['to'], ENT_QUOTES, 'UTF-8')), '/');

			if (!file_exists($to)) {
				$json['error'] = $this->language->get('error_move');
			}	
			
			if (file_exists($to . '/' . basename($from))) {
				$json['error'] = $this->language->get('error_exists');
			}
		} else {
			$json['error'] = $this->language->get('error_directory');
		}
		
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) { 
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
			rename($from, $to . '/' . basename($from));
			
			$json['success'] = $this->language->get('text_move');
		}
		
		$this->response->setOutput(json_encode($json));
	}	
	
	public function copy() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((utf8_strlen($this->request->post['name']) < 3) || (utf8_strlen($this->request->post['name']) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}
				
			$old_name = rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath(html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'data') {
				$json['error'] = $this->language->get('error_copy');
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . $this->cleanPath(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}			
		} else {
			$json['error'] = $this->language->get('error_select');
		}
		
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) { 
      		$json['error'] = $this->language->get('error_permission');  
    	}	
		
		if (!isset($json['error'])) {
			if (is_file($old_name)) {
				copy($old_name, $new_name);
			} else {
				$this->recursiveCopy($old_name, $new_name);
			}
			
			$json['success'] = $this->language->get('text_copy');
		}
		
		$this->response->setOutput(json_encode($json));	
	}

	function recursiveCopy($source, $destination) { 
		$directory = opendir($source); 
		
		@mkdir($destination); 
		
		while (false !== ($file = readdir($directory))) {
			if (($file != '.') && ($file != '..')) { 
				if (is_dir($source . '/' . $file)) { 
					$this->recursiveCopy($source . '/' . $file, $destination . '/' . $file); 
				} else { 
					copy($source . '/' . $file, $destination . '/' . $file); 
				} 
			} 
		} 
		
		closedir($directory); 
	} 

	public function folders() {
		$this->response->setOutput($this->recursiveFolders(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory()));	
	}
	
	protected function recursiveFolders($directory) {
		$output = '';
		
		$output .= '<option value="' . utf8_substr($directory, strlen(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory())) . '">' . utf8_substr($directory, strlen(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory())) . '</option>';
		
		$directories = glob(rtrim($this->cleanPath($directory), '/') . '/*', GLOB_ONLYDIR);
		
		foreach ($directories  as $directory) {
			$output .= $this->recursiveFolders($directory);
		}
		
		return $output;
	}
	
	public function rename() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
		if (isset($this->request->post['path']) && isset($this->request->post['name'])) {
			if ((strlen(utf8_decode($this->request->post['name'])) < 3) || (strlen(utf8_decode($this->request->post['name'])) > 255)) {
				$json['error'] = $this->language->get('error_filename');
			}
				
			$old_name = rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath(html_entity_decode($this->request->post['path'], ENT_QUOTES, 'UTF-8')), '/');
			
			if (!file_exists($old_name) || $old_name == DIR_IMAGE . 'data') {
				$json['error'] = $this->language->get('error_rename');
			}
			
			if (is_file($old_name)) {
				$ext = strrchr($old_name, '.');
			} else {
				$ext = '';
			}		
			
			$new_name = dirname($old_name) . '/' . $this->cleanPath(html_entity_decode($this->request->post['name'], ENT_QUOTES, 'UTF-8') . $ext);
																			   
			if (file_exists($new_name)) {
				$json['error'] = $this->language->get('error_exists');
			}			
		}
		
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) {
      		$json['error'] = $this->language->get('error_permission');  
    	}
		
		if (!isset($json['error'])) {
			rename($old_name, $new_name);
			
			$json['success'] = $this->language->get('text_rename');
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
	public function upload() {
		$this->load->language('common/filemanager');
		
		$json = array();
		
    	if (!$this->customer->isLogged() || !$this->validateCustomer() || !$this->config->get('cpm_status')) { 
      		$json['error'][] = $this->language->get('error_permission');
    	} elseif (isset($this->request->post['directory'])) {						
			$directory = rtrim(DIR_IMAGE . 'data/' . $this->customer->getCPMImagesDirectory() . $this->cleanPath($this->request->post['directory']), '/');
			
			if (!is_dir($directory)) {
				$json['error'][] = $this->language->get('error_directory');
			}
			
			if (isset($this->request->files['image']) && $this->request->files['image']['tmp_name']) {

				$allowed = array(
					'image/jpeg',
					'image/pjpeg',
					'image/png',
					'image/x-png'/*,
					'image/gif',
					'application/x-shockwave-flash'*/
				);
				
				$allowed_ext = array(
					'.jpg',
					'.jpeg',
					/*'.gif',*/
					'.png'/*,
					'.flv'*/
				);

				$filename = basename(html_entity_decode($this->request->files['image']['name'], ENT_QUOTES, 'UTF-8'));
						
				if (!in_array($this->request->files['image']['type'], $allowed) || !in_array(strtolower(strrchr($filename, '.')), $allowed_ext) || !getimagesize($this->request->files['image']['tmp_name'])) {
					$json['error'][] = $this->language->get('error_file_type');
				} else {
					list($image_width, $image_height) = getimagesize($this->request->files['image']['tmp_name']);

					if ($image_width < $this->config->get('cpm_image_dimensions_min_width') && $image_height < $this->config->get('cpm_image_dimensions_min_height')) {
						$json['error'][] = sprintf($this->language->get('error_file_dimensions_small'), $this->config->get('cpm_image_dimensions_min_width'), $this->config->get('cpm_image_dimensions_min_height'));
					}
				}
				
				if ($this->request->files['image']['size'] > $this->config->get('cpm_image_upload_filesize_max') * 1024) {
					$json['error'][] = sprintf($this->language->get('error_file_size'), $this->config->get('cpm_image_upload_filesize_max'));
				}
				
				if ((strlen($filename) < 7) || (strlen($filename) > 255)) {
					$json['error'][] = $this->language->get('error_filename');
				}

				if ($this->request->files['image']['error'] != UPLOAD_ERR_OK) {
					$json['error'][] = 'error_upload_' . $this->request->files['image']['error'];
				}			
			} else {
				$json['error'][] = $this->language->get('error_file');
			}
		} else {
			$json['error'][] = $this->language->get('error_directory');
		}
		
		if (empty($json['error'])) {	
			if (@move_uploaded_file($this->request->files['image']['tmp_name'], $directory . '/' . $filename)) {
				if ($image_width > $this->config->get('cpm_image_dimensions_resize_width') || $image_height > $this->config->get('cpm_image_dimensions_resize_height')) {
					$this->load->model('tool/image');
					$test_image = $this->model_tool_image->resize_cpm($directory . '/' . $filename, $this->config->get('cpm_image_dimensions_resize_width'), $this->config->get('cpm_image_dimensions_resize_height'));
					$json['success'] = sprintf($this->language->get('success_file_dimensions_large'), $this->config->get('cpm_image_dimensions_resize_width'), $this->config->get('cpm_image_dimensions_resize_height'));
				} else {
					$json['success'] = $this->language->get('text_uploaded');
				}
			} else {
				$json['error'][] = $this->language->get('error_uploaded');
			}
		}
		
		$this->response->setOutput(json_encode($json));
	}
	
  	private function validateCustomer() {
    	if ($this->customer->getCustomerProductManager() !== '1') { 
      		$this->error['warning'] = $this->language->get('error_permission');  
    	}
		
		if (!$this->error) {
	  		return true;
		} else {
	  		return false;
		}
  	}

	private function cleanPath($path=false){
	    if($path){
	      while (strstr($path, "../") || strstr($path, "..\\")){
		$path = str_replace(array("../", "..\\"), '', $path);
	      }
	    }
	    return $path;
	}

} 
?>