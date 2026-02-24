<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Quote;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class QuoteController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'provider_id' => ['required', 'integer', 'exists:providers,id'],
            'service_id'  => ['nullable', 'integer', 'exists:services,id'],
            'title'       => ['required', 'string', 'max:200'],
            'description' => ['required', 'string', 'max:2000'],
            'budget_min'  => ['nullable', 'numeric', 'min:0'],
            'budget_max'  => ['nullable', 'numeric', 'min:0'],
        ]);

        Quote::create([
            'user_id'     => auth()->id(),
            'provider_id' => $request->provider_id,
            'service_id'  => $request->service_id ?: null,
            'title'       => $request->title,
            'description' => $request->description,
            'budget_min'  => $request->budget_min,
            'budget_max'  => $request->budget_max,
            'currency'    => 'EUR',
            'status'      => Quote::STATUS_PENDING,
        ]);

        $provider = Provider::findOrFail($request->provider_id);

        return redirect()
            ->route('servicos.show', $provider->slug)
            ->with('success', 'O seu pedido de orçamento foi enviado! O prestador irá responder em breve.');
    }
}
