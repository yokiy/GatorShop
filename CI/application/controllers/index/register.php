<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function index() {
        $this->load->view('register.html');
    }

    public function sign_up() {//form validation , email and password can not be empty.
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
            $this->load->view('register.html'); // login again
        } else {
            $fname = $_POST['firstname'];
            $lname = $_POST['lastname'];
            $gender = $_POST['gender'];
            $cellphone = $_POST['cellphone'];
            $city = $_POST['city'];
            $zipcode = $_POST['zipcode'];
            $address = $_POST['address'];
            $state = $_POST['state'];
            $email = $_POST['email'];
            $password = $_POST['r_password1'];
            if ($this->user_model->createNewUser($email, $password, $fname, $lname, $gender, $address, $city, $state, $zipcode, $cellphone)) {
                $valid = TRUE;
            } else {
                $valid = false;
            }

            //deal with database

            $valid = true;
            if (!$valid) {
                $this->load->view('register2.html');
            } else {
                if (!isset($_SESSION)) {
                    session_start();
                }
                $_SESSION['email'] = $email;
                redirect('/index/product', 'refresh');
            }
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */