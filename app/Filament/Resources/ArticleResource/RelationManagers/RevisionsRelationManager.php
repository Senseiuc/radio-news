<?php

namespace App\Filament\Resources\ArticleResource\RelationManagers;

use App\Models\ArticleRevision;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class RevisionsRelationManager extends RelationManager
{
    protected static string $relationship = 'revisions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('content.title')
                    ->label('Title'),
                Forms\Components\Textarea::make('content.excerpt')
                    ->label('Excerpt'),
                Forms\Components\RichEditor::make('content.body')
                    ->label('Content'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Edited By'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Revision Date'),
                Tables\Columns\TextColumn::make('content.title')
                    ->label('Old Title')
                    ->limit(30),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('user')
                    ->relationship('user', 'name'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('restore')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (ArticleRevision $record) {
                        $record->article->update($record->content);
                    }),
            ])
            ->defaultSort('created_at', 'desc')
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
    public function canEdit(Model $record): bool
    {
        return false;
    }

    public function canCreate(): bool
    {
        return false;
    }
}
