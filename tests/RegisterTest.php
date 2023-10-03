<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testCrearUsuarioExitoso()
    {
        // Datos de usuario de ejemplo
        $userData = [
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        // Envía una solicitud POST para crear un usuario
        $response = $this->json('POST', '/api/users', $userData);

        // Verifica que la respuesta tenga el código de estado 201 (creado)
        $response->assertStatus(201);

        // Verifica que la respuesta contiene el mensaje "Usuario creado exitosamente"
        $response->assertJson(['message' => 'Usuario creado exitosamente']);

        // Verifica que el usuario se haya creado en la base de datos
        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
        ]);

        // Verifica que la contraseña se haya almacenado con hash
        $this->assertTrue(Hash::check('password123', User::first()->password));
    }
}
