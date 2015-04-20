<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Product extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
    }

    public function index() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (empty($_SESSION['category'])) {
            $_SESSION['category'] = 'Children';
        }
        if (empty($_SESSION['order'])) {
            $_SESSION['order'] = 'popular';
        }
        //deal with database
        //$data = $this->product_model->getProductByCategory($_SESSION['category']);
        $data = array();
        $result=array();
        if ($_SESSION['order'] == 'popular') {
            $result = $this->product_model->sortProductBySalesCategory($_SESSION['category']);     
        } else if ($_SESSION['order'] == 'rate') {
            $result = $this->product_model->sortProductByRate($_SESSION['category']);
        } else if ($_SESSION['order'] == 'low') {
            $result = $this->product_model->sortProductByPriceAsc($_SESSION['category']);
        } else if ($_SESSION['order'] == 'high') {
            $result= $this->product_model->sortProductByPriceDesc($_SESSION['category']);
        }
         $this->load->library('pagination');
        $perPage = 21;
        $config['base_url'] = site_url('index/product/index');
        $config['total_rows'] = count($result)-21;
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
                $j = $offset+ 1;
            }
            $new = array();
            for ($i = 0; $i <= 20; $i++) {
                $new[$i] = $result[$j];
                $j = $j + 1;
            }
        $data['product'] = $new;
        $data['totalNum'] = count($result);
        $data['category'] = $_SESSION['category'];
        $data['order'] = $_SESSION['order'];
        $data['bestseller'] = $this->product_model->getTheBestSellerOfThisMonth();
        $this->load->view('product.html', $data);
    }

    public function changeCategory($catogery) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['category'] = $catogery;
        redirect('/index/product/index', 'refresh');
    }

    public function changeOrder($order) {
        if (!isset($_SESSION)) {
            session_start();
        }
        $_SESSION['order'] = $order;
        redirect('/index/product/index', 'refresh');
    }
    
    public function listAll(){
        $data['pc'] = $this->product_model->getAllProductCount();
        $data['cc'] = $this->product_model->getAllCustomerCount();
        $data['oc'] = $this->product_model->getAllOrdersCount();
        $data['cartc']= $this->product_model->getAllCartCount();
        $this->load->view('listAll.html',$data);
        
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */