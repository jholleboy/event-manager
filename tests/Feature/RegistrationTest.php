<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_register_for_an_event()
    {
        $user = User::factory()->create(['role' => 'user']);
        $event = Event::factory()->create(['capacity' => 2]);

        $this->actingAs($user);

        $response = $this->post(route('event.subscribe', $event->id));

        $this->assertDatabaseHas('registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);

        $response->assertRedirect('/');
    }

    public function test_user_cannot_register_if_event_is_full()
    {
        $event = Event::factory()->create([
            'title' => 'Laravel Conference',
            'capacity' => 1,
        ]);

        $user1 = User::factory()->create(['role' => 'user']);
        Registration::create(['user_id' => $user1->id, 'event_id' => $event->id]);

        $user2 = User::factory()->create(['role' => 'user']);
        $this->actingAs($user2);

        $response = $this->post(route('event.subscribe', $event->id));
        $event->refresh();

        $this->assertDatabaseMissing('registrations', [
            'user_id' => $user2->id,
            'event_id' => $event->id
        ]);

        $response->assertRedirect('/')->assertSessionHas('error', 'Este evento já atingiu a capacidade máxima.');
    }

    public function test_user_cannot_register_twice()
    {
        $event = Event::factory()->create(['capacity' => 5]);

        $user = User::factory()->create(['role' => 'user']);
        Registration::create(['user_id' => $user->id, 'event_id' => $event->id]);

        $this->assertDatabaseHas('registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);

        $this->actingAs($user);

        $response = $this->post(route('event.subscribe', $event->id));

        $response->assertStatus(302);

        $this->assertTrue(
            in_array($response->headers->get('Location'), [
                route('admin.events.show', $event->id),
                url('/')
            ]),
            "O redirecionamento esperado não foi encontrado. Retornado: {$response->headers->get('Location')}"
        );

        $response->assertSessionHas('error', 'Você já está inscrito neste evento.');

        $this->assertEquals(1, Registration::where('user_id', $user->id)->where('event_id', $event->id)->count());
    }

    public function test_user_can_cancel_registration()
    {
        $event = Event::factory()->create(['capacity' => 2]);
        $user = User::factory()->create(['role' => 'user']);

        Registration::create(['user_id' => $user->id, 'event_id' => $event->id]);

        $this->assertDatabaseHas('registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);

        $this->actingAs($user);
        $response = $this->delete(route('event.unsubscribe', $event->id));

        $this->assertDatabaseMissing('registrations', [
            'user_id' => $user->id,
            'event_id' => $event->id
        ]);

        $response->assertRedirect('/')->assertSessionHas('success', 'Inscrição cancelada com sucesso.');
    }
}
