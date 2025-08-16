<?php

namespace App\Filament\Resources\ArticleRevisionResource\Pages;

use App\Filament\Resources\ArticleRevisionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageArticleRevisions extends ManageRecords
{
    protected static string $resource = ArticleRevisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
