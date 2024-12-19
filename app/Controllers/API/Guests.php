<?php

namespace App\Controllers\API;

use CodeIgniter\RESTful\ResourceController;

/**
 * Guests Controller
 * 
 * Provides CRUD operations for managing event guests.
 */
class Guests extends ResourceController {
    /**
     * Model to interact with the database.
     * @var string
     */
    protected $modelName = 'App\Models\GuestModel';

    /**
     * Response format.
     * @var string
     */
    protected $format = 'json';

    /**
     * Create a new guest.
     * 
     * Endpoint: POST /guests
     * 
     * Request Body (JSON):
     * {
     *   "name": "John Doe",
     *   "email": "johndoe@gmail.com",
     *   "phone": "1234567890"
     * }
     * 
     * Response 201 (Created):
     * {
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "johndoe@gmail.com",
     *   "phone": "1234567890"
     * }
     * 
     * Response 400 (Validation Errors):
     * {
     *   "status": "error",
     *   "message": "Validation failed",
     *   "errors": { "email": "The email field must be unique." }
     * }
     */
    public function create() {
        $data = $this->request->getJSON();
        
        if ($this->model->insert($data)) {
            $data->id = $this->model->insertID(); // Add the new ID to the response.
            return $this->respondCreated($data);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    /**
     * Get a list of all guests.
     * 
     * Endpoint: GET /guests
     * 
     * Response 200 (Success):
     * [
     *   {
     *     "id": 1,
     *     "name": "John Doe",
     *     "email": "johndoe@gmail.com",
     *     "phone": "1234567890"
     *   },
     *   {
     *     "id": 2,
     *     "name": "Jane Smith",
     *     "email": "janesmith@gmail.com",
     *     "phone": "9876543210"
     *   }
     * ]
     */
    public function index() {
        $guests = $this->model->findAll();
        return $this->respond($guests);
    }

    /**
     * Get a specific guest by ID.
     * 
     * Endpoint: GET /guests/{id}
     * 
     * Response 200 (Success):
     * {
     *   "id": 1,
     *   "name": "John Doe",
     *   "email": "johndoe@gmail.com",
     *   "phone": "1234567890"
     * }
     * 
     * Response 404 (Not Found):
     * {
     *   "status": "error",
     *   "message": "Guest not found"
     * }
     */
    public function show($id = null) {
        $guest = $this->model->find($id);
        return $guest ? $this->respond($guest) : $this->failNotFound('Guest not found');
    }

    /**
     * Update a guest's information.
     * 
     * Endpoint: PUT /guests/{id}
     * 
     * Request Body (JSON):
     * {
     *   "name": "John Updated",
     *   "email": "john.updated@gmail.com",
     *   "phone": "1234567890"
     * }
     * 
     * Response 200 (Success):
     * {
     *   "message": "Guest updated successfully"
     * }
     * 
     * Response 404 (Not Found):
     * {
     *   "status": "error",
     *   "message": "Guest not found"
     * }
     */
    public function update($id = null) {
        $guest = $this->model->find($id);
        
        if (!$guest) {
            return $this->failNotFound('Guest not found');
        }
        
        $data = $this->request->getJSON();
        
        if ($this->model->update($id, $data)) {
            return $this->respond(['message' => 'Guest updated successfully']);
        }

        return $this->failValidationErrors($this->model->errors());
    }

    /**
     * Delete a guest by ID.
     * 
     * Endpoint: DELETE /guests/{id}
     * 
     * Response 200 (Success):
     * {
     *   "message": "Guest deleted successfully"
     * }
     * 
     * Response 404 (Not Found):
     * {
     *   "status": "error",
     *   "message": "Guest not found"
     * }
     */
    public function delete($id = null) {
        $guest = $this->model->find($id);

        if (!$guest) {
            return $this->failNotFound('Guest not found');
        }
        
        if ($this->model->delete($id)) {
            return $this->respondDeleted(['message' => 'Guest deleted successfully']);
        }

        return $this->failValidationErrors($this->model->errors());
    }
}
