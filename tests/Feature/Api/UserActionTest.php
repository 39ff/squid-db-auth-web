<?php

namespace Tests\Feature\Api;

use App\Models\SquidAllowedIp;
use App\Models\SquidUser;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Tests\TestCase;

class UserActionTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->admin = $this->createAdministrator();
    }

    public function test_can_create_user_by_administrator()
    {

        $response = $this->actingAs($this->admin)
            ->json('POST','api/user/create',[
            'name'=>'administrator user🍱🍺',
            'email'=>'test_can_create_user_by_administrator@example.com',
            'password'=>'test_administrator'
        ]);
        $response->assertStatus(201);
    }

    public function test_impossible_create_user_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('POST','api/user/create',[
                'name'=>'unprivileged user🍱🍺',
                'email'=>'user@example.com',
                'password'=>'test_unprivileged_user_password'
            ]);
        $response->assertStatus(403);
    }

    public function test_can_modify_own_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('POST','api/user/modify/'.$this->user->id,[
                'name'=>'update unprivileged user🍱🍺',
                'email'=>'update_unprivileged_user@example.com',
            ]);
        $response->assertStatus(200);
        $response->assertJson([
           'data'=>[
               'name'=>'update unprivileged user🍱🍺',
               'email'=>'update_unprivileged_user@example.com',
               'password'=>'*'
           ]
        ]);
    }

    public function test_can_modify_other_user_by_administrator(){
        $response = $this->actingAs($this->user)
            ->json('POST','api/user/modify/'.$this->user->id,[
                'name'=>'update unprivileged user by administrator',
                'email'=>'update_unprivileged_user_by_administrator@example.com',
            ]);
        $response->assertStatus(200);
        $response->assertJson([
            'data'=>[
                'name'=>'update unprivileged user by administrator',
                'email'=>'update_unprivileged_user_by_administrator@example.com',
                'password'=>'*'
            ]
        ]);
    }

    public function test_can_destroy_other_user_by_administrator(){
        $aUser = User::factory()->create([
            'is_administrator'=>0
        ]);
        $response = $this->actingAs($this->admin)
            ->json('POST','api/user/destroy/'.$aUser->id,[]);
        $response->assertStatus(200);
    }

    public function test_impossible_destroy_other_user_by_unprivileged_user(){
        $aUser = User::factory()->create([
            'is_administrator'=>0
        ]);
        $bUser = User::factory()->create([
            'is_administrator'=>0
        ]);
        $response = $this->actingAs($aUser)
            ->json('POST','api/user/destroy/'.$bUser->id,[]);
        $response->assertStatus(403);
    }

    public function test_impossible_destroy_own_by_unprivileged_user(){
        $aUser = User::factory()->create([
            'is_administrator'=>0
        ]);
        $response = $this->actingAs($aUser)
            ->json('POST','api/user/destroy/'.$aUser->id,[]);
        $response->assertStatus(403);
    }

    public function test_can_create_squid_user_by_administrator(){
        $response = $this->actingAs($this->admin)
            ->json('POST','api/squiduser/create/to_specified_user/'.$this->admin->id,[
                'user'=>Str::random(10),
                'password'=>Str::random(10),
                'enabled'=>1,
                'fullname'=>Str::random(10),
                'comment'=>Str::random(10)
            ]);
        $response->assertStatus(201);
    }

    public function test_impossible_create_duplicate_squid_user_by_administrator(){
        $this->actingAs($this->admin)
            ->json('POST','api/squiduser/create/to_specified_user/'.$this->admin->id,[
                'user'=>'testuser1',
                'password'=>Str::random(10),
                'enabled'=>1,
                'fullname'=>Str::random(10),
                'comment'=>Str::random(10)
            ])->assertStatus(201);

        $this->actingAs($this->admin)
            ->json('POST','api/squiduser/create/to_specified_user/'.$this->admin->id,[
                'user'=>'testuser1',
                'password'=>Str::random(10),
                'enabled'=>1,
                'fullname'=>Str::random(10),
                'comment'=>Str::random(10)
            ])->assertStatus(422);
    }

    public function test_can_create_squid_user_to_other_user_by_administrator(){
        $response = $this->actingAs($this->admin)
            ->json('POST','api/squiduser/create/to_specified_user/'.$this->user->id,[
                'user'=>Str::random(10),
                'password'=>Str::random(10),
                'enabled'=>1,
                'fullname'=>Str::random(10),
                'comment'=>Str::random(10)
            ]);
        $response->assertStatus(201);
    }

    public function test_impossible_create_squid_user_to_other_user_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('POST','api/squiduser/create/to_specified_user/'.$this->admin->id,[
                'user'=>Str::random(10),
                'password'=>Str::random(10),
                'enabled'=>1,
                'fullname'=>Str::random(10),
                'comment'=>Str::random(10)
            ]);
        $response->assertStatus(403);
    }

    public function test_can_search_squid_user_own_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('GET','/api/squiduser/search/to_specified_user/'.$this->user->id,[]);
        $response->assertStatus(200);
    }

    public function test_impossible_search_squid_user_to_other_user_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('GET','/api/squiduser/search/to_specified_user/'.$this->admin->id,[]);
        $response->assertStatus(403);
    }

    public function test_can_search_squid_user_to_other_user_by_administrator(){
        $response = $this->actingAs($this->admin)
            ->json('GET','/api/squiduser/search/to_specified_user/'.$this->user->id,[]);
        $response->assertStatus(200);
    }

    public function test_can_destroy_squid_user_own_by_unprivileged_user(){
        $aUser = User::factory()->create([
            'is_administrator'=>0
        ]);
        $aUserSquidUser = SquidUser::factory()->create([
            'user_id'=>$aUser->id
        ]);
        $response = $this->actingAs($aUser)
            ->json('POST','api/squiduser/destroy/'.$aUserSquidUser->id,[]);
        $response->assertStatus(200);
    }

    public function test_impossible_destroy_squid_user_to_other_user_by_unprivileged_user(){
        $aUser = User::factory()->create([
            'is_administrator'=>0
        ]);
        $bUser = User::factory()->create([
            'is_administrator'=>0
        ]);
        $bUserSquidUser = SquidUser::factory()->create([
            'user_id'=>$bUser->id
        ]);
        $response = $this->actingAs($aUser)
            ->json('POST','api/squiduser/destroy/'.$bUserSquidUser->id,[]);
        $response->assertStatus(403);
    }

    public function test_can_search_users_by_administrator(){
        $response = $this->actingAs($this->admin)
            ->json('GET','/api/user/search',[]);
        $response->assertStatus(200);
    }

    public function test_impossible_search_users_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('GET','/api/user/search',[]);
        $response->assertStatus(403);
    }

    public function test_can_create_squid_allowed_ip_own_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('POST','api/squidallowedip/create/to_specified_user/'.$this->user->id,[
                'ip'=>'1.1.1.1'
            ]);
        $response->assertStatus(201);
    }

    public function test_can_create_squid_allowed_ip_to_other_user_by_administrator(){
        $response = $this->actingAs($this->admin)
            ->json('POST','api/squidallowedip/create/to_specified_user/'.$this->user->id,[
                'ip'=>'8.8.8.8'
            ]);
        $response->assertStatus(201);
    }

    public function test_impossible_create_squid_allowed_ip_to_other_user_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('POST','api/squidallowedip/create/to_specified_user/'.$this->admin->id,[
                'ip'=>'127.0.0.1'
            ]);
        $response->assertStatus(403);
    }

    public function test_can_search_squid_allowed_ip_own_by_unprivileged_user(){
        $response = $this->actingAs($this->user)
            ->json('GET','api/squidallowedip/search/to_specified_user/'.$this->user->id,[]);
        $response->assertStatus(200);
    }

    public function test_can_destroy_squid_allowed_ip_own_by_unprivileged_user(){
        $ip = SquidAllowedIp::factory()->create([
            'user_id'=>$this->user->id
        ]);
        $response = $this->actingAs($this->user)
            ->json('POST','api/squidallowedip/destroy/'.$ip->id,[]);
        $response->assertStatus(200);
    }

    private function createAdministrator(){
        $user = new User();
        $user->email = 'admin@example.com';
        $user->name = 'admin';
        $user->password = Hash::make('dummy');
        $user->is_administrator = 1;
        $user->save();
        return $user;
    }

    private function createUser(){
        $user = new User();
        $user->email = 'user@example.com';
        $user->name = 'user';
        $user->password = Hash::make('dummy');
        $user->is_administrator = 0;
        $user->save();
        return $user;
    }

}
