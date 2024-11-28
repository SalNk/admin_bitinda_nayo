<?php

namespace App\Filament\Resources\DeliveryResource\Pages;

use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\DeliveryResource;

class ListDeliveries extends ListRecords
{
    protected static string $resource = DeliveryResource::class;
    protected ?string $heading = "Les livraisons";

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
            'Nouvelles' => Tab::make()->query(fn($query) => $query->where('order.status', 'new')),
            'En cours' => Tab::make()->query(fn($query) => $query->where('order.status', 'processing')),
            'Livrées' => Tab::make()->query(fn($query) => $query->where('order.status', 'delivered')),
            'Annulées' => Tab::make()->query(fn($query) => $query->where('order.status', 'cancelled')),
        ];
    }
}
