<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search extends CI_Controller {

	
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