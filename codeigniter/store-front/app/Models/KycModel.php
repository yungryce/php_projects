<?php

namespace App\Models;

use CodeIgniter\Model;

class KycModel extends Model
{
    protected $table            = 'kycs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'first_name', 'last_name', 'address', 'city', 'postal_code', 'state', 'country', 'phone_number'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

   // Validation rules
   protected $skipValidation       = false;
   protected $cleanValidationRules = true;
   protected $validationRules = [
       'user_id' => 'required|integer',
       'first_name' => 'required|max_length[255]',
       'last_name' => 'required|max_length[255]',
       'address' => 'required|max_length[255]',
       'city' => 'required|max_length[255]',
       'postal_code' => 'required|max_length[20]',
       'state' => 'required|max_length[255]',
       'country' => 'required|max_length[255]',
       'phone_number' => 'required|max_length[20]',
   ];
   
    // Validation messages
    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required.',
            'integer' => 'User ID must be an integer.',
        ],
        'first_name' => [
            'required' => 'First name is required.',
            'max_length' => 'First name cannot exceed 255 characters.',
        ],
        'last_name' => [
            'required' => 'Last name is required.',
            'max_length' => 'Last name cannot exceed 255 characters.',
        ],
        'address' => [
            'required' => 'Address is required.',
            'max_length' => 'Address cannot exceed 255 characters.',
        ],
        'city' => [
            'required' => 'City is required.',
            'max_length' => 'City cannot exceed 255 characters.',
        ],
        'postal_code' => [
            'required' => 'Postal code is required.',
            'max_length' => 'Postal code cannot exceed 20 characters.',
        ],
        'state' => [
            'required' => 'State is required.',
            'max_length' => 'State cannot exceed 255 characters.',
        ],
        'country' => [
            'required' => 'Country is required.',
            'max_length' => 'Country cannot exceed 255 characters.',
        ],
        'phone_number' => [
            'required' => 'Phone number is required.',
            'max_length' => 'Phone number cannot exceed 20 characters.',
        ],
    ];
}
