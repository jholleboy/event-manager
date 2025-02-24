<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Registration;
use App\Models\User;
use App\Models\Event;

class RegistrationSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        $events = Event::all();

        foreach ($users as $user) {
            $randomEvents = $events->random(rand(1, 3));

            foreach ($randomEvents as $event) {
                if ($event->registrations()->count() < $event->capacity) {
                    Registration::create([
                        'user_id' => $user->id,
                        'event_id' => $event->id,
                    ]);
                }
            }
        }
    }
}
