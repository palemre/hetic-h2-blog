<?php
    include '../../database.php';

    //EDIT SUB CATEGORY NAME
    if(isset($_GET['edit_sub_cat']))
    {
        $sub_cat_id = $_GET['edit_sub_cat'];
        $prepare = $pdo->prepare('SELECT * FROM sub_cat WHERE sub_cat_id = :sub_cat_id');
        $prepare->bindValue('sub_cat_id', $sub_cat_id);
        $prepare->execute();
        $sub_cat_name = $prepare->fetch();
    }
    else
    {
        //ADD FOOD SUB CATEGORY : SUB CATEGORY HAS SAME CATEGORY ID DEPENDING ON PARENT CATEGORY ID
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
            include '../../database.php';
            $query = $pdo->query('SELECT * FROM cat');
            $categories = $query->fetchAll();
            foreach($categories as $category) :
                echo "<option value='".$category->cat_id."'>" .$category->cat_name. "</option>";
            endforeach;
        }
    
        //DISPLAY SUB CATEGORIES WITH PARENT CATEGORY ID
        function view_sub_cat()
        {
            include '../../database.php';
            $query = $pdo->query('SELECT * FROM sub_cat');
            $sub_categories = $query->fetchAll();
            foreach ($sub_categories as $sub_category):
                $sub_cat_parent_id = (int)$sub_category->cat_id;
                $prepare = $pdo->prepare('SELECT * FROM cat WHERE cat_id = :sub_cat_parent_id');
                $prepare->bindValue('sub_cat_parent_id', $sub_cat_parent_id);
                $prepare->execute();
                $parent_cat_name = $prepare->fetch();
    
                echo "<tr>
                        <td>".$sub_category->sub_cat_id."</td>
                        <td>".$parent_cat_name->cat_name."</td>
                        <td>".$sub_category->sub_cat_name."</td>
                        <td><a href='index.php?sub_cat&edit_sub_cat=".$sub_category->sub_cat_id."'>Edit</a></td>
                        <td><a href='index.php?sub_cat&delete_sub_cat=".$sub_category->sub_cat_id."'>Delete</a></td>
                    </tr>";
            endforeach;
        }

        //DELETE FOOD SUB CATEGORY
        if(isset($_GET['delete_sub_cat']))
        {
            $sub_cat_id = $_GET['delete_sub_cat'];
            $prepare = $pdo->prepare('DELETE FROM sub_cat WHERE sub_cat_id = :sub_cat_id');
            $prepare->bindValue('sub_cat_id', $sub_cat_id);
            $prepare->execute();
        }
    }
?>

<!-- RIGH SIDE NAV MENU -->
<div class="admin-panel-right-content">
    <h3>Sub Categories</h3>
    <div class="add-category">

        <!-- EDIT SUB CATEGORY NAME -->
        <?php if(isset($_GET['edit_sub_cat'])) { ?>
            <input type="text" name="sub_cat_name" placeholder="<?= $sub_cat_name->sub_cat_name ?>">
            <input type="submit" name="edit_sub_cat" value="Edit sub category">
        <?php } else { ?>

            <!-- ADD SUB CATEGORY -->
            <form method="post" action="">
                <select name="cat_id">
                    <option value="">Select Category</option>
                    <?= select_cat(); ?>
                </select>
                <input type="text" name="sub_cat_name" placeholder="Sub Category Name">
                <input type="submit" name="add_sub_cat" value="Add sub category">
            </form>

            <!-- DISPLAY SUB CATEGORIES -->
            <table>
                <tr>
                    <th>Id</th>
                    <th>Category Name</th>
                    <th>Sub Category Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                <?= view_sub_cat(); ?>
            </table>
        <?php } ?>
    </div>
</div>