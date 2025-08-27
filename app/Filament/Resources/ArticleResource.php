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
                Forms\Components\Toggle::make('is_breaking')->label('Breaking'),
                Forms\Components\TextInput::make('image_url')->label('Image URL'),
                Forms\Components\TextInput::make('video_url')->label('Video URL'),
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
                ToggleColumn::make('is_breaking')->label('Breaking'),
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
