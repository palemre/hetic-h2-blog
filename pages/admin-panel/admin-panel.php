<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin panel - Burno Cooking</title>
    <link rel="stylesheet" href="../../reset.css" type="text/css">
    <link rel="stylesheet" href="../../style.css" type="text/css">
</head>
<body>
    <!-- HEADER OF ADMIN PANEL -->
    <div class="header">
        <div class="logo">
            <h2><a href="index.php">Burno Cooking</a></h2>
        </div>
        <div class="page-title">
            <h2>Admin panel</h2>
        </div>
        <div class="link">
            <h3><a href="../../index.php">Logout</a></h3>
        </div>
    </div>

    <!-- ADMIN PANEL LEFT NAV MENU -->
    <div class="admin-panel">
        <div class="admin-panel-left-nav">
            <h3>Overview</h3>
            <ul>
                <li><a href="admin-panel.php">Dashboard</a></li>
                <li><a href="admin-panel.php?cat">Categories</a></li>
                <li><a href="admin-panel.php?sub_cat">Sub Categories</a></li>
            </ul>
        </div>
    </div>

    <!-- RIGHT : CONTENT DEPENDING ON PAGE SET -->
    <?php
        if(isset($_GET['cat']))
        {
            include 'cat.php';
        }
        else if(isset($_GET['sub_cat']))
        {
            include 'sub_cat.php';
        }
    ?>
</body>
</html>
