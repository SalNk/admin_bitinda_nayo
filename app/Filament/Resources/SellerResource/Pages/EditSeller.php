<?php

namespace App\Filament\Resources\SellerResource\Pages;

use App\Filament\Resources\SellerResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSeller extends EditRecord
{
    protected static string $resource = SellerResource::class;
    public ?string $heading = "Editer le vendeur";

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
