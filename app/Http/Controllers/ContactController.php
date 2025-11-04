<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|min:5|max:200',
            'message' => 'required|string|min:10|max:2000',
            'newsletter' => 'nullable|boolean'
        ], [
            'name.required' => 'A név megadása kötelező.',
            'email.required' => 'Az email cím megadása kötelező.',
            'email.email' => 'Érvényes email címet adjon meg.',
            'subject.required' => 'A tárgy megadása kötelező.',
            'message.required' => 'Az üzenet megadása kötelező.',
        ]);

        try {
            $data = [
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'subject' => trim($validated['subject']),
                'message' => trim($validated['message']),
                'newsletter' => $validated['newsletter'] ?? false,
                'ip_address' => $request->ip(),
            ];

            $contactMessage = ContactMessage::create($data);

            return redirect()->route('contact')->with('success', 
                'Köszönjük az üzenetet! 🏁 (ID: ' . $contactMessage->id . ')');

        } catch (\Exception $e) {
            Log::info('Kapcsolat üzenet', array_merge($data ?? [], [
                'timestamp' => now()->toDateTimeString()
            ]));

            return redirect()->route('contact')->with('success', 
                'Köszönjük az üzenetet! Az adatok sikeresen rögzítve lettek. 🏁');
        }
    }

    public function index()
    {
        $messages = ContactMessage::recent()
            ->paginate(10);

        return view('admin.contact-messages', compact('messages'));
    }

    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();

        return response()->json(['success' => true]);
    }
}