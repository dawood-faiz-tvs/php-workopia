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
        $listings = $this->db->query("SELECT * FROM listings")->fetchAll();

        loadView("listings/index", [
            "listings" => $listings
        ]);
    }

    public function show($params)
    {
        $id = $params['id'] ?? '';
        $params = [
            'id' => $id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        if (!$listing) {
            ErrorController::notFound('Listing not found!');
            return;
        }

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
            'salary',
            'requirements',
            'benefits',
            'company',
            'address',
            'city',
            'state',
            'phone',
            'email',
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
            $fieldsArray = array_keys($newListingData);
            $fields = implode(', ', $fieldsArray);

            $valuesArray = array_map('placeholder', $fieldsArray);
            $values = implode(', ', $valuesArray);

            $newListingData = array_map('nullable', $newListingData);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";
            $this->db->query($query, $newListingData);

            redirect('listings/create?success=' . urlencode('Listing created successfully'));
        }
    }
}
