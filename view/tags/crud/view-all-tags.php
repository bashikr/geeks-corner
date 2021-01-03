<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

?>

<?php if (!$items) : ?>
    <p style="text-align:center;">There are no items to show.</p>
<?php
    return;
endif;
?>


<h3 style="text-align:center;">All tags</h3>
    <div class="box-center">
        <?php foreach ($items as $item) : ?>
            <div class="box">
                <p><?= $item->tag?></p>
            </div>
        <?php endforeach; ?>
    </div>

<style>
    .box {
        border: 5px solid #333;
        padding: 10px 20px;
        padding-top:25px;
        width: 30%;
        max-width: 100%;
        text-align: center;
        margin-bottom:20px;
        vertical-align: center;
        border-radius:25px;
    }

    .box-center p {
        vertical-align: center;
    }

    .box-center {
        margin: auto;
        width: 40%;
        vertical-align: center;
    }
</style>
