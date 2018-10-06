<?php
require_once 'base.php';
class Hall extends Base {
    protected $table_name = 'hall';

    public $name;
    public $is_imax;
    public $is_dolby;
    public $type;
    public $cinema_id;
}