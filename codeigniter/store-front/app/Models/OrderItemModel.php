<?php

namespace App\Models;

use CodeIgniter\Model;

class OrderItemModel extends Model
{
    protected $table            = 'order_items';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'product_id', 'quantity', 'unit_price'];

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
        'order_id' => 'required|integer',
        'product_id' => 'required|integer',
        'quantity' => 'required|integer|min_length[1]',
        'unit_price' => 'required|numeric|min_length[1]',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'The order ID is required.',
            'integer' => 'The order ID must be an integer.',
        ],
        'product_id' => [
            'required' => 'The product ID is required.',
            'integer' => 'The product ID must be an integer.',
        ],
        'quantity' => [
            'required' => 'The quantity is required.',
            'integer' => 'The quantity must be an integer.',
            'min_length' => 'The quantity must be at least {param} units.',
        ],
        'unit_price' => [
            'required' => 'The unit price is required.',
            'numeric' => 'The unit price must be a numeric value.',
            'min_length' => 'The unit price must be at least {param}.',
        ],
    ];
}
