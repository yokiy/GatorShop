<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Account extends CI_Controller {

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
			redirect('/index/login','refresh');
		}
		else
		{
			$this->load->view('account.html');
		}
	}

	public function modify()
	{
		//deal with database
		$data=array();
		$this->load->view('update.html',$data);
		
	}
	

	public function update(){
		//post
		$data=array();

		$this->load->library('form_validation');
		$this->form_validation->set_rules('firstname','FirstName','required|alpha');
		$this->form_validation->set_rules('lastname','LastName','required|alpha');
		$this->form_validation->set_rules('gender','Gender','required');
		$this->form_validation->set_rules('cellphone','Cellphone','required');
		$this->form_validation->set_rules('city','City','required|alpha');
		$this->form_validation->set_rules('zipcode','Zipcode','required|integer|exact_length[5]|');
		$this->form_validation->set_rules('address','Address','required');
		$this->form_validation->set_rules('state','State','required');

		$this->form_validation->set_rules('email','Email','required|valid_email');
		$this->form_validation->set_rules('r_password1','Password1','required|min_length[6]|alpha_numeric');
		$this->form_validation->set_rules('r_password2','Password2','required|min_length[6]|alpha_numeric|matches[r_password1]');
		$valid =$this->form_validation->run(); //run the validtion
		if(!$valid)// form is illegal
		{
			$this->load->view('update.html',$data);// login again
		}
		else
		{ 
			$fname=$_POST['firstname'];
			$lname=$_POST['lastname'];
			$gender=$_POST['gender'];
			$cellphone=$_POST['cellphone'];
			$city=$_POST['city'];
			$zipcode=$_POST['zipcode'];
			$address=$_POST['address'];
			$state=$_POST['state'];
			$email=$_POST['email'];
			$password=$_POST['r_password1'];


			//deal with database

			if(!isset($_SESSION))
			{
				session_start();
			}
			$_SESSION['email']=$Email;
			redirect('/index/product','refresh');
			
		}
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */