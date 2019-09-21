<?php
    session_start();
    session_destroy();
    // echo var_dump($_GET);
    header("Location:../../".$_GET['p'].".php");
?>