<?php require './connection.php' ?>
<?php
$sql = "SELECT * FROM blogs";
$stmt = DB_connect::getConn()->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$countrow = $result->num_rows;
?>
<html lang="en">

<?php include './views/header.php' ?>

<?php include './views/navbar.php' ?>

<body>

    <div class="d-blogs">
        <?php if ($countrow > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
            <div class="blog my-2">
                <a class="viewlink" href="blogview.php?blogNo=<?php echo $row['blog_no']?>">
                    <h4 class="displayblog text-white"><?php echo $row['blog_title'] ?></h4>
                </a>
                <div class="blogpara">
                    <p class="text-white m-0" ><?php echo $row['blog_content'] ?></p>
                    <a class="readmore" href="blogview.php?blogNo=<?php echo $row['blog_no']?>">Read more</a>
                </div>
            </div>
            <?php } ?>
        <?php } else { ?>
            <h2 class="text-white">No blogs to display</h2>
        <?php } ?>
    </div>



    <?php include './views/footer.php' ?>
</body>

</html>