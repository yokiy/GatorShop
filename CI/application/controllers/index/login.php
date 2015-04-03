<?php

//if (!defined('BASEPATH'))
//    exit('No direct script access allowed');

//namespace GatorShop;

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        if (!isset($_SESSION)) {
            session_start();
        }
        if (empty($_SESSION['email'])) {
            $this->load->view('login.html');
        } else {
            redirect('/index/logout', 'refresh');
        }
    }

    public function log_in() {//form validation , email and password can not be empty.
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $valid = $this->form_validation->run(); //run the validtion
        if (!$valid) {// form is illegal
            $this->load->view('login.html'); // login again
        } else {
            $Email = $_POST['email'];
            $Password = $_POST['password'];
            //deal with database
            $account = $this->user_model->getUserAccount($Email, $Password);
            if ($account != NULL) {
                $valid = True;
            } else {
                $valid = false;
            }
//            $valid = $this->backend->login($Email, $Password);
//			$valid=true;
            if (!$valid) {
                $this->load->view('login2.html');
            } else {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['email'] = $Email;
                redirect('/index/product', 'refresh');
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */