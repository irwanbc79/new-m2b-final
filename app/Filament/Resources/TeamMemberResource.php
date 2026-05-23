<?php
namespace App\Filament\Resources;

use App\Filament\Resources\TeamMemberResource\Pages;
use App\Models\TeamMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TeamMemberResource extends Resource
{
    protected static ?string $model = TeamMember::class;
    protected static ?string $navigationIcon = "heroicon-o-user-group";
    protected static ?string $navigationLabel = "Tim M2B";
    protected static ?string $navigationGroup = "Konten";
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make("Profil")->schema([
                Forms\Components\FileUpload::make("photo")->label("Foto")->image()
                    ->directory("team")->imageResizeMode("cover")->imageCropAspectRatio("1:1")
                    ->columnSpanFull(),
                Forms\Components\TextInput::make("name")->label("Nama Lengkap")->required(),
                Forms\Components\TextInput::make("position")->label("Jabatan")->required(),
                Forms\Components\TextInput::make("division")->label("Divisi"),
                Forms\Components\Textarea::make("bio")->label("Bio Singkat")->rows(3),
            ])->columns(2),

            Forms\Components\Section::make("Kontak & Sosial")->schema([
                Forms\Components\TextInput::make("linkedin")->label("LinkedIn URL")->url(),
                Forms\Components\TextInput::make("email")->label("Email")->email(),
                Forms\Components\Toggle::make("is_active")->label("Tampilkan")->default(true),
                Forms\Components\TextInput::make("sort_order")->label("Urutan")->numeric()->default(0),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make("photo")->label("Foto")->circular(),
            Tables\Columns\TextColumn::make("name")->label("Nama")->searchable(),
            Tables\Columns\TextColumn::make("position")->label("Jabatan"),
            Tables\Columns\TextColumn::make("division")->label("Divisi"),
            Tables\Columns\IconColumn::make("is_active")->label("Aktif")->boolean(),
            Tables\Columns\TextColumn::make("sort_order")->label("Urutan")->sortable(),
        ])
        ->defaultSort("sort_order")
        ->reorderable("sort_order")
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListTeamMembers::route("/"),
            "create" => Pages\CreateTeamMember::route("/create"),
            "edit" => Pages\EditTeamMember::route("/{record}/edit"),
        ];
    }
}
