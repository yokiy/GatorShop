<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Account extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    public function register() {
        if ($this->user_model->createNewUser('jjdhas@test.com', '123ooo')) {
//        if ($this->user_model->isValidUserName('peter@ss.com')) {
            echo 'valid username';
        } else {
            echo 'failed';
        }
    }

    //dispaly user account info, show account page
    public function getuser() {
        $account = $this->user_model->getUserAccount('name@test.com', '123456');
        if ($account != NULL) {
            echo $account['FNAME'];
            var_dump($account);
        } else {
            echo 'mismatch';
        }
    }

       //show welcom info with matching username and password
    public function login() {
        $account = $this->user_model->getUserAccount('name@test.com', '123456');
        if ($account != NULL) {
            echo $account['FNAME'];
            echo ', Welcome!';
        } else {
            echo 'mismatch';
        }
    }
    
//   public function  changePassword() {
//       $this->user_model->changePass('new@test.com', '123ooo' );
//       
//   }

    public function updateAccount() {
        $data = array(
            'username'=> 'jack@test.c',
            'password' => '1236v',
            'gender' => 'M',
                       
        );
        $this->user_model->updateUserAccount($data);
        echo 'updated';
    }
    
}
