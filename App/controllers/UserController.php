<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class UserController
{
    protected $db;

    public function __construct()
    {
        $config = require(basePath('config/db.php'));
        $this->db = new Database($config);
    }

    public function register()
    {
        loadView("users/register");
    }

    public function login()
    {
        loadView("users/login");
    }
}
