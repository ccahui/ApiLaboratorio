<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Curso;

/**
 * PRUEBAS REALIZADAS A LA API
 */
class CursoTest extends BaseTest
{
    
    public $keys = ['nombre','codigo','tieneLab','created_at','updated_at'];
    public $table = 'cursos';
    public $url = '/cursos';

    /*TODO */
    public function test_obtener_listado()
    {
        $cursos = factory(Curso::class, 2)->create(); 
        $keys = $this->keys;

        $data = $cursos->map( function ($curso) use ($keys){
                return $curso->refresh()->only($keys);
             })->toArray();
       // dd(json_encode($data));
        $response = $this->get($this->apiUrl());
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);
    }

    public function test_obtener_por_id()
    {
        $curso = factory(Curso::class)->create()->refresh();
        $data = $curso->only($this->keys);   
        
        $response = $this->get($this->apiUrl($curso->id));
       
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);
    }

    public function test_obtener_error_id_not_found()
    {
        $id = 1;
        $response = $this->get($this->apiUrl($id));
        
        $this->assertError($response);
    }

    public function test_crear()
    {
        $curso = factory(Curso::class)->make();   
        $request = [
            'nombre' => $curso->nombre,
            'codigo' => $curso->codigo,
            'tieneLab' => $curso->tieneLab,
        ];

        $response = $this->post($this->apiUrl(), $request);

        $this->assertDatabaseHas($this->table, ['codigo'=> $curso->codigo]);
        
        $this->assertSuccess($response, 201);
        
    }

    public function test_nombre_required_validacion_para_crear()
    {
        
        $curso = factory(Curso::class)->make(['nombre' => '']);
        
        $request = [
            'nombre'=>$curso->nombre,
            'codigo' => $curso->codigo,
            'tieneLab' => $curso->tieneLab,
        ];

        $response = $this->post($this->apiUrl(), $request);

        $this->assertError($response);
        $response->assertJson([ 'message'=>'Validation Error.']);
        $response->assertSee('The nombre field is required.');
    }

    public function test_actualizar_nombre()
    {
        $nuevoNombre = 'Matematica';
        $curso = factory(Curso::class)->create();

        $request = ['nombre' => $nuevoNombre];

        $response = $this->put($this->apiUrl($curso->id), $request);

        $this->assertDatabaseHas($this->table, ['nombre'=> $nuevoNombre]);

        $data = Curso::find($curso->id)->only($this->keys);
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);                
    }

    public function test_nombre_required_validacion_para_actualizar()
    {
        $curso = factory(Curso::class)->create();
        $request = ['nombre'=> ''];

        $response = $this->put($this->apiUrl($curso->id), $request);
        
        $this->assertError($response);
        $response->assertJson(['message' => 'Validation Error.']);
        $response->assertSee('The nombre field is required.');

    }

    public function test_eliminar_por_id()
    {
        $curso = factory(Curso::class)->create();
        $data = $curso->refresh()->only($this->keys);

        $response = $this->delete($this->apiUrl($curso->id));
        $this->assertDatabaseMissing($this->table,[
            'id'=> $curso->id
        ]);

        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]); 
        
    }

    public function test_eliminar_por_id_not_found()
    {
        $id = 1;
        $response = $this->delete($this->apiUrl($id));

        $this->assertError($response);
    }

}
