<?php

namespace App\Controllers;

use Framework\Database;
use Framework\Validation;
use Framework\Session;
use Framework\Authorization;

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
        $listings = $this->db->query("SELECT * FROM listings ORDER BY id DESC")->fetchAll();

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

    public function edit($params)
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

        if (!Authorization::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to edit this listing!');
            redirect('/listings/' . $listing->id);
        }

        loadView("listings/edit", [
            "listing" => $listing
        ]);
    }

    public function destroy($params)
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

        if (!Authorization::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to delete this listing!');
            redirect('/listings/' . $listing->id);
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', $params);
        Session::setFlashMessage('success_message', 'Listing deleted successfully!');

        redirect('/listings');
    }

    public function create()
    {
        loadView("listings/create");
    }

    public function store()
    {
        $allowedFields = [
            'title', 'description', 'salary', 'requirements', 'benefits', 'company', 'address', 'city', 'state', 'phone', 'email', 'tags'
        ];

        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
        $newListingData['user_id'] = Session::get('user')['id'];
        $newListingData = array_map('sanitize', $newListingData);

        $requiredFields = [
            'title', 'description', 'salary', 'requirements', 'benefits', 'company', 'address', 'city', 'state', 'phone', 'email'
        ];

        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($newListingData[$field]) || !Validation::string($newListingData[$field])) {
                $errors[$field] = "The " . ucfirst($field) . " field is required!";
            }
        }

        if (!empty($errors)) {
            loadView("listings/create", [
                'errors' => $errors,
                'listing' => $newListingData
            ]);
            exit;
        }

        $fieldsArray = array_keys($newListingData);
        $fields = implode(', ', $fieldsArray);

        $valuesArray = array_map('placeholder', $fieldsArray);
        $values = implode(', ', $valuesArray);

        $newListingData = array_map('nullable', $newListingData);

        $query = "INSERT INTO listings ({$fields}) VALUES ({$values})";
        $this->db->query($query, $newListingData);
        Session::setFlashMessage('success_message', 'Listing created successfully!');

        redirect('listings/create');
    }

    public function update($params)
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

        if (!Authorization::isOwner($listing->user_id)) {
            Session::setFlashMessage('error_message', 'You are not authorized to edit this listing!');
            redirect('/listings/' . $listing->id);
        }

        $allowedFields = [
            'title', 'description', 'salary', 'requirements', 'benefits', 'company', 'address', 'city', 'state', 'phone', 'email', 'tags'
        ];

        $updatedData = array_intersect_key($_POST, array_flip($allowedFields));
        $updatedData = array_map('sanitize', $updatedData);

        $requiredFields = [
            'title', 'description', 'salary', 'requirements', 'benefits', 'company', 'address', 'city', 'state', 'phone', 'email'
        ];

        $errors = [];
        foreach ($requiredFields as $field) {
            if (empty($updatedData[$field]) || !Validation::string($updatedData[$field])) {
                $errors[$field] = "The " . ucfirst($field) . " field is required!";
            }
        }

        if (!empty($errors)) {
            loadView("listings/edit", [
                'errors' => $errors,
                'listing' => $listing
            ]);
            exit;
        }

        $fieldsArray = array_keys($updatedData);
        $fieldsArray = array_map('updatePlaceholder', $fieldsArray);
        $fields = implode(', ', $fieldsArray);

        $updatedData = array_map('nullable', $updatedData);
        $updatedData['id'] = $id;

        $query = "UPDATE listings SET {$fields} WHERE id = :id";
        $this->db->query($query, $updatedData);
        Session::setFlashMessage('success_message', 'Listing updated successfully!');

        redirect('/listings');
    }

    public function search()
    {
        $keywords = isset($_GET['keywords']) ? sanitize($_GET['keywords']) : '';
        $location = isset($_GET['location']) ? sanitize($_GET['location']) : '';

        $query = "SELECT * FROM listings WHERE (title LIKE :keywords OR description LIKE :keywords OR tags like :keywords OR company LIKE :keywords) AND (city like :location OR state LIKE :location)";
        $params = [
            'keywords' => '%' . $keywords . '%',
            'location' => '%' . $location . '%'
        ];

        $listings = $this->db->query($query, $params)->fetchAll();
        loadView("listings/index", [
            "listings" => $listings,
            "keywords" => $keywords,
            "location" => $location
        ]);
    }
}
