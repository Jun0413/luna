<?php
$config = array(
    'navLink' => 'cinemas',
    'styles' => array('./libs/css/pages/cinemas.css'),
    'scripts' => array('./libs/javascript/pages/cinemas.js')
);

require_once './components/layout_header.php';
?>

<main>
    <div>
        <img src="./images/cinemas/banner.jpg" id='banner'>
    </div>

    <section>
        <div class='cinemas'>
        <?php 
            require_once './api/models/cinema.php';
            $cinema = new Cinema();
            $query = 'SELECT c.id, c.name, c.address, c.phone, 
                        SUM(is_imax) > 0 AS is_imax, SUM(is_dolby) > 0 as is_dolby 
                        FROM hall h LEFT JOIN cinema c on h.cinema_id = c.id GROUP BY cinema_id;';
            $result = $cinema->getAll($query);
            while($row = $result->fetch_assoc()) {
        ?>
            <a href="showtime.php?cinema=<?php echo $row['id'] ?>&movie=0">
                <img src="./images/cinemas/<?php echo $row['id'] ?>.jpg">
                <div>
                    <h1>
                        <?php 
                        echo $row['name'];
                        if($row['is_imax']) echo "<i data-icon='imax'></i>";
                        if($row['is_dolby']) echo "<i data-icon='dolby'></i>";
                        ?>
                    </h1>
                    <p><?php echo $row['address'] ?></p>
                    <p><?php echo $row['phone'] ?></p>
                </div>
            </a>
        <?php
            }
        ?>
        </div>    
    </section>
</main>

<?php
require_once './components/layout_footer.php';
?>
