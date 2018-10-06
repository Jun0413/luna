<?php
require_once 'base.php';
class Transaction extends Base {
    protected $table_name = 'transaction';

    public $name;
    public $email;
    public $combo_a;
    public $combo_b;
}