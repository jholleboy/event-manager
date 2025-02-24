<?php

namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_an_event()
    {
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum'); 

        $data = [
            "title" => "Evento Teste",
            "description" => "Descrição do evento de teste",
            "start_date" => "2025-05-01",
            "end_date" => "2025-05-02",
            "location" => "São Paulo",
            "capacity" => 50,
            "status" => "aberto"
        ];

        $response = $this->postJson('/api/events', $data);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'Evento criado com sucesso!',
                'event' => ['title' => "Evento Teste"]
            ]);

        $this->assertDatabaseHas('events', ['title' => "Evento Teste"]);
    }

    public function test_user_can_view_an_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->getJson("/api/events/{$event->id}");

        $response->assertStatus(200)
            ->assertJson([
                'event' => ['id' => $event->id]
            ]);
    }

    public function test_user_can_update_an_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $this->actingAs($user, 'sanctum');

        $updateData = ["title" => "Evento Atualizado"];

        $response = $this->putJson("/api/events/{$event->id}", $updateData);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Evento atualizado com sucesso!',
                'event' => ['title' => "Evento Atualizado"]
            ]);

        $this->assertDatabaseHas('events', ['title' => "Evento Atualizado"]);
    }

    public function test_user_can_delete_an_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->deleteJson("/api/events/{$event->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}
