<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Alumno;

/**
 * PRUEBAS REALIZADAS A LA API
 */
class AlumnoTest extends TestCase
{
    use RefreshDatabase;

    public function testListado()
    {
        $nombre = 'Juan';
        $alumno = factory(Alumno::class)->create([
            'nombre' => $nombre,
        ]);

        $response = $this->get("/alumnos");

        $response->assertStatus(200)
        ->assertSee($alumno->nombre);
        $this->assertSeeKeysEsperados($response);
    }

    public function testShowById()
    {
        $nombre = 'Juan';
        $alumno = factory(Alumno::class)->create([
            'nombre' => $nombre,
        ]);

        $response = $this->get("/alumnos/{$alumno->id}");
        $response->assertStatus(200)
        ->assertSee($alumno->nombre);

        $this->assertSeeKeysEsperados($response);
    }

    public function testShowByIdNotFound()
    {
        $id = 5;
        $response = $this->get("/alumnos/{$id}");
        $response->assertStatus(404)
        ->assertSee('ok')
        ->assertSee('false');
    }

    public function testStore()
    {
        $nombre = 'Juan';
        $alumno = factory(Alumno::class)->make([
            'nombre' => $nombre,
        ]);
        
        $request = [
            'nombre' => $alumno->nombre,
            'apellido' => $alumno->apellido,
            'grupo_id' => $alumno->grupo_id,
            'gmail'=> $alumno->gmail,
            'cui'=> $alumno->cui,
        ];

        $response = $this->post("/alumnos", $request);

        $this->assertDatabaseHas('alumnos',[
            'nombre'=> $alumno->nombre,
        ]);

        $response->assertStatus(201);
        $this->assertSeeKeysEsperados($response);
    }

    public function testStoreCuiNoValidate()
    {
        $cui = '2015093';
        $alumno = factory(Alumno::class)->make([
            'cui' => $cui,
        ]);
        
        $request = [
            'nombre'=>$alumno->nombre,
            'apellido' => $alumno->apellido,
            'grupo_id' => $alumno->grupo_id,
            'gmail'=> $alumno->gmail,
            'cui'=> $cui,
        ];

        $response = $this->post("/alumnos", $request);

        $this->assertDatabaseMissing('alumnos',[
            'cui'=> $alumno->cui,
        ]);

        $response->assertStatus(404)
        ->assertSee('ok')
        ->assertSee('false')
        ->assertSee('cui')
        ->assertSee('Validation Error');
    }

    public function testUpdateAlumno()
    {
        $nuevoNombre = 'Juan Marcos';
        $alumno = factory(Alumno::class)->create();

        $request = [
            'nombre' => $nuevoNombre,
            'autorizacion'=>true,
            'matriculado'=>true
        ];

        $response = $this->put("/alumnos/{$alumno->id}", $request);

        $this->assertDatabaseHas('alumnos',[
            'nombre'=> $nuevoNombre,
            'autorizacion'=> true,
            'matriculado'=> true
        ]);

        $response->assertStatus(200)
                 ->assertSee($nuevoNombre);
        $this->assertSeeKeysEsperados($response);
    }


    public function testUpdateEmailRequired()
    {
        $alumno = factory(Alumno::class)->create();
        $gmail = '';

        $request = [
            'gmail'=> $gmail
        ];
        $response = $this->put("/alumnos/{$alumno->id}", $request);

        $this->assertDatabaseHas('alumnos',[
            'gmail'=> $alumno->gmail,
        ]);
        $response->assertStatus(404)
                    ->assertSee('ok')
                    ->assertSee('false')         
                    ->assertSee('gmail')
                    ->assertSee('Validation Error');
    }

    public function testDestroyAlumno()
    {
        $nombre = 'Jose';
        $alumno = factory(Alumno::class)->create([
            'nombre' => $nombre
        ]);

        $response = $this->delete("/alumnos/{$alumno->id}");

        $this->assertDatabaseMissing('alumnos',[
            'nombre'=> $nombre
        ]);

        $response->assertStatus(200)
        ->assertSee($nombre);
        $this->assertSeeKeysEsperados($response);
    }

    public function testDestroyAlumnoNotFound()
    {
        $id = 5;
        $response = $this->delete("/alumnos/{$id}");

        $response->assertStatus(404)
        ->assertSee('ok')
        ->assertSee('false');
        
    }

    private function assertSeeKeysEsperados($response) {
        $response->assertSee('id')
        ->assertSee('nombre')
        ->assertSee('apellido')
        ->assertSee('cui')
        ->assertSee('gmail')
        ->assertSee('autorizacion')
        ->assertSee('matriculado');
    }
    


}
