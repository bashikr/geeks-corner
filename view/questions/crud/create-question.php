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
    <div class="form">
        <h5 style="border-bottom:none; margin-bottom:50px;">You have to login to create a question.</h5>
        <a class="button" href="<?= $urlToLogin ?>">Login</a>
        <a class="button" href="<?= $urlToRegister ?>">Register</a>
    </div>
<?php else : ?>
    <div class="form" style="height:auto;width:50%;padding-top:20px;">
        <h1 style="border-bottom:none;">Create a new question</h1>
        <?= $form ?>
    </div>
<?php endif; ?>
