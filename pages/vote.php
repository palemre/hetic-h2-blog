<?php
    include '../database.php';

    if(isset($_POST['choice']))
    {
        $poll = $_POST['poll'];
        $choice = $_POST['choice'];

        // INSERT WHICH CHOICE USER SUBMITTED TO POLLS_ANSWERS WITH FOLLOWING STEPS :
        //      FIRST CHECK IF POLL EXISTS
        //      THEN CHECK IF CHOICES EXISTS AND ARE LINKED TO THIS POLL
        //      FINALLY CHECK IF USER HAS NOT VOTED YET

        $prepare = $pdo->prepare('
            INSERT INTO
                polls_answers (polls_answers_user, polls_answers_poll, polls_answers_choice)
                SELECT :user, :poll, :choice
                FROM polls
                WHERE EXISTS
                (
                    SELECT poll_id
                    FROM polls
                    WHERE poll_id = :poll
                )
                AND EXISTS
                (
                    SELECT polls_choices_id
                    FROM polls_choices
                    WHERE polls_choices_id = :choice
                    AND polls_choices_poll = :poll
                )
                AND NOT EXISTS
                (
                    SELECT polls_answers_id
                    FROM polls_answers
                    WHERE polls_answers_user = :user
                    AND polls_answers_poll = :poll
                )
                LIMIT 1
        ');
        $prepare->bindValue('user', $_SESSION['user_id']);
        $prepare->bindValue('poll', $poll);
        $prepare->bindValue('choice', $choice);
        $prepare->execute();
        header('Location: poll.php?poll=' . $poll);
        exit();
    }
    else
    {
        header('Location: polls.php');
    }
