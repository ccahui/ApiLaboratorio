<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Alumno;

/**
 * PRUEBAS REALIZADAS A LA API
 */
class AlumnoTest extends BaseTest
{
    
    public $keys = ['nombre','apellido','gmail','autorizacion','matriculado','cui'];
    public $table = 'alumnos';
    public $url = '/alumnos';

    /*TODO*/
    public function test_obtener_listado()
    {
        $alumnos = factory(Alumno::class, 2)->create(); 
        $keys = $this->keys;

        $data = $alumnos->map( function ($alumno) use ($keys){
                return $alumno->refresh()->only($keys);
             })->toArray();
        
        $response = $this->get($this->apiUrl());
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);
    }

    public function test_obtener_por_id()
    {
        $alumno = factory(Alumno::class)->create()->refresh();
        $data = $alumno->only($this->keys);   
        
        $response = $this->get($this->apiUrl($alumno->id));
       
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
        $alumno = factory(Alumno::class)->make();   
        $request = [
            'nombre' => $alumno->nombre,
            'apellido' => $alumno->apellido,
            'grupo_id' => $alumno->grupo_id,
            'gmail'=> $alumno->gmail,
            'cui'=> $alumno->cui,
        ];

        $response = $this->post($this->apiUrl(), $request);

        $this->assertDatabaseHas($this->table, ['gmail'=> $alumno->gmail]);
        
        $this->assertSuccess($response, 201);
        
    }

    public function test_gmail_required_validacion_para_crear()
    {
        
        $alumno = factory(Alumno::class)->make(['gmail' => '']);
        
        $request = [
            'nombre'=>$alumno->nombre,
            'apellido' => $alumno->apellido,
            'grupo_id' => $alumno->grupo_id,
            'gmail'=> $alumno->gmail,
            'cui'=> $alumno->cui,
        ];

        $response = $this->post($this->apiUrl(), $request);

        $this->assertError($response);
        $response->assertJson([ 'message'=>'Validation Error.']);
        $response->assertSee('The gmail field is required.');
    }

    public function test_actualizar_nombre()
    {
        $nuevoNombre = 'Juan Marcos';
        $alumno = factory(Alumno::class)->create();

        $request = ['nombre' => $nuevoNombre];

        $response = $this->put($this->apiUrl($alumno->id), $request);

        $this->assertDatabaseHas($this->table, ['nombre'=> $nuevoNombre]);

        $data = Alumno::find($alumno->id)->only($this->keys);
        
        $this->assertSuccess($response);
        $response->assertJson(['data' => $data]);                
    }

    public function test_gmail_required_validacion_para_actualizar()
    {
        $alumno = factory(Alumno::class)->create();
        $request = ['gmail'=> ''];

        $response = $this->put($this->apiUrl($alumno->id), $request);
        
        $this->assertError($response);
        $response->assertJson(['message' => 'Validation Error.']);
        $response->assertSee('The gmail field is required.');

    }

    public function test_eliminar_por_id()
    {
        $alumno = factory(Alumno::class)->create();
        $data = $alumno->refresh()->only($this->keys);

        $response = $this->delete($this->apiUrl($alumno->id));
        $this->assertDatabaseMissing($this->table,[
            'id'=> $alumno->id
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
