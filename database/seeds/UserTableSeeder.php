<?php

use Illuminate\Database\Seeder;
use \App\Entities\User;
use \App\Entities\Client;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class, 10)->create()->each(function($user){
            $user->client()->save(factory(Client::class)->make());
        });
    }
}
