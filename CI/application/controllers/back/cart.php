<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class cart extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('cart_model');
    }

    //test insert item  date fixed   passed
    public function addToCart() {
        $user = 'simon@test.c';
        $pid =  20140401;
        $num = 3;
        $this->cart_model->addToCart($user, $pid, $num);
        $result = $this->cart_model->existItem($user, $pid);
        if ($result > 0)  {
        echo 'success';
        echo $result;
        } else {
            echo 'failed';
        }
    }
    
    //test change amount passed
    public function changeAmount() {
        $user = 'jack@test.c';
        $pid = 20140401;
        $num = 5;
        $this->cart_model->changeAmount($user, $pid, $num);
    }
    
//test delete item passed
    public function delItem() {
         $user = 'jack@test.c';
        $pid = 20140401;
        $this->cart_model->delItemInCart($user, $pid);
    }
    
}