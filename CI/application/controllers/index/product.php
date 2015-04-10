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
            $_SESSION['category'] = 'book';
        }
        if (empty($_SESSION['order'])) {
            $_SESSION['order'] = 'popular';
        }
        //deal with database
        //$data = $this->product_model->getProductByCategory($_SESSION['category']);
        $data=array();
        if ($_SESSION['order'] == 'popular') {
            $data['product'] = $this->product_model->sortProductBySalesCategory($_SESSION['category']);
        } else if ($_SESSION['order'] == 'rate') {
            $data['product'] = $this->product_model->sortProductByRate($_SESSION['category']);
        } else if ($_SESSION['order'] == 'low') {
            $data['product'] = $this->product_model->sortProductByPriceAsc($_SESSION['category']);
        } else if ($_SESSION['order'] == 'high') {
            $data['product'] = $this->product_model->sortProductByPriceDesc($_SESSION['category']);
        }
        $data['totalNum']=count($data['product']);
        $data['category']=$_SESSION['category'];
        $data['order']=$_SESSION['order'];
        $this->load->view('product.html',$data);
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

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */