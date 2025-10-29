<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
            'newsletter' => 'nullable|boolean'
        ]);

        // Here you would typically save to database or send email
        // For now, we'll just return a success response
        
        return redirect()->route('contact')->with('success', 'Thank you for your message! We\'ll get back to you soon.');
    }
}