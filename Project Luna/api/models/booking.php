<?php
require_once 'base.php';
class Booking extends Base{
    protected $table_name = 'booking';

    public $showtime_id;
    public $transaction_id;
    public $seat;
}