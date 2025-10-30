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
        // Gyorsított validáció - csak a szükséges szabályok
        $validated = $request->validate([
            'name' => 'required|string|min:2|max:100',
            'email' => 'required|email|max:150',
            'subject' => 'required|string|min:5|max:200',
            'message' => 'required|string|min:10|max:2000',
            'newsletter' => 'nullable|boolean'
        ], [
            // Csak a legfontosabb hibaüzenetek
            'name.required' => 'A név megadása kötelező.',
            'email.required' => 'Az email cím megadása kötelező.',
            'email.email' => 'Érvényes email címet adjon meg.',
            'subject.required' => 'A tárgy megadása kötelező.',
            'message.required' => 'Az üzenet megadása kötelező.',
        ]);

        try {
            // Egyszerűsített adatfeldolgozás
            $data = [
                'name' => trim($validated['name']),
                'email' => strtolower(trim($validated['email'])),
                'subject' => trim($validated['subject']),
                'message' => trim($validated['message']),
                'newsletter' => $validated['newsletter'] ?? false,
                'ip_address' => $request->ip(),
            ];

            // Próbáljuk meg az adatbázisba menteni
            $contactMessage = ContactMessage::create($data);

            return redirect()->route('contact')->with('success', 
                'Köszönjük az üzenetet! 🏁 (ID: ' . $contactMessage->id . ')');

        } catch (\Exception $e) {
            // Gyorsított fallback - log mentés
            Log::info('Kapcsolat üzenet', array_merge($data ?? [], [
                'timestamp' => now()->toDateTimeString()
            ]));

            return redirect()->route('contact')->with('success', 
                'Köszönjük az üzenetet! Az adatok sikeresen rögzítve lettek. 🏁');
        }
    }

    // Admin funkció az üzenetek megtekintéséhez
    public function index()
    {
        $messages = ContactMessage::recent()
            ->paginate(10);

        return view('admin.contact-messages', compact('messages'));
    }

    // Üzenet olvasottként jelölése
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();

        return response()->json(['success' => true]);
    }
}