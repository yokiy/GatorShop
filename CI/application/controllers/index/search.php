<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

<<<<<<< HEAD
    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
    }

    public function index() {
        
    }

    public function find() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $Search_value = $_POST['search_value'];
        if ($Search_value != null) {
            //deal with database
            $data = array();
            $data['product'] = $this->product_model->getProductByName($Search_value);

            $this->load->view('search_result.html', $data);
        } else {
            redirect('/index/product', 'refresh');
        }
    }

=======
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
        public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        }
    
        public function index()
	{
	}

	public function find()
	{
		if(!isset($_SESSION)){
                    session_start();
		}
                $searchType=$POST['serch_type'];
		$searchValue=$_POST['search_value'];
		if($searchValue!=null)
		{
			//deal with database
                        $data=array();
                        if( $searchType=='title')
                        {
                             $data['product'] = $this->product_model->getProductByName($searchValue);
                        }
                        else if($searchType=='author')
                        {
                             $data['product'] = $this->product_model->SearchByAuthor($searchValue);
                        }
                        else if($searchType=='publisher')
                        {
                            $data['product']=$this->product_model->SearchByPublisher($searchValue);
                        }
                        else
                        {
                             $data['product'] = $this->product_model->getProductByName($searchValue);
                        }
			
			$this->load->view('result.html',$data);
		}
		else
		{
			redirect('/index/product','refresh');
		}
	}


	
>>>>>>> change
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */