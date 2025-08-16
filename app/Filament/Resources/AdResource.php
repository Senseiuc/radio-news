<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdResource\Pages;
//use App\Filament\Resources\AdResource\RelationManagers;
use App\Models\Ad;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AdResource extends Resource
{
    protected static ?string $model = Ad::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required(),
            TextInput::make('slot_id')
                ->label('Google AdSense Slot ID')
                ->required(),
            Select::make('type')
                ->options([
                    'banner' => 'Banner',
                    'in-article' => 'In-Article',
                    'auto' => 'Auto',
                    'custom' => 'Custom (Raw HTML/JS)',
                ])
                ->required(),
            TextInput::make('placement')
                ->placeholder('e.g. header, sidebar, footer'),
            Toggle::make('is_active')
                ->label('Active')
                ->default(true),
            Textarea::make('custom_code')
                ->label('Custom HTML/JS Code')
                ->rows(5)
                ->helperText('Optional: For custom ads or affiliate scripts.'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('slot_id'),
                TextColumn::make('type'),
                TextColumn::make('placement'),
                IconColumn::make('is_active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-badge')
                    ->falseIcon('heroicon-o-x-mark'),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListAds::route('/'),
            'create' => Pages\CreateAd::route('/create'),
            'edit' => Pages\EditAd::route('/{record}/edit'),
        ];
    }
}
