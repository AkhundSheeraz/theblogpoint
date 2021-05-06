<?php require './connection.php' ?>
<?php
if (isset($_SESSION['currentUser']) && !empty($_SESSION['currentUser'])) {
    $sql = "SELECT `idusers`, `gender`,`userdp` FROM users WHERE username = ?";
    $stmt = DB_connect::getConn()->prepare($sql);
    $stmt->bind_param('s', $_SESSION['currentUser']);
    $stmt->execute();
    $result = $stmt->get_result();
    $rows = $result->fetch_assoc();
    $count = $result->num_rows;
} else {
    echo "404 not found";
    die;
}
?>
<?php
if (isset($_FILES['filename'])) {
    $allowed = array("jpg" => "image/jpg", "jpeg" => "img/jpeg", "png" => "image/png");
    $filename = $_FILES["filename"]["name"];
    $filetype = $_FILES["filename"]["type"];
    $filesize = $_FILES["filename"]["size"];
    $temp = $_FILES["filename"]["tmp_name"];

    // verify file extention
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    if (!array_key_exists($ext, $allowed)) {
        echo json_encode([
            "status" => false,
            "message" => "invalid file type!"
        ]);
        die;
    }
    //verify size of the file
    $maxsize = 5 * 1024 * 1024;
    if ($filesize > $maxsize) {
        echo json_encode([
            "status" => false,
            "message" => "size limit exceed!"
        ]);
        die;
    } else {
        if (in_array($filetype, $allowed)) {
            if (file_exists("./img/uploads/" . $filename)) {
                echo json_encode([
                    "status" => false,
                    "message" => "file already exists!"
                ]);
                die;
            } else {
                move_uploaded_file($temp, "./img/uploads/" . $filename);
                $path = "./img/uploads/" . $filename;
                echo json_encode([
                    "status" => true,
                    "message" => $path
                ]);
                $sql = "UPDATE `users` SET `userdp` = ? WHERE `idusers` = " . $rows["idusers"];
                $stmt = DB_connect::getConn()->prepare($sql);
                $stmt->bind_param('s', $path);
                $stmt->execute();
                die;
            }
        } else {
            echo "some error";
            die;
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] === "DELETE") {
    $data = file_get_contents('php://input'); //this give request body data;
    $check = file_exists($data);
    if (!is_null($rows['userdp']) && $check == true) {
        $sql = "UPDATE `users` SET `userdp` = NULL WHERE `idusers` = ?";
        $stmt = DB_connect::getConn()->prepare($sql);
        $stmt->bind_param('i', $rows["idusers"]);
        $stmt->execute();
        unlink($data);
        echo json_encode([
            "status" => true,
            "message" => "./img/default-p.png"
        ]);
        die;
    } else {
        echo json_encode([
            "status" => false,
            "message" => "upload an img first!"
        ]);
        die;
    }
}
?>
<html lang="en">

<head>
    <?php include './views/header.php' ?>

    <?php include './views/navbar.php' ?>
</head>

<body>
    <div class="users-content">
        <h1 class="text-center text-white">Profile</h1>
        <div class="text-center">
            <p class="error m-0"></p>
        </div>
        <div class="dp">
            <div class="svgdropdown">
                <a type="button" class="dropdwn">...</a>
                <div class="d-down">
                    <ul>
                        <li>
                            <label class="uploadsvg" for="userdp">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-upload" viewBox="0 0 16 16">
                                    <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                    <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                </svg>
                            </label>
                        </li>
                        <li>
                            <label class="uploadsvg" for="upload-dp">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                    <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z" />
                                    <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z" />
                                </svg>
                            </label>
                        </li>
                        <li>
                            <label class="uploadsvg" for="remove-dp">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z" />
                                </svg>
                            </label>
                        </li>
                    </ul>
                </div>
            </div>
            <?php if (is_null($rows['userdp'])) { ?>
                <img id="profilepic" class="w-50 my-2 d-block mx-auto rounded-circle" src="./img/default-p.png" alt="user">
            <?php } else { ?>
                <img id="profilepic" class="w-50 my-2 d-block mx-auto rounded-circle" src="<?php echo $rows['userdp'] ?>" alt="user">
            <?php } ?>
        </div>
        <div>
            <form method="POST" class="d-none" id="upload-form">
                <input type="file" name="uploadpic" id="userdp" required>
                <button type="submit" name="upload-dp" id="upload-dp">upload</button>
                <button type="button" name="remove" id="remove-dp">remove</button>
            </form>
        </div>
        <table class="profiletable text-white">
            <tr>
                <td class="text-left">User-ID</td>
                <td class="text-center"><?php echo $rows["idusers"] ?></td>
            </tr>
            <tr>
                <td class="text-left">Username</td>
                <td class="text-center"><?php echo ucfirst($_SESSION["currentUser"]) ?></td>
            </tr>
            <tr>
                <td class="text-left">Gender</td>
                <td class="text-center"><?php echo ucfirst($rows["gender"]) ?></td>
            </tr>
            <tr>
                <td class="text-left">Usermail</td>
                <td class="text-center"><?php echo $_SESSION["activeUsermail"] ?></td>
            </tr>
        </table>
    </div>
    <?php include './views/footer.php' ?>
</body>

</html>