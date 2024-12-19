<?php namespace App\Models;

use CodeIgniter\Model;

class GuestModel extends Model {
    protected $table = 'guests';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'email', 'phone'];
    protected $validationRules = [
        'name' => 'required|min_length[3]',
        'email' => 'required|valid_email|is_unique[guests.email]',
        'phone' => 'required',
    ];

    protected $useTimestamps = true;

    protected $validationMessages = [
        'email' => [
            'is_unique' => 'The email provided is already in use. Please use a different email.',
        ],
    ];
}