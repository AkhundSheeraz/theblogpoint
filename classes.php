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

    function store_indb($name,$password2,$gender_value,$bool){
        require './connection.php';
        if($password2 == $this->pass){
            $hashed_password = password_hash($this->pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (`username`,`usermail`,`password`,`gender`, `verification`) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $name, $this->mail, $hashed_password, $gender_value, $bool);
            $stmt->execute();
            if($stmt->affected_rows == 1){
                return true;
            }else{
                return false;
            }
        }
    }
}

$name = "sheeraz";
$newmail = "akhund.sheeraz@gmail.com";
$newcode = "code";
$newcode2 = "code";
$gender = "male";
$boolen = 0;

$createuser = new User($newmail,$newcode);
$mailexist = $createuser->mail_indb();
if($mailexist == true){
    echo "usermail exists!";
}else{
    $usercreated = $createuser->store_indb($name,$newcode2,$gender,$boolen);
    if($usercreated == true){
        echo "user created data insertion success";
    }else{
        echo "user creation failed";
    }
}
