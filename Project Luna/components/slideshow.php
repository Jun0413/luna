<?php
function slide_show($config)
{
    echo "<div class='slideshow' data-delay='" . $config['delay'] . "' data-speed='" . $config['speed'] . "'>
     <figure>";

    foreach ($config['items'] as $item) {
        echo strtr("<img data-src='./images/_src' data-target='_target' alt='_name'>", $item);
    }

    echo "</figure>
    </div>";
}
?>
