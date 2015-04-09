<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->model('orders_model');
    }

    //username test passed
    public function index() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (empty($_SESSION['email'])) {
            redirect('/index/login', 'refresh');
        } else {
            $data = $this->user_model->getUserAccount($_SESSION['email']);
            //order_history is also a big array, including mutiple orders
            $data['order']  = $this->orders_model->orderHistory($_SESSION['email']);
            $this->load->view('account.html', $data);
        }
    }

    public function modify() {
           if (!isset($_SESSION)) {
            session_start();
        }
        //deal with database
        $data = $this->user_model->getUserAccount($_SESSION['email']);
        $this->load->view('update.html', $data);
    }

    public function update() {
        //post
        $data['FNAME'] = $_POST['firstname'];
        $data['LNAME'] = $_POST['lastname'];
        $data['GENDER'] = $_POST['gender'];
        $data['CELLPHONE'] = $_POST['cellphone'];
        $data['CITY'] = $_POST['city'];
        $data['ZIPCODE'] = $_POST['zipcode'];
        $data['ADDRESS'] = $_POST['address'];
        $data['STATE'] = $_POST['state'];
        $data['PASSWORD'] = $_POST['r_password1'];

        $this->load->library('form_validation');
        $this->form_validation->set_rules('firstname', 'FirstName', 'required|alpha');
        $this->form_validation->set_rules('lastname', 'LastName', 'required|alpha');
        $this->form_validation->set_rules('gender', 'Gender', 'required');
        $this->form_validation->set_rules('cellphone', 'Cellphone', 'required');
        $this->form_validation->set_rules('city', 'City', 'required|alpha');
        $this->form_validation->set_rules('zipcode', 'Zipcode', 'required|integer|exact_length[5]|');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('r_password1', 'Password1', 'required|min_length[6]|alpha_numeric');
        $this->form_validation->set_rules('r_password2', 'Password2', 'required|min_length[6]|alpha_numeric|matches[r_password1]');
        $valid = $this->form_validation->run(); //run the validtion
        if (!$valid) {// form is illegal
            $this->load->view('update.html', $data); // login again
        } else {
           /* $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $cellphone = $_POST['cellphone'];
            $city = $_POST['city'];
            $zipcode = $_POST['zipcode'];
            $address = $_POST['address'];
            $state = $_POST['state'];
            //$email = $_POST['email'];
            $password = $_POST['r_password1'];
            
//modify
            $data = array();
            $data['fname'] = $fname;
            $data['lname'] = $lname;
            $data['gender'] = $gender;
            $data['cellphone'] = $cellphone;
            $data['city'] = $city;
            $data['zipcode'] = $zipcode;
            $data['address'] = $address;
            $data['state'] = $state;
            $data['password'] = $password;*/         
            // where is username?
            if (!isset($_SESSION)) {
                session_start();
            }
            $data['USERNAME'] =  $_SESSION['email'];
            //deal with database
            $this->user_model->updateUserAccount($data);
            redirect('/index/product', 'refresh');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */