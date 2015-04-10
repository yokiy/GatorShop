<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Search extends CI_Controller {

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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */