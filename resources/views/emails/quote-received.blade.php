<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo pedido de orçamento</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #f9fafb; margin: 0; padding: 0; color: #374151; }
        .wrapper { max-width: 580px; margin: 40px auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
        .header { background: linear-gradient(135deg, #4f46e5, #6366f1); padding: 32px 40px; text-align: center; }
        .header h1 { color: #ffffff; margin: 0; font-size: 20px; font-weight: 700; }
        .header p  { color: #c7d2fe; margin: 6px 0 0; font-size: 14px; }
        .body { padding: 32px 40px; }
        .label { font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: .05em; color: #9ca3af; margin-bottom: 2px; }
        .value { font-size: 15px; color: #111827; margin-bottom: 20px; }
        .value a { color: #4f46e5; text-decoration: none; }
        .badge { display: inline-block; background: #eef2ff; color: #4338ca; font-size: 12px; font-weight: 600; padding: 3px 10px; border-radius: 99px; }
        .divider { border: none; border-top: 1px solid #f3f4f6; margin: 24px 0; }
        .footer { background: #f9fafb; padding: 20px 40px; text-align: center; font-size: 12px; color: #9ca3af; }
        .btn { display: inline-block; background: #4f46e5; color: #fff !important; text-decoration: none; padding: 12px 28px; border-radius: 8px; font-weight: 600; font-size: 14px; margin-top: 8px; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>Novo pedido de orçamento</h1>
        <p>Para {{ $provider->business_name }}</p>
    </div>
    <div class="body">

        <p class="label">De</p>
        <p class="value">
            @if($quote->user)
                {{ $quote->user->name }}
                @if($quote->user->email)
                    &lt;<a href="mailto:{{ $quote->user->email }}">{{ $quote->user->email }}</a>&gt;
                @endif
            @else
                {{ $quote->guest_name }}
                @if($quote->guest_email)
                    &lt;<a href="mailto:{{ $quote->guest_email }}">{{ $quote->guest_email }}</a>&gt;
                @endif
                @if($quote->guest_phone)
                    &nbsp;·&nbsp; {{ $quote->guest_phone }}
                @endif
            @endif
        </p>

        <p class="label">Assunto / Serviço</p>
        <p class="value">{{ $quote->title }}</p>

        <p class="label">Descrição</p>
        <p class="value" style="white-space: pre-wrap;">{{ $quote->description }}</p>

        @if($quote->deadline)
            <p class="label">Prazo</p>
            <p class="value">{{ $quote->deadline }}</p>
        @endif

        @if($quote->budget_max)
            <p class="label">Orçamento estimado</p>
            <p class="value">€ {{ number_format($quote->budget_max, 0, ',', '.') }}</p>
        @endif

        <hr class="divider">

        <p style="text-align:center;">
            <a href="{{ route('prestador.orcamentos') }}" class="btn">Ver orçamentos</a>
        </p>
    </div>
    <div class="footer">
        Navego · Plataforma de serviços para imigrantes em Portugal<br>
        Este email foi gerado automaticamente. Por favor não responda a este endereço.
    </div>
</div>
</body>
</html>
