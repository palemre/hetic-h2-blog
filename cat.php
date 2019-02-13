<?php include 'database.php'; ?>

<!-- RIGH SIDE NAV MENU -->
<div class="admin-panel-right-content">
    <h3>Categories</h3>
    <div class="add-category">
        <form method="post" action="">
            <input type="text" name="cat_name" placeholder="Category Name">
            <input type="submit" name="add_cat" value="Add category">
        </form>
    </div>
</div>
<!-- ADD FOOD CATEGORY -->
<?php
    if(isset($_POST['add_cat']))
    {
        $cat_name = $_POST['cat_name'];
        $prepare = $pdo->prepare('
            INSERT INTO
                cat (cat_name)
            VALUES
                (:cat_name)
        ');

        $prepare->bindValue('cat_name', $cat_name);
        $execute = $prepare->execute();
    }
?>