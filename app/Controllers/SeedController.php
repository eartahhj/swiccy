<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SeedController extends BaseController
{
    public function index()
    {
        $seeder = \Config\Database::seeder();
        $seeder->call('UserSeeder');
        echo 'Users seeded';
    }
}
