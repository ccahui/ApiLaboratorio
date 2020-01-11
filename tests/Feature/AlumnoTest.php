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

    public function testListadoAlumnos()
    {
        $nombre = 'Juan';
        $alumno = factory(Alumno::class)->create([
            'nombre' => $nombre,
        ]);

        $response = $this->get("/alumnos");
        $response->assertStatus(200)
        ->assertSee($alumno->nombre)
        ->assertSee('id')
        ->assertSee('nombre')
        ->assertSee('apellido')
        ->assertSee('cui')
        ->assertSee('autorizacion');
    }

    public function testShowAlumnoById()
    {
        $nombre = 'Juan';
        $alumno = factory(Alumno::class)->create([
            'nombre' => $nombre,
        ]);

        $response = $this->get("/alumnos/{$alumno->id}");
        $response->assertStatus(200)
        ->assertSee($alumno->nombre)
        ->assertSee('id')
        ->assertSee('nombre')
        ->assertSee('apellido')
        ->assertSee('cui')
        ->assertSee('autorizacion');
    }

    public function testStoreAlumno()
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

        $response->assertStatus(201)
        ->assertSee($alumno->nombre)
        ->assertSee('id')
        ->assertSee('nombre')
        ->assertSee('apellido')
        ->assertSee('cui')
        ->assertSee('autorizacion');
    }

    public function testUpdateAlumno()
    {
        $nuevoNombre = 'Juan Marcos';
        $alumno = factory(Alumno::class)->create();

        $request = [
            'nombre' => $nuevoNombre,
            'apellido' => $alumno->apellido,
            'grupo_id' => $alumno->grupo_id,
            'gmail'=> $alumno->gmail,
            'cui'=> $alumno->cui,
        ];

        $response = $this->put("/alumnos/{$alumno->id}", $request);

        $this->assertDatabaseHas('alumnos',[
            'nombre'=> $nuevoNombre,
        ]);

        $response->assertStatus(200)
        ->assertSee($nuevoNombre)
        ->assertSee('id')
        ->assertSee('nombre')
        ->assertSee('apellido')
        ->assertSee('cui')
        ->assertSee('autorizacion');
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
        ->assertSee($nombre)
        ->assertSee('id')
        ->assertSee('nombre')
        ->assertSee('apellido')
        ->assertSee('cui')
        ->assertSee('autorizacion');
    }

    


}
