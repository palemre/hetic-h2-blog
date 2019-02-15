<?php
    // GET CLICKED POST INFORMATIONS
    function get_posts()
    {
        include '../database.php';
        $post_id = $_GET['id'];
        $prepare = $pdo->prepare('SELECT * FROM posts WHERE post_id = :post_id');
        $prepare->bindValue('post_id', $post_id);
        $prepare->execute();
        global $post;
        $post = $prepare->fetch();
    }
    get_posts();

    // INSERT NEW COMMENT
    if(isset($_POST['add_comment']))
    {
        include '../database.php';

        $comment_name = $_POST['comment_author'];
        $comment_email = $_POST['comment_author_email'];
        $comment_comment = $_POST['comment_comment'];
        $post_id = $_GET['id'];
        $prepare = $pdo->prepare('
            INSERT INTO
                comments (comment_name, comment_email, comment_comment, post_id, comment_date)
            VALUES
                (:comment_name, :comment_email, :comment_comment, :post_id, NOW())
        ');
        $prepare->bindValue('comment_name', $comment_name);
        $prepare->bindValue('comment_email', $comment_email);
        $prepare->bindValue('comment_comment', $comment_comment);
        $prepare->bindValue('post_id', $post_id);
        $execute = $prepare->execute();    
    }
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
        <span><?= date("d/m/Y à H:i", strtotime($post->post_date)); ?> written by <?= $post->post_author ?></span>
    </div>

    <!-- DISPLAY COMMENTS -->
    <h3 class="comments-title">Comments</h3>

    <?php
        // GET POSTS COMMENTS
        function get_comments()
        {
            include '../database.php';
            $post_id = $_GET['id'];
            $prepare = $pdo->prepare('SELECT * FROM comments WHERE post_id = :post_id');
            $prepare->bindValue('post_id', $post_id);
            $prepare->execute();
            global $comment;
            $comments = $prepare->fetchAll();

            // IF POST HAS COMMENTS DISPLAY THEM
            if($comments)
            {
                foreach($comments as $comment):
                {
                    echo
                    "
                        <blockquote>
                            <span>by $comment->comment_name the $comment->comment_date</span>
                            <p> $comment->comment_comment</p>
                        </blockquote>
                    "; 
                }
                endforeach;
            }
            // IF POST HAS NOT COMMENTS DISPLAY NO COMMENTS
            else
            {
                echo
                "
                    <h3 class='no-comments-title'>No comments yet. Share first !</h3>
                ";
            }
        }
        get_comments();
    ?>

    <!-- INSERT NEW COMMENT FORM -->
    <form class="new-comment-form" method="post" action="#">
        <p>Share your comment</p>
        <input type="text" name="comment_author" placeholder="nickname">
        <input type="email" name="comment_author_email" placeholder="email">
        <textarea name="comment_comment" placeholder="Your comment" cols="30" rows="10"></textarea>
        <input type="submit" name="add_comment" value="Add comment">
    </form>

</body>
</html>

    
