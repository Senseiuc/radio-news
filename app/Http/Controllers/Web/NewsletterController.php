<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'email' => ['required','email','max:255'],
            'name' => ['nullable','string','max:255']
        ]);

        $existing = Newsletter::where('email', $data['email'])->first();
        if (!$existing) {
            Newsletter::create($data);
        }

        return back()->with('newsletter_status', 'Thanks for subscribing!');
    }
}
