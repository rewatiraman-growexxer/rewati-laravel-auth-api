<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Setting;
use App\Models\User;
use Laravel\Passport\Passport;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use Faker;
class SettingTest extends TestCase
{
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_all_setting_return()
    {
        $t = User::first();
        $token = $t->token;
        $headers = [
            'HTTP_Authorization' => 'Bearer ' . $token
            ];
            $response = $this->call('GET', '/api/settings',[],[],[],$headers);

            $this->assertEquals(200, $response->getStatusCode(200));
    }
   
    public function test_can_user_get_a_setting()
    {
        $id = Setting::first()->id;
        $token = User::first()->token;
        $headers = [
            'HTTP_Authorization' => 'Bearer ' . $token
            ];
            $response = $this->call('GET', '/api/settings/'.$id,[],[],[],$headers);

            $this->assertEquals(200, $response->getStatusCode(200));
    }
    
    public function test_user_can_create_setting()
    {
        
        $faker = Faker\Factory::create();
        $token = User::first()->token;
        $headers = [
            'HTTP_Authorization' => 'Bearer ' . $token
            ];
            $key = $faker->word;
            $value = $faker->numberBetween(0, 1);
        $response = $this->call('POST','/api/settings',['key'=>$key,'value'=>$value],[],[],$headers);
        $this->assertEquals(201, $response->getStatusCode(201));
    }
    public function test_failer_on_create_setting()
    {
        
        $faker = Faker\Factory::create();
        $token = User::first()->token;
        $headers = [
            'HTTP_Authorization' => 'Bearer ' . $token
            ];
            $key = $faker->word;
            $value = $faker->numberBetween(0, 1);
            $response = $this->call('POST','/api/settings',['value'=>$value],[],[],$headers);
            $this->assertEquals(404, $response->getStatusCode(404));
    }
    public function test_user_can_update_setting()
    {
        $id = Setting::first()->id;
        $faker = Faker\Factory::create();
        $token = User::first()->token;
        $headers = [
            'HTTP_Authorization' => 'Bearer ' . $token
            ];
            $key = $faker->word;
            $value = $faker->numberBetween(0, 1);
            $response = $this->call('PUT','/api/settings/'.$id,['key'=>$key,'value'=>$value],[],[],$headers);
            $this->assertEquals(200, $response->getStatusCode(200));
    }
    public function test_user_can_delete_setting()
    {
        $id = Setting::first()->id;
        $token = User::first()->token;
        $headers = [
            'HTTP_Authorization' => 'Bearer ' . $token
            ];
            $response = $this->call('DELETE', 'api/settings/'.$id,['_token' => $token ],[],[],$headers);

            $this->assertEquals(200, $response->getStatusCode(200));
    }
    
    
}
