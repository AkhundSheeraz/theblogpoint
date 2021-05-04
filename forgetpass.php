<?php require './connection.php' ?>
<?php
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
                    <h4 class="text-center text-white"><?php echo $getmail ?></h4>
                    <input class="frminputs" type="password" name="recode" id="pass" placeholder="New password">
                    <input class="frminputs" type="password" name="recode2" id="pass1" placeholder="Confirm-password">
                    <button class="btn btn-success py-0 w-50" type="submit">Change Password</button>
                </form>
            </div>

            <?php include './views/footer.php' ?>
        </body>

        </html>
    <?php } else {
        echo "404 not found!";
    } ?>
<?php } else {
    echo "404 not found!";
} ?>