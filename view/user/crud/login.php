<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;


// Prepare classes
$classes[] = "article";
if (isset($class)) {
    $classes[] = $class;
}


?>

<h1 style="border-bottom:none;text-align:center;">User login</h1>
<div class="form" style="height:300px;width:50%;padding-top:20px;">
    <?= $form ?>
</div>
