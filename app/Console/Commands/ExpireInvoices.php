<?php

namespace App\Console\Commands;

use App\Models\AuditLog;
use App\Models\Invoice;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('stackease:expire-invoices')]
#[Description('Expire unpaid invoices after their expiry time has passed.')]
class ExpireInvoices extends Command
{
    public function handle(): int
    {
        $expiredInvoices = Invoice::query()
            ->where('status', 'awaiting_payment')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<', now())
            ->get();

        if ($expiredInvoices->isEmpty()) {
            $this->info('No expired invoices found.');

            return self::SUCCESS;
        }

        foreach ($expiredInvoices as $invoice) {
            $oldValues = [
                'status' => $invoice->status,
                'expires_at' => $invoice->expires_at,
            ];

            $invoice->update([
                'status' => 'expired',
            ]);

            AuditLog::create([
                'actor_id' => null,
                'action' => 'invoice_auto_expired',
                'target_type' => Invoice::class,
                'target_id' => $invoice->id,
                'old_values' => $oldValues,
                'new_values' => [
                    'status' => $invoice->status,
                    'invoice_reference' => $invoice->invoice_reference,
                    'expires_at' => $invoice->expires_at,
                ],
                'ip_address' => null,
                'user_agent' => 'system',
            ]);
        }

        $this->info($expiredInvoices->count() . ' invoice(s) expired.');

        return self::SUCCESS;
    }
}