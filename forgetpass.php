<?php require './connection.php' ?>
<?php
if (isset($_POST['recode']) && isset($_POST['recode2']) && isset($_POST['headmail'])) {
    $mailhere = $_POST['headmail'];
    $passcode = $_POST['recode'];
    $passcode2 = $_POST['recode2'];
    if ($passcode == $passcode2) {
        $encode_pass = password_hash($passcode, PASSWORD_DEFAULT);
        $sql = "UPDATE `users` SET `password` = ? WHERE `usermail` = '$mailhere'";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $encode_pass);
        $stmt->execute();
        $post_effect = $stmt->affected_rows;
        if($post_effect == 1){
            echo json_encode([
                "type" => true,
                "message" => "Password changed succesfully"
            ]);
            die;
        }else{
            echo json_encode([
                "type" => false,
                "message" => "Password change unsuccesful!"
            ]);
            die;
        }
    } else {
        echo json_encode([
            "type" => false,
            "message" => "Password not matching"
        ]);
        die;
    }
}

if (isset($_GET['rlink']) && !empty($_GET['rlink']) && isset($_GET['umail']) && !empty($_GET['umail'])) {
    $getmail = $_GET['umail'];
    $gethashlink = $_GET['rlink'];
    $sql = "SELECT `usermail` FROM `users` WHERE `usermail` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $getmail);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $result->num_rows;
    if ($count == 1) {
?>

        <html lang="en">

        <?php include './views/header.php' ?>

        <?php include './views/navbar.php' ?>

        <body>

            <div class="containfp">
                <form class="forgetpass" id="resetcode">
                    <img class="invert" src="./img/userblack.png" alt="user">
                    <h4 class="setmail text-center text-white"><?php echo $getmail ?></h4>
                    <input class="frminputs" type="password" name="recode" id="pass" placeholder="New password" required>
                    <input class="frminputs" type="password" name="recode2" id="pass1" placeholder="Confirm-password" required>
                    <p id="codechangemsg" class="text-center"></p>
                    <button class="btn btn-success py-0 w-50" type="submit">Change Password</button>
                </form>
            </div>

            <?php include './views/footer.php' ?>
        </body>

        </html>
    <?php } else {
        echo "user does'nt exist!";
    } ?>
<?php } else {
    echo "404 not found!";
} ?>