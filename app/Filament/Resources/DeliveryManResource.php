<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\DeliveryMan;
use Filament\Resources\Resource;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\DeliveryManResource\Pages;
use App\Filament\Resources\DeliveryManResource\RelationManagers;

class DeliveryManResource extends Resource
{
    protected static ?string $model = DeliveryMan::class;
    protected static ?string $navigationIcon = 'carbon-delivery';
    protected static ?string $navigationLabel = 'Livreurs';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Nom complet')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('is_available')
                    ->label('Disponibilité')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color(fn(int $state) => match ($state) {
                        1 => 'success',
                        0 => 'warning',
                    })
                    ->formatStateUsing(fn($state) => $state ? 'Disponible' : 'Non disponible'),
                TextColumn::make('user.email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.telephone')
                    ->label('Téléphone')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('user.address')
                    ->label('Adresse')
                    ->limit(20)
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeliveryMen::route('/'),
            'create' => Pages\CreateDeliveryMan::route('/create'),
            'edit' => Pages\EditDeliveryMan::route('/{record}/edit'),
        ];
    }
}
