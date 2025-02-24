<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    protected bool $includeUsers; 

    public function __construct($resource, $includeUsers = false)
    {
        parent::__construct($resource);
        $this->includeUsers = $includeUsers;
    }

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'location' => $this->location,
            'capacity' => $this->capacity,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'registrations_count' => $this->registrations->count(),

            'registrations' => $this->when($this->includeUsers, fn () => $this->registrations->map(fn ($registration) => [
                'id' => $registration->id,
                'user_id' => $registration->user->id,
                'user_name' => $registration->user->name,
                'user_email' => $registration->user->email,
                'registered_at' => $registration->created_at->format('Y-m-d H:i:s'),
            ])),
        ];
    }
}
