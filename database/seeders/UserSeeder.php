<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = File::get('public/data/users.json');
        $users = json_decode($users, true)['users'];

        foreach($users as $user) {
            User::create([
                'email'         => $user['email'],
                'provider_id'   => $user['id'],
                'currency'      => $user['currency'],
                'balance'       => $user['balance'],
                'created_at'    => Carbon::createFromFormat('d/m/Y', $user['created_at'])->format('Y-m-d')
            ]);
        }
    }
}
