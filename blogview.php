<?php require './connection.php' ?>
<?php $blogid = $_GET['blogNo'];
$sql = "SELECT `blog_title`, `blog_content` FROM blogs WHERE blog_no = ?";
$stmt = DB_connect::getConn()->prepare($sql);
$stmt->bind_param('i', $blogid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$count = $result->num_rows;
?>
<html lang="en">

<?php include './views/header.php' ?>

<?php include './views/navbar.php' ?>

<body>
    <?php if ($count == 1) { ?>
        <div class="viewblog text-white my-5">
        <h3 class="text-center"><?php echo $row['blog_title'] ?></h3>
        <p class="my-3"><?php echo $row['blog_content'] ?></p>
        </div>
    <?php } else { ?>
        <h4 class="text-white">Blog not Found</h4>
    <?php } ?>
    <?php include './views/footer.php' ?>

</body>

</html>