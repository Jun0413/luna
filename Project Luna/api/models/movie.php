<?php
require_once 'base.php';
class Movie extends Base{
    protected $table_name = 'hall';

    public $name;
    public $genre;
    public $region;
    public $rating;
    public $overview;
    public $director;
    public $length;
    public $cast;
    public $is_showing;
}