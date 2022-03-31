<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateAdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Str::random(30);
        echo $password.PHP_EOL;

        $aUser = new User();
        $aUser->fill([
            'name'=>'administrator',
            'email'=>'administrator@example.com',
            'password'=>Hash::make($password),
            'is_administrator'=>1,
        ]);
        $aUser->save();
        $user = Auth::loginUsingId($aUser->id);
        $token = $user->createToken('token1');

        dd($token);

    }
}
