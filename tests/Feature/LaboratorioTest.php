<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Laboratorio;

/**
 * PRUEBAS REALIZADAS A LA API
 */
class LaboratorioTest extends BaseTest
{
    
    public $keys = ['id','cupos','grupo'];
    public $table = 'laboratorios';
    public $url = '/laboratorios';

    /*TODO */
    public function test_obtener_listado()
    {
        $laboratorios = factory(Laboratorio::class, 1)->create(); 
        $keys = $this->keys;

        $data = $laboratorios->map( function ($laboratorio) use ($keys){
            $laboratorio = $laboratorio->refresh()->only($keys);
            return  $laboratorio;   
        })->toArray();  

        $response = $this->get($this->apiUrl());
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);
    }

    public function test_obtener_por_id()
    {
        $laboratorio = factory(Laboratorio::class)->create()->refresh();
        $data = $laboratorio->only($this->keys);   
        
        $response = $this->get($this->apiUrl($laboratorio->id));
       
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
        $laboratorio = factory(Laboratorio::class)->make();   
        $request = [
            'curso_id' => $laboratorio->curso_id,
            'grupo' => $laboratorio->grupo,
            'cupos'=>$laboratorio->cupos,
        ];

        $response = $this->post($this->apiUrl(), $request);

        /**TODO */
        $this->assertDatabaseHas($this->table, ['curso_id'=> $laboratorio->curso_id]);
        $this->assertSuccess($response, 201);
        
    }

    public function test_curso_required_validacion_para_crear()
    {
        
        $laboratorio = factory(Laboratorio::class)->make(['curso_id' => '']);
        
        $request = [
            'curso_id' => $laboratorio->curso_id,
            'grupo' => $laboratorio->grupo,
            'cupos'=>$laboratorio->cupos,
        ];

        $response = $this->post($this->apiUrl(), $request);

        $this->assertError($response, 400);
        $response->assertJson([ 'message'=>'Validation Error.']);
        $response->assertSee('The curso id field is required.');
    }

    public function test_actualizar_grupo()
    {
        $nuevoGrupo = 'A';
        $laboratorio = factory(Laboratorio::class)->create();

        $request = ['grupo' => $nuevoGrupo];

        $response = $this->put($this->apiUrl($laboratorio->id), $request);

        $this->assertDatabaseHas($this->table, ['grupo'=> $nuevoGrupo]);

        $data = Laboratorio::find($laboratorio->id)->only($this->keys);
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);                
    }

    public function test_actualizar_id_not_found()
    {
        $id = 1;
        $nuevoGrupo = 'A';

        $request = ['grupo' => $nuevoGrupo];

        $response = $this->put($this->apiUrl($id), $request);

        $this->assertError($response);                
    }

    public function test_grupo_required_validacion_para_actualizar()
    {
        $laboratorio = factory(Laboratorio::class)->create();
        $request = ['grupo'=> ''];

        $response = $this->put($this->apiUrl($laboratorio->id), $request);
        
        $this->assertError($response, 400);
        $response->assertJson(['message' => 'Validation Error.']);
        $response->assertSee('The grupo field is required.');

    }

    public function test_eliminar_por_id()
    {
        $laboratorio = factory(Laboratorio::class)->create();
        $data = $laboratorio->refresh()->only($this->keys);

        $response = $this->delete($this->apiUrl($laboratorio->id));
        $this->assertDatabaseMissing($this->table,[
            'id'=> $laboratorio->id
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
