<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


/**
 * PRUEBAS REALIZADAS A LA API
 */
class BaseTest extends TestCase
{
    
    use RefreshDatabase;
   
    public function test_basic_test(){
        $response = $this->get('/');
        $response->assertStatus(200);
    }   
    public function assertSuccess($response, $code = 200 ){
        $response->assertStatus($code)
            ->assertJson(['ok' => true ]);
    }

    public function assertError($response, $code = 404){
        $response->assertStatus($code)
            ->assertJson(['ok' => false]);
    }

}
