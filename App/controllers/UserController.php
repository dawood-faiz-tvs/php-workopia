<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;

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

    public function registerUser()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $city = $_POST['city'];
        $state  = $_POST['state'];
        $password  = $_POST['password'];
        $passwordConfirmation  = $_POST['password_confirmation'];

        $errors = [];

        if (!Validation::string($name, 2, 50)) {
            $errors['name'] = 'Name must be between 2 and 50 characters!';
        }

        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address!';
        }

        if (!Validation::string($password, 6, 50)) {
            $errors['password'] = 'Password must be atleast 6 characters long!';
        }

        if (!Validation::match($password, $passwordConfirmation)) {
            $errors['password_confirmation'] = 'Passwords do not match!';
        }

        if (!empty($errors)) {
            loadView("users/register", [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state
                ]
            ]);
            exit;
        }

        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if ($user) {
            $errors['email'] = 'This email is already registered!';
            loadView("users/register", [
                'errors' => $errors,
                'user' => [
                    'name' => $name,
                    'email' => $email,
                    'city' => $city,
                    'state' => $state
                ]
            ]);
            exit;
        }

        $userData = [
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $fieldsArray = array_keys($userData);
        $fields = implode(', ', $fieldsArray);

        $valuesArray = array_map('placeholder', $fieldsArray);
        $values = implode(', ', $valuesArray);

        $userData = array_map('nullable', $userData);

        $query = "INSERT INTO users ({$fields}) VALUES ({$values})";
        $this->db->query($query, $userData);
        $userId = $this->db->conn->lastInsertId();

        Session::set('success_message', 'User registered successfully!');
        Session::set('user', [
            'id' => $userId,
            'name' => $name,
            'email' => $email,
            'city' => $city,
            'state' => $state
        ]);

        redirect('/auth/login');
    }

    public function logout()
    {
        Session::clearAll();
        $cookieParams = session_get_cookie_params();

        setcookie('PHPSESSID', '', time() - 86400, $cookieParams['path'], $cookieParams['domain']);
        redirect('/auth/login');
    }

    public function authenticate()
    {
        $email = $_POST['email'];
        $password  = $_POST['password'];

        $errors = [];

        if (!Validation::string($password)) {
            $errors['password'] = 'Please enter a password!';
        }

        if (!Validation::email($email)) {
            $errors['email'] = 'Please enter a valid email address!';
        }

        if (!empty($errors)) {
            loadView("users/login", [
                'errors' => $errors,
                'user' => [
                    'email' => $email
                ]
            ]);
            exit;
        }

        $params = [
            'email' => $email
        ];

        $user = $this->db->query('SELECT * FROM users WHERE email = :email', $params)->fetch();

        if (!$user) {
            Session::set('error_message', 'Invalid credentials!');
            redirect('/auth/login');
        }

        if (!password_verify($password, $user->password)) {
            Session::set('error_message', 'Invalid credentials!');
            redirect('/auth/login');
        }

        Session::set('user', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'city' => $user->city,
            'state' => $user->state
        ]);

        redirect('/');
    }
}
