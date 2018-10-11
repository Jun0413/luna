<?php
session_start();
require_once './api/config/database.php';
$database = new Database();
$db = $database->getConnection();

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
