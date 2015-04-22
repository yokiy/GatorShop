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
        $sql = 'select * from PRODUCT where pid = ? ';
        $result = $this->db->query($sql, array($id));
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
            $products = $result->result_array();
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
            $products = $result->result_array();
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
            $products = $result->result_array();
        } else {
            $products = NULL;
        }
        return $products;
    }

    //decrease product amount by 1
    public function decreaseProductAmount($id, $am) {
        $sql = 'update Product set amount = amount- ?  where pid= ? ';
        $this->db->query($sql, array($am, $id));
    }

    //add product amount when cart changes with amount
    public function AddProductAmount($pid, $amount) {
//        $pid = intval($pid);
        $amount = intval($amount);
        $sql = 'update Product set amount = amount + ?  where pid=?';
        $this->db->query($sql, array($amount, $pid));
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
        $sql = 'select amount from PRODUCT where pid = ? ';
        $stock = $this->db->query($sql, array($id));
        $result = $stock->result_array();
        return $result;
    }

    //sort product in a category by order of sales amount in recent three month
    public function sortProductBySalesCategory($cate) {
        $sql = 'select  product.*  from (select orders.pid as op,  sum(orders.amount) as countnum from orders group by orders.PID), product where op= product.pid and product.category = ?  order by countnum DESC';
        $result = $this->db->query($sql, array($cate));
        $products = $result->result_array();
        return $products;
    }

    //sort product by rate
    public function sortProductByRate($cate) {
        $sql = 'select * from product where category = ? order by product.RATE DESC';
        $result = $this->db->query($sql, array($cate));
        $ret = $result->result_array();
        return $ret;
    }

    //product with rate between price range
    public function selectProductwithRateBetweenPriceRange($rate, $category, $lowprice, $highprice) {
        $sql = 'select *  from product
                                   where rate >= ? and price <= ? and price >= ? and category = ? order by rate desc';
        $result = $this->db->query($sql, array($rate, $highprice, $lowprice, $category));
        $select = $result->result_array();
        return $select;
    }

    public function Recommend($pid) {
        $sql = 'select * from(select * from product p,(select pid as inpid,sum(amount) as tot from orders where orders.username in (select distinct username from orders where orders.pid= ?) and pid != ? group by pid) where p.pid=inpid order by tot) where rownum<=5';
        $result = $this->db->query($sql, array($pid, $pid));
        $recommend = $result->result_array();

        return $recommend;
    }

    //search product title contained $name
    public function getProductByName($name) {
        $name = '%' . $name . '%';
        $sql = 'select * from PRODUCT where lower(title) like lower(?)';
        $result = $this->db->query($sql, array($name));
        if ($result->num_rows() > 0) {
            $product = $result->result_array();
        } else {
            $product = NULL;
        }
        return $product;
    }

    // publisher and author

    public function getProductByAuthor($name) {
        $name = '%' . $name . '%';
        $sql = 'select * from PRODUCT where lower(author) like lower(?)';
        $result = $this->db->query($sql, array($name));
        if ($result->num_rows() > 0) {
            $product = $result->result_array();
        } else {
            $product = NULL;
        }
        return $product;
    }

    public function getProductByPublisher($name) {
        $name = '%' . $name . '%';
        $sql = 'select * from PRODUCT where lower(publisher) like lower(?)';
        $result = $this->db->query($sql, array($name));
        if ($result->num_rows() > 0) {
            $product = $result->result_array();
        } else {
            $product = NULL;
        }
        return $product;
    }

    public function getTheBestSellerOfThisMonth() {
        // get the month of current time
//        $month = date('ym');
        $format = 'yyyy-mm-dd';
        $begin = date('Ymd', strtotime('-3 month'));
        $end = date('Ymd', strtotime('+1 month'));

        $sql = 'select * from product, (select  orders.PID as op, sum(orders.amount) as countnum  from product, orders where product.PID = orders.pid 
                        and orders.DT > to_date(?,  ?) 
                        and orders.DT < to_date(?, ?)
                        group by orders.PID) where product.PID = op and rownum = 1';

        $result = $this->db->query($sql, array($begin, $format, $end, $format));
        if ($result->num_rows() > 0) {
            $product = $result->result_array();
        } else {
            $product = NULL;
        }
        return $product;
    }
    
    public function RecommendByCategory($cate) {
        $sql = 'select * from ( select  product.*  from (select orders.pid as op,  sum(orders.amount) as countnum from orders group by orders.PID), product where op= product.pid and product.category = ?  order by countnum DESC) where rownum <=5';
        $result = $this->db->query($sql, array($cate));
        $products = $result->result_array();
        return $products;
    }
    
     public function getAllProductCount(){
        $sql = 'select count(*) as count from product';
        $result = $this->db->query($sql);
        $count = $result->result_array()[0]['COUNT'];
        return $count;
     }
     
     public function getAllCustomerCount() {
         $sql = 'select count(*) as count from customer';
         $result = $this->db->query($sql);
         $count = $result->result_array()[0]['COUNT'];
         return $count;
     }

     public function getAllOrdersCount() {
         $sql = 'select count(*) as count from orders';
         $result = $this->db->query($sql);
         $count = $result->result_array()[0]['COUNT'];
         return $count;
     }
         public function getAllCartCount() {
         $sql = 'select count(*) as count from cart';
         $result = $this->db->query($sql);
         $count = $result->result_array()[0]['COUNT'];
         return $count;
     }
}
