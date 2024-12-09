<?php

namespace App\Filament\Resources\DeliveryManResource\Pages;

use App\Filament\Resources\DeliveryManResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewDeliveryMan extends ViewRecord
{
    protected static string $resource = DeliveryManResource::class;
    protected ?string $heading = "Détail du livreur";

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
