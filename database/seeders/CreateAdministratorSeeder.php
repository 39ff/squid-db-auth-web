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
        $email = 'administrator'.date('Ymd').'@example.com';
        $password = Str::random(30);
        $aUser = new User();
        $aUser->fill([
            'name'=>'administrator',
            'email'=>$email,
            'password'=>Hash::make($password),
            'is_administrator'=>1,
        ]);
        $aUser->save();
        $user = Auth::loginUsingId($aUser->id);
        $token = $user->createToken('token1');

        echo 'Email: '.$email.PHP_EOL;
        echo 'Password: '.$password.PHP_EOL;
        echo 'Token: '.$token->plainTextToken.PHP_EOL;
    }
}
