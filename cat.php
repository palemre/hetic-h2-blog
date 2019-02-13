<?php
    include 'database.php';

    //ADD FOOD CATEGORY
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

    //VIEW CATEGORIES
    function view_cat()
    {
        include 'database.php';
        $query = $pdo->query('SELECT * FROM cat');
        $categories = $query->fetchAll();
        foreach ($categories as $category):
            echo "<tr>
                    <td>".$category->cat_id."</td>
                    <td>".$category->cat_name."</td>
                    <td><a href='index.php?cat&edit_cat=".$category->cat_id."'>Edit</a></td>
                    <td><a href='index.php?cat&delete_cat=".$category->cat_id."'>Delete</a></td>
                </tr>";
        endforeach;
    }

    //EDIT FOOD CATEGORY NAME
    if(isset($_GET['edit_cat']))
    {
        $cat_id = $_GET['edit_cat'];
        $prepare = $pdo->prepare('SELECT * FROM cat WHERE cat_id = :cat_id');
        $prepare->bindValue('cat_id', $cat_id);
        $prepare->execute();
        $cat_name = $prepare->fetch();
        
        if(isset($_POST['edit_cat']))
        {
            $new_cat_name = $_POST['cat_name'];
            $prepare = $pdo->prepare('UPDATE cat SET cat_name = :new_cat_name WHERE cat_id = :cat_id');
            $prepare->bindValue('new_cat_name', $new_cat_name);
            $prepare->bindValue('cat_id', $cat_id);
            $prepare->execute();
            echo "<script>alert('Category name updated')</script>";
        }
    }

    //DELETE FOOD CATEGORY
    if(isset($_GET['delete_cat']))
    {
        $cat_id = $_GET['delete_cat'];
        $prepare = $pdo->prepare('DELETE FROM cat WHERE cat_id = :cat_id');
        $prepare->bindValue('cat_id', $cat_id);
        $prepare->execute();
        echo "<script>alert('Category deleted')</script>";
        echo "<script>window.open('index.php?cat','_self'</script>";
    }
?>

<!-- RIGHT SIDE CONTENT -->
<div class="admin-panel-right-content">
    <h3>Categories</h3>

    <!-- EDIT CATEGORY -->
    <?php if(isset($_GET['edit_cat'])) { ?>
        <div class="add-category">
            <form method="post" action="">
                <input type="text" name="cat_name" placeholder="<?= $cat_name->cat_name ?>">
                <input type="submit" name="edit_cat" value="Update category name">
            </form>
        </div>
    <?php } else { ?>

        <!-- ADD CATEGORY -->
        <div class="add-category">
            <form method="post" action="">
                <input type="text" name="cat_name" placeholder="Category Name">
                <input type="submit" name="add_cat" value="Add category">
            </form>
        </div>

        <!-- DISPLAY CATEGORIES -->
        <table>
            <tr>
                <th>Id</th>
                <th>Category Name</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
            <?= view_cat(); ?>
        </table>
    <?php } ?>
</div>