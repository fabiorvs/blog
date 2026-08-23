<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LegacySiteSeeder extends Seeder
{
    public function run()
    {
        $this->call('LegacyPostsSeeder');
        $this->call('SobrePageSeeder');
    }
}
