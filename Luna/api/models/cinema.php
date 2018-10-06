<?php
require_once 'base.php';
class Cinema extends Base {
    protected $table_name = 'cinema';

    public $name;
    public $address;
    public $phone;
}