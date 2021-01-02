<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$item = isset($item) ? $item : null;

// Create urls for navigation
$urlToView = url("user");

?>

<h1 style="border-bottom:none;text-align:center;">Update user information</h1>
<div class="form" style="text-align:center; margin-bottom:20px; width:50%;margin:auto;height:auto;">
    <?= $form ?>
</div>

