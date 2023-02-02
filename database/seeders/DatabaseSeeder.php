<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AppSetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin Masjid',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin123'),
            'user_level'    => 'admin',
        ]);

        User::create([
            'name' => 'Bendahara Masjid',
            'email' => 'user@user.com',
            'password' => bcrypt('user123'),
            'user_level'    => 'bendahara',
        ]);

        AppSetting::create([
            'revision_id'   => uniqid(),
            'interval'  => 10,
            'is_ticker' => '1',
            'is_gallery' => '1',
            'is_idfitri' => '0',
            'is_idadha' => '0',
            'is_ramadhan' => '0',
            'ketua_bkm' => 'Ryan Syah',
            'bendahara_bkm' => 'Achdiadsyah',
        ]);
    }
}
