<?php

namespace Anax\View;


$filter = new \Anax\TextFilter\TextFilter;

// Gather incoming variables and use default values if not set
$questions = isset($questions) ? $questions : null;

// Create urls for navigation
$urlToCreate = url("questions/create-question");
$urlToRegister = url("user/register");
$urlToLogin = url("user/login");

?>
<meta charset="utf-8">

<h1 style="text-align:center;border-bottom:none;">View all questions</h1>

<?php if ($di->session->get("login") == false || $di->session->get("login") == null) : ?>
    <div class="form">
        <h5 style="border-bottom:none; margin-bottom:50px;">You have to login to create a question.</h5>
        <a class="button" href="<?= $urlToLogin ?>">Login</a>
        <a class="button" href="<?= $urlToRegister ?>">Register</a>
    </div>
<?php elseif($di->session->get("login") == true) : ?>
    <div style="text-align:center; margin:50px;">
        <a class="button" href='<?= $urlToCreate . "/". $di->session->get("userId") ?>'>New Question</a>
    </div>
<?php endif; ?>

<div style="padding: 0 20%;">
<?php foreach ($questions as $question) : ?>
    <div style="padding:10px;margin:50px 0px;background:#f5f5f5;border-radius:25px;background-image: linear-gradient(315deg,#088080 0,#380036 74%);">
        <div class="box-questions" style="padding:10px;width:100%;margin-bottom:20px;height:auto;background:white;box-shadow: 7px 22px 42px -20px black;">
            <?php $answer = $answers->findAllWhere("questionId = ?", $question->id); ?>
            <a href="<?= url("questions/view/{$question->id}"); ?>">
                <h2><?= mb_substr($question->question, 0, 110, "UTF-8") ?></h2>
            </a>
            <div class="boxInsideBox">
                <?php if ($di->session->get("login") == false || $di->session->get("login") == null) : ?>
                    <div style="filter: blur(4px); user-select:none;" id="test" onmousedown='return false;' onselectstart='return false;'>
                        <h3>Question:</h3> <p>You have to login first!</p>
                    </div>
                <?php elseif($di->session->get("login") == true) :?>
                    <div>
                        <h3>Question:</h3> <p><?= $filter->markdown($question->question); ?></p>
                    </div>
                <?php endif; ?>

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
                        <i class="fas fa-hashtag ml-5 tagsI"></i>
                        <a href=<?= url("tags/questions/{$link}") ?> class="tagsA">
                            <?= mb_substr($tag, 0, 50, "UTF-8") ?>
                        </a>
                        <?php endforeach; ?>
                </div>
                <br>
                <p>Posted at: <?= $question->created ?> </p>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>

<?php if (!$questions) : ?>
    <p style="text-align:center;">There are no questions to show.</p>
<?php
    return;
endif;
?>
