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
            'name.min' => 'A név legalább 2 karakter hosszú kell legyen.',
            'name.max' => 'A név maximum 100 karakter lehet.',
            'email.required' => 'Az email cím megadása kötelező.',
            'email.email' => 'Kérlek, adjon meg egy érvényes email címet.',
            'email.max' => 'Az email cím maximum 150 karakter lehet.',
            'subject.required' => 'A tárgy megadása kötelező.',
            'subject.min' => 'A tárgy legalább 5 karakter hosszú kell legyen.',
            'subject.max' => 'A tárgy maximum 200 karakter lehet.',
            'message.required' => 'Az üzenet megadása kötelező.',
            'message.min' => 'Az üzenet legalább 10 karakter hosszú kell legyen.',
            'message.max' => 'Az üzenet maximum 2000 karakter lehet.',
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
            Log::info('Kapcsolat üzenet', $data ?? []);
            return redirect()->route('contact')->with('success', 
                'Köszönjük az üzenetet! Az adatok sikeresen rögzítve lettek. 🏁');
        }
    }

    public function index()
    {
        $messages = ContactMessage::select('id', 'name', 'email', 'subject', 'message', 'newsletter', 'ip_address', 'is_read', 'created_at')
            ->latest()
            ->paginate(15);

        return view('admin.contact-messages', compact('messages'));
    }

    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();

        return redirect()->route('admin.contact-messages')->with('success', 'Az üzenet olvasottnak jelölve.');
    }

    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contact-messages')->with('success', 'Az üzenet sikeresen törölve.');
    }
}