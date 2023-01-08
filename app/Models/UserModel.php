<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends \CodeIgniter\Shield\Models\UserModel
{
    protected $returnType = 'App\Entities\UserEntity';
}
