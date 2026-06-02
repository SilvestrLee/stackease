<?php

namespace App\Filament\Resources\ConciergeRequests\Pages;

use App\Filament\Resources\ConciergeRequests\ConciergeRequestResource;
use App\Models\AuditLog;
use App\Models\Invoice;
use App\Models\InvoicePricingSnapshot;
use App\Services\InvoiceCalculator;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\DB;

class EditConciergeRequest extends EditRecord
{
    protected static string $resource = ConciergeRequestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generateInvoice')
                ->label('Generate Invoice')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->schema([
                    TextInput::make('base_usd_cost')
                        ->label('Base USD Cost')
                        ->numeric()
                        ->required()
                        ->minValue(0),

                    TextInput::make('fx_rate')
                        ->label('FX Rate')
                        ->numeric()
                        ->required()
                        ->minValue(0),

                    TextInput::make('fx_buffer_percent')
                        ->label('FX Buffer %')
                        ->numeric()
                        ->required()
                        ->default(10)
                        ->minValue(0),

                    TextInput::make('service_fee')
                        ->label('Service Fee')
                        ->numeric()
                        ->required()
                        ->default(0)
                        ->minValue(0),

                    TextInput::make('gateway_fee')
                        ->label('Gateway Fee')
                        ->numeric()
                        ->required()
                        ->default(0)
                        ->minValue(0),

                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3),
                ])
                ->action(function (array $data): void {
                    $existingInvoice = $this->record->invoices()
                        ->whereIn('status', [
                            'draft',
                            'sent',
                            'awaiting_payment',
                            'paid',
                        ])
                        ->latest()
                        ->first();

                    if ($existingInvoice) {
                        Notification::make()
                            ->title('Invoice already exists')
                            ->body(
                                'This concierge request already has an active invoice: ' .
                                $existingInvoice->invoice_reference
                            )
                            ->warning()
                            ->send();

                        return;
                    }

                    $calculator = app(InvoiceCalculator::class);

                    $calculation = $calculator->calculate(
                        baseUsdCost: (float) $data['base_usd_cost'],
                        fxRate: (float) $data['fx_rate'],
                        fxBufferPercent: (float) $data['fx_buffer_percent'],
                        serviceFee: (float) $data['service_fee'],
                        gatewayFee: (float) $data['gateway_fee'],
                    );

                    DB::transaction(function () use ($data, $calculation, $calculator): void {
                        $invoice = Invoice::create([
                            'user_id' => $this->record->user_id,
                            'concierge_request_id' => $this->record->id,
                            'invoice_reference' => $calculator->generateReference(),
                            'base_usd_cost' => $data['base_usd_cost'],
                            'fx_rate' => $data['fx_rate'],
                            'fx_buffer_percent' => $data['fx_buffer_percent'],
                            'fx_buffer_amount' => $calculation['fx_buffer_amount'],
                            'service_fee' => $data['service_fee'],
                            'gateway_fee' => $data['gateway_fee'],
                            'total_naira_amount' => $calculation['total_naira_amount'],
                            'currency' => 'NGN',
                            'status' => 'awaiting_payment',
                            'sent_at' => now(),
                            'expires_at' => now()->addHour(),
                            'notes' => $data['notes'] ?? null,
                        ]);

                        InvoicePricingSnapshot::create([
                            'invoice_id' => $invoice->id,
                            'provider_cost_amount' => $data['base_usd_cost'],
                            'provider_cost_currency' => 'USD',
                            'fx_rate' => $data['fx_rate'],
                            'local_provider_cost' => $calculation['local_cost'],
                            'fx_buffer_percent' => $data['fx_buffer_percent'],
                            'fx_buffer_amount' => $calculation['fx_buffer_amount'],
                            'service_fee' => $data['service_fee'],
                            'gateway_fee' => $data['gateway_fee'],
                            'final_total' => $calculation['total_naira_amount'],
                            'rate_source' => 'manual_admin_entry',
                            'valid_until' => $invoice->expires_at,
                            'metadata' => [
                                'concierge_request_id' => $this->record->id,
                                'request_reference' => $this->record->request_reference,
                            ],
                        ]);

                        $this->record->update([
                            'status' => 'awaiting_payment',
                            'reviewed_at' => $this->record->reviewed_at ?? now(),
                        ]);

                        AuditLog::create([
                            'actor_id' => auth()->id(),
                            'action' => 'generated_invoice_from_concierge_request',
                            'target_type' => Invoice::class,
                            'target_id' => $invoice->id,
                            'old_values' => null,
                            'new_values' => [
                                'invoice_id' => $invoice->id,
                                'invoice_reference' => $invoice->invoice_reference,
                                'concierge_request_id' => $this->record->id,
                                'total_naira_amount' => $invoice->total_naira_amount,
                                'expires_at' => $invoice->expires_at,
                            ],
                            'ip_address' => request()->ip(),
                            'user_agent' => request()->userAgent(),
                        ]);
                    });

                    Notification::make()
                        ->title('Invoice generated successfully')
                        ->success()
                        ->send();
                }),

            DeleteAction::make(),
        ];
    }
}