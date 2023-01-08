<?php

namespace App\Entities;

use CodeIgniter\Shield\Entities\User;

class UserEntity extends User
{
    public function avatar(int $size = 250): string
    {
        if ($size < 80) {
            $size = 80;
        }

        if ($size > 2048) {
            $size = 2048;
        }

        return 'https://seccdn.libravatar.org/avatar/' . md5(strtolower(trim($this->email))) . "?s={$size}&d=mp";
    }
}
