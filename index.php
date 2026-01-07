<?php
include 'router.php';
ilFautLogged();
include 'deguelasDb.php';
kifeFort();
checkCtl();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Title</title>
</head>
<body>
<div class="header">
    <?php
    include 'header.php';
    ?>
</div>
<div class="mid">
    <div class="menu">
        <?php
        include 'menu.php';
        ?>
    </div>
    <div class="content">
        <?php
        include 'content.php';
        ?>
    </div>
</div>
<div class="footer">
    <?php
    include 'footer.php';
    ?>
</div>
</body>
</html>