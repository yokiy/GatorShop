<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

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
	}

	public function find()
	{
		if(!isset($_SESSION)){
				session_start();
		}
		$Search_value=$_POST['search_value'];
		if($Search_value!=null)
		{
			redirect('/index/contact','refresh');
		}
		else
		{
			redirect('/index/product','refresh');
		}
	}


	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */