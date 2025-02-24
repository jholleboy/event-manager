<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'location',
        'capacity',
        'status'
    ];

    //------------------------------------------------------------------
    // Relationships
    //------------------------------------------------------------------
    public function registrations(): HasMany
    {
        return $this->hasMany(Registration::class);
    }

    //------------------------------------------------------------------
    //  Scopes
    //------------------------------------------------------------------
    public function scopeAbertos($query): mixed
    {
        return $query->where('status', 'aberto');
    }

    //------------------------------------------------------------------
    // Accessors
    //------------------------------------------------------------------
    public function getCapacityRestantyAttribute(): int
    {
        return $this->capacity - $this->registrations()->count();
    }

    public function getFormattedStartDateAttribute(): string
    {
        return Carbon::parse($this->start_date)->format('d/m/Y H:i');
    }

    public function getFormattedEndDateAttribute(): string
    {
        return Carbon::parse($this->end_date)->format('d/m/Y H:i');
    }

    //------------------------------------------------------------------
    // Methods
    //------------------------------------------------------------------
    public function isUserRegistered(): bool
    {
        if (!Auth::check()) {
            return false; 
        }

        return $this->registrations()->where('user_id', Auth::id())->exists();
    }
}
