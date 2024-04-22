<?php

namespace App\Models;

use CodeIgniter\Model;

class TransactionModel extends Model
{
    protected $table            = 'transactions';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['payments_id', 'amount', 'status'];

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
        protected $validationRules = [
            'user_payment_id' => 'required|integer',
            'amount' => 'required|decimal',
            'status' => 'required|in_list[pending,completed,failed]'
        ];
        protected $validationMessages = [
            'user_payment_id' => [
                'required' => 'The user payment ID is required.',
                'integer' => 'The user payment ID must be an integer.',
            ],
            'amount' => [
                'required' => 'The amount is required.',
                'decimal' => 'The amount must be a decimal number.',
            ],
            'status' => [
                'required' => 'The status is required.',
                'in_list' => 'The status must be one of: pending, completed, failed.',
            ],
        ];
        
        protected $skipValidation       = false;
        protected $cleanValidationRules = true;
}
