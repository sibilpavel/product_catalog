<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_product(): void
    {
        $user = User::factory()->create();

        $category = Category::factory()->create();

        $token = $user->createToken('test-token')->plainTextToken;

        $payload = [
            'name' => 'Test Product',
            'description' => 'Test Description',
            'price' => 199.99,
            'category_id' => $category->id,
        ];

        $response = $this
            ->withHeader('Authorization', "Bearer {$token}")
            ->postJson('/api/products', $payload);

        $response->assertStatus(201);

        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'price' => 199.99,
        ]);
    }

    public function test_guest_cannot_create_product(): void
    {
        $category = Category::factory()->create();

        $payload = [
            'name' => 'Test Product',
            'price' => 100,
            'category_id' => $category->id,
        ];

        $response = $this->postJson('/api/products', $payload);

        $response->assertStatus(401);
    }
}
