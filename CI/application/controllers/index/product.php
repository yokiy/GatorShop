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
            $_SESSION['category'] = '';
        }
        if (empty($_SESSION['order'])) {
            $_SESSION['order'] = '';
        }
        //deal with database
        $data = $this->product_model->getProductByCategory($_SESSION['category']);
        
        if ($_SESSION['order'] == 'popular') {
            $data = $this->product_model->sortProductBySalesCategory($_SESSION['category']);
        } else if ($_SESSION['order'] == 'rate') {
            $data = $this->product_model->sortProductByRate($_SESSION['category']);
        } else if ($_SESSION['order'] == 'low') {
            $data = $this->product_model->sortProductByPriceAsc($_SESSION['category']);
        } else if ($_SESSION['order'] == 'high') {
            $data = $this->product_model->sortProductByPriceDesc($_SESSION['category']);
        }
        $this->load->view('product.html');
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