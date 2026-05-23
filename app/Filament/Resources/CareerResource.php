<?php
namespace App\Filament\Resources;

use App\Filament\Resources\CareerResource\Pages;
use App\Models\Career;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;
    protected static ?string $navigationIcon = "heroicon-o-briefcase";
    protected static ?string $navigationLabel = "Lowongan Karir";
    protected static ?string $navigationGroup = "Konten";
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make("Detail Posisi")->schema([
                Forms\Components\TextInput::make("title")->label("Nama Posisi")->required(),
                Forms\Components\TextInput::make("department")->label("Divisi/Departemen"),
                Forms\Components\TextInput::make("location")->label("Lokasi")->default("Jakarta, Indonesia"),
                Forms\Components\Select::make("type")->label("Tipe Pekerjaan")
                    ->options(["full-time"=>"Full Time","part-time"=>"Part Time","remote"=>"Remote","contract"=>"Kontrak"])
                    ->default("full-time")->required(),
            ])->columns(2),

            Forms\Components\Section::make("Deskripsi")->schema([
                Forms\Components\RichEditor::make("description")->label("Deskripsi Pekerjaan")->required(),
                Forms\Components\RichEditor::make("requirements")->label("Kualifikasi & Persyaratan"),
                Forms\Components\RichEditor::make("benefits")->label("Benefit & Fasilitas"),
            ]),

            Forms\Components\Section::make("Status")->schema([
                Forms\Components\Select::make("status")->options(["open"=>"Dibuka","closed"=>"Ditutup"])->default("open"),
                Forms\Components\DatePicker::make("deadline")->label("Batas Pendaftaran"),
                Forms\Components\TextInput::make("sort_order")->label("Urutan")->numeric()->default(0),
            ])->columns(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make("title")->label("Posisi")->searchable(),
            Tables\Columns\TextColumn::make("department")->label("Divisi"),
            Tables\Columns\BadgeColumn::make("type")
                ->colors(["success"=>"full-time","warning"=>"part-time","info"=>"remote","gray"=>"contract"]),
            Tables\Columns\BadgeColumn::make("status")
                ->colors(["success"=>"open","danger"=>"closed"]),
            Tables\Columns\TextColumn::make("deadline")->label("Deadline")->date("d M Y"),
        ])
        ->defaultSort("sort_order")
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCareers::route("/"),
            "create" => Pages\CreateCareer::route("/create"),
            "edit" => Pages\EditCareer::route("/{record}/edit"),
        ];
    }
}
