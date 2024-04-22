<?php

namespace App\Models;

use CodeIgniter\Model;

class ShippingModel extends Model
{
    protected $table            = 'shippings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['order_id', 'provider', 'tracking_id'];

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
        'provider' => 'required|max_length[255]',
        'tracking_id' => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'order_id' => [
            'required' => 'The order ID is required.',
            'integer' => 'The order ID must be an integer.',
        ],
        'provider' => [
            'required' => 'The provider name is required.',
            'max_length' => 'The provider name must not exceed 255 characters.',
        ],
        'tracking_id' => [
            'required' => 'The tracking ID is required.',
            'max_length' => 'The tracking ID must not exceed 255 characters.',
        ],
    ];
}
