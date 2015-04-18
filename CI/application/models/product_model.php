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
            $product = $result->result_array();
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
    public function decreaseProductAmount($id) {
        $sql = 'update Product set amount = amount-1  where pid='.$id;
        $this->db->query($sql);
    }

    //add product amount when cart changes with amount
    public function AddProductAmount($pid, $amount) {
        $pid = intval($pid);
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
        $sql = 'select amount from PRODUCT where pid ='.$id;
        $stock = $this->db->query($sql);
        $result = $stock->result_array();
        return $result;
    }

    //sort product in a category by order of sales amount in recent three month
    public function sortProductBySalesCategory($cate) {
        $sql = ' select product.*  from (select orders.pid as op,  sum(orders.amount) as countnum from orders group by orders.PID), product where op= product.pid and product.category = ?  order by countnum DESC';
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
    
    public function selectProduct($gender,$category,$lowprice,$highprice){
        $sql='select * 
                                 from product
                                 where pid in  (select * from    
                                ( select product.pid
                                  from product, orders,customer
                                  where product.pid=orders.pid
                                  and customer.username=orders.username
                                  and customer.rate>=?
                                  and product.category=?
                                  and price>=?
                                  and price<=?
                                  group by product.pid
                                  order by count(*) desc)
                                where rownum <=20)';
        $result = $this->db->query($sql, array($gender,$category,$lowprice,$highprice));
        $select = $result->result_array();
        return $select;}
        
    public function topFiveCategory($username){
        $sql='select * from
                                (select category,count(*) as catnum
                                from product 
                                where pid in( select pid
                                              from orders
                                              where DT > (select sysdate - interval '3' month from dual)
                                                    
                                              and username=?) 
                                group by category order by count(*) desc) where rownum <=5 ';
        $result = $this->db->query($sql, array($username));
        $history = $result->result_array();
        return $history;}
    
    
      public function others ($username){
        $sql= 'select * from product
                                where pid in (select pid
                                from orders
                                where username in ( select * from(
                                            select o2.username
                                            from orders o1,orders o2
                                            where o1.pid=o2.pid
                                            and o2.username!=o1.username
                                            and o2.username!=?
                                            group by o2.username
                                            order by count(*) desc)              
                                           where rownum<=5)
                                and rownum<=5)';
        
        
                
        $result = $this->db->query($sql, array($username));
        $other = $result->result_array();
        return $other;}
        
        public function Recommend($pid){
            $sql=' select pid,sum(amount) from orders where orders.username in (select distinct username from orders where orders.pid=?) and pid!=? group by pid order by sum(amount) desc';
            $result =$this->db->query($sql,array($pid));
            $recommend=$result->result_array();
            
            return $recommend;}
            
        public function SimilarUser($username) {
        $sql = ' select username  from (select username,count(*) from orders where username!=? and pid in (select distinct pid from orders where username=?) group by username order by count(*)) where rownum<=5';
        $result = $this->db->query($sql, array($username));
        $users = $result->result_array();
        return $users; }
        public function SearchByAuthor($author){
            $sql='select * from product where author = ?';
            $result=$this->db->query($sql,array($author));
            $book=$result->result_array();
            return $book;
        }
        public function SearchByPublication($publication){
            $sql='select * from product where publication = ?';
            $result=$this->db->query($sql,array($publication));
            $book=$result->result_array();
            return $book;
        }
        public function SearchByPublisher($publisher){
            $sql='select * from product where author = ?';
            $result=$this->db->query($sql,array($publisher));
            $book=$result->result_array();
            return $book;
        }
    
    
        
        
        
        
    }


