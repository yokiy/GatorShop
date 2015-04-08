<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

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
		if(empty($_SESSION['category']))
		{
			$_SESSION['category']='';
		}
		if(empty($_SESSION['order']))
		{
			$_SESSION['order']='';
		}
		//deal with database
		$data=array();
		$this->load->view('product.html');
	}

	public function changeCategory($catogery)
	{	
		if(!isset($_SESSION)){
				session_start();
		}
		$_SESSION['category']=$catogery;
		redirect('/index/product/index','refresh');
		
	}

	public function changeOrder($order)
	{
		if(!isset($_SESSION)){
			session_start();
		}
		$_SESSION['order']=$order;
		redirect('/index/product/index','refresh');
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */