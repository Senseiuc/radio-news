<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    protected static ?string $navigationGroup = 'Administration';
    protected static ?int $navigationSort = 99;
    protected static ?string $pluralModelLabel = 'Site Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Social Links')->schema([
                    Forms\Components\TextInput::make('facebook_url')->label('Facebook URL')->url()->maxLength(255),
                    Forms\Components\TextInput::make('twitter_url')->label('Twitter/X URL')->url()->maxLength(255),
                    Forms\Components\TextInput::make('instagram_url')->label('Instagram URL')->url()->maxLength(255),
                    Forms\Components\TextInput::make('youtube_url')->label('YouTube URL')->url()->maxLength(255),
                    Forms\Components\TextInput::make('youtube_live_url')->label('YouTube Live URL')->url()->maxLength(255),
                    Forms\Components\TextInput::make('facebook_live_url')->label('Facebook Live URL')->url()->maxLength(255),
                    Forms\Components\TextInput::make('linkedin_url')->label('LinkedIn URL')->url()->maxLength(255),
                    Forms\Components\TextInput::make('tiktok_url')->label('TikTok URL')->url()->maxLength(255),
                ])->columns(2),
                Forms\Components\Section::make('Contact')->schema([
                    Forms\Components\TextInput::make('contact_email')->email()->maxLength(255),
                ]),
                Forms\Components\Section::make('Radio / Streaming')->schema([
                    Forms\Components\TextInput::make('radio_stream_url')
                        ->label('Stream URL (HLS/MP3)')
                        ->placeholder('https://example.com/stream.mp3')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('radio_now_playing')
                        ->label('Now Playing (fallback text)')
                        ->maxLength(255),
                    Forms\Components\Repeater::make('radio_schedule')
                        ->label('Weekly Schedule')
                        ->schema([
                            Forms\Components\Select::make('day')
                                ->options([
                                    'monday' => 'Monday',
                                    'tuesday' => 'Tuesday',
                                    'wednesday' => 'Wednesday',
                                    'thursday' => 'Thursday',
                                    'friday' => 'Friday',
                                    'saturday' => 'Saturday',
                                    'sunday' => 'Sunday',
                                ])->required()->native(false),
                            Forms\Components\TimePicker::make('start')->required()->withoutSeconds(),
                            Forms\Components\TimePicker::make('end')->required()->withoutSeconds(),
                            Forms\Components\TextInput::make('title')->label('Show Title')->required(),
                            Forms\Components\TextInput::make('host')->label('Host')->maxLength(255),
                        ])
                        ->collapsible()
                        ->grid(2)
                        ->columnSpanFull(),
                ])->columns(2),
                Forms\Components\Section::make('Chat / Feedback')
                    ->schema([
                        Forms\Components\TextInput::make('tawk_property_id')
                            ->label('Tawk Property ID')
                            ->helperText('Paste the Tawk.to property ID (Settings > Property).')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('tawk_widget_id')
                            ->label('Tawk Widget ID')
                            ->helperText('Paste the Tawk.to widget ID (e.g., the trailing ID in the embed URL). If empty, we will default to 1.')
                            ->maxLength(255),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('contact_email')->label('Email'),
                Tables\Columns\TextColumn::make('updated_at')->dateTime()->since()->sortable(),
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
            'index' => Pages\ManageSettings::route('/'),
        ];
    }
}
