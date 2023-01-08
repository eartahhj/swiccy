<?php

namespace App\Models;

use CodeIgniter\Model;

class TaskModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'task';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    // protected $returnType       = 'array';
    protected $returnType       = 'object';
    // protected $returnType       = 'App\Entitites\Task';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['description'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = ['description' => 'required'];
    protected $validationMessages   = [
        'description' => [
            'required' => 'Description is required'
        ]
    ];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

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

    public static $pager = null;

    public function getTasksByUserId(int $userId)
    {
        return $this->where('user_id', $userId)
        ->orderBy('created_at', 'DESC')
        ->paginate();
    }

    public function search($term, $userId) : array
    {
        if (!$term) {
            return [];
        }
        
        return $this->select('id, description')
        ->where('user_id', $userId)
        ->like('description', $term)
        ->get()
        ->getResultArray();
    }
}
