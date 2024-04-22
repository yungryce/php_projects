<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table            = 'products';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'price', 'quantity', 'category_id'];

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
        'name' => 'required|min_length[3]|max_length[255]',
        'description' => 'required',
        'price' => 'required|numeric',
        'quantity' => 'required|integer',
        'category_id' => 'required|integer',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'The product name is required.',
            'min_length' => 'The product name must be at least {param} characters long.',
            'max_length' => 'The product name cannot exceed {param} characters.',
        ],
        'description' => [
            'required' => 'The product description is required.',
        ],
        'price' => [
            'required' => 'The product price is required.',
            'numeric' => 'The product price must be a numeric value.',
        ],
        'quantity' => [
            'required' => 'The product quantity is required.',
            'integer' => 'The product quantity must be an integer value.',
        ],
        'category_id' => [
            'required' => 'The category ID is required.',
            'integer' => 'The category ID must be an integer value.',
        ],
    ];
}
