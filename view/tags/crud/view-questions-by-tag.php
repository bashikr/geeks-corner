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
<div style="padding: 0 20%;">
    <?php foreach ($questions as $question) : ?>
        <div style="padding:10px;margin:50px 0px;background:#f5f5f5;border-radius:25px;background-image: linear-gradient(315deg,#088080 0,#380036 74%);">
            <div class="box-questions" style="margin-bottom:20px;padding:10px;width:100%;margin-bottom:20px;height:auto;background:white;box-shadow: 7px 22px 42px -20px black;">
                <?php $answer = $answers->findAllWhere("questionId = ?", $question->id); ?>
                <a class="tagsA" href="<?= url("questions/view/{$question->id}"); ?>"></a>
                    <h2><?= mb_substr($question->question, 0, 86, "UTF-8") ?></h2>
                <div style="height:auto;padding-left:20px;">
                    <p>Answers: <?= count($answer) ?></p>
                    <p>Posted at: <?= $question->created ?> </p>
                    <p>Posted by: <?= $question->username ?> </p>
                </div>

                <div>
                Tags: <?php $tags = explode(" ", $question->tags); ?>
                    <?php foreach ($tags as $tag) : ?>
                        <?php $link=htmlentities($tag) ?>
                        <a href=<?= url("tags/questions/{$link}") ?> class="tag"><?= $tag ?></a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
