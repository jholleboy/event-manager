<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class NotificationComponent extends Component
{
    public $modalOpen = false; 

    protected $listeners = ['notifyRefresh' => 'refreshNotifications'];

    public function refreshNotifications()
    {
        $this->modalOpen = true; 
    }

    public function markAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->dispatch('notifyRefresh'); // Atualiza o modal
    }

    public function render()
    {
        return view('livewire.notification-component', [
            'notifications' => Auth::user()->unreadNotifications,
        ]);
    }
}
