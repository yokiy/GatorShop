<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

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
		if(!isset($_SESSION)){
				session_start();
		}
		if(empty($_SESSION['email']))
		{
		$this->load->view('login.html');
		}
		else
		{
		redirect('/index/logout','refresh');
		}
	}


	public function log_in(){//form validation , email and password can not be empty.
		$this->load->library('form_validation');
		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('password','Password','required');
		$valid =$this->form_validation->run(); //run the validtion
		if(!$valid)// form is illegal
		{
			$this->load->view('login.html');// login again
		}
		else
		{
			$Email=$_POST['email'];
			$Password=$_POST['password'];
			//deal with database
			$valid=true;
			if(!$valid)
			{
				$this->load->view('login2.html');
			}
			else{
			if(!isset($_SESSION)){
				session_start();
			}
			$_SESSION['email']=$Email;
			redirect('/index/product','refresh');
			}
		}
		
	}

	

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */