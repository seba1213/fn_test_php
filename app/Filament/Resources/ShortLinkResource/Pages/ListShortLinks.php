<?php

namespace App\Filament\Resources\ShortLinkResource\Pages;

use App\Filament\Resources\ShortLinkResource;
use App\Models\ShortLink;
use Filament\Actions;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Http;

class ListShortLinks extends ListRecords
{
    protected static string $resource = ShortLinkResource::class;

    protected static ?string $title = null;

    public function getTitle(): string
    {
        return __('short_links.nav.my_links');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('create')
                ->label(__('short_links.create.action'))
                ->icon('heroicon-o-plus')
                ->modalHeading(__('short_links.create.heading'))
                ->modalSubmitActionLabel(__('short_links.create.submit'))
                ->form([
                    TextInput::make('original_url')
                        ->label(__('short_links.create.fields.original_url.label'))
                        ->placeholder(__('short_links.create.fields.original_url.placeholder'))
                        ->rules(['url:http,https'])
                        ->required()
                        ->maxLength(2048),
                ])
                ->action(function (array $data): void {
                    $url = (string) ($data['original_url'] ?? '');

                    try {
                        $response = Http::timeout(5)
                            ->withHeaders([
                                'User-Agent' => 'ShortLinkChecker/1.0',
                            ])
                            ->head($url);

                        $status = $response->status();

                        if (in_array($status, [404, 410], true)) {
                            Notification::make()
                                ->title(__('short_links.create.notifications.unreachable_404'))
                                ->danger()
                                ->send();

                            throw new Halt();
                        }

                        if ($status >= 500) {
                            Notification::make()
                                ->title(__('short_links.create.notifications.unreachable_5xx'))
                                ->danger()
                                ->send();

                            throw new Halt();
                        }
                    } catch (Halt $e) {
                        throw $e;
                    } catch (\Throwable $e) {
                        Notification::make()
                            ->title(__('short_links.create.notifications.unreachable_network'))
                            ->danger()
                            ->send();

                        throw new Halt();
                    }

                    $shortLink = ShortLink::createForUser(
                        auth()->id(),
                        $url,
                    );

                    Notification::make()
                        ->title(__('short_links.create.notifications.created'))
                        ->success()
                        ->send();
                }),
        ];
    }
}
