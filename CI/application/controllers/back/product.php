<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class Product extends CI_Controller {
    
    public function __construct() {
        parent::__construct();
        $this->load->model('product_model');
    }
    
    //test can get Product by Id return as CI Array 
    public function getProductById() {
       $result = $this->product_model->getProductById(21354);
       var_dump($result);
    }
}
