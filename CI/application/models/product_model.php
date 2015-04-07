<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class product_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //get product by promaykey for later use
    public function getProductById($id) {
        $sql = 'select * from PRODUCT where pid =' . $id;
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $product = $result->row_array();
        } else {
            $product = NULL;
        }
        return $product;
    }

    //search product title contained $name
    public function getProductByName($name) {
        $sql = 'select * from PRODUCT where lower(title) like lower(?)';
        $result = $this->db->query($sql, array($name));
        if ($result->num_rows() > 0) {
            $product = $result->row_array();
        } else {
            $product = NULL;
        }
        return $product;
    }

    //display all product in certain category
    public function getProductByCategory($cate) {
        $cate = '\'' . $cate . '\'';
        $sql = 'select * from PRODUCT where category= ' . $cate;
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            $product = $result->result_array();
            var_dump($product);
        } else {
            $product = NULL;
        }
        return $product;
    }

    // sorting products by price in ascending order within certain category
    public function sortProductByPriceAsc($cate) {
        $sql = 'select * from PRODUCT where category= ? order by price asc';
        $result = $this->db->query($sql, array($cate));
        if ($result->num_rows() > 0) {
            $products = $result->row_array();
        } else {
            $products = NULL;
        }
        return $products;
    }

    //sort product by price in descending order within certain category
    public function sortProductByPriceDesc($cate) {
        $sql = 'select * from PRODUCT where category= ? order by price desc';
        $result = $this->db->query($sql, array($cate));
        if ($result->num_rows() > 0) {
            $products = $result->row_array();
        } else {
            $products = NULL;
        }
        return $products;
    }

    public function getProductInPriceRange($min, $max) {
        // if input is invalid, use default range
        if ($min < 0 || $min == NULL) {
            $min = 0;
        }
        if ($max == NULL) {
            $max = PHP_INT_MAX;
        }
        //if range is invalid return Null
        if ($min > $max) {
            return NULL;
        }
        $sql = 'select * from PRODUCT where price  between ? and ?;';
        $result = $this->db->query($sql, array($min, $max));
        if ($result->num_rows() > 0) {
            $products = $result->row_array();
        } else {
            $products = NULL;
        }
        return $products;
    }

    //decrease product amount by 1
    public function decreaseProductAmount($id) {
        $sql = 'update Product set amount = amount-1  where pid=?;';
        $this->db->query($sql, array($id));
    }

    //add rate to product rate for each customer's rate
    //increase rate_num for average rate caculation
    public function rateProduct($rate, $id) {
        $sql = 'update Product set rate = rate+?, rate_num=rate_num+1 where pid=?';
        $this->db->query($sql, array($rate, $id));
    }

    //retrieve average rate for a product
    public function getAverageProduct($id) {
        $sql = 'select rate/rate_num  as average_rate from product where pid=?';
        $rate = $this->db->query($sql, array($id));
        $ret = $rate->result_array();
        return $ret;
    }

    //check product stock
    public function checkProductStock($id) {
        $sql = 'select amount from PRODUCT where pid =?';
        $stock = $this->db->query($sql, array($id));
        return $stock;
    }

    //sort product in a category by order of sales amount in recent three month
    public function sortProductBySalesCategory($cate) {
        $sql = 'select product.pid, count(*) as count from product,  orders  where orders.pid = product.pid and product.category = ? group by product.PID order by count DESC';
        $pids = $this->db->query($sql, array($cate));
        return $pids;
    }

    //sort product by rate
    public function sortProductByRate($cate) {
        $sql = 'select * from product where category = ? order by product.RATE DESC ;';
        $result = $this->db->query($sql, array($cate));
        $ret = $result->result_array();
        return $ret;
    }

}
