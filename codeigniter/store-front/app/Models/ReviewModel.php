<?php

namespace App\Models;

use CodeIgniter\Model;

class ReviewModel extends Model
{
    protected $table            = 'reviews';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id', 'user_id', 'rating', 'comment'];

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

    // Validation
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;
    protected $validationRules = [
        'product_id' => 'required|integer',
        'user_id' => 'required|integer',
        'rating' => 'required|integer|greater_than_equal_to[1]|less_than_equal_to[5]',
        'comment' => 'max_length[255]',
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'The product ID is required.',
            'integer' => 'The product ID must be an integer value.',
        ],
        'user_id' => [
            'required' => 'The user ID is required.',
            'integer' => 'The user ID must be an integer value.',
        ],
        'rating' => [
            'required' => 'The rating is required.',
            'integer' => 'The rating must be an integer value.',
            'greater_than_equal_to' => 'The rating must be greater than or equal to 1.',
            'less_than_equal_to' => 'The rating must be less than or equal to 5.',
        ],
        'comment' => [
            'max_length' => 'The comment cannot exceed {param} characters.',
        ],
    ];
}
