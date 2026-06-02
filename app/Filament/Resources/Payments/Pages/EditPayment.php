<?php

namespace App\Filament\Resources\Payments\Pages;

use App\Filament\Resources\Payments\PaymentResource;
use App\Models\AuditLog;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verifyPayment')
                ->label('Verify Payment')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn () => $this->record->status !== 'verified')
                ->action(function (): void {
                    if ($this->record->invoice && $this->record->invoice->status === 'paid') {
                        Notification::make()
                            ->title('Invoice already settled')
                            ->body('This invoice is already marked as paid. Payment verification was stopped.')
                            ->warning()
                            ->send();

                        return;
                    }

                    $oldValues = [
                        'status' => $this->record->status,
                        'verified_at' => $this->record->verified_at,
                    ];

                    $this->record->update([
                        'status' => 'verified',
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);

                    if ($this->record->invoice) {
                        $this->record->invoice->update([
                            'status' => 'paid',
                            'paid_at' => now(),
                        ]);
                    }

                    AuditLog::create([
                        'actor_id' => auth()->id(),
                        'action' => 'payment_verified',
                        'target_type' => $this->record::class,
                        'target_id' => $this->record->id,
                        'old_values' => $oldValues,
                        'new_values' => [
                            'status' => 'verified',
                            'verified_by' => auth()->id(),
                            'invoice_id' => $this->record->invoice_id,
                        ],
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);

                    Notification::make()
                        ->title('Payment verified successfully')
                        ->success()
                        ->send();
                }),

            Action::make('rejectPayment')
                ->label('Reject Payment')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->visible(fn () => ! in_array($this->record->status, ['verified', 'rejected']))
                ->action(function (): void {
                    $oldValues = [
                        'status' => $this->record->status,
                    ];

                    $this->record->update([
                        'status' => 'rejected',
                    ]);

                    AuditLog::create([
                        'actor_id' => auth()->id(),
                        'action' => 'payment_rejected',
                        'target_type' => $this->record::class,
                        'target_id' => $this->record->id,
                        'old_values' => $oldValues,
                        'new_values' => [
                            'status' => 'rejected',
                        ],
                        'ip_address' => request()->ip(),
                        'user_agent' => request()->userAgent(),
                    ]);

                    Notification::make()
                        ->title('Payment rejected')
                        ->success()
                        ->send();
                }),

            DeleteAction::make(),
        ];
    }
}