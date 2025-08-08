<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage as MailContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index(){
        return view("index");
    }
    public function about(){
        return view("about");
    }
    public function service01(){
        return view("services.communication");
    }
    public function service02(){
        return view("services.immo");
    }
    public function service03(){
        return view("services.agroalimentaire");
    }
    public function contact(){
        return view("contact");
    }
    public function demarche(){
        return view("demarche");
    }
    public function awa(){
        return view("awa");
    }
    public function demo(){
        return view("demo");
    }
    public function industries(){
        return view("industries");
    }
    public function technology(){
        return view("technology");
    }
    public function resources(){
        return view("resources");
    }
    public function commercialDashboard(){
        return view("commercial-dashboard");
    }
    public function brainAssistant(){
        return view("solutions.brain-assistant");
    }
    public function brainRh(){
        return view("solutions.brain-rh");
    }
    public function brainInvest(){
        return view("solutions.brain-invest");
    }
    public function store(Request $request)
    {
        // Valider les données reçues
        $validated = $request->validate([
            'user-name' => 'required|string',
            'user-email' => 'required|email',
            'user-subject' => 'required|string',
            'user-message' => 'required|string',
        ]);

        // Préparer les données pour l'email
        $data = [
            'user-name' => $validated['user-name'],
            'user-email' => $validated['user-email'],
            'user-subject' => $validated['user-subject'],
            'user-message' => $validated['user-message'],
        ];
 
        // Envoyer l'email
        Mail::to("contact@braingentech.com")->send(new MailContactMessage($data));

        // Rediriger avec un message de succès
        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès!');
    }
}
