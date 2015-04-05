<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Cart_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

// add item to cart with each user and product
    public function addToCart($user, $pid, $am) {
        $time = new DateTime('now');
        $num = $this->existItem($user, $pid);
//check if item is in cart
        $date = $time->format('Y-m-d H:i:s');
        $amount = $am+$num;
        $format = 'yyyy-mm-dd hh24:mi:ss';
        $sql = "INSERT INTO YAN.CART(cart_id, dt, amount, username, pid)  VALUES ( SEQUENCE_CART.Nextval, To_date(?, ?), ?, ?, ?)";
        $this->db->query($sql, array($date, $format, $amount, $user, $pid));

    }

//detemine the amount of the exsiting product in cart
    public function existItem($user, $pid) {
        $sql = 'select * from YAN.CART where username = ?  And pid = ?';
        $result = $this->db->query($sql, array($user, $pid));
        if ($result->num_rows() > 0) {
            foreach ($result->result_array() as $row) {
                $amount = $row['AMOUNT'];
            }
        } else {
            $amount = 0;
        }
        return $amount;
    }

// change the amount of certain item in cart, $num > 0
    public function changeAmount($user, $pid, $num) {
        if ($this->existItem($user, $pid) <= 0) {
            $this->addToChart($user, $pid, $num);
        }
        $sql = 'update cart set amount = ? where username = ?  And pid = ?';
        $this->db->query($sql, array($num, $user, $pid));
    }

    //delete item in cart for checkout or cart expiration
    public function delItemInCart($user, $pid) {
        if ($this->existItem($user, $pid) > 0) {
            $sql = 'DELETE FROM cart WHERE username = ? And pid = ?';
            $this->db->query($sql, array($user, $pid));
            return true;
        } else {
            return false;
        }
    }

}
