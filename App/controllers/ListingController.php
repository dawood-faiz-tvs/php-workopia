<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;

class ListingController
{
    protected $db;

    public function __construct()
    {
        $config = require(basePath('config/db.php'));
        $this->db = new Database($config);
    }

    public function index()
    {
        dd(Validation::match('com', 'com'));
        $listings = $this->db->query("SELECT * FROM listings")->fetchAll();

        loadView("listings/index", [
            "listings" => $listings
        ]);
    }

    public function show()
    {
        $id = $_GET['id'] ?? '';
        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        loadView("listings/show", [
            "listing" => $listing
        ]);
    }

    public function create()
    {
        loadView("listings/create");
    }

    public function store()
    {
        $allowedFields = [
            'title',
            'description',
            'salary',
            'requirements',
            'benefits',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
            'tags'
        ];

        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
        $newListingData['user_id'] = 1;
        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = [
            'title',
            'description',
        ];

        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = "The " . ucfirst($field) . " field is required";
            }
        }

        if (!empty($errors)) {
            loadView("listings/create", [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
        } else {
            echo "Success";
        }
    }
}
