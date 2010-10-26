<?php
//
// Print Form header.
//
if(! function_exists(''))
{
	function ajaxform_open($action = '', $attributes = '', $hidden = array())
	{
		$CI =& get_instance();

		if($attributes == '')
			$attributes = 'method="post"';

		$action = (strpos($action, '://') === FALSE) ? $CI->config->site_url($action) : $action;

		$form = '<form action="'.$action.'"';
		$form .= _ajax_attributes_to_string($attributes, TRUE);
		$form .= '>';

		$hidden['ajaxform'] = '1';
		$form .= form_hidden($hidden);
		
		return $form;	
	}
}

//
// Detect if it is an ajax request or not.
//
if(! function_exists('isAjax'))
{
	function isAjax() {
    return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH']=="XMLHttpRequest");
	}
}

//
// Helper function used by some of the form helpers
//
if ( ! function_exists('_ajax_attributes_to_string'))
{
	function _ajax_attributes_to_string($attributes, $formtag = FALSE)
	{	
		if (is_string($attributes) AND strlen($attributes) > 0)
		{
			if ($formtag == TRUE AND strpos($attributes, 'method=') === FALSE)
			{
				$attributes .= ' method="post"';
			}

			if ($formtag == TRUE AND strpos($attributes, 'class=') === FALSE)
			{
				$attributes .= ' class="ciajaxform"';
			}

			return ' '.$attributes;
		}
	
		if (is_object($attributes) AND count($attributes) > 0)
		{
			$attributes = (array)$attributes;
		}

		if (is_array($attributes) AND count($attributes) > 0)
		{
		$atts = '';

		if ( ! isset($attributes['method']) AND $formtag === TRUE)
		{
			$atts .= ' method="post"';
		}

		foreach ($attributes as $key => $val)
		{
			if(strtolower($key) == 'class')
				$val . ' ciajaxform';			
			$atts .= ' '.$key.'="'.$val.'"';
		}

		return $atts;
		}
	}
}

?>