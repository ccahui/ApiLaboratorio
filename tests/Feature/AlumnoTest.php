<?php

namespace Tests\Feature;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Alumno;
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
        ->assertSee($alumno->nombre);
    }
}
