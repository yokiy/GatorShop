<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//namespace GatorShop;


Class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function register($uname, $pass, $fname, $lname, $gender, $addr, $city, $state, $zipcode, $tel) {
        if ($this->user_model->createNewUser($uname, $pass, $fname, $lname, $gender, $addr, $city, $state, $zipcode, $tel)) {
            return TRUE;
        } else {
            return false;
        }
    }

    //dispaly user account info, show account page
    public function getuser($uname, $pass) {
        $account = $this->user_model->getUserAccount($uname, $pass);
        return $account;
    }

    //show welcom info with matching username and password
    public function login($uname, $pass) {
        $account = $this->user_model->getUserAccount($uname, $pass);
        if ($account != NULL) {
            return True;
        } else {
            return false;
        }
    }
    
    public function updateAccount() {
        $data = array(
            'username' => 'jack@test.c',
            'password' => '1236v',
            'gender' => 'M',
        );
        $this->user_model->updateUserAccount($data);
        echo 'updated';
    }

}
