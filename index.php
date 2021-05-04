<?php
require './connection.php';
require './mailer.php';
?>

<?php
if (isset($_POST['name'])) {
    $username = $_POST['name'];
    $usermail = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $gender_value = $_POST['Gender'];
    $bool = 0;

    $findmail = "SELECT usermail FROM users WHERE usermail = ?";
    $stmt = $conn->prepare($findmail);
    $stmt->bind_param("s", $usermail);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows() == 1) {
        echo json_encode([
            "status" => false,
            "number" => 0,
            "message" => 'Email already exists'
        ]);
        die;
    } else {
        if ($password == $password2) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (`username`,`usermail`,`password`,`gender`, `verification`) VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $username, $usermail, $hashed_password, $gender_value, $bool);
            $stmt->execute();
            $hashedlink = "http://blogsite.test/?getvlink=" . $hashed_password . "&vmail=" . $usermail;
            $linkmessage = "verify your E-mail for the registration";
            echo json_encode([
                "status" => true,
                "message" => 'Registration Successful'
            ]);
            $verify = new mailer($usermail, $hashedlink, $linkmessage);
            $verify->send_mail();
            die;
        } else {
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
    $sql = "SELECT `usermail`,`verification` FROM users WHERE usermail = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $usermail);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $valid = $row['verification'];
    $count = $result->num_rows;
    if ($count == 1) {
        if ($valid == 0) {
            echo json_encode([
                "status" => false,
                "message" => "unverified email!"
            ]);
            die;
        } else {
            $sql = "SELECT `username`, `password` FROM users WHERE usermail = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $usermail);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $activeUser = $row['username'];
            $usercode = $row['password'];
            if (password_verify($password, $usercode)) {
                $_SESSION['currentUser'] = $activeUser;
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
    $hashingmail = password_hash($mailhere, PASSWORD_DEFAULT);
    $resetlink = "http://blogsite.test/forgetpass.php?rlink=" . $hashingmail . "&umail=" . $mailhere;
    $resetmessage = "reset you password for account";
    echo json_encode([
        "status" => true,
        "message" => "recovery email sent"
    ]);
    $reset = new mailer($mailhere, $resetlink, $resetmessage);
    $reset->send_mail();
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

        $getmail = $_GET['vmail'];
        $bool = 1;
        $sql = "UPDATE `users` SET `verification` = ? WHERE `usermail` = '$getmail'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $bool);
        $stmt->execute();
        $effect = $stmt->affected_rows;
        if ($effect == 1) {
            echo "<script>activation();</script>";
        }
    }
    ?>
</body>

</html>