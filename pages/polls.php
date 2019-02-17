<?php
    include '../database.php';

    // GET ALL POLLS
    $query = $pdo->query('
        SELECT poll_id, poll_question
        FROM polls
        WHERE DATE(NOW()) BETWEEN poll_start AND poll_end
    ');
    $polls = $query->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Polls - Burno Cooking</title>
    <link rel="stylesheet" href="../reset.css" type="text/css">
    <link rel="stylesheet" href="../tyle.css" type="text/css">
</head>
<body>
    <!-- IF POLLS EXIST, DISPLAYS THEM -->
    <?php if(!empty($polls)): ?>
        <h1>POLLS LIST</h1>
        <ul>
            <?php foreach($polls as $poll): ?>
                <li><a href="poll.php?poll=<?= $poll->poll_id ?>"><?= $poll->poll_question ?></a></li>
            <?php endforeach; ?>
        </ul>
    <!-- ELSE, DISPLAYS NO POLLS MESSAGE -->
    <?php else: ?>
        <h1>No polls created.</h1>
    <?php endif; ?>
</body>
</html>