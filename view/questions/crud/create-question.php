<?php

namespace Anax\View;

// Gather incoming variables and use default values if not set
$items = isset($items) ? $items : null;

// Create urls for navigation
$urlToViewItems = url("user");
$urlToRegister = url("user/register");
$urlToLogin = url("user/login");
?>

<?php if (empty($di->session->get("login"))) : ?>
    <p>
        <p>You have to login to access this page.</p>
        <a href="<?= $urlToLogin ?>">Login</a> |
        <a href="<?= $urlToRegister ?>">Register</a>
    </p>
    <hr>
<?php else : ?>
    <div class="form" style="height:auto;width:50%;padding-top:20px;">
        <h1 style="border-bottom:none;">Create a new question</h1>
        <?= $form ?>
    </div>
<?php endif; ?>
