<?php require './connection.php' ?>
<?php
$blogtitle = $_POST['blogtitle'];
$blogcontent = $_POST['blogcontent'];
$usersmail = $_SESSION['activeUsermail'];
$sql = "SELECT idusers FROM users WHERE usermail = ?";
$stmt = DB_connect::getConn()->prepare($sql);
$stmt->bind_param('s', $usersmail);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$currentid = $row['idusers'];
if (count($row) == 1) {
    $sql = "INSERT INTO blogs (`idusers`, `blog_title`, `blog_content`) VALUES (?,?,?)";
    $stmt = DB_connect::getConn()->prepare($sql);
    $stmt->bind_param('iss', $currentid, $blogtitle, $blogcontent);
    $stmt->execute();
    $lastid = DB_connect::getConn()->insert_id;
?>
    <div class="text-white my-2">
        <div class="titlediv">
            <a class="viewlink" href="blogview.php?blogNo=<?php echo $lastid ?>">
                <h4 class="displayblog text-white"><?php echo $blogtitle ?></h4>
            </a>
            <button class="delbtn" data-id="<?php echo $lastid ?>">
                <img src="./img/trash-fill.svg" alt="delete">
            </button>
        </div>
        <div class="blogpara">
            <p class="m-0"><?php echo $blogcontent ?></p>
            <a class="readmore" href="blogview.php?blogNo=<?php echo $lastid ?>">Read more</a>
        </div>
    </div>
<?php } ?>