<?php

namespace App\Filament\Resources\SiteSettingResource\Pages;

use App\Filament\Resources\SiteSettingResource;
use Filament\Resources\Pages\ManageRecords;

class ManageSettings extends ManageRecords
{
    protected static string $resource = SiteSettingResource::class;

    protected static ?string $title = 'Site Settings';

    protected function getHeaderActions(): array
    {
        return [
            // allow create if no record exists, otherwise hide
            \Filament\Actions\CreateAction::make()
                ->visible(fn () => static::getModel()::count() === 0),
        ];
    }
}
