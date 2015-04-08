<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Orders extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('orders_model');
    }

    //test passes false does not return 
    public function checkExistence() {
        $od = 10000010;
        $boolean = $this->orders_model->isExisted($od);
        echo $boolean;
    }

    //test passed
    public function getOrderById() {
        $id = 1;
        $ret = $this->orders_model->getOrderByOrderId($id);
        var_dump($ret[0]['ORDER_NUMBER']);
    }

    //test passes
    public function getOrderHistory() {
        $user = 'simon@test.c';
        $orders = $this->orders_model->orderHistory($user);
        //var_dump($orders);
        foreach ($orders as $order) {
            echo $order['ORDER_NUMBER'];
            echo "<br>";
        }
    }

    // test passed, get big array
    public function getOrderDetail() {
        $od = 10000000;
        $result = $this->orders_model->getOrderDetail($od);
//        var_dump($result);
        $total = $this->getTotal($result);
        $result['total'] = $total;
        var_dump($result);
    }

    public function getTotal($order) {
        foreach ($order as $item) {
            $total += $item['PRICE'] * $item['AMOUNT'];
        }
        return $total;
    }
    
    public function checkout() {
        $user = 'simon@test.c';
        $od =  $this->orders_model->checkout($user);
        echo $od;
    }

}
