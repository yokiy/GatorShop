<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Quicksearch extends CI_Controller {

    public function __construct() {
        parent::__construct();
      $this->load->model('product_model');
    }
    public function index() {
           $this->load->view('quicksearch.html');
    }

     public function quickSearch() {
         $category = $_POST['category'];
         $rate= $_POST['rate'];
         $lprice= $_POST['lprice'];
         $hprice= $_POST['hprice'];
         $data['product']=$this->product_model->selectProductwithRateBetweenPriceRange($rate,$category,$lprice,$hprice);
         $data['c'] =$category;
         $data['r'] =$rate;
         $data['l']=$lprice;
         $data['h']=$hprice;
         $this->load->view('quicksearch2.html', $data);
         
    }
    

}