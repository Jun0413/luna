<?php
require_once 'base.php';
class User extends Base {
    protected $table_name = 'user';

    public $name;
    public $email;
    public $password;
}