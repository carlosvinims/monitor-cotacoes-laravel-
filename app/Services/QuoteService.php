<?php
namespace App\Services;

use App\Models\Asset;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class QuoteService
{
    public function updateQuotes(): int
    {
        $url = config('services.quotes.url');


        $response =  Http::withOptions([
            'verify' => false,
        ])
        
             ->timeout(15)
             ->retry(3, 500)
             ->get($url);

        if (!$response->successful()) {
            Log::warning('A API de cotação retornou erro.', [
                'status' => $response->status(),
            ]);

            throw new RuntimeException(
                'Não foi possível consultar a API de cotações.'
            );
        }

        $data = $response->json();

        if (!is_array($data)) {
            throw new RuntimeException(
                'A API retornou dados em formato inválido.'
            );
        }

        $updated = 0;

        foreach ($data as $quote) {
            if (!isset(
                $quote['code'],
                $quote['bid'],
                $quote['high'],
                $quote['low'],
                $quote['pctChange']
            )) {
                Log::warning(
                    'Registro de cotação ignorado por dados incompletos.'
                );
                continue;
            }
            $asset = Asset::where(
                'code',
                $quote['code']
            )->first();

            if (!$asset) {
                Log::warning(
                    'Ativo recebido pela API não está cadastrado.',
                    [
                        'code' => $quote['code'],
                    ]
                );
                continue;
            }
            $asset->update([
                'current_price' => $quote['bid'],
                'high_price' => $quote['high'],
                'low_price' => $quote['low'],
                'variation_24h' => $quote['pctChange'],
            ]);
            $asset->priceHistories()->create([
                'price' => $quote['bid'],
                'high_price' => $quote['high'],
                'low_price'  => $quote['low'],
                'fetched_at' => now(),
            ]);
            $updated++;
        }
        return $updated;
    }
}