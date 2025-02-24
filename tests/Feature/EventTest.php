<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);
        $eventData = [
            'title' => 'Laravel Conference',
            'description' => 'Evento sobre Laravel',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'location' => 'São Paulo',
            'capacity' => 100,
            'status' => 'aberto',
        ];

        $response = $this->post(route('admin.events.store'), $eventData);
        $this->assertDatabaseHas('events', ['title' => 'Laravel Conference']);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_edit_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $event = Event::factory()->create([
            'title' => 'Laravel Conference',
            'description' => 'Evento original sobre Laravel',
            'start_date' => now()->addDays(5),
            'end_date' => now()->addDays(6),
            'location' => 'São Paulo',
            'capacity' => 100,
            'status' => 'aberto',
        ]);

        $updatedData = [
            'title' => 'Laravel Summit 2025',
            'capacity' => 150,
        ];

        $response = $this->put(route('admin.events.update', $event), $updatedData);

        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Laravel Summit 2025',
            'capacity' => 150,
            'description' => 'Evento original sobre Laravel',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
    }

    public function test_admin_can_view_events_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        Event::factory()->count(3)->create();

        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(200)
            ->assertViewIs('admin.dashboard')
            ->assertViewHas('events');

        $this->assertEquals(3, $response->viewData('events')->count());
    }

    public function test_admin_can_view_event_details()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $event = Event::factory()->create();

        $response = $this->get(route('admin.events.show', $event->id));

        $response->assertStatus(200)
            ->assertViewIs('admin.events.show')
            ->assertViewHas('event', $event);
    }

    public function test_admin_can_delete_event()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $event = Event::factory()->create();

        $this->assertDatabaseHas('events', ['id' => $event->id]);

        $response = $this->delete(route('admin.events.destroy', $event->id));

        $this->assertDatabaseMissing('events', ['id' => $event->id]);

        $response->assertRedirect(route('admin.dashboard'))
            ->assertSessionHas('success', 'Evento excluído com sucesso!');
    }
}
