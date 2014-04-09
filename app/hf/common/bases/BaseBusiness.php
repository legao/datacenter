<?php
use Legao\Data\Connection;

class BaseBusiness
{
	protected $db;

    function __construct()
    {
        $this->db = Connection::factory();
    }
}