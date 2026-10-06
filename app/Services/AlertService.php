<?php

namespace App\Services;

use App\Mail\PriceAlertTriggered;
use App\Models\PriceAlert;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AlertService 
{
    public function checkAlerts(): int
    {
        $triggeredCount = 0;

        $alerts = PriceAlert::query()->with(['asset', 'user'])
        ->where('is_triggered', false)
        ->get();

        foreach ($alerts as $alert) {
            if (!$this->shouldTrigger($alert)) {
                continue;
            }

            $this->trigger($alert);

            $triggeredCount++;
        }

        return $triggeredCount;
    }

    private function shouldTrigger(PriceAlert $alert): bool
    {
        $currentPrice = (float) $alert->asset->current_price;
        $targetPrice = (float) $alert->target_price;

        return match ($alert->condition) {
            'above' => $currentPrice >= $targetPrice,
            'below' => $currentPrice <= $targetPrice,
            default => false,
        };
    }

    private function trigger(PriceAlert $alert): void
    {
        $alert->update([
            'is_triggered' => true,
            'triggered_at' => now(),
        ]);

        try {
            Mail::to($alert->user->email)
            ->send(new PriceAlertTriggered($alert));
        } catch (\Throwable $exception) {
            Log::error('Falha ao enviar alerta por e-mail.', [
                'alert_id' => $alert->id,
                'user_id' => $alert->user_id,
                'error' => $exception->getMessage(),
            ]);
        }
    }
}

