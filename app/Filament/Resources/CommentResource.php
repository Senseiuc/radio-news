<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommentResource\Pages;
use App\Models\Comment;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;

class CommentResource extends Resource
{
    protected static ?string $model = Comment::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 3;
    protected static ?string $pluralModelLabel = 'Comments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('body')->required()->maxLength(5000),
                Forms\Components\Toggle::make('is_approved')->label('Approved'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('article.title')->label('Article')->limit(40)->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('User')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('body')->limit(60)->toggleable(),
                Tables\Columns\IconColumn::make('is_approved')->boolean()->label('Approved')->sortable(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->since()->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_approved')->label('Approved'),
            ])
            ->actions([
                Tables\Actions\Action::make('approve')
                    ->visible(fn ($record) => ! $record->is_approved)
                    ->requiresConfirmation()
                    ->action(fn ($record) => $record->update(['is_approved' => true]))
                    ->color('success')
                    ->icon('heroicon-o-check'),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkAction::make('approve_selected')
                    ->label('Approve Selected')
                    ->icon('heroicon-o-check')
                    ->color('success')
                    ->action(function ($records) {
                        foreach ($records as $record) {
                            if (! $record->is_approved) {
                                $record->update(['is_approved' => true]);
                            }
                        }
                    }),
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListComments::route('/'),
            'edit' => Pages\EditComment::route('/{record}/edit'),
        ];
    }
}
