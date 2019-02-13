<!-- RIGH SIDE NAV MENU -->
<div class="admin-panel-right-content">
    <h3>Sub Categories</h3>
    <div class="add-category">
        <form method="post" action="">
            <select name="cat_id">
                <option value="">Select Category</option>
                <?php echo select_cat(); ?>
            </select>
            <input type="text" name="sub_cat_name" placeholder="Sub Category Name">
            <input type="submit" name="add_sub_cat" value="Add sub category">
        </form>
    </div>
</div>
<!-- ADD FOOD SUB CATEGORY : SUB CATEGORY HAS SAME CATEGORY ID DEPENDING ON CATEGORY ID -->
<?php
    include 'database.php';
    if(isset($_POST['add_sub_cat']))
    {
        $sub_cat_name = $_POST['sub_cat_name'];
        $cat_id = $_POST['cat_id'];
        $prepare = $pdo->prepare('
            INSERT INTO
                sub_cat (sub_cat_name, cat_id)
            VALUES
                (:sub_cat_name, :cat_id)
        ');
        $prepare->bindValue('sub_cat_name', $sub_cat_name);
        $prepare->bindValue('cat_id', $cat_id);
        $execute = $prepare->execute();
    }

    function select_cat()
    {
        include 'database.php';
        $query = $pdo->query('SELECT * FROM cat');
        $categories = $query->fetchAll();
        foreach($categories as $category) :
            echo "<option value='".$category->cat_id."'>" .$category->cat_name. "</option>";
        endforeach;
    }
?>