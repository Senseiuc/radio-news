<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Articles';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->required()->maxLength(255),
                Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true)->maxLength(255),
                Forms\Components\Textarea::make('excerpt')->rows(3)->maxLength(1000),
                Forms\Components\RichEditor::make('body')->columnSpanFull(),
                Forms\Components\DateTimePicker::make('published_at')->label('Published At'),
                Forms\Components\Toggle::make('is_trending')->label('Trending'),
                Forms\Components\Toggle::make('is_featured')->label('Featured'),
                Forms\Components\Toggle::make('is_top')->label('Top'),
                Forms\Components\Select::make('categories')
                    ->label('Categories')
                    ->relationship('categories', 'name')
                    ->multiple()
                    ->preload(),
                Forms\Components\TextInput::make('image_url')->label('Image URL'),
                Forms\Components\TextInput::make('video_url')->label('Video URL')->url()->nullable(),
                Forms\Components\TextInput::make('audio_url')->label('Audio URL')->url()->nullable(),
                Forms\Components\FileUpload::make('audio_file_path')
                    ->label('Upload Audio')
                    ->directory('media/articles')
                    ->disk('public')
                    ->acceptedFileTypes(['audio/mpeg','audio/mp3','audio/wav','audio/ogg','audio/aac'])
                    ->maxSize(51200)
                    ->helperText('Optional. If provided, this will be used instead of the Audio URL.'),
                Forms\Components\FileUpload::make('video_file_path')
                    ->label('Upload Video')
                    ->directory('media/articles')
                    ->disk('public')
                    ->acceptedFileTypes(['video/mp4','video/webm','video/ogg'])
                    ->maxSize(204800)
                    ->helperText('Optional. If provided, this will be used instead of the Video URL.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('published_at')->dateTime()->sortable(),
                ToggleColumn::make('is_trending')->label('Trending'),
                ToggleColumn::make('is_featured')->label('Featured'),
                ToggleColumn::make('is_top')->label('Top'),
            ])
            ->filters([
                // optional filters could be added
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }
}
