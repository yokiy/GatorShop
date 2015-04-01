<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('register.html');
	}

	public function sign_up(){//form validation , username and password can not be empty.
		$this->load->library('form_validation');
		$this->form_validation->set_rules('firstname','FirstName','required|alpha');
		$this->form_validation->set_rules('lastname','LastName','required|alpha');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('cellphone','Cellphone','required');
		$this->form_validation->set_rules('city','City','required|alpha');
		$this->form_validation->set_rules('zipcode','Zipcode','required|integer|exact_length[5]|');
		$this->form_validation->set_rules('address','Address','required');
		$this->form_validation->set_rules('state','State','required');
		$this->form_validation->set_rules('r_username','UserName','required|alpha_numeric');
		$this->form_validation->set_rules('r_password1','Password1','required|min_length[6]|alpha_numeric');
		$this->form_validation->set_rules('r_password2','Password2','required|min_length[6]|alpha_numeric|matches[r_password1]');
		$valid =$this->form_validation->run(); //run the validtion
		if(!$valid)// form is illegal
		{
			$this->load->view('register.html');// login again
		}
		else
		{ 
			//deal with database

			if(!isset($_SESSION)){
				session_start();
			}
			
			redirect('/index/product','refresh');
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */