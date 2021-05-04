<?php
require './connection.php';
?>

<html lang="en">

<?php include './views/header.php' ?>

<?php include './views/navbar.php' ?>

<body>

    <div class="containfp">
        <form class="forgetpass" id="resetcode">
            <img class="invert" src="./img/userblack.png" alt="user">
            <h3 class="text-center text-white">Username</h3>
            <input class="frminputs" type="password" name="recode" id="pass" placeholder="New password">
            <input class="frminputs" type="password" name="recode2" id="pass1" placeholder="Confirm-password">
            <button class="btn btn-success py-0 w-50" type="submit">Change Password</button>
        </form>
    </div>

    <?php include './views/footer.php' ?>
</body>

</html>