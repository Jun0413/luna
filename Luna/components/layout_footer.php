<footer>
    <p>Luna Cinema Pte Ltd &copy; 2018</p>
</footer>
<?php
foreach ($config['scripts'] as $script) {
    echo "<script type='application/javascript' src='$script'></script>";
}
?>
</body>
</html>