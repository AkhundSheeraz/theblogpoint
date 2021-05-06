<?php require './connection.php' ?>
<?php
$sql = "SELECT `blog_no`, `blog_title`, `blog_content` FROM blogs INNER JOIN users ON blogs.idusers = users.idusers WHERE usermail = ? ";
$stmt = DB_connect::getConn()->prepare($sql);
$stmt->bind_param('s', $_SESSION['activeUsermail']);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->num_rows;

?>

<?php
if (isset($_POST['id'])) {
    $blogid = $_POST['id'];
    $sql = "DELETE blogs.* FROM blogs INNER JOIN users ON blogs.idusers = users.idusers WHERE usermail = ? AND blog_no = ?";
    $stmt = DB_connect::getConn()->prepare($sql);
    $stmt->bind_param('si', $_SESSION['activeUsermail'], $blogid);
    $success = $stmt->execute();
    $effected = $stmt->affected_rows;
    if($success == true){
        echo json_encode([
           'status'=> true, 
        ]);
    }
    die;
}
?>

<html lang="en">

<?php include './views/header.php' ?>

<?php include './views/navbar.php' ?>

<body>
    <div class="d-blogs">
        <?php if ($count >= 1) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <div class="text-white my-2">
                    <div class="titlediv">
                        <a class="viewlink" href="blogview.php?blogNo=<?php echo $row['blog_no'] ?>">
                            <h4 class="displayblog text-white"><?php echo $row['blog_title'] ?></h4>
                        </a>
                        <button class="delbtn" data-id="<?php echo $row['blog_no'] ?>">
                            <img src="./img/trash-fill.svg" alt="delete">
                        </button>
                    </div>
                    <div class="blogpara">
                        <p class="m-0"><?php echo $row['blog_content'] ?></p>
                        <a class="readmore" href="blogview.php?blogNo=<?php echo $row['blog_no'] ?>">Read more</a>
                    </div>
                </div>
            <?php } ?>
        <?php } else { ?>
            <h2 class="text-white">You have no Blogs</h2>
        <?php } ?>
    </div>

    <?php include './views/footer.php' ?>

</body>

</html>