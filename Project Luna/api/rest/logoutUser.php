<?php
    session_start();
    if(isset($_SESSION['user_name'])) {
        unset($_SESSION['user_name']);
    }
    if(isset($_SESSION['user_email'])) {
        unset($_SESSION['user_email']);
    }
    // echo var_dump($_GET);
    header("Location:../../".$_GET['p'].".php");
?>