<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Cart extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('cart_model');
        $this->load->model('orders_model');
        $this->load->model('product_model');
    }

    public function index() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (empty($_SESSION['email'])) {
            redirect('/index/login', 'refresh');
        } else {
            $this->load->library('pagination');
            $perPage = 1;
            $config['base_url'] = site_url('index/cart/index');
            $config['total_rows'] = 5;
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
            $this->load->model('cart_model');
            $data ['product'] = $this->cart_model->getCart($_SESSION['email']);
//            $num = count($items);
//            $total = $items['total'];
//            
            //conncet db  return row_num and items

            $this->load->view('cart.html', $data);
        }
    }

    public function addToCart() {
        $user = $_SESSION['email'];
        $pid = $_POST['pid'];
        $amount = $_POST['amount'];
        $stock = $this->product_model->checkProductStock($pid);
        if ($amount > $stock) {
            //echo out of stock
        } else {
            $this->cart_model->addToCart($user, $pid, $amount);
            $this->product_model->decreaseProductAmount($pid);
        }
    }

    public function deleteItem() {
        $user = $_SESSION['email'];
        $pid = $_POST['pid'];
        $amount = $_POST['$amount'];
        $this->cart_model->delItemInCart($user, $pid);
        $this->product_model->changeProductAmount($pid, $amount);
    }
    
    
    public function changeItemAmount() {
        $user = $_SESSION['email'];
        $pid = $_POST['pid'];
        //original amount in cart
        $o_amount = $_POST['quantity'];
        //new amount in cart 
        $amount = $_POST['amount'];
     // opreate cart and product amount
        $this->cart_model->addToCart($user, $pid, $amount);
        $this->product_model->changeProductAmount($pid, ($o_amount - $amount));
     
    }


    public function checkout() {
        //deal with the database;
        $order_number = $this->orders_model->checkout($_SESSION['email']);
        $this->load->view('checkout.html', $order_number);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */