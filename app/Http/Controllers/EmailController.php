<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactMessage;

class EmailController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user-name' => 'required|string',
            'user-email' => 'required|email',
            'user-subject' => 'required|string',
            'user-message' => 'required|string',
        ]);

        $data = [
            'user-name' => $validated['user-name'],
            'user-email' => $validated['user-email'],
            'user-subject' => $validated['user-subject'],
            'user-message' => $validated['user-message'],
        ];

        Mail::to("contact@braingentech.com")->send(new ContactMessage($data));

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès!');
    }
}
