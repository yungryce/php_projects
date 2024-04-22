<?php

namespace App\Models;

use CodeIgniter\Model;

class PaymentsModel extends Model
{
    protected $table            = 'payments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['user_id', 'card_token', 'card_name', 'provider', 'card_expiry'];

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
        'card_token' => 'permit_empty|string|max_length[255]',
        'card_name' => 'permit_empty|string|max_length[255]',
        'provider' => 'required|string|max_length[255]',
        'card_expiry' => 'permit_empty|valid_date',
    ];

    // Validation messages
    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required.',
            'integer' => 'User ID must be an integer.',
        ],
        'card_token' => [
            'string' => 'Card token must be a string.',
            'max_length' => 'Card token cannot exceed 255 characters.',
        ],
        'card_name' => [
            'string' => 'Card name must be a string.',
            'max_length' => 'Card name cannot exceed 255 characters.',
        ],
        'provider' => [
            'required' => 'Provider is required.',
            'string' => 'Provider must be a string.',
            'max_length' => 'Provider cannot exceed 255 characters.',
        ],
        'card_expiry' => [
            'valid_date' => 'Card expiry must be a valid date.',
        ],

    ];
}
