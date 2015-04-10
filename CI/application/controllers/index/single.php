<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Single extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
        $this->load->model('cart_model');
    }

    public function index() {
        
    }

    public function findSingle($pid) {
        //look up single product 
        $data['p'] = $this->product_model->getProductById($pid);
        $this->load->view('single.html', $data);
    }

    public function addToCart() {
        if (!isset($_SESSION)) {
            session_start();
        }
        $user = $_SESSION['email'];
        $pid = $_POST['pid'];
        $amount = $_POST['amount'];
        $stock = $this->product_model->checkProductStock($pid);
        if ($amount > $stock) {
            //echo out of stock 
            redirect('/index/single/findSingle/' . $pid, 'refresh');
        } else {
            $this->cart_model->addToCart($user, $pid, $amount);
            $this->product_model->decreaseProductAmount($pid);
            $data['PID'] = $pid;
            $this->load->view('confirm.html', $data);
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */