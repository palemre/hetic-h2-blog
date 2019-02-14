<!-- GET CLICKED POST INFORMATIONS -->
<?php
    include '../database.php';
    $post_id = $_GET['id'];
    $prepare = $pdo->prepare('SELECT * FROM posts WHERE post_id = :post_id');
    $prepare->bindValue('post_id', $post_id);
    $prepare->execute();
    $post = $prepare->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $post->post_title ?></title>
    <link rel="stylesheet" href="../reset.css" type="text/css">
    <link rel="stylesheet" href="../style.css" type="text/css">
</head>
<body>

    <!-- DISPLAY POST -->
    <div class="post">
        <h1><?= $post->post_title ?></h1>
        <img class="displayed-post-image" src="../images/<?= $post->post_image ?>" alt="<?= $post->post_title ?>">
        <p><?= $post->post_content ?></p>
        <span><?= date("d/m/Y à H:i", strtotime($post->post_date)); ?> écrit par <?= $post->post_author ?></span>
    </div>
</body>
</html>

    
