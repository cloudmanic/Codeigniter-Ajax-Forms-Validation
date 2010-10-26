<?php
class AjaxForm extends Controller 
{
	function AjaxForm()
	{
		parent::Controller();	
		$this->load->helper('form');
		$this->load->helper('ajaxform');	
		$this->load->library('form_validation');
	}
	
	//
	// Give a test of how the ajax validation works.
	//
	function index()
	{
		$opts['redirect'] = site_url('/ajaxform/success');
		$opts['html'] = $this->load->view('validationajaxreturn', '', TRUE);
		$opts['action'] = 'none';
		$opts['htmlcont'] = 'ajax-return';
		$opts['errorstart'] = '<p>';
		$opts['errorend'] = '</p>';
		$opts['blur'] = TRUE;
		//$opts['errorcont'] = 'error-cont';
		$this->form_validation->set_options($opts);
													
		if($this->input->post('ajaxform')) {
			sleep(1);		
			$this->form_validation->set_rules('FirstName', 'First Name', 'required');
			$this->form_validation->set_rules('LastName', 'Last Name', 'required');
			$this->form_validation->set_rules('Email', 'Email', 'required');
			$this->form_validation->set_rules('Sex', 'Sex', 'required');
			$this->form_validation->set_rules('Note', 'Note', 'required');
			$this->form_validation->run();
		}
													
	
		if(isAjax())
			echo $this->form_validation->get_json();	
		else 
			$this->load->view('validationtest');
	}
	
	//
	// Success.
	//
	function success()
	{
		echo "Sweet!! Redirecting after validation success worked.";
	}
}
?>