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
    public function createNewUser($uname, $pass, $fname, $lname, $gender, $addr, $city, $state, $zipcode, $tel, $img) {

        if ($this->IsValidUserName($uname)) {
            $data = array(
                'username' => $uname,
                'password' => $pass,
                 'gender' => $gender,
                'fname' => $fname,
                'lname' => $lname,
                'address' => $addr,
                'city' => $city,
                'province' => $state,
                'zipcode' => $zipcode,
                'cellphone' => $tel,
                'img' => $img
            );
//            $sql = "INSERT INTO Customer (username, password,  gender)  VALUES (?, ?,?)";
            $sql = "INSERT INTO Customer (username, password,  gender, fname, lname, address, cellphone, city, province, zipcode, portrait)  VALUES (?, ?,?,?,?,?,?,?,?,?, ?)";
            $this->db->query($sql, $data);
            return true;
        } else {
            return false;
        }
    }

    //retrieve user info with valid username and password
    public function getUserAccount($uname) {
//        if (strlen($uname) != 0 && strlen($pass) != 0) {
//            $uname = "\'".$uname."\'";
//            $pass =  '\''.$pass.'\'';
            $query = "select * from Customer where username = ? ";
            $account = $this->db->query($query, array($uname));
            if ($account->num_rows() > 0) {
                $info = $account->row_array();
            } else {
                $info = NULL;
            }
        return$info;
    }

    public function IsValidUserName($uname) {
        $uname = '\'' . $uname . '\'';
        $query = "select * from Customer where username = " . $uname;
        $account = $this->db->query($query);
        if (($account->num_rows()) == 0) {
            return true;
        } else {
//            var_dump($account);
            return false;
        }
    }

//update user info 
 //arg $data should be a array with db attributes 
    public function updateUserAccount($data) {
        if ($data != null || strlen($data) != 0) {
          $sql = "UPDATE Customer  SET  password = ?, gender = ?, FNAME =?, LNAME=?, ADDRESS=?,	CELLPHONE =?, CITY=?,ZIPCODE=?, PROVINCE=?  WHERE  username= ? ";
           $this->db->query($sql, array($data['password'], $data['gender'], $data['fname'], $data['lname'], $data['address'], $data['cellphone'], $data['city'], $data['zipcode'], $data['province'], $data['username']));
        }
    }
    
      public function SimilarUser($username) {
        $sql = 'select * from(select *  from Customer c, (select username as suser,count(*) as tot from orders where username !=? and pid in (select distinct pid from orders where username=?) group by username order by count(*) desc) where c.username=suser) where rownum<=5';
        $result = $this->db->query($sql, array($username, $username));
        $users = $result->result_array();
        return $users;
    }
    
     public function topFiveCategory($username){
        $sql='select * from
                                (select category,count(*) as catnum
                                from product 
                                where pid in( select pid
                                              from orders  
                                             where username=?) 
                                group by category order by count(*) desc) where rownum <=5 ';
        $result = $this->db->query($sql, array($username));
        $data= $result->result_array();
        return $data;}
        

//    public function changePass($uname, $newpass) {
//        if ($newpass != null || strlen($newpass) != 0) {
//            $account = $this->getUserAccount($uname, $oldpass);
//            if ($account != NULL) {
//                $sql = 'update  Customer set password= ? where username =?';
//                $this->db->query($sql, array($password, $uname));
//            } else {
//                echo 'new password can not be same with old password';
//            }
//        } else {
//            echo 'new password can not be empty';
//        }
//    }

}
