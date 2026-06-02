<?php

namespace App\Filament\Resources\Invoices\Pages;

use App\Filament\Resources\Invoices\InvoiceResource;
use App\Models\AuditLog;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('markPaid')
                ->label('Mark Paid')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status !== 'paid')
                ->action(function (): void {
                    $oldValues = [
                        'status' => $this->record->status,
                        'paid_at' => $this->record->paid_at,
                    ];

                    $this->record->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);

                    AuditLog::create([
                        'actor_id' => auth()->id(),
                        'action' => 'invoice_marked_paid',
                        'target_type' => $this->record::class,
                        'target_id' => $this->record->id,
                        'old_values' => $oldValues,
                        'new_values' => [
                            'status' => 'paid',
                            'paid_at' => $this->record->fresh()->paid_at,
                        ],
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);

                    Notification::make()
                        ->title('Invoice marked as paid')
                        ->success()
                        ->send();
                }),

            Action::make('cancelInvoice')
                ->label('Cancel Invoice')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn () => ! in_array($this->record->status, ['paid', 'cancelled', 'refunded']))
                ->action(function (): void {
                    $oldValues = [
                        'status' => $this->record->status,
                    ];

                    $this->record->update([
                        'status' => 'cancelled',
                    ]);

                    AuditLog::create([
                        'actor_id' => auth()->id(),
                        'action' => 'invoice_cancelled',
                        'target_type' => $this->record::class,
                        'target_id' => $this->record->id,
                        'old_values' => $oldValues,
                        'new_values' => [
                            'status' => 'cancelled',
                        ],
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);

                    Notification::make()
                        ->title('Invoice cancelled')
                        ->success()
                        ->send();
                }),

            Action::make('refundInvoice')
                ->label('Refund Invoice')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status === 'paid')
                ->action(function (): void {
                    $oldValues = [
                        'status' => $this->record->status,
                    ];

                    $this->record->update([
                        'status' => 'refunded',
                    ]);

                    AuditLog::create([
                        'actor_id' => auth()->id(),
                        'action' => 'invoice_refunded',
                        'target_type' => $this->record::class,
                        'target_id' => $this->record->id,
                        'old_values' => $oldValues,
                        'new_values' => [
                            'status' => 'refunded',
                        ],
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);

                    Notification::make()
                        ->title('Invoice marked as refunded')
                        ->success()
                        ->send();
                }),

            DeleteAction::make(),
        ];
    }
}