<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Blog</title>
    <link rel="stylesheet" href="reset.css" type="text/css">
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <!-- HEADER OF INDEX -->
    <div class="header">
        <div class="logo">
            <h2><a href="index.php">Burno Cooking</a></h2>
        </div>
        <div class="page-title">
            <h2>Last posts</h2>
        </div>
        <div class="link">
            <h3><a href="pages/admin-panel/admin-panel.php">Login</a></h3>
        </div>
    </div>

    <?php
        //GET WRITTEN LAST 2 POSTS
        function get_posts()
        {
            include 'database.php';
            $query = $pdo->query('SELECT * FROM posts WHERE post_displayed = 1 ORDER BY post_date DESC LIMIT 0,2');
            $posts = $query->fetchAll();
            foreach ($posts as $post):
    ?>
                <!-- DISPLAY LAST 2 WRITTEN POSTS -->
                <div class="posts">
                    <div class="post-box">
                        <h2><?= $post->post_title ?></h2>
                        <span><?= date("d/m/Y à H:i", strtotime($post->post_date)); ?> par <?= $post->post_author ?></span>
                        <p><?= substr(nl2br($post->post_content),0,200); ?>...</p>
                        <img class="post-preview-image" src="images/<?= $post->post_image ?>" alt="<?= $post->post_title ?>">
                        <a href="pages/post.php?id=<?= $post->post_id ?>">Read article</a>
                    </div>
                </div>
    <?php
            endforeach;
        }
        $get_posts = get_posts();
    ?>
</body>
</html>