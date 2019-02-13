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

<!-- ADMIN PANEL LEFT NAV MENU -->
<div class="admin-panel">
    <div class="admin-panel-left-nav">
        <h3>Overview</h3>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="index.php?cat">Categories</a></li>
            <li><a href="index.php?sub_cat">Sub Categories</a></li>
        </ul>
    </div>
</div>

