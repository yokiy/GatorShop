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
          if (empty($_SESSION['searchtype'])) {
            $_SESSION['searchtype'] = 'title';
        }
        if (empty($_SESSION['searchvalue'])) {
            $_SESSION['searchvalue'] = '';
        }
        $sType = $_POST['select'];
        $sValue = $_POST['search_value'];
        if(!empty($searchType))
            $_SESSION['searchtype']=$sType;
         if(!empty($searchValue))
            $_SESSION['searchvalue']=$sValue;
        $searchType=$_SESSION['searchtype'];
        $searchValue=$_SESSION['searchvalue'];
        if (!empty($searchValue)) {
            //deal with database
            $data = array();
            $result = array();
            if ($searchType == 'title') {
                $result = $this->product_model->getProductByName($searchValue);
            } else if ($searchType == 'author') {
                $result = $this->product_model->getProductByAuthor($searchValue);
            } else if ($searchType == 'publisher') {
                $result = $this->product_model->getProductByPublisher($searchValue);
            } else {
                $result = $this->product_model->getProductByName($searchValue);
            }
            $this->load->library('pagination');
            $perPage = 21;
            $config['base_url'] = site_url('index/search/find');
            $config['total_rows'] = count($result) - 21;
            $config['per_page'] = $perPage;
            $config['uri_segment'] = 4;
            $config['prev_link'] = 'Pre Page';
            $config['next_link'] = 'Next Page';
            $this->pagination->initialize($config);
            $data['links'] = $this->pagination->create_links();
            $offset = $this->uri->segment(4);
            if ($offset == 1) {
                $j = $offset;
            } else {
                $j = $offset + 1;
            }
            $new = array();
            for ($i = 0; $i <= 20; $i++) {
                $new[$i] = $result[$j];
                $j = $j + 1;
            }
            $data['product'] = $new;
            $data['sv'] = $searchValue;
            $data['type'] = $searchType;
            $data['totalNum'] = count($result);
            $this->load->view('result.html', $data);
        } else {
            redirect('/index/product', 'refresh');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */