<?php
require_once 'base.php';
class Showtime extends Base {
    protected $table_name = 'showtime';

    public $hall_id;
    public $movie_id;
    public $day;
    public $start_time;
    public $price;

}