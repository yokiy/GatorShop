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
		if(empty($_SESSION['email']))
		{
			redirect('/index/login','refresh');
		}
		else
		{
			$this->load->library('pagination');
			$perPage = 1;
			$config['base_url'] = site_url('index/cart/index');
			$config['total_rows'] = 10;
			$config['per_page'] = $perPage;
			$config['uri_segment'] = 4;
			$config['first_link'] = 'FirstPage';
			$config['prev_link'] = 'Pre';
			$config['next_link'] = 'Next';
			$config['last_link'] = 'LastPage';

			$this->pagination->initialize($config);
			$data['links'] = $this->pagination->create_links();
			$offset = $this->uri->segment(4);
			$this->db->limit($perPage, $offset);
			$this->load->view('cart.html',$data);
		}
	}


	public function checkout(){
		//deal with the database;
		$this->load->view('checkout.html');
	}

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */