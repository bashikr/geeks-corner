<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$questions = isset($questions) ? $questions : null;

// Create urls for navigation
$urlToCreate = url("questions/create-question");
$urlToRegister = url("user/register");
$urlToLogin = url("user/login");

?>
 <meta charset="utf-8">
<h1 style="text-align:center;border-bottom:none;">View all questions</h1>

<?php if (empty($di->session->get("login"))) : ?>
    <div class="form">
        <h5 style="border-bottom:none; margin-bottom:50px;">You have to login to create a question.</h5>
        <a class="button" href="<?= $urlToLogin ?>">Login</a>
        <a class="button" href="<?= $urlToRegister ?>">Register</a>
    </div>
<?php else : ?>
    <div style="text-align:center; margin:50px;">
        <a class="button" href='<?= $urlToCreate . "/". $di->session->get("userId") ?>'>New Question</a>
    </div>
<?php endif; ?>
<?php foreach ($questions as $question) : ?>
    <div class="box-questions" style="margin-bottom:20px;">
        <?php $answer = $answers->findAllWhere("questionId = ?", $question->id); ?>
        <a href="<?= url("questions/view/{$question->id}"); ?>">
            <h2><?= mb_substr($question->question, 0, 110, "UTF-8") ?></h2>
        </a>
        <div class="boxInsideBox">
            <h3>Question:</h3> <p><?= $question->question?></p>

            <div>
                <?php $tags = explode(" ", $question->tags); ?>
                <?php $answer = $answers->findAllWhere("questionId = ?", $question->id); ?>
                <p style="border-top:2px solid black;padding-top:50px;">Answers on this question: <?= count($answer) ?></p>
                <p style=>Question rank: <?= $question->votes ?></p>
                Written by:<a class="tagsA" href="<?= url("user/view-user-info") . "/" . $question->userId . "/user"; ?>">
                <?= $question->username ?>
                </a>
                <br>

                <br>
                Tags:<?php foreach ($tags as $tag) : ?>
                    <?php $link=htmlentities($tag) ?>
                    <i class="fa fa-user-tag ml-5 tagsI"></i>
                    <a href=<?= url("tags/questions/{$link}") ?> class="tagsA">
                        <?= mb_substr($tag, 0, 50, "UTF-8") ?>
                    </a>
                    <?php endforeach; ?>
            </div>
            <br>
            <p>Posted at: <?= $question->created ?> </p>
        </div>
    </div>
<?php endforeach; ?>

<?php if (!$questions) : ?>
    <p style="text-align:center;">There are no questions to show.</p>
<?php
    return;
endif;
?>
