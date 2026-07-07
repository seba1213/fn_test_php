<?php

namespace App\Filament\Resources\ShortLinkStatisticResource\Pages;

use App\Filament\Resources\ShortLinkStatisticResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShortLinkStatistics extends ListRecords
{
    protected static string $resource = ShortLinkStatisticResource::class;

    protected static ?string $title = null;

    public function getTitle(): string
    {
        return __('statistics.pages.list_title');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('backToLinks')
                ->label(__('statistics.pages.back_to_links'))
                ->url(fn (): string => \App\Filament\Resources\ShortLinkResource::getUrl('index'))
                ->icon('heroicon-o-link'),
        ];
    }
}

