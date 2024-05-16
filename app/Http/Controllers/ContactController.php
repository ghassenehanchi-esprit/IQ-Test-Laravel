<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Quizz;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('contact.contact');
    }
    public function store(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'fullname' => 'required|string',
            'email' => 'required|email',
            'phone' => 'nullable|string',
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        // Create a new contact record
        Contact::create($validatedData);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Thank you for contacting us!');
    }

}
