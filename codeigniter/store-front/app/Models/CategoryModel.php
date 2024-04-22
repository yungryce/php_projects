<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoryModel extends Model
{
    protected $table            = 'categories';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'description', 'parent_id'];

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
        'name' => 'required|min_length[3]|max_length[255]|is_unique[categories.name]',
        'description' => 'max_length[255]',
        'parent_id' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'name' => [
            'required' => 'The category name is required.',
            'min_length' => 'The category name must be at least {param} characters long.',
            'max_length' => 'The category name cannot exceed {param} characters.',
            'is_unique' => 'The category name must be unique.',
        ],
        'description' => [
            'max_length' => 'The description cannot exceed {param} characters.',
        ],
        'parent_id' => [
            'integer' => 'The parent ID must be an integer value.',
        ],
    ];
}
