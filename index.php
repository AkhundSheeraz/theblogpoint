<?php require './classes.php'?>

<?php
if (isset($_POST['name'])) {
    $username = $_POST['name'];
    $usermail = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $gender_value = $_POST['Gender'];
    $bool = 0;

    $create_user = new User($usermail,$password);
    $user_exists = $create_user->mail_indb();
    if($user_exists == true){
        echo json_encode([
            "status" => false,
            "number" => 0,
            "message" => 'Email already exists'
        ]);
        die;
    }else{
        $registration = $create_user->store_indb($username,$password2,$gender_value,$bool);
        if($registration == true){
            echo json_encode([
                "status" => true,
                "message" => 'Registration Successful'
            ]);
            $create_user->send_vemail("verify your E-mail for the registration");
            die;
        }else{
            echo json_encode([
                "status" => false,
                "number" => 1,
                "message" => 'Password did not match'
            ]);
            die;
        }
    }
}

if (isset($_POST['username'])) {
    $usermail = $_POST['username'];
    $_SESSION['activeUsermail'] = $usermail;
    $password = $_POST['password'];
    $logging  = new User($usermail, $password);
    $checkmail = $logging->mail_indb();
    if ($checkmail == true) {
        $verfication = $logging->verify_mail();
        if ($verfication == true) {
            $access = $logging->login_User();
            if ($access == true) {
                echo json_encode([
                    "status" => true
                ]);
                die;
            } else {
                echo json_encode([
                    "status" => false,
                    "type" => 1,
                    "message" => "Wrong password!"
                ]);
                die;
            }
        } else {
            echo json_encode([
                "status" => false,
                "message" => "unverified email!"
            ]);
            die;
        }
    } else {
        echo json_encode([
            "status" => false,
            "message" => "User doesn't exist!"
        ]);
        die;
    }
}

if (isset($_POST['mail']) && isset($_POST['process'])) {
    $mailhere = $_POST['mail'];
    $forgetpassword = new forget_password($mailhere);
    $forgetpassword->reset_password();
    echo json_encode([
        "status" => true,
        "message" => "recovery email sent"
    ]);
    die;
}

if (isset($_POST['status'])) {
    session_start();
    session_destroy();
    die;
}
?>
<html lang="en">

<?php include './views/header.php' ?>

<?php include './views/navbar.php' ?>

<body>
    <div class="branding">
        <h1>Join our Community now!</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, suscipit earum. Nam nulla, a consequatur quidem
            quisquam neque quasi praesentium rem, repellendus quia vero perspiciatis iste laboriosam illo suscipit. Ab.
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Expedita, nemo harum. Explicabo non illo
            reprehenderit cum! Expedita, eius numquam. Esse earum velit quos deserunt nesciunt unde at, praesentium
            quidem aliquam?
        </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, suscipit earum. Nam nulla, a consequatur quidem
            quisquam neque quasi praesentium rem, repellendus quia vero perspiciatis iste laboriosam illo suscipit. Ab.
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Expedita, nemo harum. Explicabo non illo
            reprehenderit cum! Expedita, eius numquam. Esse earum velit quos deserunt nesciunt unde at, praesentium
            quidem aliquam?
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, suscipit earum. Nam nulla, a consequatur quidem
            quisquam neque quasi praesentium rem, repellendus quia vero perspiciatis iste laboriosam illo suscipit. Ab.
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Expedita, nemo harum. Explicabo non illo
            reprehenderit cum! Expedita, eius numquam. Esse earum velit quos deserunt nesciunt unde at, praesentium
            quidem aliquam?
        </p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut, suscipit earum. Nam nulla, a consequatur quidem
            quisquam neque quasi praesentium rem, repellendus quia vero perspiciatis iste laboriosam illo suscipit. Ab.
            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Expedita, nemo harum. Explicabo non illo
            reprehenderit cum! Expedita, eius numquam. Esse earum velit quos deserunt nesciunt unde at, praesentium
            quidem aliquam?
        </p>
    </div>
    <?php include './views/footer.php' ?>
    <?php
    if (isset($_GET['getvlink']) && !empty($_GET['getvlink']) && isset($_GET['vmail']) && !empty($_GET['vmail'])) {
        $getvlink = $_GET['getvlink'];
        $getmail = $_GET['vmail'];
        if (password_verify($getmail, $getvlink)) {
            $bool = 1;
            $sql = "UPDATE `users` SET `verification` = ? WHERE `usermail` = '$getmail'";
            $stmt = DB_connect::getConn()->prepare($sql);
            $stmt->bind_param("i", $bool);
            $stmt->execute();
            $effect = $stmt->affected_rows;
            if ($effect == 1) {
                echo "<script>
                const success = {type:true, msg:'Account activated please login'};
                activation(success);
                </script>";
            } else {
                echo "Acitvation failed";
                die;
            }
        } else {
            echo "
            <script>
            const err = {type:false, msg:'Invalid link'};
            activation(err);
            </script>
            ";
            die;
        }
    }
    ?>
</body>

</html>