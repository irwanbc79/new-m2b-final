<?php
namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;
    protected static ?string $navigationIcon = "heroicon-o-document-text";
    protected static ?string $navigationLabel = "Blog Posts";
    protected static ?string $navigationGroup = "Konten";
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make("Konten Artikel")->schema([
                Forms\Components\TextInput::make("title")
                    ->label("Judul")->required()->maxLength(255)
                    ->live(debounce: 500)
                    ->afterStateUpdated(fn ($state, Forms\Set $set) =>
                        $set("slug", Str::slug($state))),
                Forms\Components\TextInput::make("slug")
                    ->label("Slug URL")->required()->unique(ignoreRecord: true),
                Forms\Components\Textarea::make("excerpt")
                    ->label("Ringkasan")->rows(3)->maxLength(300),
                Forms\Components\RichEditor::make("content")
                    ->label("Isi Artikel")->required()->columnSpanFull(),
            ])->columns(2),

            Forms\Components\Section::make("Media & Kategori")->schema([
                Forms\Components\FileUpload::make("featured_image")
                    ->label("Gambar Utama")->image()->directory("posts")
                    ->imageResizeMode("cover")->imageCropAspectRatio("16:9"),
                Forms\Components\TextInput::make("category")->label("Kategori"),
                Forms\Components\TextInput::make("tags")->label("Tags (pisah koma)"),
                Forms\Components\Select::make("lang")
                    ->label("Bahasa")->options(["id" => "Indonesia","en" => "English"])
                    ->default("id")->required(),
            ])->columns(2),

            Forms\Components\Section::make("Publikasi")->schema([
                Forms\Components\Select::make("status")
                    ->options(["draft" => "Draft","published" => "Published"])
                    ->default("draft")->required(),
                Forms\Components\DateTimePicker::make("published_at")
                    ->label("Tanggal Publish")->default(now()),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\ImageColumn::make("featured_image")->label("Gambar")->circular(false),
            Tables\Columns\TextColumn::make("title")->label("Judul")->searchable()->limit(50),
            Tables\Columns\BadgeColumn::make("status")
                ->colors(["warning" => "draft","success" => "published"]),
            Tables\Columns\BadgeColumn::make("lang")
                ->colors(["primary" => "id","info" => "en"]),
            Tables\Columns\TextColumn::make("category")->label("Kategori"),
            Tables\Columns\TextColumn::make("published_at")->label("Publish")->dateTime("d M Y")->sortable(),
        ])
        ->defaultSort("published_at","desc")
        ->filters([
            Tables\Filters\SelectFilter::make("status")->options(["draft"=>"Draft","published"=>"Published"]),
            Tables\Filters\SelectFilter::make("lang")->options(["id"=>"Indonesia","en"=>"English"]),
        ])
        ->actions([Tables\Actions\EditAction::make()])
        ->bulkActions([Tables\Actions\BulkActionGroup::make([Tables\Actions\DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListPosts::route("/"),
            "create" => Pages\CreatePost::route("/create"),
            "edit" => Pages\EditPost::route("/{record}/edit"),
        ];
    }
}
