<?php
session_start();

if (!isset($_SESSION['user_email']) || !isset($_SESSION['user_name'])) {
    header('location: home.php');
    die();
} else {
    $email = $_SESSION['user_email'];
    $name = $_SESSION['user_name'];
}

$config = array(
    'navLink' => 'home',
    'styles' => array('./libs/css/pages/user.css'),
    'scripts' => array()
);

require_once './components/layout_header.php';
require_once './api/config/database.php';
?>

<main>
    <section class="user_header">
        <div class="user_profile">
            <div class="user_info">
                <?php echo "<h3>$name</h3>" ?>
                <?php echo "<p>$email</p>" ?>
            </div>
            <i data-icon="avatar"></i>
            <hr>
        </div>
    </section>
     <section class="bookings">
         <?php
            $db = Database::getConnection();
            
            $query = "select movie.name as movie_name, cinema.name as cinema_name, mvbk.day, mvbk.start_time, mvbk.timestamp, hall.name as hall_name, mvbk.seat from (select st.hall_id, st.movie_id, st.day, st.start_time, show_seat.seat, show_seat.timestamp from (select bkn.showtime_id, bkn.seat,txn.timestamp from transaction as txn, booking as bkn where txn.email = '$email' and txn.id = bkn.transaction_id) as show_seat, showtime as st where show_seat.showtime_id = st.id) as mvbk, hall, cinema, movie where mvbk.hall_id = hall.id and mvbk.movie_id = movie.id and hall.cinema_id = cinema.id";
             $retrieved = array();
             $result = $db->query($query);
            $num_rows = $result->num_rows;
            for ($i = 0; $i < $num_rows; $i++) {
                $row = $result->fetch_assoc();
                $retrieved[] = $row;
            }
             // compute date, add it to the retrieved array
            for ($i = 0; $i < count($retrieved); $i++) {
                $row = $retrieved[$i];
                $date_time = date('y-m-d', strtotime(date('y-m-d', $row['timestamp'])))." ".substr($row['start_time'], 0, 5);
                $retrieved[$i]['date_time'] = $date_time;
            }
             // combine hall & seats
            $formatted_data = array();
            for ($i = 0; $i < count($retrieved); $i++) {
                $row = $retrieved[$i];
                $isNew = true;
                foreach ($formatted_data as $j => $formatted_row) {
                    if ($row['movie_name'] == $formatted_row['movie_name'] && $row['cinema_name'] == $formatted_row['cinema_name'] && $row['hall_name'] == $formatted_row['hall_name'] && $row['date_time'] == $formatted_row['date_time']) {
                        $isNew = false;
                        $formatted_data[$j]['location'] .= (", ".$row['seat']);
                        break;
                    }
                }
                if ($isNew) {
                    $formatted_data[] = array('movie_name' => $row['movie_name'], 'cinema_name' => $row['cinema_name'], 'date_time' => $row['date_time'], 'hall_name' => $row['hall_name'], "location" => $row['hall_name']." ".$row['seat']);
                }
            }
             // sort the formatted data by date
            function date_sort($x, $y) {
                return strtotime($y['date_time'].":00") - strtotime($x['date_time'].":00");
            }
            usort($formatted_data, "date_sort");
             // render the formatted data
            $dt_obj = new DateTime();
            $timestamp_now = $dt_obj->getTimestamp();
            $upcoming_rows = "";
            $past_rows = "";
            $continue_from = 0;
            $upcoming_count = 0;
            $past_count = 0;
            foreach ($formatted_data as $i => $row) {
                if (strtotime($row['date_time'].":00") <= $timestamp_now) {
                    $continue_from = $i;
                    break;
                } else {
                    $upcoming_count++;
                    $upcoming_rows .= "<tr><td>".$row['movie_name']."</td><td>".$row['cinema_name']."</td><td>".$row['date_time']."</td><td>".$row['location']."</td></tr>";
                }
            }
            foreach ($formatted_data as $i => $row) {
                if ($i >= $continue_from) {
                    $past_count++;
                    $past_rows .= "<tr><td>".$row['movie_name']."</td><td>".$row['cinema_name']."</td><td>".$row['date_time']."</td><td>".$row['location']."</td></tr>";
                }
            }
            echo "<div class='upcoming'>";
            echo "<h1 data-count='".$upcoming_count.($upcoming_count > 1 ? ' bookings' : ' booking')."'><span>Upcoming</span></h1>";
            if ($upcoming_rows != "") {
                echo "<table>
                    <thead>
                        <tr><td>Movie</td><td>Cinema</td><td>Time</td><td>Seats</td></tr>
                    </thead>
                    <tbody>
                ";
                echo $upcoming_rows;
                echo "</tbody></table>";
            }
            echo "</div>";
            echo "<div class='past'>";
            echo "<h1 data-count='".$past_count.($past_count > 1 ? ' bookings' : ' booking')."'><span>Past</span></h1>";
            if ($past_rows != "") {
                echo "<table>
                        <thead>
                            <tr><td>Movie</td><td>Cinema</td><td>Time</td><td>Seats</td></tr>
                        </thead>
                        <tbody>";
                echo $past_rows;
                echo "</tbody></table>";
            }
            echo "</div>";
        ?>
    </section>
</main>


<?php
require_once './components/layout_footer.php';
?>
