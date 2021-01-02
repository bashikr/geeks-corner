<?php
namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;
?>
<h1>View all answers</h1>


<?php if (!$items) : ?>
    <p>There are no items to show.</p>
    <?php
    return;
endif;
?>

<table>
    <tr>
        <th>Id</th> 
        <th>answer</th>
    </tr>
    <?php foreach ($items as $item) : ?>
    <tr>
        <td>
            <?= $item->id ?>
        </td>
        <td><?= $item->answer ?></td>
    </tr>
    <?php endforeach; ?>
</table>
