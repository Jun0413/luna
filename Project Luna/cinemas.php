<?php
$config = array(
    'navLink' => 'cinemas',
    'styles' => array('./libs/css/pages/cinemas.css'),
    'scripts' => array('./libs/javascript/pages/cinemas.js')
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
