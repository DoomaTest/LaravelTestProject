<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportSeeder extends Seeder
{
    const OAUTH_CLIENTS = [
        [
            'name' => 'Laravel Personal Access Client',
            'secret' => 'U3hoC6I78y7krANjPeooL1ftOYH57j2MFlHsCoZi',
            'provider' => '',
            'redirect' => 'http://localhost',
            'personal_access_client' => 'true',
            'password_client' => 'false',
            'revoked' => 'false',
            ],
        [
            'name' => 'Laravel Password Grant Client',
            'secret' => 'ncvXemjm2ksARewNnrJSCij6E7Jwi3BL5PvnptYW',
            'provider' => 'users',
            'redirect' => 'http://localhost',
            'personal_access_client' => 'false',
            'password_client' => 'true',
            'revoked' => 'false',
            ],

    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('oauth_clients')->insertOrIgnore(self::OAUTH_CLIENTS);
    }
}
