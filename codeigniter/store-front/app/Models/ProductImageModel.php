<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductImageModel extends Model
{
    protected $table            = 'product_images';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['product_id', 'filename'];

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
        'filename' => 'required|max_length[255]',
    ];

    protected $validationMessages = [
        'product_id' => [
            'required' => 'The product ID is required.',
            'integer' => 'The product ID must be an integer value.',
        ],
        'filename' => [
            'required' => 'The filename is required.',
            'max_length' => 'The filename cannot exceed {param} characters.',
        ],
    ];
}
