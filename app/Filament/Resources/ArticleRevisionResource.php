<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleRevisionResource\Pages;
use App\Models\ArticleRevision;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ArticleRevisionResource extends Resource
{
    protected static ?string $model = ArticleRevision::class;
    protected static ?string $navigationIcon = 'heroicon-o-clock';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('content.title'),
                Forms\Components\Textarea::make('content.body')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('article.title')
                    ->label('Article'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Edited By'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('restore')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (ArticleRevision $record) {
                        $record->article->update($record->content);
                    }),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageArticleRevisions::route('/'),
        ];
    }
}
