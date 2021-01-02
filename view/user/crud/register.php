<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;


?>

<h1 style="border-bottom:none;text-align:center;">Register a new user</h1>
<div class="form" style="text-align:center; margin-bottom:20px; width:50%;margin:auto;height:auto;">
    <?= $form ?>
</div>
