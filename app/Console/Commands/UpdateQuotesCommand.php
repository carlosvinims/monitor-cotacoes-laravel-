<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use App\Services\QuoteService;
use App\Services\AlertService;
use Throwable;

class UpdateQuotesCommand extends Command
{
    /**
     * Execute the console command.
     */
    protected $signature = 'quotes:update';

    protected $description = 'Atualiza as cotações, grava o histórico e verifica os alertas';

    public function __construct(
        private QuoteService $quoteService,
        private AlertService $alertService,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->info('Iniciando atualizações das cotações...');

        try {
            $updatedAssets = $this->quoteService->updateQuotes();

            $this->info("{$updatedAssets} ativo(s) atualizado(s).");

            $triggeredAlerts = $this->alertService->checkAlerts();

            $this->info("{$triggeredAlerts} alertas(s) disparadao(s).");

            $this->info('Pocesso concluído com sucesso.');

            return self::SUCCESS;

        } catch (Throwable $exception) {

            $this->error('Não foi possível concluir a atualização.');

            $this->error($exception->getMessage());

            return self::FAILURE;
        }
    }
}
