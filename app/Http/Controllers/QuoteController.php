<?php

namespace App\Http\Controllers;

use App\Mail\QuoteReceived;
use App\Models\Provider;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class QuoteController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'provider_id'  => ['required', 'integer', 'exists:providers,id'],
            'name'         => ['required', 'string', 'max:150'],
            'email'        => ['required', 'email', 'max:150'],
            'phone'        => ['nullable', 'string', 'max:30'],
            'description'  => ['required', 'string', 'max:2000'],
            'deadline'     => ['nullable', 'string', 'max:100'],
            'budget_range' => ['nullable', 'string', 'max:100'],
        ]);

        $provider = Provider::findOrFail($data['provider_id']);

        $quote = Quote::create([
            'provider_id'  => $provider->id,
            'name'         => $data['name'],
            'email'        => $data['email'],
            'phone'        => $data['phone'] ?? null,
            'description'  => $data['description'],
            'deadline'     => $data['deadline'] ?? null,
            'budget_range' => $data['budget_range'] ?? null,
            'status'       => Quote::STATUS_NEW,
        ]);

        $provider->increment('quotes_count');

        // Notify provider
        $providerEmail = optional($provider->user)->email;
        if ($providerEmail) {
            Mail::to($providerEmail)->send(new QuoteReceived($quote, $provider));
        }

        // Notify admin
        $adminEmail = config('app.admin_email');
        if ($adminEmail && $adminEmail !== $providerEmail) {
            Mail::to($adminEmail)->send(new QuoteReceived($quote, $provider));
        }

        return redirect()
            ->route('servicos.show', $provider->slug)
            ->with('success', 'O seu pedido de orçamento foi enviado! O prestador irá responder em breve.');
    }
}
