<?php
    // IF NO POLL OR WRONG POLL, GO TO POLLS PAGE
    if(!isset($_GET['poll']))
    {
        header('Location: polls.php');
    }
    // ELSE DISPLAY POLL INFOS
    else
    {
        include '../database.php';
        $poll_id = (int)$_GET['poll'];

        //GET POLL INFOS
        $prepare = $pdo->prepare
        ('
            SELECT poll_id, poll_question
            FROM polls
            WHERE poll_id = :poll_id
            AND DATE(NOW()) BETWEEN poll_start AND poll_end
        ');
        $prepare->bindValue('poll_id', $poll_id);
        $prepare->execute();
        $poll = $prepare->fetch();
    }

    // GET THE USER ANSWER FOR THIS POLL
    $poll_id = (int)$_GET['poll'];
    $prepareAnswer = $pdo->prepare
    ('
        SELECT polls_choices.polls_choices_id AS choice_id, polls_choices.polls_choices_name AS choice_name
        FROM polls_answers
        JOIN polls_choices
        ON polls_answers.polls_answers_choice = polls_choices.polls_choices_id
        WHERE polls_answers.polls_answers_user = :user
        AND polls_answers.polls_answers_poll = :poll
    ');
    $prepareAnswer->bindValue('user', $_SESSION['user_id']);
    $prepareAnswer->bindValue('poll', $poll_id);
    $prepareAnswer->execute();

    // CHECK IF POLL DONE
    $completed = $prepareAnswer->rowCount() ? true : false;

    if($completed)
    {
        //GET ALL ANSWERS TO SHOW RESULTS
        $prepareAnswers = $pdo->prepare
        ('
            SELECT
            polls_choices.polls_choices_name,
            COUNT(polls_answers.polls_answers_id) * 100 / (
                SELECT COUNT(*)
                FROM polls_answers
                WHERE polls_answers.polls_answers_poll = :poll) AS percentage
            FROM polls_choices
            LEFT JOIN polls_answers
            ON polls_choices.polls_choices_id = polls_answers.polls_answers_choice
            WHERE polls_choices.polls_choices_poll = :poll
            GROUP BY polls_choices.polls_choices_id
        ');
        $prepareAnswers->bindValue('poll', $poll_id);
        $prepareAnswers->execute();
        $answers = $prepareAnswers->fetchAll();

    }
    else
    {
        // GET POLL CHOICES
        $choicesQuery = $pdo->prepare
        ('
            SELECT polls_choices_name, polls_choices_id
            FROM polls_choices
            WHERE polls_choices_poll = :poll_id
        ');
        $choicesQuery->bindValue('poll_id', $poll_id);
        $choicesQuery->execute();
        $choices = $choicesQuery->fetchAll();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Poll - Burno Cooking</title>
    <link rel="stylesheet" href="../reset.css" type="text/css">
    <link rel="stylesheet" href="../tyle.css" type="text/css">
</head>
<body>
    <form action="vote.php" method="post">

        <!-- IF ALREADY DONE -->
        <?php if($completed) : ?>
            <p>You already have voted.</p>
            <ul>
                <?php foreach ($answers as $answer): ?>
                    <li><?= $answer->polls_choices_name ?>--------->(<?= number_format($answer->percentage, 2) ?>%)</li>
                <?php endforeach; ?>
            </ul>

        <!-- ELSE DISPLAY POLL -->
        <?php else : ?>
            <div class="poll-question">
                <?= $poll->poll_question ?>
            </div>
            <!-- DISPLAY POLL CHOICES & SUBMIT -->
            <?php foreach($choices as $index=> $choice) : ?>
                <div class="poll-option">
                    <input type="radio" name="choice" value="<?= $choice->polls_choices_id ?>" id="c<?= $index ?>">
                    <label for="c<?= $index ?>"><?= $choice->polls_choices_name ?></label>
                </div>
            <?php endforeach; ?>
            <input type="submit" value="Submit">
            <input type="hidden" name="poll" value="<?= $poll_id ?>">
        <?php endif; ?>
    </form>
</body>
</html>