<?php

namespace Tests;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\User;
use Faker;
class UserTest extends TestCase
{
   
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_register()
    {

        $faker = Faker\Factory::create();
        $email = $faker->unique()->email;
        $response = $this->call('POST','/register',['name' =>'rajnikant','email' => $email,'password'=>'123456']);
        $this->assertEquals(200, $response->getStatusCode(200));
    }
    public function test_user_can_login()
    {
        $response = $this->call('POST','/login',['email' =>'r@gmail.com','password'=>'123456']);
        $this->assertEquals(200, $response->getStatusCode(200));
    }
    public function test_login_failer()
    {
        $response = $this->call('POST','/login',['email' =>'r@gmail.com','password'=>'1234569']);
        $this->assertEquals(401, $response->getStatusCode(401));
    }
    public function test_user_not_atuhenticate()
    {
        
        $authenticate = new Authenticate(auth());
        $request = Request::create('/api/settings/', 'GET');
        $response = $authenticate->handle($request, function () {});
        $this->assertEquals(401, $response->getStatusCode(401));
    }
}
