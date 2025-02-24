<?php
namespace Tests\Feature\Api;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_for_an_event()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 2]);

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson("/api/events/{$event->id}/participants", ['user_id' => $user->id]);

        $response->assertStatus(201)
                 ->assertJson(['message' => 'Participante adicionado com sucesso!']);

        $this->assertDatabaseHas('registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);
    }

    public function test_user_cannot_register_if_event_is_full()
    {
        $event = Event::factory()->create(['capacity' => 1]); 
    
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
    
        $this->actingAs($user1, 'sanctum');
        $this->postJson("/api/events/{$event->id}/participants", ['user_id' => $user1->id]);
    
        $this->actingAs($user2, 'sanctum');
        $response = $this->postJson("/api/events/{$event->id}/participants", ['user_id' => $user2->id]);
         
        $response->assertStatus(403) 
                 ->assertJson(['error' => 'O evento atingiu sua capacidade máxima.']);
         $event->refresh();
        
        $this->assertDatabaseMissing('registrations', [
            'user_id' => $user2->id,
            'event_id' => $event->id
        ]);
    }

    public function test_user_cannot_register_twice()
    {
        $event = Event::factory()->create(['capacity' => 2]); 
    
        $user = User::factory()->create();
    
        $this->actingAs($user, 'sanctum');
        $this->postJson("/api/events/{$event->id}/participants", ['user_id' => $user->id]);
        
        $this->assertDatabaseHas('registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);

        $response = $this->postJson("/api/events/{$event->id}/participants", ['user_id' => $user->id]);
        
        $response->assertStatus(409) 
                 ->assertJson(['error' => 'Usuário já está inscrito neste evento.']);
    }

    public function test_user_can_cancel_registration()
    {
        $user = User::factory()->create();
        $event = Event::factory()->create(['capacity' => 5]);

        $this->actingAs($user, 'sanctum');

        $this->postJson("/api/events/{$event->id}/participants", ['user_id' => $user->id]);

        $response = $this->deleteJson("/api/events/{$event->id}/participants/{$user->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);
    }
}

