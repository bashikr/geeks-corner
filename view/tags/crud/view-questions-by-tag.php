<?php
namespace Anax\View;
$filter = new \Anax\TextFilter\TextFilter;

// Gather incoming variables and use default values if not set
$questions = isset($questions) ? $questions : null;
// $answers = isset($answers) ? $answers : null;

// Create urls for navigation
$urlToCreate = url("questions/create-question");
$urlToDelete = url("questions/delete");
$urlToLogin = url("user/login");

$urlToRegister = url("user/register");
?>

<div class="box-questions" style="margin-bottom:20px;">
    <?php foreach ($questions as $question) : ?>
        <?php $answer = $answers->findAllWhere("questionId = ?", $question->id); ?>
        <div>
            <a href="<?= url("questions/view/{$question->id}"); ?>">
                <h2><?= $question->question ?></h2>
            </a>
            <div>
                <p>Answers: <?= count($answer) ?></p>
                <p>Posted at: <?= $question->created ?> </p>
                <p>Posted by: <?= $question->username ?> </p>
            <div>
               Tags: <?php $tags = explode(" ", $question->tags); ?>
                <?php foreach ($tags as $tag) : ?>
                    <?php $link=htmlentities($tag) ?>
                    <a href=<?= url("tags/questions/{$link}") ?> class="tag"><?= $tag ?></a>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
