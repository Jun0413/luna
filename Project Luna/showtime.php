<?php
$config = array(
    'navLink' => 'movies',
    'styles' => array('./libs/css/pages/showtime.css'),
    'scripts' => array('./libs/javascript/pages/showtime.js')
);

require_once './api/config/database.php';
$database = new Database();
$db = $database->getConnection();

require_once './components/layout_header.php';
?>

<main>
</main>

<?php
require_once './components/layout_footer.php';
?>
