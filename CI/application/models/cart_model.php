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
        $am = intval($am);
        $pid = strval($pid);
//check if item is in cart, if yes change the amount; if no inset into cart;
        $date = $time->format('Y-m-d H:i:s');
        $format = 'yyyy-mm-dd hh24:mi:ss';
        if ($num > 0) {
            $amount = $am + $num;
            $this->changeAmount($user, $pid, $amount);
        } else {
            $sql = "INSERT INTO CART(cart_id, dt, amount, username, pid)  VALUES ( SEQUENCE_CART.Nextval, To_date(?, ?), ?, ?, ?)";
            $this->db->query($sql, array($date, $format, $am, $user, intval($pid)));
        }
    }

    //display items in the cart
    public function getCart($user) {
        $sql = 'select product.amount as stock, cart.*, product.TITLE, product.PRICE, product.IMG, product.pid from CART, product where cart.PID = product.PID and username = ? ';
        $items = $this->db->query($sql, array($user));
        $result = $items->result_array();
        $total = 0;
       foreach ($result as $item) {
            $total += $item['PRICE'] * $item['AMOUNT'];
        }
        $_SESSION['total'] = $total;
        return $result;
    }

//detemine the amount of the exsiting product in cart
    public function existItem($user, $pid) {
        $sql = 'select * from CART where username = ?  And pid = ?';
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

    //empty cart for user after checkout
    public function emptyCart($user) {
        $sql = 'DELETE FROM cart WHERE username = ?';
        $this->db->query($sql, array($user));
    }

}
