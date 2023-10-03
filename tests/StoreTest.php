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
        
        $userData = [
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
            'password' => 'password123',
        ];

        
        $response = $this->json('POST', '/api/users', $userData);

        
        $response->assertStatus(201);

        $response->assertJson(['message' => 'Usuario creado exitosamente']);

        $this->assertDatabaseHas('users', [
            'name' => 'John',
            'lastname' => 'Doe',
            'email' => 'johndoe@example.com',
        ]);

        $this->assertTrue(Hash::check('password123', User::first()->password));
    }
}
