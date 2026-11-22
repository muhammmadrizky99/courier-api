<?php

namespace Tests\Feature;

use App\Models\Courier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourierApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_lists_couriers_sorted_by_name_by_default(): void
    {
        Courier::factory()->create(['name' => 'Budiono Hadi Agung', 'level' => 3]);
        Courier::factory()->create(['name' => 'Amelia Putri', 'level' => 1]);

        $this->getJson('/api/couriers')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Amelia Putri')
            ->assertJsonCount(2, 'data');
    }

    public function test_it_searches_by_name_and_filters_levels(): void
    {
        Courier::factory()->create(['name' => 'Budiono Hadi Agung', 'level' => 2]);
        Courier::factory()->create(['name' => 'Budi Santoso', 'level' => 3]);
        Courier::factory()->create(['name' => 'Budi Wijaya', 'level' => 4]);

        $this->getJson('/api/couriers?search=budi+agung&level=2,3')
            ->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.name', 'Budiono Hadi Agung');
    }

    public function test_it_can_sort_by_registration_date(): void
    {
        Courier::factory()->create(['name' => 'Older', 'registered_at' => '2024-01-01']);
        Courier::factory()->create(['name' => 'Newer', 'registered_at' => '2025-01-01']);

        $this->getJson('/api/couriers?sort=registered_at&direction=desc')
            ->assertOk()
            ->assertJsonPath('data.0.name', 'Newer');
    }

    public function test_it_shows_a_courier(): void
    {
        $courier = Courier::factory()->create();

        $this->getJson("/api/couriers/{$courier->id}")
            ->assertOk()
            ->assertJsonPath('id', $courier->id)
            ->assertJsonPath('name', $courier->name);
    }

    public function test_it_stores_a_courier(): void
    {
        $payload = [
            'name' => 'Budi Agung',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'level' => 3,
            'vehicle_type' => 'Motorcycle',
            'is_active' => true,
        ];

        $this->postJson('/api/couriers', $payload)
            ->assertCreated()
            ->assertJsonPath('name', 'Budi Agung');

        $this->assertDatabaseHas('couriers', [
            'name' => 'Budi Agung',
            'email' => 'budi@example.com',
            'level' => 3,
        ]);
    }

    public function test_it_validates_courier_input(): void
    {
        $this->postJson('/api/couriers', [
            'name' => '',
            'email' => 'not-an-email',
            'level' => 6,
        ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name', 'email', 'level']);
    }

    public function test_it_updates_a_courier(): void
    {
        $courier = Courier::factory()->create(['level' => 1]);

        $this->putJson("/api/couriers/{$courier->id}", [
            'name' => 'Updated Courier',
            'level' => 5,
        ])
            ->assertOk()
            ->assertJsonPath('name', 'Updated Courier');

        $this->assertDatabaseHas('couriers', [
            'id' => $courier->id,
            'name' => 'Updated Courier',
            'level' => 5,
        ]);
    }

    public function test_it_deletes_a_courier(): void
    {
        $courier = Courier::factory()->create();

        $this->deleteJson("/api/couriers/{$courier->id}")
            ->assertNoContent();

        $this->assertDatabaseMissing('couriers', ['id' => $courier->id]);
    }
}
