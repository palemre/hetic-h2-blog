<?php
    include '../../database.php';

    $query = $pdo->query('SELECT * FROM comments');
    $comments = $query->fetchAll();
    // DISPLAY COMMENTS IF AT LEAST ONE HAVE BEEN PUBLISHED
    if($comments)
    {
?>
        <div class="comments-admin-panel">
            <h1>COMMENTS</h1>
<?php
            foreach($comments as $comment):
                $post_id = $comment->post_id;
                $prepare = $pdo->prepare('SELECT post_title FROM posts WHERE post_id = :post_id');
                $prepare->bindValue('post_id', $post_id);
                $prepare->execute();
                $post_name_value = $prepare->fetch();

                echo
                "
                    posted by $comment->comment_name ($comment->comment_email) the $comment->comment_date <br>
                    on article entitled : $post_name_value->post_title
                    $comment->comment_comment <br><br>
                    <form method='POST' action='#'>
                        <input type='submit' name='delete_comment' value='DELETE COMMENT' class='delete-comment-admin-panel'>
                    </form>
                ";
            endforeach;
?>
        </div>
<?php
    // DELETE COMMENT
    if(isset($_POST['delete_comment']))
    {
        $comment_name = $comment->comment_name;
        $delete = $pdo->prepare('DELETE FROM comments WHERE comment_name= :comment_name');
        $delete->bindValue('comment_name', $comment_name);
        $delete->execute();
    }
    }
    // DISPLAY MESSAGE IF NO COMMENTS
    else
    {
        echo 'No comments posted yet.';
    }
?>