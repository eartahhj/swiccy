<?php
namespace App\Controllers;

class MigrateController extends BaseController
{
    public function index()
    {
        $migrate = \Config\Services::migrations();

        try {
            $migrate->latest();
            echo 'Migrated ok';
        } catch(\Exception $e) {
            echo $e->getMessage();
        }
    }
}