<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;
    protected ?string $heading = 'Liste des Bitinda';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('Toutes'),
            'Nouvelles' => Tab::make()->query(fn($query) => $query->where('status', 'new')),
            'En cours' => Tab::make()->query(fn($query) => $query->where('status', 'processing')),
            'Livrées' => Tab::make()->query(fn($query) => $query->where('status', 'delivered')),
            'Annulées' => Tab::make()->query(fn($query) => $query->where('status', 'cancelled')),
        ];
    }
}
