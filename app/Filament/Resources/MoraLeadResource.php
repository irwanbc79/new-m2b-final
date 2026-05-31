<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MoraLeadResource\Pages;
use App\Filament\Resources\MoraLeadResource\RelationManagers;
use App\Models\MoraLead;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

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
        return (string) static::getModel()::count();
    }

    public static function canCreate(): bool
    {
        return false; // Leads masuk otomatis dari MORA Chat, bukan input manual.
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(100),
                Forms\Components\TextInput::make('company')
                    ->maxLength(100)
                    ->default(null),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(100)
                    ->default(null),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->maxLength(20),
                Forms\Components\Toggle::make('emailed')
                    ->required(),
            ]);
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
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable(),
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
                    ->label('Email terkirim')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('emailed')
                    ->label('Status email'),
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
