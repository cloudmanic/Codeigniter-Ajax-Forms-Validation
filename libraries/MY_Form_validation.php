<?php
//
// Company: Cloudmanic Labs, LLC (http://www.cloudmanic.com)
// Author: Spicer Matthews <spicer@cloudmanic.com>
// Date: 10/21/2010
// Description: Library behind Ajax form. A wrapper to use CI validation with Ajax.
//							Extends core library Form_validation
//
class MY_Form_validation extends CI_Form_validation
{
	private $json = array();
	private $opts = array();
	
	//
	// Set configuration variables. 
	//
	function set_options($opts, $val = '')
	{
		if(is_array($opts)) {
			foreach($opts AS $key => $row)
				$this->set_option($key, $row);
		} else {
			$this->set_option($opts, $val);
		}
	}
	
	//
	// Set a single option.
	//
	function set_option($key, $val)
	{
		$this->opts[$key] = $val;
	}
	
	//
	// Get options.
	//
	function get_options()
	{
		return $this->opts;
	}
	
	//
	// Clear all configuration settings.
	//
	function clear_options()
	{
		$this->opts = array();
	}
	
	//
	// Return json based on valiation.
	//
	function get_json()
	{
		$this->json['options'] = $this->opts;
	
		foreach($this->_error_array AS $key => $row)
			$error[] = array('field' => $key, 'error' => $row);
			
		if(isset($error)) {
			$this->json['status'] = 'error';
			$this->json['errorfields'] = $error;
		} else {
			$this->json['status'] = 'success';		
		}	
		return json_encode($this->json);
	}
}
?>