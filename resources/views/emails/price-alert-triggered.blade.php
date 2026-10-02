<!DOCTYPE html> 
<html lang="pt-BR"> 
<head> 
    <meta charset="UTF-8"> 
 
    <title>Alerta de Cotação</title> 
</head> 
<body style="font-family: Arial, sans-serif;"> 
    <h2>Alerta de Cotação Atingido</h2> 
    <p> 
        Olá, {{ $alert->user->name }}! 
    </p> 
    <p> 
        O alerta configurado para o ativo 
        <strong>{{ $alert->asset->name }}</strong> 
        foi atingido. 
    </p> 
    <p> 
        <strong>Código:</strong> 
        {{ $alert->asset->code }} 
    </p> 
    <p> 
        <strong>Cotação atual:</strong> 
        R$ {{ number_format($alert->asset->current_price, 4, ',', '.') }} 
    </p> 
    <p> 
        <strong>Preço alvo:</strong> 
        R$ {{ number_format($alert->target_price, 4, ',', '.') }} 
    </p> 
    <p> 
        <strong>Condição:</strong> 
        {{ $alert->condition === 'above' 
            ? 'Maior ou igual ao preço alvo' 
            : 'Menor ou igual ao preço alvo' }} 
    </p> 
    <p> 
        <strong>Disparado em:</strong> 
        {{ $alert->triggered_at?->format('d/m/Y H:i:s') }} 
    </p> 
 
    <hr> 
    <p> 
        MarketWatch Analytics 
    </p> 
</body> 
</html>