<?php

namespace App\Models;

use CodeIgniter\Model;

class PostModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'posts';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'App\Entities\PostEntity';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['title', 'text', 'city', 'email', 'phone_number', 'address', 'quantity_give', 'quantity_receive'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'title' => 'required|min_length[5]|max_length[200]',
        'text' => 'required|min_length[10]|max_length[2000]',
        'city' => 'required|min_length[2]|max_length[200]',
        'email' => 'required|valid_email|max_length[200]',
        'phone_number' => 'max_length[20]',
        'address' => 'max_length[200]',
        'quantity_give' => 'required|numeric|greater_than[0]|less_than[1000]',
        'quantity_receive' => 'required|numeric|greater_than[0]|less_than[1000]',
    ];
    
    protected $validationMessages   = [];

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
}
