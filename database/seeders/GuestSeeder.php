<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Hash;

class GuestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $aes_key = config('app.aes_key');
        $aes_type = config('app.aes_type');
        User::create([
            'name' => openssl_encrypt('ゲスト', $aes_type, $aes_key),
            'email' => openssl_encrypt('guest@test.com', $aes_type, $aes_key),
            'email_verified_at' => new DateTime(),
            'password' => Hash::make('aaaaaaaa'),
        ]);
        $path = 'database/seeders/data/default.sql';
        \DB::unprepared(file_get_contents($path));
    }
}
