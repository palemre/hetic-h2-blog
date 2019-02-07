<div class="admin-panel">
    <div class="admin-panel-left-nav">
        <h3>Overview</h3>
        <ul>
            <li><a href="index.php">Dashboard</a></li>
            <li><a href="index.php?cat">Categories</a></li>
        </ul>
    </div>

    <?php if(!isset($_GET['cat'])) { ?>
        <div class="admin-panel-right-content">
            <h3>Overview</h3>
        </div>
    <?php } ?>

    <?php
        if(isset($_GET['cat']))
        {
            include 'cat.php';
        }
    ?>
</div>

