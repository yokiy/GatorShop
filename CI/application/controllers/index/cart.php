<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cart extends CI_Controller {

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
			redirect('/index/login','refresh');
		}
		else
		{
			$this->load->view('cart.html');
		}
	}

	public function checkout(){
		//deal with the database;
		$this->load->view('checkout.html');
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */