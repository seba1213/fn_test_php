<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShortLinkStatisticResource\Pages;
use App\Models\ShortLink;
use App\Models\ShortLinkStatistic;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ShortLinkStatisticResource extends Resource
{
    protected static ?string $model = ShortLinkStatistic::class;

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    public static function getNavigationLabel(): string
    {
        return __('statistics.resource.navigation');
    }

    public static function getModelLabel(): string
    {
        return __('statistics.resource.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('statistics.resource.plural');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('shortLink.code')
                    ->label(__('statistics.table.link'))
                    ->formatStateUsing(fn (?string $state): string => $state ? url($state) : '—')
                    ->copyable()
                    ->copyableState(fn (?string $state): string => $state ? url($state) : '')
                    ->searchable(isIndividual: false)
                    ->sortable(),
                Tables\Columns\TextColumn::make('shortLink.original_url')
                    ->label(__('statistics.table.original_url'))
                    ->limit(60)
                    ->url(fn (ShortLinkStatistic $record): ?string => $record->shortLink?->original_url, shouldOpenInNewTab: true),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label(__('statistics.table.ip'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('clicked_at')
                    ->label(__('statistics.table.clicked_at'))
                    ->dateTime('d.m.Y H:i:s')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('short_link_id')
                    ->label(__('statistics.table.filter_link'))
                    ->options(fn (): array => ShortLink::query()
                        ->where('user_id', auth()->id())
                        ->orderByDesc('created_at')
                        ->get()
                        ->mapWithKeys(fn (ShortLink $link): array => [
                            $link->id => sprintf('%s — %s', $link->code, str($link->original_url)->limit(60)),
                        ])
                        ->all())
                    ->searchable()
                    ->preload(),
            ])
            ->defaultSort('clicked_at', 'desc')
            ->paginated([25, 50, 100]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('shortLink', fn (Builder $query) => $query->where('user_id', auth()->id()));
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShortLinkStatistics::route('/'),
        ];
    }
}

