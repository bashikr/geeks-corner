<?php

namespace Anax\View;

$filter = new \Anax\TextFilter\TextFilter;
$answers = isset($answers) ? $answers : null;
$questions = isset($questions) ? $questions : null;
$user = isset($user) ? $user : null;

$urlToAnswer = url("answers/create");
$urlToComment = url("comments/create")
?>
<?php foreach ($questions as $question) : ?>
    <div class="box-questions" style="margin-bottom:20px;height:300px;">
    <a href="<?= url("questions/view/{$question->id}"); ?>">
    <h2><?= mb_substr(strtoupper($question->question), 0, 25, "UTF-8") ?></h2>
    </a>

        <p><?= $filter->doFilter($question->question, ["markdown"]); ?></p>
        <p>Posted at: <?= $question->created ?> </p>
        <p>By: <a href="<?= url("user/"); ?>"><?= $question->username?></a></p>
    </div>
<?php endforeach ?>
