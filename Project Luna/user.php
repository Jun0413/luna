<?php
session_start();

$config = array(
    'navLink' => 'home',
    'styles' => array('./libs/css/pages/user.css'),
    'scripts' => array('./libs/javascript/pages/user.js')
);


require_once './components/layout_header.php';
?>

<main>

</main>


<?php
require_once './components/layout_footer.php';
?>
