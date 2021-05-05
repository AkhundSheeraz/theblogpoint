<?php

class User
{
    public $usermail;
    public $userpass;

    function __construct($usermail, $userpass)
    {
        $this->mail = $usermail;
        $this->pass = $userpass;
    }

    function mail_indb()
    {
        require './connection.php';
        $sql = "SELECT usermail FROM users WHERE usermail = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $this->mail);
        $stmt->execute();
        $result = $stmt->get_result();
        $count = $result->num_rows;
        if($count == 1){
            return true;
        }else{
            return false;
        }
    }

    function store_indb(){
        require './connection.php';
        if($password2 == $this->pass){
            $hashed_password = password_hash($this->pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (`username`,`usermail`,`password`,`gender`, `verification`) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $username, $this->mail, $hashed_password, $gender_value, $bool);
            $stmt->execute();
            if($stmt->affected_rows == 1){
                return true;
            }else{
                return false;
            }
        }
    }
}

$newmail = "akhund.sheeraz@gmail.com";
$newcode = "code";
