<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table            = 'product_variants';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id', 'name', 'price'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
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
        'name' => 'required|max_length[255]',
        'price' => 'required|decimal',
    ];
    
    protected $validationMessages = [
        'product_id' => [
            'required' => 'The product ID is required.',
            'integer' => 'The product ID must be an integer.',
        ],
        'name' => [
            'required' => 'The variant name is required.',
            'max_length' => 'The variant name must not exceed 255 characters.',
        ],
        'price' => [
            'required' => 'The price is required.',
            'decimal' => 'The price must be a decimal number.',
        ],
    ];
}
