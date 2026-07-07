<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShortLinkResource\Pages;
use App\Models\ShortLink;
use App\Filament\Resources\ShortLinkStatisticResource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\DeleteAction;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ShortLinkResource extends Resource
{
    protected static ?string $model = ShortLink::class;

    protected static ?string $navigationIcon = 'heroicon-o-link';

    protected static ?string $navigationLabel = null;

    protected static ?string $modelLabel = null;

    protected static ?string $pluralModelLabel = null;

    public static function getNavigationLabel(): string
    {
        return __('short_links.nav.my_links');
    }

    public static function getModelLabel(): string
    {
        return __('short_links.resource.model');
    }

    public static function getPluralModelLabel(): string
    {
        return __('short_links.resource.plural');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->label(__('short_links.table.short_url'))
                    ->formatStateUsing(fn (string $state): string => url($state))
                    ->copyable()
                    ->copyableState(fn (string $state): string => url($state))
                    ->searchable(),
                Tables\Columns\TextColumn::make('original_url')
                    ->label(__('short_links.table.original_url'))
                    ->limit(60)
                    ->searchable()
                    ->url(fn (ShortLink $record): string => $record->original_url, shouldOpenInNewTab: true),
                ViewColumn::make('total_clicks')
                    ->label(__('short_links.table.total_clicks'))
                    ->view('filament.tables.columns.short-link-clicks'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('short_links.table.created_at'))
                    ->dateTime('d.m.Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Action::make('statistics')
                    ->label(__('short_links.table.actions.statistics'))
                    ->icon('heroicon-o-chart-bar')
                    ->url(fn (ShortLink $record): string => ShortLinkStatisticResource::getUrl('index', [
                        'tableFilters' => [
                            'short_link_id' => [
                                'value' => $record->id,
                            ],
                        ],
                    ])),
                DeleteAction::make()
                    ->label(__('short_links.table.actions.delete'))
                    ->requiresConfirmation()
                    ->modalHeading(__('short_links.table.delete.heading'))
                    ->modalDescription(__('short_links.table.delete.description'))
                    ->modalSubmitActionLabel(__('short_links.table.delete.submit')),
            ])
            ->defaultSort('created_at', 'desc')
            ->paginated([10, 25, 50]);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('user_id', auth()->id());
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShortLinks::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
