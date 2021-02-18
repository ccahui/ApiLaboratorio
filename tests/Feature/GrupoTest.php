<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Grupo;

class GrupoTest extends BaseTest
{
    public $keys = ['id','numero','descripcion','fechaInicio','fechaFin'];
    public $table = 'grupos';
    public $url = '/grupos';

    /*TODO*/
    public function test_obtener_listado()
    {
        $grupos = factory(Grupo::class, 2)->create(); 
        $keys = $this->keys;

        $data = $grupos->map( function ($grupo) use ($keys){
                return $grupo->refresh()->only($keys);
             })->toArray();
        
        $response = $this->get($this->apiUrl());
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);
    }

    public function test_obtener_por_id()
    {
        $grupo = factory(Grupo::class)->create()->refresh();
        $data = $grupo->only($this->keys);   
        
        $response = $this->get($this->apiUrl($grupo->id));
       
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);
    }
    
    public function test_obtener_por_id_not_found()
    {
       $id = 1;
        
        $response = $this->get($this->apiUrl($id));
       
        $this->assertError($response);
    }
}

