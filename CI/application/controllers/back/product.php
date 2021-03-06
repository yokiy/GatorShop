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
    public function getProduct() {
        $result = $this->product_model->getProductById(21354);
//       var_dump($result);
        //echo $result['TITLE'];
    }

    //TEST can get products in a category passed
    //can get each item as a big array
    public function getProductByCategory() {
        $cate = 'Book';
        $results = $this->product_model->getProductByCategory($cate);
        var_dump($results);
        foreach ($results as $product) {
            echo $product['TITLE'];
        }
    }

    public function sortProductBySalesCategory() {
        $cate = 'Children';
        $result = $this->product_model->sortProductBySalesCategory($cate, 5);
        var_dump($result);
    }

//    public function sortProductDesc() {
//        $cate = 'Book';
//         $this->product_model->sortProductByPriceDesc($cate);
//    }

    public function sortProductByRate() {
        $cate = 'Book';
        $result = $this->product_model->sortProductByRate($cate);
        var_dump($result);
    }

    public function checkProductStock() {
        $id = 201404041;
        $stock = $this->product_model->checkProductStock($id);
        var_dump($stock);
    }

    public function searchByRecommend() {
        $pid = 20140401;
        $result = $this->product_model->recommend($pid);
        var_dump($result);
    }

    public function SimilarUser() {
        $user = 'insert@test.com';
        $result = $this->product_model->SimilarUser($user);
        var_dump($result);
    }

    public function getTheBestSellerOfThisMonth() {
//    $user = 'insert@test.com';
        $result = $this->product_model->getTheBestSellerOfThisMonth();
        var_dump($result);
    }

    public function getAllCustomerCount() {
        $result = $this->product_model->getAllCustomerCount();
        var_dump($result);
    }
}
