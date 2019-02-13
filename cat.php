<?php include 'database.php'; ?>
<!-- RIGH SIDE NAV MENU -->
<div class="admin-panel-right-content">
    <h3>Categories</h3>

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
        <?php echo view_cat(); ?>
    </table>

</div>

<?php
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
                    <td><a href='#'>Edit</a></td>
                    <td><a href='#'>Delete</a></td>
                </tr>";
        endforeach;
    }
?>