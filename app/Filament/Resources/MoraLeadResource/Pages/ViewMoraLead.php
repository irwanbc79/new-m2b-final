<?php

namespace App\Filament\Resources\MoraLeadResource\Pages;

use App\Filament\Resources\MoraLeadResource;
use App\Models\MoraLead;
use Filament\Actions;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\ViewRecord;

class ViewMoraLead extends ViewRecord
{
    protected static string $resource = MoraLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('whatsapp')
                ->label('Hubungi via WhatsApp')
                ->icon('heroicon-o-chat-bubble-oval-left')
                ->color('success')
                ->url(fn() => $this->record->waUrl())
                ->openUrlInNewTab(),
            Actions\EditAction::make()
                ->label('Edit Lead'),
        ];
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([

            Infolists\Components\Section::make('Status & Prioritas')
                ->columns(4)
                ->schema([
                    Infolists\Components\TextEntry::make('score')
                        ->label('Score')
                        ->formatStateUsing(fn($state) => MoraLead::SCORES[$state] ?? $state)
                        ->badge()
                        ->color(fn($state) => match($state) {
                            'hot'  => 'danger',
                            'warm' => 'warning',
                            default => 'gray',
                        }),
                    Infolists\Components\TextEntry::make('status')
                        ->label('Status')
                        ->formatStateUsing(fn($state) => MoraLead::STATUSES[$state] ?? $state)
                        ->badge()
                        ->color(fn($state) => match($state) {
                            'contacted'   => 'warning',
                            'negotiating' => 'info',
                            'converted'   => 'success',
                            'lost'        => 'danger',
                            default       => 'gray',
                        }),
                    Infolists\Components\TextEntry::make('source')
                        ->label('Sumber')
                        ->formatStateUsing(fn($state) => MoraLead::SOURCES[$state] ?? $state)
                        ->badge()
                        ->color('info'),
                    Infolists\Components\TextEntry::make('service_interest')
                        ->label('Layanan Diminati')
                        ->formatStateUsing(fn($state) => $state ? (MoraLead::SERVICES[$state] ?? $state) : '—')
                        ->badge()
                        ->color('success'),
                ]),

            Infolists\Components\Section::make('Data Kontak')
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('name')->label('Nama'),
                    Infolists\Components\TextEntry::make('company')->label('Perusahaan')->default('—'),
                    Infolists\Components\TextEntry::make('phone')
                        ->label('HP / WA')
                        ->copyable()
                        ->copyMessage('Nomor disalin!'),
                    Infolists\Components\TextEntry::make('email')
                        ->label('Email')
                        ->copyable()
                        ->default('—'),
                    Infolists\Components\TextEntry::make('created_at')
                        ->label('Masuk')
                        ->dateTime('d M Y, H:i'),
                    Infolists\Components\TextEntry::make('estimated_value')
                        ->label('Est. Nilai (Rp)')
                        ->money('IDR')
                        ->default('—'),
                ]),

            Infolists\Components\Section::make('Tindak Lanjut')
                ->columns(2)
                ->schema([
                    Infolists\Components\TextEntry::make('follow_up_at')
                        ->label('Jadwal Follow-up')
                        ->dateTime('d M Y, H:i')
                        ->default('—')
                        ->color(fn($record) => $record->isFollowUpOverdue() ? 'danger' : null),
                    Infolists\Components\TextEntry::make('followed_up_at')
                        ->label('Terakhir Dihubungi')
                        ->dateTime('d M Y, H:i')
                        ->default('—'),
                    Infolists\Components\TextEntry::make('notes')
                        ->label('Catatan Sales')
                        ->columnSpanFull()
                        ->default('(belum ada catatan)')
                        ->html(),
                ]),

            Infolists\Components\Section::make('⚡ Ringkasan AI')
                ->schema([
                    Infolists\Components\TextEntry::make('summary')
                        ->label('')
                        ->default('(tidak ada ringkasan — lead masuk tanpa percakapan MORA Chat)')
                        ->columnSpanFull(),
                ])
                ->collapsible(),

            Infolists\Components\Section::make('💬 Riwayat Percakapan MORA Chat')
                ->schema([
                    Infolists\Components\ViewEntry::make('chat_history')
                        ->label('')
                        ->view('filament.lead-chat-history')
                        ->columnSpanFull(),
                ])
                ->collapsible()
                ->collapsed(false),

        ]);
    }
}
