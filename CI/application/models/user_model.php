<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_Model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //register new user with username(primary key), and password
    public function createNewUser($uname, $pass, $fname, $lname, $gender, $addr, $city, $state, $zipcode, $tel) {

        if ($this->IsValidUserName($uname)) {
            $data = array(
                'username' => $uname,
                'password' => $pass,
                'fname' => $fname,
                'lname' => $lname,
                'gender' => $gender,
                'address' => $addr,
                'city' => $city,
                'state' => $state,
                'zipcode' => $zipcode,
                'cellphone' => $tel,
            );
            $sql = "INSERT INTO Customer (username, password,  gender,fname, lname, address, cellphone, city, province, zipcode)  VALUES (?, ?,?,?,?,?,?,?,?,?)";
            $this->db->query($sql, $data);
            return true;
        } else {
            echo "repeated username";
            return false;
        }
    }

    //retrieve user info with valid username and password
    public function getUserAccount($uname, $pass) {
        if (strlen($uname) != 0 && strlen($pass) != 0) {
//            $uname = '\''.$uname.'\'';
//            $pass =  '\''.$pass.'\'';
            $query = "select * from Customer where username = ? AND password = ?";
            $account = $this->db->query($query, array($uname, $pass));
//            $account = $result->db->result_array();
            if ($account->num_rows() > 0) {
                $info = $account->row_array();
            } else {
                $info = NULL;
            }
        }
//            if ($account == null) {
//                return "not valid username or password";
//            } else {
        return$info;
//            }
//        }
    }

    public function IsValidUserName($uname) {
        $uname = '\'' . $uname . '\'';
        $query = "select * from Customer where username = " . $uname;
        $account = $this->db->query($query);
        if (($account->num_rows()) == 0) {
            return true;
        } else {
            var_dump($account);
            return false;
        }
    }

//update user info 
    public function updateUserAccount($data) {
        if ($data != null || strlen($data) != 0) {
            $sql = "select * From Customer where username = " . $data['username'];
            $account = $this->db->query($sql);
            $this->db->update('Customer', $data);
//            $fname = $data['fname'];
//            $lname = $data['lname'];
//            $gender = $data['gender'];
        }
    }

    public function changePass($uname, $password) {
        if ($password != null || strlen($password) != 0) {
            $sql = "select * From Customer where username = " . $uname;
            $account = $this->db->query($sql);
            if ($account['password'] != $password) {
                $sql = 'update  Customer set password= ? where username =?';
                $this->db->query($sql, array($password, $uname));
            } else {
                echo 'new password can not be same with old password';
            }
        } else {
            echo 'new password can not be empty';
        }
    }

}
