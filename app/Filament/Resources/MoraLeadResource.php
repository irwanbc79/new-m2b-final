<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MoraLeadResource\Pages;
use App\Models\MoraLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MoraLeadResource extends Resource
{
    protected static ?string $model = MoraLead::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationLabel = 'Leads MORA';
    protected static ?string $modelLabel = 'Lead';
    protected static ?string $pluralModelLabel = 'Leads MORA';
    protected static ?int $navigationSort = 5;

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
        return false; // Leads masuk otomatis dari MORA Chat, bukan input manual.
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Kontak')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')->label('Nama')->required()->maxLength(100),
                        Forms\Components\TextInput::make('phone')->label('HP / WA')->tel()->required()->maxLength(20),
                        Forms\Components\TextInput::make('company')->label('Perusahaan')->maxLength(100)->default(null),
                        Forms\Components\TextInput::make('email')->label('Email')->email()->maxLength(100)->default(null),
                    ]),

                Forms\Components\Section::make('Status & Tindak Lanjut')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options(MoraLead::STATUSES)
                            ->required(),
                        Forms\Components\Toggle::make('emailed')
                            ->label('Email terkirim')
                            ->inline(false),
                    ]),

                Forms\Components\Section::make('Ringkasan AI')
                    ->schema([
                        Forms\Components\Textarea::make('summary')
                            ->label('Ringkasan Percakapan (AI)')
                            ->rows(3)
                            ->placeholder('(belum ada ringkasan)')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Riwayat Percakapan')
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

    private static function statusColor(string $status): string
    {
        return match($status) {
            'contacted'   => 'warning',
            'negotiating' => 'info',
            'converted'   => 'success',
            'lost'        => 'danger',
            default       => 'gray',
        };
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
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
                    ->color(fn($state) => static::statusColor($state)),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->description(fn($record) => $record->summary
                        ? \Illuminate\Support\Str::limit($record->summary, 80)
                        : null),
                Tables\Columns\TextColumn::make('company')
                    ->label('Perusahaan')
                    ->placeholder('-')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('HP/WA')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\TextColumn::make('email')
                    ->placeholder('-')
                    ->searchable()
                    ->copyable(),
                Tables\Columns\IconColumn::make('emailed')
                    ->label('Email')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('score')
                    ->label('Score')
                    ->options(MoraLead::SCORES),
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options(MoraLead::STATUSES),
                Tables\Filters\SelectFilter::make('source')
                    ->label('Sumber')
                    ->options(MoraLead::SOURCES),
                Tables\Filters\TernaryFilter::make('emailed')
                    ->label('Email terkirim'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMoraLeads::route('/'),
            'edit' => Pages\EditMoraLead::route('/{record}/edit'),
        ];
    }
}
