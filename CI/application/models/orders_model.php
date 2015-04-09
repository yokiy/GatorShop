<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Orders_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('cart_model');
    }

    public function isExisted($od) {
        $sql = 'select order_number from orders';
        $result = $this->db->query($sql);
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                if (in_array($od, $row)) {
                    var_dump($row);
                    return TRUE;
                }
            }
            return FALSE;
        }
        return FALSE;
    }

    public function generateOD() {
        $order_number = mt_rand(10000000, 99999999);
        while ($this->isExist($order_number)) {
            $order_number = mt_rand(10000000, 99999999);
        }
        return $order_number;
    }

    public function isExist($od) {
        $sql = 'select * from YAN.ORDERS where order_number = ?';
        $this->db->query($sql,array($od));
    }
            
//    insert records into orders table and generate eight digit order_number
//return selected item  and price
    public function checkout($user) {
        $order_number = $this->generateOD();
        $time = new DateTime('now');
        $date = $time->format('Y-m-d H:i:s');
        $format = 'yyyy-mm-dd hh24:mi:ss';
        $items = $this->cart_model->getCart($user);
        foreach ($items as $item) {
            $pid =  intval($item['PID']);
            $amount = intval($item['AMOUNT']);
            $sql = 'insert into orders values(SEQ_order.nextval, to_date(?, ?), 0, null , ?, ?, ?, ?)';
            $this->db->query($sql, array($date, $format, $user, $pid, $amount, $order_number));            
        }
        $this->cart_model->emptyCart($user);
        return $order_number;
    }

//user can rate  comment item with every order
    public function rateOrder($order_id, $rate, $review) {
        $sql = 'update orders set rate = ?, review = ? where order_id = ' . $rate;
        $this->db->query($sql, array($rate, $review, $order_id));
    }

// retrieve order history of a user
    public function orderHistory($user) {
        $sql = 'select orders.order_number  from orders,  product where orders.pid = product.pid and orders.username = ?';
        $result = $this->db->query($sql, array($user));
        if ($result->num_rows() > 0) {
            $ret = $result->result_array();
        } else {
            $ret = NULL;
        }
        return $ret;
    }

//get order detail by orderId
    public function getOrderByOrderId($id) {
        $sql = 'select * from orders where order_id = ' . $id;
        $result = $this->db->query($sql);
        $orders = $result->result_array();
        return $orders;
    }

    //get order details by order number
    public function getOrderDetail($od) {
        $sql = 'select orders.*, product.TITLE, product.PRICE, product.PRICTURE from orders, product where product.pid = orders.pid and orders.order_number = ?';
        $result = $this->db->query($sql, array($od));
        $order = $result->result_array();
        return $order;
    }

}
