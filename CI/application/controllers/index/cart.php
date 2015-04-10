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
            $data ['total'] = $_SESSION['total'];
            $data['user']=$_SESSION['email'];
//            $num = count($items);
//            $total = $items['total'];
//            
            //conncet db  return row_num and items

            $this->load->view('cart.html', $data);
        }
    }


    public function deleteItem($pid,$amount) {
        if(!isset($_SESSION))
        {
            session_start();
        }
        $user = $_SESSION['email'];
        $this->cart_model->delItemInCart($user, $pid);
        //Some problems here
        $this->product_model->AddProductAmount($pid, $amount);
        redirect('/index/cart','refresh');
    }
    
    
    public function changeItemAmount() {
        if(!isset($_SESSION))
        {
            session_start();
        }
        $user = $_SESSION['email'];
        $pid = $_POST['pid'];
        //original amount in cart
        $oldAmount = $_POST['oldAmount'];
        //new amount in cart 
        $newAmount = $_POST['newAmount'];
     // opreate cart and product amount
        $this->cart_model->changeAmount($user, $pid, $newAmount);
        $this->product_model->AddProductAmount($pid, ($oldAmount - $newAmount));
       redirect('/index/cart','refresh');
    }


    public function checkout() {
           if (!isset($_SESSION)) {
            session_start();
        }
        //deal with the database;
        $order_number = $this->orders_model->checkout($_SESSION['email']);
        $this->load->view('checkout.html', $order_number);
    }



}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */