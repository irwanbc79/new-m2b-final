<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MoraLeadResource\Pages;
use App\Filament\Widgets\MoraLeadStatsWidget;
use App\Models\MoraLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;

class MoraLeadResource extends Resource
{
    protected static ?string $model = MoraLead::class;

    protected static ?string $navigationIcon        = 'heroicon-o-user-group';
    protected static ?string $navigationLabel       = 'Lead Management';
    protected static ?string $modelLabel            = 'Lead';
    protected static ?string $pluralModelLabel      = 'Lead Management';
    protected static ?string $navigationGroup       = 'MORA · Sales & Marketing';
    protected static ?int    $navigationSort        = 1;

    public static function getNavigationBadge(): ?string
    {
        $count = static::getModel()::where('status', 'new')->count();
        return $count > 0 ? (string) $count : null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'danger';
    }

    public static function canCreate(): bool
    {
        return false;
    }

    // ─── FORM ────────────────────────────────────────────────────────────────

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Data Kontak')
                ->icon('heroicon-o-user')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama')->required()->maxLength(100),
                    Forms\Components\TextInput::make('phone')
                        ->label('HP / WA')->tel()->required()->maxLength(20),
                    Forms\Components\TextInput::make('company')
                        ->label('Perusahaan')->maxLength(100),
                    Forms\Components\TextInput::make('email')
                        ->label('Email')->email()->maxLength(100),
                ]),

            Forms\Components\Section::make('Klasifikasi & Prioritas')
                ->icon('heroicon-o-tag')
                ->columns(3)
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status Pipeline')
                        ->options(MoraLead::STATUSES)
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, Forms\Set $set) {
                            if ($state === 'contacted') {
                                $set('followed_up_at', now()->format('Y-m-d H:i:s'));
                            }
                        }),
                    Forms\Components\Select::make('score')
                        ->label('Lead Score')
                        ->options(MoraLead::SCORES)
                        ->required(),
                    Forms\Components\Select::make('service_interest')
                        ->label('Layanan Diminati')
                        ->options(MoraLead::SERVICES)
                        ->placeholder('Belum terdeteksi'),
                ]),

            Forms\Components\Section::make('Tindak Lanjut')
                ->icon('heroicon-o-calendar-days')
                ->columns(2)
                ->schema([
                    Forms\Components\DateTimePicker::make('follow_up_at')
                        ->label('Jadwal Follow-up Berikutnya')
                        ->native(false)
                        ->placeholder('Pilih tanggal & waktu'),
                    Forms\Components\DateTimePicker::make('followed_up_at')
                        ->label('Terakhir Dihubungi')
                        ->native(false),
                    Forms\Components\TextInput::make('estimated_value')
                        ->label('Estimasi Nilai Deal (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->placeholder('0')
                        ->columnSpanFull(),
                    Forms\Components\Textarea::make('notes')
                        ->label('Catatan Sales')
                        ->rows(4)
                        ->placeholder('Tambahkan catatan, hasil percakapan, kebutuhan spesifik...')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Ringkasan AI & Sumber')
                ->icon('heroicon-o-cpu-chip')
                ->columns(2)
                ->collapsible()
                ->schema([
                    Forms\Components\Select::make('source')
                        ->label('Sumber Lead')
                        ->options(MoraLead::SOURCES),
                    Forms\Components\Toggle::make('emailed')
                        ->label('Email notifikasi terkirim')
                        ->inline(false),
                    Forms\Components\Textarea::make('summary')
                        ->label('Ringkasan AI')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Tautan Produk Terdeteksi')
                ->icon('heroicon-o-link')
                ->visible(fn($record) => $record && $record->product_links)
                ->schema([
                    Forms\Components\Placeholder::make('product_links_placeholder')
                        ->label('Link dari Supplier')
                        ->content(function ($record) {
                            if (!$record || !$record->product_links) return '—';
                            $urls = explode(', ', $record->product_links);
                            $html = '<ul class="list-disc pl-5 space-y-1">';
                            foreach ($urls as $url) {
                                $html .= "<li><a href=\"{$url}\" target=\"_blank\" class=\"text-primary-600 hover:underline break-all\">{$url}</a></li>";
                            }
                            $html .= '</ul>';
                            return new \Illuminate\Support\HtmlString($html);
                        }),
                ]),

            Forms\Components\Section::make('Riwayat Percakapan MORA Chat')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->collapsible()
                ->collapsed()
                ->schema([
                    Forms\Components\Textarea::make('chat_history_display')
                        ->label('')
                        ->disabled()
                        ->rows(14)
                        ->dehydrated(false)
                        ->columnSpanFull()
                        ->afterStateHydrated(function ($component, $record) {
                            if (!$record || empty($record->chat_history)) {
                                $component->state('(tidak ada riwayat percakapan)');
                                return;
                            }
                            $lines = collect($record->chat_history)->map(function ($msg) {
                                $prefix = $msg['role'] === 'user' ? 'Pengunjung' : 'MORA';
                                return "[{$prefix}]\n{$msg['content']}";
                            })->implode("\n\n──────────────────────\n\n");
                            $component->state($lines);
                        }),
                ]),

        ]);
    }

    // ─── TABLE ───────────────────────────────────────────────────────────────

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([

                Tables\Columns\BadgeColumn::make('score')
                    ->label('')
                    ->formatStateUsing(fn($state) => MoraLead::SCORES[$state] ?? $state)
                    ->color(fn($state) => match($state) {
                        'hot'  => 'danger',
                        'warm' => 'warning',
                        default => 'gray',
                    }),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => MoraLead::STATUSES[$state] ?? $state)
                    ->color(fn($state) => match($state) {
                        'contacted'   => 'warning',
                        'negotiating' => 'info',
                        'converted'   => 'success',
                        'lost'        => 'danger',
                        default       => 'gray',
                    }),

                Tables\Columns\TextColumn::make('name')
                    ->label('Lead')
                    ->searchable()
                    ->weight('bold')
                    ->description(fn($record) => $record->summary
                        ? \Illuminate\Support\Str::limit($record->summary, 90)
                        : ($record->company ?: null)),

                Tables\Columns\TextColumn::make('phone')
                    ->label('HP/WA')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Nomor disalin!')
                    ->icon('heroicon-o-device-phone-mobile'),

                Tables\Columns\BadgeColumn::make('service_interest')
                    ->label('Layanan')
                    ->formatStateUsing(fn($state) => $state ? (MoraLead::SERVICES[$state] ?? $state) : '—')
                    ->color('success'),

                Tables\Columns\TextColumn::make('product_links')
                    ->label('Link Produk')
                    ->placeholder('—')
                    ->formatStateUsing(function ($state) {
                        if (!$state) return null;
                        $urls = explode(', ', $state);
                        $linksHtml = [];
                        foreach ($urls as $index => $url) {
                            $num = $index + 1;
                            $linksHtml[] = "<a href=\"{$url}\" target=\"_blank\" class=\"text-primary-600 hover:underline\">🔗 Link #{$num}</a>";
                        }
                        return implode('<br>', $linksHtml);
                    })
                    ->html(),

                Tables\Columns\TextColumn::make('follow_up_at')
                    ->label('Follow-up')
                    ->dateTime('d M, H:i')
                    ->placeholder('—')
                    ->color(fn($record) => $record->isFollowUpOverdue() ? 'danger' : 'gray')
                    ->icon(fn($record) => $record->isFollowUpOverdue() ? 'heroicon-o-exclamation-triangle' : null)
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('source')
                    ->label('Sumber')
                    ->formatStateUsing(fn($state) => MoraLead::SOURCES[$state] ?? $state)
                    ->color(fn($state) => $state === 'mora_chat' ? 'info' : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Masuk')
                    ->since()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),

            ])
            ->filters([
                Tables\Filters\SelectFilter::make('score')
                    ->label('Score')->options(MoraLead::SCORES),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')->options(MoraLead::STATUSES),
                Tables\Filters\SelectFilter::make('service_interest')
                    ->label('Layanan')->options(MoraLead::SERVICES),
                Tables\Filters\SelectFilter::make('source')
                    ->label('Sumber')->options(MoraLead::SOURCES),
                Tables\Filters\Filter::make('overdue_followup')
                    ->label('Follow-up Terlewat')
                    ->query(fn($query) => $query
                        ->whereNotNull('follow_up_at')
                        ->where('follow_up_at', '<', now())
                        ->whereNotIn('status', ['converted', 'lost'])),
                Tables\Filters\Filter::make('this_month')
                    ->label('Bulan Ini')
                    ->query(fn($query) => $query
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)),
            ])
            ->actions([
                Tables\Actions\Action::make('whatsapp')
                    ->label('WA')
                    ->icon('heroicon-o-chat-bubble-oval-left')
                    ->color('success')
                    ->size('sm')
                    ->url(fn(MoraLead $record) => $record->waUrl())
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('mark_contacted')
                    ->label('Hubungi')
                    ->icon('heroicon-o-check-circle')
                    ->color('warning')
                    ->size('sm')
                    ->requiresConfirmation()
                    ->modalHeading('Tandai sebagai Dihubungi?')
                    ->modalDescription('Status lead akan diubah ke "Dihubungi" dan waktu tindak lanjut akan dicatat.')
                    ->action(fn(MoraLead $record) => $record->update([
                        'status'        => 'contacted',
                        'followed_up_at' => now(),
                    ]))
                    ->visible(fn(MoraLead $record) => $record->status === 'new'),

                Tables\Actions\ViewAction::make()->label('Detail'),
                Tables\Actions\EditAction::make()->label('Edit'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('bulk_contacted')
                        ->label('Tandai: Dihubungi')
                        ->icon('heroicon-o-check-circle')
                        ->color('warning')
                        ->requiresConfirmation()
                        ->action(fn($records) => $records->each(fn($r) => $r->update([
                            'status'         => 'contacted',
                            'followed_up_at' => now(),
                        ]))),
                    Tables\Actions\BulkAction::make('bulk_hot')
                        ->label('Tandai: 🔥 Hot')
                        ->icon('heroicon-o-fire')
                        ->color('danger')
                        ->action(fn($records) => $records->each->update(['score' => 'hot'])),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([])
            ->emptyStateHeading('Belum ada lead masuk')
            ->emptyStateDescription('Lead akan otomatis masuk saat pengunjung mengisi form di website m2b.co.id')
            ->emptyStateIcon('heroicon-o-inbox');
    }

    // ─── PAGES ───────────────────────────────────────────────────────────────

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMoraLeads::route('/'),
            'view'   => Pages\ViewMoraLead::route('/{record}'),
            'edit'   => Pages\EditMoraLead::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [MoraLeadStatsWidget::class];
    }
}
