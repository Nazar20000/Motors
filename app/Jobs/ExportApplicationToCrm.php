<?php

namespace App\Jobs;

use App\Models\Application;
use App\Services\CrmLeadExporter;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ExportApplicationToCrm implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $applicationId;

    /** Number of attempts */
    public int $tries = 5;

    /** Backoff strategy (seconds) */
    public function backoff(): array
    {
        return [60, 300, 900]; // 1m, 5m, 15m
    }

    public function __construct(int $applicationId)
    {
        $this->applicationId = $applicationId;
    }

    public function handle(): void
    {
        $application = Application::find($this->applicationId);
        if (!$application) {
            Log::warning('ExportApplicationToCrm: application not found', ['application_id' => $this->applicationId]);
            return;
        }

        (new CrmLeadExporter())->export($application);
        Log::info('ExportApplicationToCrm: exported to CRM', ['application_id' => $this->applicationId]);
    }
}


