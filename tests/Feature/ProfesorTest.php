<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Profesor;

/**
 * PRUEBAS REALIZADAS A LA API
 */
class ProfesorTest extends BaseTest
{
    
    public $keys = ['nombre','apellido','gmail','descripcion'];
    public $table = 'profesores';
    public $url = '/profesores';

    /*TODO*/
    public function test_obtener_listado()
    {
        $profesores = factory(Profesor::class, 2)->create(); 
        $keys = $this->keys;

        $data = $profesores->map( function ($profesor) use ($keys){
                return $profesor->refresh()->only($keys);
             })->toArray();
        
        $response = $this->get($this->apiUrl());
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);
    }

    public function test_obtener_por_id()
    {
        $profesor = factory(Profesor::class)->create()->refresh();
        $data = $profesor->only($this->keys);       
        $response = $this->get($this->apiUrl($profesor->id));

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
        $profesor = factory(Profesor::class)->make();   
        $request = [
            'nombre' => $profesor->nombre,
            'apellido' => $profesor->apellido,
            'gmail'=> $profesor->gmail,
            'descripcion'=>$profesor->descripcion
        ];

        $response = $this->post($this->apiUrl(), $request);

        $this->assertDatabaseHas($this->table, ['gmail'=> $profesor->gmail]);
        
        $this->assertSuccess($response, 201);
        
    }

    public function test_gmail_required_validacion_para_crear()
    {
        
        $profesor = factory(Profesor::class)->make(['gmail' => '']);
        
        $request = [
            'nombre'=>$profesor->nombre,
            'apellido' => $profesor->apellido,
            'gmail'=> $profesor->gmail,
            'descripcion'=> $profesor->descripcion,
        ];

        $response = $this->post($this->apiUrl(), $request);

        $this->assertError($response);
        $response->assertJson([ 'message'=>'Validation Error.']);
        $response->assertSee('The gmail field is required.');
    }

    public function test_actualizar_nombre()
    {
        $nuevoNombre = 'Juan Marcos';
        $profesor = factory(Profesor::class)->create();

        $request = ['nombre' => $nuevoNombre];

        $response = $this->put($this->apiUrl($profesor->id), $request);

        $this->assertDatabaseHas($this->table, ['nombre'=> $nuevoNombre]);

        $data = Profesor::find($profesor->id)->only($this->keys);
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);                
    }

    public function test_gmail_required_validacion_para_actualizar()
    {
        $profesor = factory(Profesor::class)->create();
        $request = ['gmail'=> ''];

        $response = $this->put($this->apiUrl($profesor->id), $request);
        
        $this->assertError($response);
        $response->assertJson(['message' => 'Validation Error.']);
        $response->assertSee('The gmail field is required.');

    }

    public function test_eliminar_por_id()
    {
        $profesor = factory(Profesor::class)->create();
        $data = $profesor->refresh()->only($this->keys);

        $response = $this->delete($this->apiUrl($profesor->id));
        $this->assertDatabaseMissing($this->table,[
            'id'=> $profesor->id
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
    
    public function apiUrl($id = null){
        if($id === null){
            return $this->url;
        }
        else return "{$this->url}/{$id}";
    }
}
