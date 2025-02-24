<?php

namespace App\Http\Controllers;

use App\Services\RegistrationService;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    protected RegistrationService $registrationService;

    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    public function store($eventId)
    {
        $message = $this->registrationService->registerUserToEvent($eventId);

        return redirect()->back()->with(
            str_contains($message, 'sucesso') ? 'success' : 'error',
            $message
        );
    }

    public function destroy($eventId)
    {
        $message = $this->registrationService->cancelUserRegistration($eventId);

        return redirect()->back()->with(
            str_contains($message, 'sucesso') ? 'success' : 'error',
            $message
        );
    }
}
