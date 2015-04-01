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
		if(empty($_SESSION['username']))
		{
		$this->load->view('login.html');
		}
		else
		{
		redirect('/index/logout','refresh');
		}
	}


	public function log_in(){//form validation , username and password can not be empty.
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username','UserName','required');
		$this->form_validation->set_rules('password','Password','required');
		$valid =$this->form_validation->run(); //run the validtion
		if(!$valid)// form is illegal
		{
			$this->load->view('login.html');// login again
		}
		else
		{
			$Username=$_POST['username'];
			$Password=$_POST['password'];
			

			//deal with database

			if(!isset($_SESSION)){
				session_start();
			}
			$_SESSION['username']=$Username;
			redirect('/index/product','refresh');

		}
		
	}

	

	

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */